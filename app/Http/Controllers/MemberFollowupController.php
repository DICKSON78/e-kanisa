<?php

namespace App\Http\Controllers;

use App\Models\MemberFollowup;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberFollowupController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberFollowup::with(['member', 'assignedUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('follow_up_type')) {
            $query->where('follow_up_type', $request->follow_up_type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        // Show overdue by default
        if (!$request->has('status') && !$request->has('show_all')) {
            $query->where('status', '!=', 'Imekamilika');
        }

        $followups = $query->orderBy('follow_up_date', 'asc')->paginate(15);

        // Stats
        $stats = [
            'total' => MemberFollowup::count(),
            'pending' => MemberFollowup::pending()->count(),
            'overdue' => MemberFollowup::overdue()->count(),
            'completed' => MemberFollowup::where('status', 'Imekamilika')->count(),
        ];

        if ($request->ajax()) {
            return view('panel.followups._table', compact('followups'));
        }

        return view('panel.followups.index', compact('followups', 'stats'));
    }

    public function create(Request $request)
    {
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $users = User::whereIn('role_id', [
            \App\Models\Role::where('slug', 'mchungaji')->first()?->id,
            \App\Models\Role::where('slug', 'mhasibu')->first()?->id,
        ])->get();

        $preselectedMember = $request->member_id;

        return view('panel.followups.create', compact('members', 'users', 'preselectedMember'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'follow_up_type' => 'required|in:Kutokuwepo,Mtihani,Shida ya Kiafya,Nyingine',
            'priority' => 'required|in:Ya Dharura,Ya Juu,Ya Kawaida',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'follow_up_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_to' => 'nullable|exists:users,id',
        ], [
            'member_id.required' => 'Tafadhali chagua muumini',
            'follow_up_type.required' => 'Tafadhali chagua aina ya ufuatiliaji',
            'priority.required' => 'Tafadhali chagua kipaumbele',
            'subject.required' => 'Tafadhali ingiza kichwa',
            'start_date.required' => 'Tafadhali ingiza tarehe ya kuanza',
            'follow_up_date.after_or_equal' => 'Tarehe ya ufuatiliaji lazima iwe baada ya au sawa na tarehe ya kuanza',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'Inasubiri';

        MemberFollowup::create($validated);

        return redirect()->route('followups.index')
            ->with('success', 'Ufuatiliaji umeanzishwa kikamilifu');
    }

    public function show($id)
    {
        $followup = MemberFollowup::with(['member', 'assignedUser', 'creator'])->findOrFail($id);
        return view('panel.followups.show', compact('followup'));
    }

    public function edit($id)
    {
        $followup = MemberFollowup::findOrFail($id);
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $users = User::whereIn('role_id', [
            \App\Models\Role::where('slug', 'mchungaji')->first()?->id,
            \App\Models\Role::where('slug', 'mhasibu')->first()?->id,
        ])->get();

        return view('panel.followups.edit', compact('followup', 'members', 'users'));
    }

    public function update(Request $request, $id)
    {
        $followup = MemberFollowup::findOrFail($id);

        $validated = $request->validate([
            'follow_up_type' => 'required|in:Kutokuwepo,Mtihani,Shida ya Kiafya,Nyingine',
            'priority' => 'required|in:Ya Dharura,Ya Juu,Ya Kawaida',
            'status' => 'required|in:Inasubiri,Imeanzishwa,Imekamilika',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'follow_up_date' => 'nullable|date',
            'last_contact_date' => 'nullable|date',
            'action_taken' => 'nullable|string|max:1000',
            'outcome' => 'nullable|string|max:1000',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $followup->update($validated);

        return redirect()->route('followups.show', $followup->id)
            ->with('success', 'Ufuatiliaji umesasishwa');
    }

    public function destroy($id)
    {
        $followup = MemberFollowup::findOrFail($id);
        $followup->delete();

        return redirect()->route('followups.index')
            ->with('success', 'Ufuatiliaji umefutwa');
    }

    public function updateStatus($id, Request $request)
    {
        $followup = MemberFollowup::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Inasubiri,Imeanzishwa,Imekamilika',
            'action_taken' => 'nullable|string|max:1000',
            'outcome' => 'nullable|string|max:1000',
            'last_contact_date' => 'nullable|date',
        ]);

        $followup->update($validated);

        return redirect()->back()->with('success', 'Hali imesasishwa');
    }
}
