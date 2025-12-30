<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display expenses in monthly grid view
     */
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));

        return $this->monthlyView($year);
    }

    /**
     * Show monthly grid view for specific year
     */
    public function monthlyView($year)
    {
        // Get all active expense categories
        $categories = ExpenseCategory::active()->ordered()->get();

        // Month names in Swahili
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Machi', 4 => 'Aprili',
            5 => 'Mei', 6 => 'Juni', 7 => 'Julai', 8 => 'Agosti',
            9 => 'Septemba', 10 => 'Oktoba', 11 => 'Novemba', 12 => 'Desemba'
        ];

        // Get all expenses for the year grouped by category and month
        $expenses = Expense::where('year', $year)
            ->with('category')
            ->get()
            ->groupBy(function($expense) {
                return $expense->expense_category_id . '_' . $expense->month;
            });

        // Build grid data structure
        $gridData = [];
        $monthlyTotals = array_fill(1, 12, 0);

        foreach ($categories as $category) {
            $categoryRow = [
                'category' => $category,
                'months' => [],
                'total' => 0
            ];

            for ($month = 1; $month <= 12; $month++) {
                $key = $category->id . '_' . $month;
                $expenseCollection = $expenses->get($key);

                // Sum all expenses for this category/month
                $amount = $expenseCollection ? $expenseCollection->sum('amount') : 0;
                $expenseCount = $expenseCollection ? $expenseCollection->count() : 0;

                $categoryRow['months'][$month] = [
                    'amount' => $amount,
                    'expenses' => $expenseCollection,
                    'expense_count' => $expenseCount
                ];
                $categoryRow['total'] += $amount;
                $monthlyTotals[$month] += $amount;
            }

            $gridData[] = $categoryRow;
        }

        $grandTotal = array_sum($monthlyTotals);

        // Get available years
        $years = Expense::selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        return view('panel.expenses.index', compact(
            'gridData',
            'months',
            'monthlyTotals',
            'grandTotal',
            'year',
            'years',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new expense
     */
    public function create(Request $request)
    {
        $categories = ExpenseCategory::active()->ordered()->get();

        // Pre-fill year and month if provided
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));

        return view('panel.expenses.create', compact('categories', 'year', 'month'));
    }

    /**
     * Store a newly created expense in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0|max:999999999999.99',
            'payee' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'confirm_past_month' => 'nullable|boolean',
        ], [
            'expense_category_id.required' => 'Tafadhali chagua kategoria ya matumizi',
            'expense_category_id.exists' => 'Kategoria iliyochaguliwa haipo',
            'year.required' => 'Tafadhali ingiza mwaka',
            'year.integer' => 'Mwaka lazima uwe nambari',
            'year.min' => 'Mwaka si sahihi',
            'year.max' => 'Mwaka si sahihi',
            'month.required' => 'Tafadhali chagua mwezi',
            'month.integer' => 'Mwezi si sahihi',
            'month.min' => 'Mwezi si sahihi',
            'month.max' => 'Mwezi si sahihi',
            'expense_date.required' => 'Tafadhali ingiza tarehe ya matumizi',
            'expense_date.date' => 'Tarehe si sahihi',
            'amount.required' => 'Tafadhali ingiza kiasi',
            'amount.numeric' => 'Kiasi lazima kiwe nambari',
            'amount.min' => 'Kiasi lazima kiwe chanya',
            'amount.max' => 'Kiasi ni kubwa mno',
            'payee.max' => 'Jina la mpokeaji ni refu mno',
            'receipt_number.max' => 'Nambari ya risiti ni ndefu mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        // Check if the selected month is in the past (requires confirmation)
        $currentYear = (int) date('Y');
        $currentMonth = (int) date('n');
        $selectedYear = (int) $validated['year'];
        $selectedMonth = (int) $validated['month'];

        $isPastMonth = ($selectedYear < $currentYear) ||
                       ($selectedYear == $currentYear && $selectedMonth < $currentMonth);

        // If past month and no confirmation, return with warning
        if ($isPastMonth && !$request->input('confirm_past_month')) {
            return redirect()->back()
                ->with('past_month_warning', true)
                ->with('warning_message', 'Unaongeza matumizi kwa mwezi uliopita. Je, una uhakika unataka kuendelea?')
                ->withInput();
        }

        $validated['created_by'] = Auth::id();
        unset($validated['confirm_past_month']);

        Expense::create($validated);

        return redirect()->route('expenses.index', ['year' => $validated['year']])
            ->with('success', 'Matumizi yamerekodiwa kikamilifu');
    }

    /**
     * Display the specified expense
     */
    public function show($id)
    {
        $expense = Expense::with(['category', 'creator', 'updater'])->findOrFail($id);

        return view('panel.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $categories = ExpenseCategory::active()->ordered()->get();

        return view('panel.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified expense in storage
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0|max:999999999999.99',
            'payee' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ], [
            'expense_category_id.required' => 'Tafadhali chagua kategoria ya matumizi',
            'expense_category_id.exists' => 'Kategoria iliyochaguliwa haipo',
            'year.required' => 'Tafadhali ingiza mwaka',
            'year.integer' => 'Mwaka lazima uwe nambari',
            'year.min' => 'Mwaka si sahihi',
            'year.max' => 'Mwaka si sahihi',
            'month.required' => 'Tafadhali chagua mwezi',
            'month.integer' => 'Mwezi si sahihi',
            'month.min' => 'Mwezi si sahihi',
            'month.max' => 'Mwezi si sahihi',
            'expense_date.required' => 'Tafadhali ingiza tarehe ya matumizi',
            'expense_date.date' => 'Tarehe si sahihi',
            'amount.required' => 'Tafadhali ingiza kiasi',
            'amount.numeric' => 'Kiasi lazima kiwe nambari',
            'amount.min' => 'Kiasi lazima kiwe chanya',
            'amount.max' => 'Kiasi ni kubwa mno',
            'payee.max' => 'Jina la mpokeaji ni refu mno',
            'receipt_number.max' => 'Nambari ya risiti ni ndefu mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        $validated['updated_by'] = Auth::id();

        $expense->update($validated);

        return redirect()->route('expenses.index', ['year' => $validated['year']])
            ->with('success', 'Matumizi yamebadilishwa kikamilifu');
    }

    /**
     * Display expenses for a specific month in calendar view
     */
    public function monthlyExpenses($year, $month)
    {
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Machi', 4 => 'Aprili',
            5 => 'Mei', 6 => 'Juni', 7 => 'Julai', 8 => 'Agosti',
            9 => 'Septemba', 10 => 'Oktoba', 11 => 'Novemba', 12 => 'Desemba'
        ];

        $monthName = $monthNames[(int)$month] ?? 'Mwezi';

        // Get all expenses for this month
        $expenses = Expense::where('year', $year)
            ->where('month', $month)
            ->with('category')
            ->orderBy('expense_date')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group expenses by date for calendar
        $expensesByDate = $expenses->groupBy(function($expense) {
            return $expense->expense_date ? $expense->expense_date->format('Y-m-d') : null;
        });

        // Get all categories with colors for legend
        $allCategories = ExpenseCategory::active()->ordered()->get();

        // Assign colors to categories
        $categoryColors = [
            'red', 'blue', 'green', 'purple', 'orange', 'pink', 'teal', 'indigo',
            'amber', 'cyan', 'lime', 'emerald', 'violet', 'fuchsia', 'rose', 'sky'
        ];

        $categoriesWithColors = [];
        foreach ($allCategories as $index => $category) {
            $colorIndex = $index % count($categoryColors);
            $categoriesWithColors[$category->id] = [
                'category' => $category,
                'color' => $categoryColors[$colorIndex]
            ];
        }

        // Calculate calendar data
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
        $daysInMonth = $lastDayOfMonth->day;
        $startDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

        // Calculate totals
        $totalAmount = $expenses->sum('amount');
        $totalCount = $expenses->count();
        $categoryCount = $expenses->pluck('expense_category_id')->unique()->count();
        $avgPerCategory = $categoryCount > 0 ? $totalAmount / $categoryCount : 0;

        // Get days with expenses and their totals
        $daysWithExpenses = [];
        foreach ($expensesByDate as $date => $dayExpenses) {
            if ($date) {
                $day = Carbon::parse($date)->day;
                $daysWithExpenses[$day] = [
                    'expenses' => $dayExpenses,
                    'total' => $dayExpenses->sum('amount'),
                    'count' => $dayExpenses->count()
                ];
            }
        }

        return view('panel.expenses.monthly', compact(
            'expenses',
            'expensesByDate',
            'categoriesWithColors',
            'year',
            'month',
            'monthName',
            'totalAmount',
            'totalCount',
            'categoryCount',
            'avgPerCategory',
            'daysInMonth',
            'startDayOfWeek',
            'daysWithExpenses',
            'firstDayOfMonth'
        ));
    }

    /**
     * Remove the specified expense from storage (soft delete)
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $year = $expense->year;
        $expense->delete();

        return redirect()->route('expenses.index', ['year' => $year])
            ->with('success', 'Matumizi yamefutwa kikamilifu');
    }

    /**
     * Display expense categories
     */
    public function categories()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('panel.expenses.categories', compact('categories'));
    }

    /**
     * Store a new expense category
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        ExpenseCategory::create($validated);

        return redirect()->route('expenses.categories')
            ->with('success', 'Kategoria imeongezwa kikamilifu!');
    }
}
