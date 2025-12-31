<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Event;
use App\Models\Request as RequestModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect regular members to their portal - they cannot access the main dashboard
        if (Auth::user()->isMwanachama()) {
            return redirect()->route('member.portal');
        }

        // Member statistics
        $totalMembers = Member::count();
        $activeMembers = Member::where('is_active', true)->count();
        $newMembersThisMonth = Member::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count();

        // Financial statistics for current month
        $currentMonth = Carbon::now();
        $monthlyIncome = Income::whereMonth('collection_date', $currentMonth->month)
                              ->whereYear('collection_date', $currentMonth->year)
                              ->sum('amount');

        $monthlyExpenses = Expense::where('year', $currentMonth->year)
                                 ->where('month', $currentMonth->month)
                                 ->sum('amount');

        // Year-to-date income
        $yearlyIncome = Income::whereYear('collection_date', $currentMonth->year)->sum('amount');

        // Upcoming events
        $upcomingEvents = Event::where('event_date', '>=', Carbon::today())
                               ->where('is_active', true)
                               ->orderBy('event_date', 'asc')
                               ->take(5)
                               ->get();

        // Pending requests
        $pendingRequests = RequestModel::where('status', 'Inasubiri')->count();
        $approvedRequests = RequestModel::where('status', 'Imeidhinishwa')->count();
        $totalRequests = RequestModel::count();

        // Last 6 months income for chart
        $monthlyIncomeData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyIncomeData[] = [
                'month' => $month->translatedFormat('M'),
                'amount' => Income::whereMonth('collection_date', $month->month)
                                 ->whereYear('collection_date', $month->year)
                                 ->sum('amount')
            ];
        }

        // Recent activities
        $recentIncomes = Income::with('category')
                              ->latest()
                              ->take(5)
                              ->get();

        $recentMembers = Member::latest()
                              ->take(5)
                              ->get();

        $recentEvents = Event::latest()
                            ->take(5)
                            ->get();

        return view('panel.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'newMembersThisMonth',
            'monthlyIncome',
            'monthlyExpenses',
            'yearlyIncome',
            'upcomingEvents',
            'pendingRequests',
            'approvedRequests',
            'totalRequests',
            'monthlyIncomeData',
            'recentIncomes',
            'recentMembers',
            'recentEvents'
        ));
    }

    // API endpoints for AJAX
    public function getStats()
    {
        return response()->json([
            'total_members' => Member::count(),
            'monthly_income' => Income::whereMonth('collection_date', Carbon::now()->month)->sum('amount'),
            'pending_requests' => RequestModel::where('status', 'Inasubiri')->count(),
            'approved_requests' => RequestModel::where('status', 'Imeidhinishwa')->count(),
            'rejected_requests' => RequestModel::where('status', 'Imekataliwa')->count(),
            'total_requests' => RequestModel::count(),
            'upcoming_events' => Event::where('event_date', '>=', Carbon::today())->count()
        ]);
    }

    public function getMonthlyIncome()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $data[] = [
                'month' => $month->translatedFormat('M'),
                'amount' => Income::whereMonth('collection_date', $month->month)
                                 ->whereYear('collection_date', $month->year)
                                 ->sum('amount')
            ];
        }
        return response()->json($data);
    }

    public function getRecentActivities()
    {
        $activities = [];

        // Recent income
        $incomes = Income::with('category')->latest()->take(3)->get();
        foreach ($incomes as $income) {
            $activities[] = [
                'type' => 'income',
                'message' => "Mapato ya {$income->category->name}: TZS " . number_format($income->amount, 2),
                'time' => $income->created_at->diffForHumans()
            ];
        }

        // Recent members
        $members = Member::latest()->take(2)->get();
        foreach ($members as $member) {
            $activities[] = [
                'type' => 'member',
                'message' => "Muumini mpya: {$member->full_name}",
                'time' => $member->created_at->diffForHumans()
            ];
        }

        return response()->json($activities);
    }

    public function getFilteredIncome(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $period = $request->get('period', 'last_6_months');

        $monthlyIncomeData = [];

        if ($period === 'last_6_months') {
            // Last 6 months from current date
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthlyIncomeData[] = [
                    'month' => $month->translatedFormat('M'),
                    'amount' => Income::whereMonth('collection_date', $month->month)
                                     ->whereYear('collection_date', $month->year)
                                     ->sum('amount')
                ];
            }
        } elseif ($period === 'this_year') {
            // Current year from January to current month
            $currentMonth = Carbon::now()->month;
            for ($i = 1; $i <= $currentMonth; $i++) {
                $month = Carbon::create($year, $i, 1);
                $monthlyIncomeData[] = [
                    'month' => $month->translatedFormat('M'),
                    'amount' => Income::whereMonth('collection_date', $i)
                                     ->whereYear('collection_date', $year)
                                     ->sum('amount')
                ];
            }
        } elseif ($period === 'custom_year') {
            // Full year (12 months) for selected year
            for ($i = 1; $i <= 12; $i++) {
                $month = Carbon::create($year, $i, 1);
                $monthlyIncomeData[] = [
                    'month' => $month->translatedFormat('M'),
                    'amount' => Income::whereMonth('collection_date', $i)
                                     ->whereYear('collection_date', $year)
                                     ->sum('amount')
                ];
            }
        }

        $total = collect($monthlyIncomeData)->sum('amount');

        return response()->json([
            'data' => $monthlyIncomeData,
            'total' => $total
        ]);
    }
}
