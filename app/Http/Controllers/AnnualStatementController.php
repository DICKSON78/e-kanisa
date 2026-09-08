<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Income;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnualStatementController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');

        $members = Member::active()
            ->with(['incomes.category'])
            ->get()
            ->map(function ($member) use ($year) {
                $yearlyIncome = $member->incomes
                    ->filter(fn($i) => $i->collection_date->year == $year)
                    ->groupBy(fn($i) => $i->category->name ?? 'Nyingine')
                    ->map(fn($group) => $group->sum('amount'));

                return [
                    'id' => $member->id,
                    'member_number' => $member->member_number,
                    'full_name' => $member->full_name,
                    'phone' => $member->phone,
                    'email' => $member->email,
                    'total' => $yearlyIncome->sum(),
                    'breakdown' => $yearlyIncome,
                ];
            })
            ->filter(fn($m) => $m['total'] > 0)
            ->sortBy('full_name')
            ->values();

        $yearlyStats = [
            'total_members' => $members->count(),
            'total_giving' => $members->sum('total'),
            'year' => $year,
        ];

        return view('panel.statements.index', compact('members', 'yearlyStats', 'year'));
    }

    public function show($memberId, Request $request)
    {
        $year = $request->year ?? date('Y');
        $member = Member::with(['incomes.category'])->findOrFail($memberId);

        $yearlyContributions = $member->incomes()
            ->whereYear('collection_date', $year)
            ->with('category')
            ->orderBy('collection_date')
            ->get();

        $byCategory = $yearlyContributions->groupBy(fn($i) => $i->category->name ?? 'Nyingine')
            ->map(fn($group) => [
                'total' => $group->sum('amount'),
                'count' => $group->count(),
                'items' => $group,
            ]);

        $totalGiving = $yearlyContributions->sum('amount');

        return view('panel.statements.show', compact('member', 'yearlyContributions', 'byCategory', 'totalGiving', 'year'));
    }

    public function printStatement($memberId, Request $request)
    {
        $year = $request->year ?? date('Y');
        $member = Member::with(['incomes.category'])->findOrFail($memberId);

        $yearlyContributions = $member->incomes()
            ->whereYear('collection_date', $year)
            ->with('category')
            ->orderBy('collection_date')
            ->get();

        $byCategory = $yearlyContributions->groupBy(fn($i) => $i->category->name ?? 'Nyingine')
            ->map(fn($group) => [
                'total' => $group->sum('amount'),
                'count' => $group->count(),
                'items' => $group,
            ]);

        $totalGiving = $yearlyContributions->sum('amount');

        return view('panel.statements.print', compact('member', 'yearlyContributions', 'byCategory', 'totalGiving', 'year'));
    }

    public function bulkPrint(Request $request)
    {
        $year = $request->year ?? date('Y');
        $memberIds = $request->member_ids ?? Member::active()->pluck('id')->toArray();

        $members = Member::whereIn('id', $memberIds)
            ->with(['incomes.category'])
            ->get()
            ->map(function ($member) use ($year) {
                $contributions = $member->incomes()
                    ->whereYear('collection_date', $year)
                    ->with('category')
                    ->orderBy('collection_date')
                    ->get();

                $byCategory = $contributions->groupBy(fn($i) => $i->category->name ?? 'Nyingine')
                    ->map(fn($group) => [
                        'total' => $group->sum('amount'),
                        'count' => $group->count(),
                        'items' => $group,
                    ]);

                return [
                    'member' => $member,
                    'contributions' => $contributions,
                    'byCategory' => $byCategory,
                    'total' => $contributions->sum('amount'),
                ];
            });

        return view('panel.statements.bulk-print', compact('members', 'year'));
    }
}
