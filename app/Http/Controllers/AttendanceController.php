<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('member');

        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        } else {
            $query->whereDate('attendance_date', today());
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->paginate(15);

        // Stats for selected date
        $selectedDate = $request->date ? Carbon::parse($request->date) : today();
        $stats = [
            'total_members' => Member::active()->count(),
            'present_today' => Attendance::whereDate('attendance_date', $selectedDate)->where('status', 'Hudhuria')->count(),
            'absent_today' => Member::active()->count() - Attendance::whereDate('attendance_date', $selectedDate)->where('status', 'Hudhuria')->count(),
            'total_records' => Attendance::whereDate('attendance_date', $selectedDate)->count(),
        ];

        // Monthly stats
        $monthlyStats = Attendance::whereMonth('attendance_date', $selectedDate->month)
            ->whereYear('attendance_date', $selectedDate->year)
            ->selectRaw('DATE(attendance_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        if ($request->ajax()) {
            return view('panel.attendance._table', compact('attendances', 'stats'));
        }

        return view('panel.attendance.index', compact('attendances', 'stats', 'selectedDate', 'monthlyStats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
            'attendance_date' => 'required|date',
            'service_type' => 'required|string',
            'status' => 'required|in:Hudhuria,Kuchukuliwa,Kutohudhuria',
            'notes' => 'nullable|string|max:500',
        ], [
            'member_ids.required' => 'Tafadhali chagua wanachama',
            'member_ids.*.exists' => 'Muumini mmoja au zaidi hajapatikana',
            'attendance_date.required' => 'Tafadhali ingiza tarehe',
            'service_type.required' => 'Tafadhali chagua aina ya huduma',
            'status.required' => 'Tafadhali chagua hali',
        ]);

        $recorded_by = auth()->id();
        $created = 0;
        $updated = 0;

        foreach ($validated['member_ids'] as $memberId) {
            $existing = Attendance::where('member_id', $memberId)
                ->whereDate('attendance_date', $validated['attendance_date'])
                ->where('service_type', $validated['service_type'])
                ->first();

            if ($existing) {
                $existing->update([
                    'status' => $validated['status'],
                    'notes' => $validated['notes'] ?? $existing->notes,
                ]);
                $updated++;
            } else {
                Attendance::create([
                    'member_id' => $memberId,
                    'attendance_date' => $validated['attendance_date'],
                    'service_type' => $validated['service_type'],
                    'status' => $validated['status'],
                    'notes' => $validated['notes'] ?? null,
                    'recorded_by' => $recorded_by,
                ]);
                $created++;
            }
        }

        $totalProcessed = count($validated['member_ids']);
        $message = "Uhudhuriaji umesajiliwa: {$totalProcessed} wanachama";
        if ($created > 0) $message .= ", {$created} wameongezwa";
        if ($updated > 0) $message .= ", {$updated} wamesasishwa";

        return redirect()->back()->with('success', $message);
    }

    public function show($id)
    {
        $attendance = Attendance::with(['member', 'recorder'])->findOrFail($id);
        return view('panel.attendance.show', compact('attendance'));
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Uhudhuriaji umefutwa');
    }

    public function getAbsentMembers(Request $request)
    {
        $date = $request->date ?? today()->toDateString();
        $serviceType = $request->service_type ?? 'Ibada Kuu';

        $presentMemberIds = Attendance::whereDate('attendance_date', $date)
            ->where('service_type', $serviceType)
            ->pluck('member_id')
            ->toArray();

        $absentMembers = Member::active()
            ->whereNotIn('id', $presentMemberIds)
            ->get(['id', 'first_name', 'last_name', 'member_number', 'phone']);

        return response()->json($absentMembers);
    }

    public function report(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');

        $monthlyAttendance = Attendance::whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->selectRaw('DATE(attendance_date) as date, service_type, COUNT(*) as count')
            ->groupBy('date', 'service_type')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        $totalMembers = Member::active()->count();
        $avgAttendance = Attendance::whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->selectRaw('DATE(attendance_date) as date, COUNT(DISTINCT member_id) as count')
            ->groupBy('date')
            ->avg('count');

        $attendanceRate = $totalMembers > 0 ? round(($avgAttendance / $totalMembers) * 100, 1) : 0;

        return view('panel.attendance.report', compact('monthlyAttendance', 'totalMembers', 'avgAttendance', 'attendanceRate', 'year', 'month'));
    }
}
