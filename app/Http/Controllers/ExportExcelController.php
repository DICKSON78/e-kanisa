<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MapatoExport;
use App\Exports\KiwanjaExport;
use App\Exports\MatumiziExport;
use App\Exports\AhadiExport;
use App\Models\Setting;
use App\Models\Export;
use App\Models\Pledge;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExportExcelController extends Controller
{
    public function index()
    {
        $recentExports = Export::latest()->get();
        $settings = (object) [
            'company_name' => null, 'address' => null, 'phone' => null, 'email' => null,
        ];
        try {
            $settings->company_name = Setting::get('company_name');
            $settings->address = Setting::get('address');
            $settings->phone = Setting::get('phone');
            $settings->email = Setting::get('email');
        } catch (\Exception $e) {}

        return view('panel.reports', compact('recentExports', 'settings'));
    }

    public function download($id)
    {
        $export = Export::findOrFail($id);
        $path = Storage::disk('public')->path($export->filepath);
        if (!\File::exists($path)) {
            return back()->with('error', 'Faili haiwezi kupatikana.');
        }
        return Storage::disk('public')->download($export->filepath, $export->filename);
    }

    public function exportMapato(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $year = $request->input('year');
            $month = $request->input('month');
            $format = $request->input('format', 'excel');
            $period = $request->input('period', 'custom');

            if ($format === 'pdf') {
                return app('App\Http\Controllers\ReportController')->generate($request);
            }

            $filename = 'mapato_' . ($year ?? date('Y'));
            if ($month) $filename .= '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $filename .= '_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            $exportClass = new MapatoExport($startDate, $endDate, $year, $month);
            Excel::store($exportClass, $filepath, 'public');

            $export = $this->saveExportRecord([
                'type' => 'mapato', 'format' => 'excel', 'filename' => $filename,
                'filepath' => $filepath, 'description' => 'Mapato - ' . ($year ?? date('Y')),
                'period' => $period,
            ]);

            return response()->json([
                'success' => true,
                'download_url' => $export->download_url,
                'message' => 'Ripoti ya mapato imetengenezwa!',
            ]);
        } catch (\Exception $e) {
            \Log::error('Export Mapato Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function exportKiwanja(Request $request)
    {
        try {
            $status = $request->get('status', 'all');
            $statusLabel = $status === 'paid' ? 'Zilizolipwa' : ($status === 'pending' ? 'Bado' : 'Zote');
            $filename = 'kiwanja_ahadi_' . $statusLabel . '_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            Excel::store(new KiwanjaExport($status), $filepath, 'public');

            $export = $this->saveExportRecord([
                'type' => 'kiwanja', 'format' => 'excel', 'filename' => $filename,
                'filepath' => $filepath, 'description' => 'Kiwanja na ahadi - ' . $statusLabel,
                'period' => 'custom',
            ]);

            return response()->json([
                'success' => true, 'download_url' => $export->download_url,
                'message' => 'Ripoti ya kiwanja imetengenezwa!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function exportSadaka(Request $request)
    {
        try {
            $year = $request->input('year', date('Y'));
            $month = $request->input('month');
            $format = $request->input('format', 'excel');
            $period = $request->input('period', 'yearly');

            if ($format === 'pdf') {
                $request->merge(['type' => 'mapato', 'period' => $month ? 'custom' : 'yearly']);
                return app('App\Http\Controllers\ReportController')->generate($request);
            }

            $filename = 'sadaka_' . $year;
            if ($month) $filename .= '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $filename .= '_' . date('Y_m_d_His') . '.xlsx';
            $filepath = 'exports/' . $filename;

            $sadakaQuery = \App\Models\Income::with(['category', 'member'])->whereYear('collection_date', $year);
            if ($month) $sadakaQuery->whereMonth('collection_date', $month);
            $sadakaData = $sadakaQuery->get();

            Excel::store(new \App\Exports\SadakaExport($sadakaData, $year, $month), $filepath, 'public');

            $export = $this->saveExportRecord([
                'type' => 'sadaka', 'format' => 'excel', 'filename' => $filename,
                'filepath' => $filepath, 'description' => 'Sadaka - Mwaka ' . $year,
                'period' => $period,
            ]);

            return response()->json([
                'success' => true, 'download_url' => $export->download_url,
                'message' => 'Ripoti ya sadaka imetengenezwa!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function exportAhadi(Request $request)
    {
        try {
            $year = $request->input('year', date('Y'));
            $month = $request->input('month');
            $format = $request->input('format', 'excel');
            $period = $request->input('period', 'yearly');

            $ahadiQuery = Pledge::with(['member', 'payments'])->whereYear('pledge_date', $year);
            if ($month) $ahadiQuery->whereMonth('pledge_date', $month);
            $ahadiData = $ahadiQuery->get();

            $monthNames = [1=>'Januari',2=>'Februari',3=>'Machi',4=>'Aprili',5=>'Mei',6=>'Juni',7=>'Julai',8=>'Agosti',9=>'Septemba',10=>'Oktoba',11=>'Novemba',12=>'Desemba'];
            $periodLabel = 'MWAKA ' . $year;
            if ($month) $periodLabel .= ' - ' . strtoupper($monthNames[(int)$month]);

            $totalPledged = 0; $totalPaid = 0;
            foreach ($ahadiData as $ahadi) {
                $totalPaid += $ahadi->payments ? $ahadi->payments->sum('amount') : 0;
                $totalPledged += floatval($ahadi->amount);
            }
            $totalBalance = $totalPledged - $totalPaid;

            $churchName = Setting::get('church_name', 'ROC [Reality of Christ]');
            $address = Setting::get('address', '');
            $phone = Setting::get('phone', '');
            $email = Setting::get('email', '');

            if ($format === 'pdf') {
                $filename = 'ahadi_' . $year;
                if ($month) $filename .= '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
                $filename .= '_' . date('Y_m_d_His') . '.pdf';
                $filepath = 'exports/' . $filename;

                $pdf = Pdf::loadView('panel.reports.pdf.ahadi-report', compact(
                    'ahadiData', 'periodLabel', 'totalPledged', 'totalPaid', 'totalBalance',
                    'churchName', 'address', 'phone', 'email'
                ));
                Storage::disk('public')->put($filepath, $pdf->output());

                $export = $this->saveExportRecord([
                    'type' => 'ahadi', 'format' => 'pdf', 'filename' => $filename,
                    'filepath' => $filepath, 'description' => 'Ahadi - ' . $periodLabel,
                    'period' => $period,
                ]);

                return response()->json([
                    'success' => true, 'download_url' => $export->download_url,
                    'message' => 'Ripoti ya ahadi (PDF) imetengenezwa!',
                ]);
            } else {
                $filename = 'ahadi_' . $year;
                if ($month) $filename .= '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
                $filename .= '_' . date('Y_m_d_His') . '.xlsx';
                $filepath = 'exports/' . $filename;

                Excel::store(new AhadiExport($ahadiData, $year, $month), $filepath, 'public');

                $export = $this->saveExportRecord([
                    'type' => 'ahadi', 'format' => 'excel', 'filename' => $filename,
                    'filepath' => $filepath, 'description' => 'Ahadi - ' . $periodLabel,
                    'period' => $period,
                ]);

                return response()->json([
                    'success' => true, 'download_url' => $export->download_url,
                    'message' => 'Ripoti ya ahadi imetengenezwa!',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function exportMatumizi(Request $request)
    {
        try {
            $year = $request->input('year', date('Y'));
            $startMonth = (int) $request->input('start_month', 1);
            $endMonth = (int) $request->input('end_month', 12);
            $startYear = $request->input('start_year', $year);
            $endYear = $request->input('end_year', $year);
            $format = $request->input('format', 'excel');
            $period = $request->input('period', 'yearly');

            if ($format === 'pdf') {
                return app('App\Http\Controllers\ReportController')->generate($request);
            }

            $monthAbbr = [1=>'jan',2=>'feb',3=>'mac',4=>'apr',5=>'mei',6=>'jun',7=>'jul',8=>'ago',9=>'sep',10=>'okt',11=>'nov',12=>'des'];
            if ($startYear == $endYear && $startMonth == 1 && $endMonth == 12) {
                $filename = 'matumizi_' . $year . '_' . date('Y_m_d_His') . '.xlsx';
            } else {
                $filename = 'matumizi_' . $startYear . '_' . $monthAbbr[$startMonth] . '_' . $endYear . '_' . $monthAbbr[$endMonth] . '_' . date('Y_m_d_His') . '.xlsx';
            }
            $filepath = 'exports/' . $filename;

            Excel::store(new MatumiziExport($year, $startMonth, $endMonth, $startYear, $endYear), $filepath, 'public');

            $export = $this->saveExportRecord([
                'type' => 'matumizi', 'format' => 'excel', 'filename' => $filename,
                'filepath' => $filepath, 'description' => 'Matumizi - Mwaka ' . $year,
                'period' => $period,
            ]);

            return response()->json([
                'success' => true, 'download_url' => $export->download_url,
                'message' => 'Ripoti ya matumizi imetengenezwa!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function customExport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $reportType = $request->input('report_type');
            $format = $request->input('format', 'excel');
            $period = $request->input('period', 'custom');

            $filename = 'custom_' . date('Y_m_d_His') . '.' . ($format === 'pdf' ? 'pdf' : 'xlsx');
            $filepath = 'exports/' . $filename;

            if ($format === 'pdf') {
                $pdf = Pdf::loadView('panel.reports.pdf.custom-report', [
                    'startDate' => $startDate, 'endDate' => $endDate, 'reportType' => $reportType,
                ]);
                Storage::disk('public')->put($filepath, $pdf->output());
            } else {
                $exportClass = new \App\Exports\CustomExport($startDate, $endDate, $reportType);
                Excel::store($exportClass, $filepath, 'public');
            }

            $export = $this->saveExportRecord([
                'type' => 'custom', 'format' => $format, 'filename' => $filename,
                'filepath' => $filepath,
                'description' => 'Custom - ' . $reportType . ' (' . $startDate . ' to ' . $endDate . ')',
                'period' => $period,
            ]);

            return response()->json([
                'success' => true, 'download_url' => $export->download_url,
                'message' => 'Ripoti imetengenezwa kikamilifu!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function deleteExport($id)
    {
        try {
            $export = Export::findOrFail($id);
            if ($export->filepath && Storage::disk('public')->exists($export->filepath)) {
                Storage::disk('public')->delete($export->filepath);
            }
            $export->delete();
            return response()->json(['success' => true, 'message' => 'Faili imefutwa kikamilifu!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu katika kufuta faili!'], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                $exportIds = $request->input('export_ids');
                if (is_string($exportIds)) {
                    $ids = array_values(array_filter(array_map('trim', explode(',', $exportIds))));
                } elseif (is_array($exportIds)) {
                    $ids = $exportIds;
                }
            }

            if (empty($ids) || !is_array($ids)) {
                return response()->json(['success' => false, 'message' => 'Hakuna faili zilizochaguliwa!'], 400);
            }

            $count = 0;
            foreach ($ids as $id) {
                $export = Export::find($id);
                if ($export) {
                    if ($export->filepath && Storage::disk('public')->exists($export->filepath)) {
                        Storage::disk('public')->delete($export->filepath);
                    }
                    $export->delete();
                    $count++;
                }
            }

            return response()->json(['success' => true, 'message' => $count . ' faili zimefutwa kikamilifu!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    public function quickExport(Request $request)
    {
        $type = $request->input('type');
        $period = $request->input('period', 'monthly');
        $format = $request->input('format', 'excel');

        $request->merge(['period' => $period, 'format' => $format]);

        switch ($type) {
            case 'mapato': return $this->exportMapato($request);
            case 'kiwanja': return $this->exportKiwanja($request);
            case 'matumizi': return $this->exportMatumizi($request);
            case 'mapato_matumizi':
            default:
                return $this->generateCombined($request);
        }
    }

    private function generateCombined(Request $request)
    {
        try {
            $period = $request->input('period', 'monthly');
            $format = $request->input('format', 'excel');
            $year = date('Y');
            $month = date('m');

            $filename = 'ripoti_' . $period . '_' . date('Y_m_d_His') . '.' . ($format === 'pdf' ? 'pdf' : 'xlsx');
            $filepath = 'exports/' . $filename;

            if ($format === 'pdf') {
                $request->merge(['type' => 'mapato_matumizi', 'period' => $period]);
                return app('App\Http\Controllers\ReportController')->generate($request);
            }

            $exportClass = new \App\Exports\MapatoMatumiziExport($year, $month);
            Excel::store($exportClass, $filepath, 'public');

            $export = $this->saveExportRecord([
                'type' => 'mapato_matumizi', 'format' => 'excel', 'filename' => $filename,
                'filepath' => $filepath, 'description' => 'Mapato na Matumizi - ' . ucfirst($period),
                'period' => $period,
            ]);

            return response()->json([
                'success' => true, 'download_url' => $export->download_url,
                'message' => 'Ripoti imetengenezwa!',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu: ' . $e->getMessage()], 500);
        }
    }

    private function saveExportRecord(array $data): Export
    {
        $data['user_id'] = auth()->id();
        $data['file_size'] = $this->formatFileSize($data['filepath'] ?? null);
        return Export::create($data);
    }

    private function formatFileSize(?string $filepath): string
    {
        if (!$filepath) return '0 KB';
        $path = Storage::disk('public')->path($filepath);
        if (!\File::exists($path)) return '0 KB';
        $bytes = \File::size($path);
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}
