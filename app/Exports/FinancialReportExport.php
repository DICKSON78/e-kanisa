<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinancialReportExport implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private array $incomeData;
    private array $expenseData;
    private string $title;
    private string $periodText;

    public function __construct(array $incomeData, array $expenseData, string $title, string $periodText)
    {
        $this->incomeData = $incomeData;
        $this->expenseData = $expenseData;
        $this->title = $title;
        $this->periodText = $periodText;
    }

    public function title(): string
    {
        return 'Ripoti';
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = [$this->title];
        $rows[] = ['Kipindi', $this->periodText];
        $rows[] = ['Imetengenezwa', now()->format('d/m/Y H:i')];
        $rows[] = [];

        $totalIncome = collect($this->incomeData)->sum('amount');
        $totalExpense = collect($this->expenseData)->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $rows[] = ['MUHTASARI'];
        $rows[] = ['Jumla ya Mapato', $totalIncome];
        $rows[] = ['Jumla ya Matumizi', $totalExpense];
        $rows[] = ['Salio', $balance];
        $rows[] = [];

        if (!empty($this->incomeData)) {
            $rows[] = ['MAPATO'];
            $rows[] = ['Tarehe', 'Kategoria', 'Maelezo', 'Mchangiaji', 'Kiasi (TZS)'];
            foreach ($this->incomeData as $item) {
                $rows[] = [
                    Carbon::parse($item['date'])->format('d/m/Y'),
                    (string) ($item['category'] ?? '-'),
                    (string) ($item['description'] ?? '-'),
                    (string) ($item['contributor'] ?? '-'),
                    (float) ($item['amount'] ?? 0),
                ];
            }
            $rows[] = ['', '', '', 'JUMLA YA MAPATO', (float) $totalIncome];
            $rows[] = [];
        }

        if (!empty($this->expenseData)) {
            $rows[] = ['MATUMIZI'];
            $rows[] = ['Tarehe', 'Kategoria', 'Maelezo', 'Kiasi (TZS)'];
            foreach ($this->expenseData as $item) {
                $rows[] = [
                    Carbon::parse($item['date'])->format('d/m/Y'),
                    (string) ($item['category'] ?? '-'),
                    (string) ($item['description'] ?? '-'),
                    (float) ($item['amount'] ?? 0),
                ];
            }
            $rows[] = ['', '', 'JUMLA YA MATUMIZI', (float) $totalExpense];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A1:E1');

        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        // Style section headers (MUHTASARI / MAPATO / MATUMIZI)
        for ($r = 1; $r <= $highestRow; $r++) {
            $value = (string) $sheet->getCell('A' . $r)->getValue();
            if (in_array($value, ['MUHTASARI', 'MAPATO', 'MATUMIZI'], true)) {
                $sheet->mergeCells('A' . $r . ':' . $highestColumn . $r);
                $sheet->getStyle('A' . $r)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '360958'],
                    ],
                ]);
            }
        }

        return [];
    }
}
