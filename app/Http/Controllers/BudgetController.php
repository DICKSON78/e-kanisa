<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');

        $query = Budget::with('category')->where('year', $year);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $budgets = $query->orderBy('month')->orderBy('budget_number')->paginate(15);

        // Stats
        $stats = [
            'total_budget' => Budget::where('year', $year)->sum('budgeted_amount'),
            'total_actual' => Budget::where('year', $year)->sum('actual_amount'),
            'remaining' => Budget::where('year', $year)->sum('budgeted_amount') - Budget::where('year', $year)->sum('actual_amount'),
            'budget_count' => Budget::where('year', $year)->count(),
        ];

        // Monthly breakdown
        $monthlyBreakdown = Budget::where('year', $year)
            ->selectRaw('month, SUM(budgeted_amount) as budgeted, SUM(actual_amount) as actual')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $categories = ExpenseCategory::active()->orderBy('name')->get();

        if ($request->ajax()) {
            return view('panel.budgets._table', compact('budgets', 'stats'));
        }

        return view('panel.budgets.index', compact('budgets', 'stats', 'year', 'monthlyBreakdown', 'categories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get();
        return view('panel.budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'budgeted_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Tafadhali ingiza jina la bajeti',
            'year.required' => 'Tafadhali ingiza mwaka',
            'year.min' => 'Mwaka lazima uwe 2020 au baadaye',
            'budgeted_amount.required' => 'Tafadhali ingiza kiasi kilichopangwa',
            'budgeted_amount.min' => 'Kiasi lazima kiwe chanya',
            'expense_category_id.exists' => 'Kundi la matumizi halipo',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['actual_amount'] = Budget::where('year', $validated['year'])
            ->where('month', $validated['month'] ?? null)
            ->where('expense_category_id', $validated['expense_category_id'] ?? null)
            ->sum('actual_amount');

        Budget::create($validated);

        return redirect()->route('budgets.index', ['year' => $validated['year']])
            ->with('success', 'Bajeti imeundwa kikamilifu');
    }

    public function show($id)
    {
        $budget = Budget::with(['category', 'creator'])->findOrFail($id);

        // Get actual expenses for this budget period
        $expenses = Expense::where('year', $budget->year)
            ->when($budget->month, fn($q) => $q->where('month', $budget->month))
            ->when($budget->expense_category_id, fn($q) => $q->where('expense_category_id', $budget->expense_category_id))
            ->with('category')
            ->orderBy('expense_date', 'desc')
            ->get();

        $totalActual = $expenses->sum('amount');

        return view('panel.budgets.show', compact('budget', 'expenses', 'totalActual'));
    }

    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = ExpenseCategory::active()->orderBy('name')->get();

        return view('panel.budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'budgeted_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Completed,Cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['updated_by'] = auth()->id();

        $budget->update($validated);

        return redirect()->route('budgets.show', $budget->id)
            ->with('success', 'Bajeti imesasishwa kikamilifu');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Bajeti imefutwa');
    }

    public function updateActualAmounts(Request $request)
    {
        $year = $request->year ?? date('Y');

        $budgets = Budget::where('year', $year)->get();

        foreach ($budgets as $budget) {
            $actual = Expense::where('year', $budget->year)
                ->when($budget->month, fn($q) => $q->where('month', $budget->month))
                ->when($budget->expense_category_id, fn($q) => $q->where('expense_category_id', $budget->expense_category_id))
                ->sum('amount');

            $budget->update(['actual_amount' => $actual]);
        }

        return redirect()->back()->with('success', 'Kiasi halisi kimerejeshwa');
    }
}
