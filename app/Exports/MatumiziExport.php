<?php

namespace App\Exports;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MatumiziExport implements FromArray, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $year;

    public function __construct($year = null)
    {
        $this->year = $year ?? date('Y');
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $categories = ExpenseCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $data = [];
        $monthlyTotals = array_fill(1, 12, 0);
        $grandTotal = 0;

        foreach ($categories as $category) {
            $row = [$category->name];
            $categoryTotal = 0;

            for ($month = 1; $month <= 12; $month++) {
                $expense = Expense::where('expense_category_id', $category->id)
                    ->where('year', $this->year)
                    ->where('month', $month)
                    ->first();

                $amount = $expense ? $expense->amount : 0;
                $row[] = $amount;
                $categoryTotal += $amount;
                $monthlyTotals[$month] += $amount;
            }

            $row[] = $categoryTotal;
            $grandTotal += $categoryTotal;
            $data[] = $row;
        }

        // Add totals row
        $totalsRow = ['JUMLA'];
        for ($month = 1; $month <= 12; $month++) {
            $totalsRow[] = $monthlyTotals[$month];
        }
        $totalsRow[] = $grandTotal;
        $data[] = $totalsRow;

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'AINA YA MATUMIZI',
            'JAN',
            'FEB',
            'MAC',
            'APR',
            'MEI',
            'JUN',
            'JUL',
            'AGO',
            'SEP',
            'OKT',
            'NOV',
            'DES',
            'JUMLA',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastDataRow = $lastRow - 1;

        // Header row styling
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '360958'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Data rows borders
        $sheet->getStyle('A2:N' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Totals row styling (last row)
        $sheet->getStyle('A' . $lastRow . ':N' . $lastRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EFC120'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Format numbers with thousand separator
        $sheet->getStyle('B2:N' . $lastRow)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // Align numbers to right
        $sheet->getStyle('B2:N' . $lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Category names (column A) - left align
        $sheet->getStyle('A2:A' . $lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Make column A a bit wider for category names
        $sheet->getColumnDimension('A')->setWidth(35);

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Matumizi ' . $this->year;
    }
}