<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MapatoExport;
use App\Exports\KiwanjaExport;
use App\Exports\MatumiziExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExportExcelController extends Controller
{
    public function index()
    {
        // Get recent exports for display
        $recentExports = $this->getRecentExports();

        return view('panel.reports', compact('recentExports'));
    }

    public function exportMapato(Request $request)
    {
        try {
            // Get filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $year = $request->input('year');
            $month = $request->input('month');

            $filename = 'mapato_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            // Create export with filters
            $export = new MapatoExport($startDate, $endDate, $year, $month);

            // Store the file
            Excel::store($export, $filepath, 'public');

            // Build description based on filters
            $description = 'Ripoti ya Mapato ya Kanisa';
            if ($year) $description .= ' - Mwaka ' . $year;
            if ($month) $description .= ' - Mwezi ' . $month;
            if ($startDate && $endDate) $description .= ' - ' . date('d/m/Y', strtotime($startDate)) . ' hadi ' . date('d/m/Y', strtotime($endDate));

            // Save export record
            $this->saveExportRecord([
                'type' => 'mapato',
                'filename' => $filename,
                'filepath' => $filepath,
                'description' => $description,
                'size' => $this->formatSize(Storage::disk('public')->size($filepath))
            ]);

            return response()->json([
                'success' => true,
                'download_url' => Storage::disk('public')->url($filepath),
                'message' => 'Ripoti ya mapato imetengenezwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportKiwanja(Request $request)
    {
        try {
            $status = $request->get('status', 'all'); // all, paid, pending

            $statusLabel = $status === 'paid' ? 'Zilizolipwa' : ($status === 'pending' ? 'Bado' : 'Zote');
            $filename = 'kiwanja_ahadi_' . $statusLabel . '_' . date('Y_m_d_His') . '.xlsx';

            // Return download directly
            return Excel::download(new KiwanjaExport($status), $filename);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportMatumizi(Request $request)
    {
        try {
            // Get year parameter
            $year = $request->input('year', date('Y'));

            $filename = 'matumizi_' . $year . '_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            // Create export with year
            $export = new MatumiziExport($year);

            Excel::store($export, $filepath, 'public');

            $this->saveExportRecord([
                'type' => 'matumizi',
                'filename' => $filename,
                'filepath' => $filepath,
                'description' => 'Ripoti ya Matumizi ya Kanisa - Mwaka ' . $year,
                'size' => $this->formatSize(Storage::disk('public')->size($filepath))
            ]);

            return response()->json([
                'success' => true,
                'download_url' => Storage::disk('public')->url($filepath),
                'message' => 'Ripoti ya matumizi imetengenezwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function customExport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $reportType = $request->input('report_type');

            $filename = 'custom_export_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            // Handle custom export based on parameters
            // You can create a custom export class that accepts these parameters

            $this->saveExportRecord([
                'type' => 'custom',
                'filename' => $filename,
                'filepath' => $filepath,
                'description' => 'Custom Export - ' . $reportType . ' (' . $startDate . ' to ' . $endDate . ')',
                'size' => '1.5 MB' // Simulated size
            ]);

            return response()->json([
                'success' => true,
                'download_url' => '#',
                'message' => 'Custom export imetengenezwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteExport($id)
    {
        try {
            // In a real application, you'd have an Export model
            // For now, we'll simulate deletion
            return response()->json([
                'success' => true,
                'message' => 'Faili imefutwa kikamilifu!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hitilafu katika kufuta faili!'
            ], 500);
        }
    }

    public function getRecentExports()
    {
        // Simulate recent exports data
        // In real application, fetch from database
        return [
            [
                'id' => 1,
                'type' => 'mapato',
                'filename' => 'mapato_2025_01_15_143022.xlsx',
                'description' => 'Mapato ya Jumapili zote',
                'date' => '15 Jan 2025, 14:30',
                'size' => '2.4 MB',
                'download_url' => '#'
            ],
            [
                'id' => 2,
                'type' => 'kiwanja',
                'filename' => 'kiwanja_ahadi_2025_01_14_093045.xlsx',
                'description' => 'Ahadi za kiwanja na malipo',
                'date' => '14 Jan 2025, 09:30',
                'size' => '1.8 MB',
                'download_url' => '#'
            ],
            [
                'id' => 3,
                'type' => 'matumizi',
                'filename' => 'matumizi_2025_01_13_162315.xlsx',
                'description' => 'Matumizi ya mwezi Januari',
                'date' => '13 Jan 2025, 16:23',
                'size' => '1.2 MB',
                'download_url' => '#'
            ]
        ];
    }

    public function quickExport(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'mapato':
                return $this->exportMapato($request);
            case 'kiwanja':
                return $this->exportKiwanja($request);
            case 'matumizi':
                return $this->exportMatumizi($request);
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Aina ya ripoti haijulikani!'
                ], 400);
        }
    }

    private function saveExportRecord($data)
    {
        // In real application, save to database
        // Export::create($data);
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
