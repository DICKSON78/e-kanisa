<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Setting;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Get settings for reports
     */
    private function getSettings()
    {
        return Setting::first() ?? new Setting();
    }

    /**
     * Get date range based on period type
     */
    private function getDateRange($period, $startDate = null, $endDate = null)
    {
        switch ($period) {
            case 'weekly':
                return [
                    'start' => Carbon::now()->subDays(7)->startOfDay(),
                    'end' => Carbon::now()->endOfDay(),
                    'text' => 'Wiki Iliyopita (' . Carbon::now()->subDays(7)->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y') . ')'
                ];
            case 'monthly':
                return [
                    'start' => Carbon::now()->subDays(30)->startOfDay(),
                    'end' => Carbon::now()->endOfDay(),
                    'text' => 'Mwezi Uliopita (' . Carbon::now()->subDays(30)->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y') . ')'
                ];
            case 'yearly':
                return [
                    'start' => Carbon::now()->subYear()->startOfDay(),
                    'end' => Carbon::now()->endOfDay(),
                    'text' => 'Mwaka Uliopita (' . Carbon::now()->subYear()->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y') . ')'
                ];
            case 'custom':
                $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth();
                $end = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();
                return [
                    'start' => $start,
                    'end' => $end,
                    'text' => 'Kipindi Maalum (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')'
                ];
            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfDay(),
                    'text' => 'Mwezi Huu'
                ];
        }
    }

    /**
     * Get income data for report
     */
    private function getIncomeData($startDate, $endDate)
    {
        $incomes = Income::with(['category', 'member'])
            ->whereBetween('collection_date', [$startDate, $endDate])
            ->orderBy('collection_date', 'desc')
            ->get();

        return $incomes->map(function ($income) {
            return [
                'date' => $income->collection_date,
                'category' => $income->category->name ?? 'Bila Kategoria',
                'description' => $income->notes ?? $income->category->name ?? '-',
                'contributor' => $income->member->full_name ?? '-',
                'amount' => $income->amount
            ];
        })->toArray();
    }

    /**
     * Get expense data for report
     */
    private function getExpenseData($startDate, $endDate)
    {
        // Expense uses year and month columns, not a date column
        $startYear = $startDate->year;
        $startMonth = $startDate->month;
        $endYear = $endDate->year;
        $endMonth = $endDate->month;

        $expenses = Expense::with('category')
            ->where(function ($query) use ($startYear, $startMonth, $endYear, $endMonth) {
                // Handle date range spanning across years/months
                $query->where(function ($q) use ($startYear, $startMonth, $endYear, $endMonth) {
                    if ($startYear == $endYear) {
                        // Same year
                        $q->where('year', $startYear)
                          ->whereBetween('month', [$startMonth, $endMonth]);
                    } else {
                        // Different years
                        $q->where(function ($sq) use ($startYear, $startMonth) {
                            $sq->where('year', $startYear)
                               ->where('month', '>=', $startMonth);
                        })->orWhere(function ($sq) use ($endYear, $endMonth) {
                            $sq->where('year', $endYear)
                               ->where('month', '<=', $endMonth);
                        })->orWhere(function ($sq) use ($startYear, $endYear) {
                            $sq->where('year', '>', $startYear)
                               ->where('year', '<', $endYear);
                        });
                    }
                });
            })
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return $expenses->map(function ($expense) {
            // Create a date from year and month for display
            $date = Carbon::createFromDate($expense->year, $expense->month, 1);
            return [
                'date' => $date,
                'category' => $expense->category->name ?? 'Bila Kategoria',
                'description' => $expense->notes ?? $expense->payee ?? '-',
                'amount' => $expense->amount
            ];
        })->toArray();
    }

    /**
     * Group data by category
     */
    private function groupByCategory($data)
    {
        $grouped = [];
        foreach ($data as $item) {
            $category = $item['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $item;
        }
        return $grouped;
    }

    /**
     * Display reports index page
     */
    public function index()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Print report view
     */
    public function print(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $type = $request->get('type', 'mapato_matumizi');

        $dateRange = $this->getDateRange($period);
        $settings = $this->getSettings();

        $incomeData = $this->getIncomeData($dateRange['start'], $dateRange['end']);
        $expenseData = $this->getExpenseData($dateRange['start'], $dateRange['end']);

        $totalIncome = collect($incomeData)->sum('amount');
        $totalExpense = collect($expenseData)->sum('amount');

        $title = $this->getReportTitle($type, $period);

        return view('panel.reports.print', [
            'settings' => $settings,
            'title' => $title,
            'period_text' => $dateRange['text'],
            'income_data' => $incomeData,
            'expense_data' => $expenseData,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'start_date' => $dateRange['start']->format('d/m/Y'),
            'end_date' => $dateRange['end']->format('d/m/Y')
        ]);
    }

    /**
     * Preview report
     */
    public function preview(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $type = $request->get('type', 'mapato_matumizi');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $dateRange = $this->getDateRange($period, $startDate, $endDate);
        $settings = $this->getSettings();

        $incomeData = [];
        $expenseData = [];

        if ($type === 'mapato' || $type === 'mapato_matumizi' || $type === 'custom') {
            $incomeData = $this->getIncomeData($dateRange['start'], $dateRange['end']);
        }

        if ($type === 'matumizi' || $type === 'mapato_matumizi' || $type === 'custom') {
            $expenseData = $this->getExpenseData($dateRange['start'], $dateRange['end']);
        }

        $totalIncome = collect($incomeData)->sum('amount');
        $totalExpense = collect($expenseData)->sum('amount');

        $title = $this->getReportTitle($type, $period);

        return view('panel.reports.print', [
            'settings' => $settings,
            'title' => $title,
            'period_text' => $dateRange['text'],
            'income_data' => $incomeData,
            'expense_data' => $expenseData,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'start_date' => $dateRange['start']->format('d/m/Y'),
            'end_date' => $dateRange['end']->format('d/m/Y')
        ]);
    }

    /**
     * Quick export report
     */
    public function quickExport(Request $request)
    {
        try {
            $period = $request->input('period', 'monthly');
            $format = $request->input('format', 'pdf');
            $type = $request->input('type', 'mapato_matumizi');

            $dateRange = $this->getDateRange($period);
            $settings = $this->getSettings();

            $incomeData = $this->getIncomeData($dateRange['start'], $dateRange['end']);
            $expenseData = $this->getExpenseData($dateRange['start'], $dateRange['end']);

            $totalIncome = collect($incomeData)->sum('amount');
            $totalExpense = collect($expenseData)->sum('amount');

            $title = $this->getReportTitle($type, $period);

            if ($format === 'pdf') {
                return $this->generatePdf([
                    'settings' => $settings,
                    'title' => $title,
                    'period_text' => $dateRange['text'],
                    'income_data' => $incomeData,
                    'expense_data' => $expenseData,
                    'income_by_category' => $this->groupByCategory($incomeData),
                    'expense_by_category' => $this->groupByCategory($expenseData),
                    'total_income' => $totalIncome,
                    'total_expense' => $totalExpense,
                    'start_date' => $dateRange['start']->format('d/m/Y'),
                    'end_date' => $dateRange['end']->format('d/m/Y'),
                    'include_logo' => $request->input('include_logo', true),
                    'include_header' => $request->input('include_header', true),
                    'include_summary' => true,
                    'include_totals' => true,
                    'group_by_category' => true,
                    'include_signature' => false,
                    'include_watermark' => false
                ], $title);
            } else {
                // Excel export
                return $this->generateExcel($incomeData, $expenseData, $title, $dateRange);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu imetokea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate full report
     */
    public function generate(Request $request)
    {
        try {
            $type = $request->input('type', 'mapato_matumizi');
            $period = $request->input('period', 'monthly');
            $format = $request->input('format', 'pdf');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dateRange = $this->getDateRange($period, $startDate, $endDate);
            $settings = $this->getSettings();

            $incomeData = [];
            $expenseData = [];

            if ($type === 'mapato' || $type === 'mapato_matumizi' || $type === 'custom') {
                $incomeData = $this->getIncomeData($dateRange['start'], $dateRange['end']);
            }

            if ($type === 'matumizi' || $type === 'mapato_matumizi' || $type === 'custom') {
                $expenseData = $this->getExpenseData($dateRange['start'], $dateRange['end']);
            }

            $totalIncome = collect($incomeData)->sum('amount');
            $totalExpense = collect($expenseData)->sum('amount');

            $title = $this->getReportTitle($type, $period);

            if ($format === 'pdf') {
                return $this->generatePdf([
                    'settings' => $settings,
                    'title' => $title,
                    'period_text' => $dateRange['text'],
                    'income_data' => $incomeData,
                    'expense_data' => $expenseData,
                    'income_by_category' => $this->groupByCategory($incomeData),
                    'expense_by_category' => $this->groupByCategory($expenseData),
                    'total_income' => $totalIncome,
                    'total_expense' => $totalExpense,
                    'start_date' => $dateRange['start']->format('d/m/Y'),
                    'end_date' => $dateRange['end']->format('d/m/Y'),
                    'include_logo' => $request->input('include_logo', true),
                    'include_header' => $request->input('include_header', true),
                    'include_summary' => $request->input('include_summary', true),
                    'include_totals' => $request->input('include_totals', true),
                    'group_by_category' => $request->input('group_by_category', true),
                    'include_signature' => $request->input('include_signature', false),
                    'include_watermark' => $request->input('include_watermark', false)
                ], $title);
            } elseif ($format === 'excel') {
                return $this->generateExcel($incomeData, $expenseData, $title, $dateRange);
            } else {
                return $this->generateCsv($incomeData, $expenseData, $title, $dateRange);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu imetokea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF report
     */
    private function generatePdf($data, $title)
    {
        $pdf = Pdf::loadView('panel.reports.pdf.financial-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = str_replace(' ', '_', $title) . '_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate Excel report
     */
    private function generateExcel($incomeData, $expenseData, $title, $dateRange)
    {
        // For now, return a simple CSV as Excel
        // In production, use Laravel Excel package
        $filename = str_replace(' ', '_', $title) . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($incomeData, $expenseData, $title, $dateRange) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Title
            fputcsv($file, [$title]);
            fputcsv($file, ['Kipindi: ' . $dateRange['text']]);
            fputcsv($file, ['Imetengenezwa: ' . date('d/m/Y H:i')]);
            fputcsv($file, []);

            // Income section
            if (!empty($incomeData)) {
                fputcsv($file, ['MAPATO']);
                fputcsv($file, ['Tarehe', 'Kategoria', 'Maelezo', 'Mchangiaji', 'Kiasi (TZS)']);

                foreach ($incomeData as $item) {
                    fputcsv($file, [
                        Carbon::parse($item['date'])->format('d/m/Y'),
                        $item['category'],
                        $item['description'],
                        $item['contributor'],
                        number_format($item['amount'], 2)
                    ]);
                }

                fputcsv($file, ['', '', '', 'JUMLA YA MAPATO:', number_format(collect($incomeData)->sum('amount'), 2)]);
                fputcsv($file, []);
            }

            // Expense section
            if (!empty($expenseData)) {
                fputcsv($file, ['MATUMIZI']);
                fputcsv($file, ['Tarehe', 'Kategoria', 'Maelezo', 'Kiasi (TZS)']);

                foreach ($expenseData as $item) {
                    fputcsv($file, [
                        Carbon::parse($item['date'])->format('d/m/Y'),
                        $item['category'],
                        $item['description'],
                        number_format($item['amount'], 2)
                    ]);
                }

                fputcsv($file, ['', '', 'JUMLA YA MATUMIZI:', number_format(collect($expenseData)->sum('amount'), 2)]);
                fputcsv($file, []);
            }

            // Summary
            $totalIncome = collect($incomeData)->sum('amount');
            $totalExpense = collect($expenseData)->sum('amount');
            $balance = $totalIncome - $totalExpense;

            fputcsv($file, ['MUHTASARI']);
            fputcsv($file, ['Jumla ya Mapato:', number_format($totalIncome, 2)]);
            fputcsv($file, ['Jumla ya Matumizi:', number_format($totalExpense, 2)]);
            fputcsv($file, ['Salio:', number_format($balance, 2)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate CSV report
     */
    private function generateCsv($incomeData, $expenseData, $title, $dateRange)
    {
        return $this->generateExcel($incomeData, $expenseData, $title, $dateRange);
    }

    /**
     * Get report title based on type and period
     */
    private function getReportTitle($type, $period)
    {
        $types = [
            'mapato' => 'Ripoti ya Mapato',
            'matumizi' => 'Ripoti ya Matumizi',
            'mapato_matumizi' => 'Ripoti ya Mapato na Matumizi',
            'kiwanja' => 'Ripoti ya Kiwanja na Ahadi',
            'custom' => 'Ripoti ya Fedha'
        ];

        $periods = [
            'weekly' => 'ya Wiki',
            'monthly' => 'ya Mwezi',
            'yearly' => 'ya Mwaka',
            'custom' => ''
        ];

        $typeTitle = $types[$type] ?? 'Ripoti ya Fedha';
        $periodTitle = $periods[$period] ?? '';

        return trim($typeTitle . ' ' . $periodTitle);
    }

    /**
     * Financial report view
     */
    public function financial()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Members report
     */
    public function members()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Offerings report
     */
    public function offerings()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Events report
     */
    public function events()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Requests report
     */
    public function requests()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Export financial report
     */
    public function exportFinancial()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Export members report
     */
    public function exportMembers()
    {
        return redirect()->route('export.excel');
    }

    /**
     * Export offerings report
     */
    public function exportOfferings()
    {
        return redirect()->route('export.excel');
    }
}
