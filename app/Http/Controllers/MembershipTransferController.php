<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransfer;
use App\Models\Member;
use Illuminate\Http\Request;

class MembershipTransferController extends Controller
{
    public function index(Request $request)
    {
        $query = MembershipTransfer::with('member');

        if ($request->filled('transfer_type')) {
            $query->where('transfer_type', $request->transfer_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transfer_number', 'like', "%{$search}%")
                  ->orWhere('from_church', 'like', "%{$search}%")
                  ->orWhere('to_church', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($mq) => $mq->where('full_name', 'like', "%{$search}%"));
            });
        }

        $transfers = $query->orderBy('transfer_date', 'desc')->paginate(15);

        // Stats
        $stats = [
            'total' => MembershipTransfer::count(),
            'pending' => MembershipTransfer::pending()->count(),
            'transfer_in' => MembershipTransfer::byType('Kuingia')->count(),
            'transfer_out' => MembershipTransfer::byType('Kutoka')->count(),
        ];

        if ($request->ajax()) {
            return view('panel.transfers._table', compact('transfers'));
        }

        return view('panel.transfers.index', compact('transfers', 'stats'));
    }

    public function create()
    {
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        return view('panel.transfers.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'transfer_type' => 'required|in:Kuingia,Kutoka',
            'from_church' => 'required_if:transfer_type,Kuingia|nullable|string|max:255',
            'to_church' => 'required_if:transfer_type,Kutoka|nullable|string|max:255',
            'from_pastor' => 'nullable|string|max:255',
            'to_pastor' => 'nullable|string|max:255',
            'transfer_date' => 'required|date',
            'reason' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ], [
            'member_id.required' => 'Tafadhali chagua muumini',
            'transfer_type.required' => 'Tafadhali chagua aina ya uhamisho',
            'from_church.required_if' => 'Tafadhali ingiza kanisa la asili',
            'to_church.required_if' => 'Tafadhali ingiza kanisa la lengo',
            'transfer_date.required' => 'Tafadhali ingiza tarehe ya uhamisho',
        ]);

        $validated['created_by'] = auth()->id();

        MembershipTransfer::create($validated);

        return redirect()->route('transfers.index')
            ->with('success', 'Uhamisho umerekodwa na unasubiri uthibitisho');
    }

    public function show($id)
    {
        $transfer = MembershipTransfer::with(['member', 'approver', 'creator'])->findOrFail($id);
        return view('panel.transfers.show', compact('transfer'));
    }

    public function approve($id)
    {
        $transfer = MembershipTransfer::findOrFail($id);

        if ($transfer->status !== 'Inasubiri') {
            return redirect()->back()->with('error', 'Uhamisho huu hauwezi kuthibitishwa');
        }

        $transfer->update([
            'status' => 'Imeidhinishwa',
            'approved_by' => auth()->id(),
        ]);

        // If transfer out, deactivate member
        if ($transfer->transfer_type === 'Kutoka') {
            $member = Member::find($transfer->member_id);
            if ($member) {
                $member->update([
                    'is_active' => false,
                    'notes' => ($member->notes ?? '') . " | Amehamishwa kwenda {$transfer->to_church} tarehe {$transfer->transfer_date}",
                ]);
                if ($member->user) {
                    $member->user->update(['is_active' => false]);
                }
            }
        }

        return redirect()->back()->with('success', 'Uhamisho umethibitishwa');
    }

    public function reject($id)
    {
        $transfer = MembershipTransfer::findOrFail($id);

        if ($transfer->status !== 'Inasubiri') {
            return redirect()->back()->with('error', 'Uhamisho huu hauwezi kukataliwa');
        }

        $transfer->update([
            'status' => 'Imekataliwa',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Uhamisho umekataliwa');
    }

    public function destroy($id)
    {
        $transfer = MembershipTransfer::findOrFail($id);

        if ($transfer->status === 'Imeidhinishwa') {
            return redirect()->back()->with('error', 'Uhamisho uliothibitishwa hauwezi kufutwa');
        }

        $transfer->delete();

        return redirect()->route('transfers.index')
            ->with('success', 'Uhamisho umefutwa');
    }
}
