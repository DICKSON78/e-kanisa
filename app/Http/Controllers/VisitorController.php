<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with('assignedUser');

        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('follow_up_status')) {
            $query->where('follow_up_status', $request->follow_up_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('visitor_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $visitors = $query->orderBy('visit_date', 'desc')->paginate(15);

        // Stats
        $thisMonth = Carbon::now();
        $stats = [
            'total' => Visitor::count(),
            'this_month' => Visitor::whereMonth('visit_date', $thisMonth->month)
                ->whereYear('visit_date', $thisMonth->year)->count(),
            'pending_followup' => Visitor::pendingFollowUp()->count(),
            'converted' => Visitor::where('status', 'Amehama')->count(), // Joined church
        ];

        if ($request->ajax()) {
            return view('panel.visitors._table', compact('visitors'));
        }

        return view('panel.visitors.index', compact('visitors', 'stats'));
    }

    public function create()
    {
        $users = User::whereIn('role_id', [
            \App\Models\Role::where('slug', 'mchungaji')->first()?->id,
            \App\Models\Role::where('slug', 'mhasibu')->first()?->id,
        ])->get();

        return view('panel.visitors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gender' => 'nullable|in:Mme,Mke',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'church_from' => 'nullable|string|max:255',
            'visit_date' => 'required|date',
            'service_type' => 'required|string',
            'referred_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'assigned_to' => 'nullable|exists:users,id',
        ], [
            'first_name.required' => 'Tafadhali ingiza jina la kwanza',
            'last_name.required' => 'Tafadhali ingiza jina la ukoo',
            'visit_date.required' => 'Tafadhali ingiza tarehe ya ziara',
            'service_type.required' => 'Tafadhali chagua aina ya huduma',
        ]);

        $validated['recorded_by'] = auth()->id();

        Visitor::create($validated);

        return redirect()->route('visitors.index')
            ->with('success', 'Mgeni amesajiliwa kikamilifu');
    }

    public function show($id)
    {
        $visitor = Visitor::with(['assignedUser', 'recorder'])->findOrFail($id);
        return view('panel.visitors.show', compact('visitor'));
    }

    public function edit($id)
    {
        $visitor = Visitor::findOrFail($id);
        $users = User::whereIn('role_id', [
            \App\Models\Role::where('slug', 'mchungaji')->first()?->id,
            \App\Models\Role::where('slug', 'mhasibu')->first()?->id,
        ])->get();

        return view('panel.visitors.edit', compact('visitor', 'users'));
    }

    public function update(Request $request, $id)
    {
        $visitor = Visitor::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gender' => 'nullable|in:Mme,Mke',
            'status' => 'required|in:Mgeni wa Kwanza,Anarudi,Amehama',
            'follow_up_status' => 'required|in:Inasubiri,Imefanyiwa,Imekamilika',
            'follow_up_notes' => 'nullable|string|max:1000',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $visitor->update($validated);

        return redirect()->route('visitors.show', $visitor->id)
            ->with('success', 'Taarifa za mgeni zimesasishwa');
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('visitors.index')
            ->with('success', 'Mgeni amefutwa');
    }

    public function followUp($id)
    {
        $visitor = Visitor::findOrFail($id);

        $visitor->update([
            'follow_up_status' => 'Imefanyiwa',
            'last_contact_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Ufuatiliaji umerekodwa');
    }

    public function convertToMember($id)
    {
        $visitor = Visitor::findOrFail($id);

        $visitor->update([
            'status' => 'Amehama', // Converted to member
            'follow_up_status' => 'Imekamilika',
        ]);

        // Create member from visitor data
        $year = date('Y');
        $lastMember = \App\Models\Member::where('member_number', 'like', "KKKT-AGAPE-{$year}-%")
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastMember) {
            $parts = explode('-', $lastMember->member_number);
            $sequence = isset($parts[3]) ? intval($parts[3]) + 1 : 1;
        }

        $memberNumber = 'KKKT-AGAPE-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $member = \App\Models\Member::create([
            'member_number' => $memberNumber,
            'envelope_number' => $memberNumber,
            'first_name' => $visitor->first_name,
            'last_name' => $visitor->last_name,
            'phone' => $visitor->phone,
            'email' => $visitor->email,
            'gender' => $visitor->gender,
            'address' => $visitor->address,
            'city' => $visitor->city,
            'membership_date' => now(),
            'is_active' => true,
            'notes' => 'Kutoka mgeni: ' . $visitor->visitor_number,
        ]);

        return redirect()->route('members.show', $member->id)
            ->with('success', 'Mgeni amebadilishwa kuwa muumini. Namba: ' . $memberNumber);
    }
}
