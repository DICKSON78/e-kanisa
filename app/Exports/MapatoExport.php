<?php

namespace App\Exports;

use App\Models\Income;
use App\Models\IncomeCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class MapatoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $year;
    protected $month;

    public function __construct($startDate = null, $endDate = null, $year = null, $month = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Income::with(['category', 'member'])
            ->orderBy('collection_date', 'asc');

        if ($this->startDate) {
            $query->where('collection_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('collection_date', '<=', $this->endDate);
        }
        if ($this->year) {
            $query->whereYear('collection_date', $this->year);
        }
        if ($this->month) {
            $query->whereMonth('collection_date', $this->month);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'TAREHE',
            'AINA YA MAPATO',
            'KIASI (TSh)',
            'MWANACHAMA',
            'NAMBA YA RISITI',
            'TAREHE YA KUINGIZA',
        ];
    }

    /**
     * @param Income $income
     */
    public function map($income): array
    {
        return [
            Carbon::parse($income->collection_date)->format('d/m/Y'),
            $income->category ? $income->category->name : '-',
            $income->amount,
            $income->member ? $income->member->first_name . ' ' . $income->member->last_name : '-',
            $income->receipt_number ?? '-',
            $income->created_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Header row styling
        $sheet->getStyle('A1:F1')->applyFromArray([
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
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Format amount column with thousand separator
        $sheet->getStyle('C2:C' . $lastRow)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // Align amount column to right
        $sheet->getStyle('C2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Mapato';
    }
}