<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display expenses in monthly grid view
     */
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));

        return $this->monthlyView($year);
    }

    /**
     * Show monthly grid view for specific year
     */
    public function monthlyView($year)
    {
        // Get all active expense categories
        $categories = ExpenseCategory::active()->ordered()->get();

        // Month names in Swahili
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Machi', 4 => 'Aprili',
            5 => 'Mei', 6 => 'Juni', 7 => 'Julai', 8 => 'Agosti',
            9 => 'Septemba', 10 => 'Oktoba', 11 => 'Novemba', 12 => 'Desemba'
        ];

        // Get all expenses for the year grouped by category and month
        $expenses = Expense::where('year', $year)
            ->with('category')
            ->get()
            ->groupBy(function($expense) {
                return $expense->expense_category_id . '_' . $expense->month;
            });

        // Build grid data structure
        $gridData = [];
        $monthlyTotals = array_fill(1, 12, 0);

        foreach ($categories as $category) {
            $categoryRow = [
                'category' => $category,
                'months' => [],
                'total' => 0
            ];

            for ($month = 1; $month <= 12; $month++) {
                $key = $category->id . '_' . $month;
                $expense = $expenses->get($key)?->first();

                $amount = $expense ? $expense->amount : 0;
                $categoryRow['months'][$month] = [
                    'amount' => $amount,
                    'expense' => $expense
                ];
                $categoryRow['total'] += $amount;
                $monthlyTotals[$month] += $amount;
            }

            $gridData[] = $categoryRow;
        }

        $grandTotal = array_sum($monthlyTotals);

        // Get available years
        $years = Expense::selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        return view('panel.expenses.index', compact(
            'gridData',
            'months',
            'monthlyTotals',
            'grandTotal',
            'year',
            'years',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new expense
     */
    public function create(Request $request)
    {
        $categories = ExpenseCategory::active()->ordered()->get();

        // Pre-fill year and month if provided
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));

        return view('panel.expenses.create', compact('categories', 'year', 'month'));
    }

    /**
     * Store a newly created expense in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'amount' => 'required|numeric|min:0|max:999999999999.99',
            'payee' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ], [
            'expense_category_id.required' => 'Tafadhali chagua kategoria ya matumizi',
            'expense_category_id.exists' => 'Kategoria iliyochaguliwa haipo',
            'year.required' => 'Tafadhali ingiza mwaka',
            'year.integer' => 'Mwaka lazima uwe nambari',
            'year.min' => 'Mwaka si sahihi',
            'year.max' => 'Mwaka si sahihi',
            'month.required' => 'Tafadhali chagua mwezi',
            'month.integer' => 'Mwezi si sahihi',
            'month.min' => 'Mwezi si sahihi',
            'month.max' => 'Mwezi si sahihi',
            'amount.required' => 'Tafadhali ingiza kiasi',
            'amount.numeric' => 'Kiasi lazima kiwe nambari',
            'amount.min' => 'Kiasi lazima kiwe chanya',
            'amount.max' => 'Kiasi ni kubwa mno',
            'payee.max' => 'Jina la mpokeaji ni refu mno',
            'receipt_number.max' => 'Nambari ya risiti ni ndefu mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        // Check for unique constraint (one expense per category per month)
        $exists = Expense::where('expense_category_id', $validated['expense_category_id'])
            ->where('year', $validated['year'])
            ->where('month', $validated['month'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Matumizi ya kategoria hii kwa mwezi huu tayari yamerekodiwa. Tafadhali hariri rekodi iliyopo.')
                ->withInput();
        }

        $validated['created_by'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('expenses.index', ['year' => $validated['year']])
            ->with('success', 'Matumizi yamerekodiwa kikamilifu');
    }

    /**
     * Display the specified expense
     */
    public function show($id)
    {
        $expense = Expense::with(['category', 'creator', 'updater'])->findOrFail($id);

        return view('panel.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $categories = ExpenseCategory::active()->ordered()->get();

        return view('panel.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified expense in storage
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'amount' => 'required|numeric|min:0|max:999999999999.99',
            'payee' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ], [
            'expense_category_id.required' => 'Tafadhali chagua kategoria ya matumizi',
            'expense_category_id.exists' => 'Kategoria iliyochaguliwa haipo',
            'year.required' => 'Tafadhali ingiza mwaka',
            'year.integer' => 'Mwaka lazima uwe nambari',
            'year.min' => 'Mwaka si sahihi',
            'year.max' => 'Mwaka si sahihi',
            'month.required' => 'Tafadhali chagua mwezi',
            'month.integer' => 'Mwezi si sahihi',
            'month.min' => 'Mwezi si sahihi',
            'month.max' => 'Mwezi si sahihi',
            'amount.required' => 'Tafadhali ingiza kiasi',
            'amount.numeric' => 'Kiasi lazima kiwe nambari',
            'amount.min' => 'Kiasi lazima kiwe chanya',
            'amount.max' => 'Kiasi ni kubwa mno',
            'payee.max' => 'Jina la mpokeaji ni refu mno',
            'receipt_number.max' => 'Nambari ya risiti ni ndefu mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        // Check for unique constraint (excluding current record)
        $exists = Expense::where('expense_category_id', $validated['expense_category_id'])
            ->where('year', $validated['year'])
            ->where('month', $validated['month'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Matumizi ya kategoria hii kwa mwezi huu tayari yamerekodiwa.')
                ->withInput();
        }

        $validated['updated_by'] = Auth::id();

        $expense->update($validated);

        return redirect()->route('expenses.index', ['year' => $validated['year']])
            ->with('success', 'Matumizi yamebadilishwa kikamilifu');
    }

    /**
     * Remove the specified expense from storage (soft delete)
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $year = $expense->year;
        $expense->delete();

        return redirect()->route('expenses.index', ['year' => $year])
            ->with('success', 'Matumizi yamefutwa kikamilifu');
    }
}
