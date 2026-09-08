<?php

namespace App\Http\Controllers;

use App\Models\ServingSchedule;
use App\Models\ServingAssignment;
use App\Models\Member;
use Illuminate\Http\Request;

class ServingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = ServingSchedule::withCount('assignments');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('schedule_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('schedule_date', '<=', $request->date_to);
        }

        $schedules = $query->orderBy('schedule_date', 'desc')->paginate(15);

        if ($request->ajax()) {
            return view('panel.serving._table', compact('schedules'));
        }

        return view('panel.serving.index', compact('schedules'));
    }

    public function create()
    {
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $roles = ['Mtangazaji', 'Mtumaji wa Madhabahu', 'Mwimbaji', 'Mtayarishaji', 'Mlinzi', 'Mgeni', 'Mhudumu wa Audio', 'Mwingine'];

        return view('panel.serving.create', compact('members', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'schedule_date' => 'required|date',
            'service_type' => 'required|string',
            'assignments' => 'required|array|min:1',
            'assignments.*.member_id' => 'required|exists:members,id',
            'assignments.*.role' => 'required|string',
            'assignments.*.position' => 'nullable|string|max:255',
            'assignments.*.notes' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Tafadhali ingiza jina la ratiba',
            'schedule_date.required' => 'Tafadhali ingiza tarehe',
            'service_type.required' => 'Tafadhali chagua aina ya huduma',
            'assignments.required' => 'Tafadhali ongeza angalazu mtumaji mmoja',
            'assignments.*.member_id.required' => 'Tafadhali chagua mtumaji',
            'assignments.*.role.required' => 'Tafadhali ingiza jukumu',
        ]);

        $validated['created_by'] = auth()->id();

        $schedule = ServingSchedule::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'schedule_date' => $validated['schedule_date'],
            'service_type' => $validated['service_type'],
            'status' => 'Active',
            'created_by' => $validated['created_by'],
        ]);

        foreach ($validated['assignments'] as $assignment) {
            ServingAssignment::create([
                'schedule_id' => $schedule->id,
                'member_id' => $assignment['member_id'],
                'role' => $assignment['role'],
                'position' => $assignment['position'] ?? null,
                'status' => 'Imekubaliwa',
                'notes' => $assignment['notes'] ?? null,
            ]);
        }

        return redirect()->route('serving.index')
            ->with('success', 'Ratiba ya kuhudumu imeundwa kikamilifu');
    }

    public function show($id)
    {
        $schedule = ServingSchedule::with(['assignments.member', 'creator'])->findOrFail($id);
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $roles = ['Mtangazaji', 'Mtumaji wa Madhabahu', 'Mwimbaji', 'Mtayarishaji', 'Mlinzi', 'Mgeni', 'Mhudumu wa Audio', 'Mwingine'];

        return view('panel.serving.show', compact('schedule', 'members', 'roles'));
    }

    public function edit($id)
    {
        $schedule = ServingSchedule::with('assignments.member')->findOrFail($id);
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $roles = ['Mtangazaji', 'Mtumaji wa Madhabahu', 'Mwimbaji', 'Mtayarishaji', 'Mlinzi', 'Mgeni', 'Mhudumu wa Audio', 'Mwingine'];

        return view('panel.serving.edit', compact('schedule', 'members', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $schedule = ServingSchedule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'schedule_date' => 'required|date',
            'service_type' => 'required|string',
            'status' => 'required|in:Active,Completed,Cancelled',
        ]);

        $schedule->update($validated);

        return redirect()->route('serving.show', $schedule->id)
            ->with('success', 'Ratiba imesasishwa');
    }

    public function destroy($id)
    {
        $schedule = ServingSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('serving.index')
            ->with('success', 'Ratiba imefutwa');
    }

    public function addAssignment(Request $request, $scheduleId)
    {
        $schedule = ServingSchedule::findOrFail($scheduleId);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'required|string',
            'position' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $exists = ServingAssignment::where('schedule_id', $scheduleId)
            ->where('member_id', $validated['member_id'])
            ->where('role', $validated['role'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Mtumaji huyu tayari yupo katika jukumu hili');
        }

        ServingAssignment::create([
            'schedule_id' => $scheduleId,
            'member_id' => $validated['member_id'],
            'role' => $validated['role'],
            'position' => $validated['position'] ?? null,
            'status' => 'Imekubaliwa',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Mtumaji ameongezwa');
    }

    public function removeAssignment($scheduleId, $assignmentId)
    {
        $assignment = ServingAssignment::where('schedule_id', $scheduleId)->findOrFail($assignmentId);
        $assignment->delete();

        return redirect()->back()->with('success', 'Mtumaji ameondolewa');
    }
}
