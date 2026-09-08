<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    // ========== CHART OF ACCOUNTS ==========
    public function chartOfAccounts(Request $request)
    {
        $query = Account::with('parent');

        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('account_code', 'like', "%{$request->search}%");
            });
        }

        $accounts = $query->orderBy('account_code')->paginate(30);

        $summary = [
            'total_assets' => Account::where('type', 'Asset')->sum('current_balance'),
            'total_liabilities' => Account::where('type', 'Liability')->sum('current_balance'),
            'total_equity' => Account::where('type', 'Equity')->sum('current_balance'),
            'total_revenue' => Account::where('type', 'Revenue')->sum('current_balance'),
            'total_expenses' => Account::where('type', 'Expense')->sum('current_balance'),
        ];

        return view('panel.accounting.chart-of-accounts', compact('accounts', 'summary'));
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'account_code' => 'required|string|unique:accounts,account_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:Asset,Liability,Equity,Revenue,Expense',
            'sub_type' => 'nullable|string|max:100',
            'opening_balance' => 'nullable|numeric|min:0',
            'parent_account_id' => 'nullable|exists:accounts,id',
        ]);

        $validated['current_balance'] = $validated['opening_balance'] ?? 0;

        Account::create($validated);

        return redirect()->back()->with('success', 'Akaunti imeundwa');
    }

    public function updateAccount(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $account->update($validated);
        return redirect()->back()->with('success', 'Akaunti imesasishwa');
    }

    // ========== JOURNAL ENTRIES ==========
    public function journalEntries(Request $request)
    {
        $query = JournalEntry::with('lines.account');

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date_from')) $query->where('entry_date', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->where('entry_date', '<=', $request->date_to);

        $entries = $query->orderBy('entry_date', 'desc')->paginate(15);

        $accounts = Account::active()->orderBy('account_code')->get();

        if ($request->ajax()) {
            return view('panel.accounting._entries-table', compact('entries'));
        }

        return view('panel.accounting.journal-entries', compact('entries', 'accounts'));
    }

    public function createJournalEntry()
    {
        $accounts = Account::active()->orderBy('account_code')->get();
        return view('panel.accounting.create-journal-entry', compact('accounts'));
    }

    public function storeJournalEntry(Request $request)
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'description' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'lines' => 'required|array|min:2',
            'lines.*.account_id' => 'required|exists:accounts,id',
            'lines.*.debit' => 'nullable|numeric|min:0',
            'lines.*.credit' => 'nullable|numeric|min:0',
            'lines.*.line_description' => 'nullable|string|max:255',
        ]);

        $totalDebit = collect($validated['lines'])->sum('debit');
        $totalCredit = collect($validated['lines'])->sum('credit');

        if (abs($totalDebit - $totalCredit) > 0.01) {
            return redirect()->back()->withInput()->with('error', 'Debit na Credit lazima zilingane. Debit: ' . number_format($totalDebit) . ', Credit: ' . number_format($totalCredit));
        }

        $entry = JournalEntry::create([
            'entry_date' => $validated['entry_date'],
            'description' => $validated['description'],
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'status' => 'Draft',
            'created_by' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['lines'] as $line) {
            if (($line['debit'] ?? 0) > 0 || ($line['credit'] ?? 0) > 0) {
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $line['account_id'],
                    'debit' => $line['debit'] ?? 0,
                    'credit' => $line['credit'] ?? 0,
                    'description' => $line['line_description'] ?? null,
                ]);
            }
        }

        return redirect()->route('accounting.journal.show', $entry->id)
            ->with('success', 'Journal entry imeundwa: ' . $entry->entry_number);
    }

    public function showJournalEntry($id)
    {
        $entry = JournalEntry::with('lines.account', 'creator', 'poster')->findOrFail($id);
        return view('panel.accounting.show-journal-entry', compact('entry'));
    }

    public function postJournalEntry($id)
    {
        $entry = JournalEntry::findOrFail($id);

        if ($entry->status !== 'Draft') {
            return redirect()->back()->with('error', 'Entry hii tayari imeshatolewa');
        }

        try {
            $entry->post(auth()->user());
            return redirect()->back()->with('success', 'Entry imetolewa kikamilifu. Akaunti zimesasishwa.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hitilafu: ' . $e->getMessage());
        }
    }

    public function voidJournalEntry($id)
    {
        $entry = JournalEntry::findOrFail($id);

        if ($entry->status !== 'Posted') {
            return redirect()->back()->with('error', 'Entry hii haiwezi kufutwa');
        }

        DB::transaction(function () use ($entry) {
            // Reverse the entries
            foreach ($entry->lines as $line) {
                $account = $line->account;
                if ($line->debit > 0) {
                    $account->decrement('current_balance', $line->debit);
                } else {
                    $account->increment('current_balance', $line->credit);
                }

                AccountTransaction::create([
                    'account_id' => $line->account_id,
                    'journal_entry_id' => $entry->id,
                    'transaction_date' => now(),
                    'debit' => $line->credit,
                    'credit' => $line->debit,
                    'balance' => $account->current_balance,
                    'description' => 'VOID: ' . ($line->description ?? $entry->description),
                ]);
            }

            $entry->update(['status' => 'Voided']);
        });

        return redirect()->back()->with('success', 'Entry imefutwa');
    }

    // ========== REPORTS ==========
    public function trialBalance(Request $request)
    {
        $asOfDate = $request->date ?? date('Y-m-d');
        $accounts = Account::active()->where('current_balance', '!=', 0)->orderBy('account_code')->get();

        $totalDebit = $accounts->where('type', 'Asset')->sum('current_balance')
            + $accounts->where('type', 'Expense')->sum('current_balance');
        $totalCredit = $accounts->where('type', 'Liability')->sum('current_balance')
            + $accounts->where('type', 'Equity')->sum('current_balance')
            + $accounts->where('type', 'Revenue')->sum('current_balance');

        return view('panel.accounting.trial-balance', compact('accounts', 'totalDebit', 'totalCredit', 'asOfDate'));
    }

    public function balanceSheet(Request $request)
    {
        $asOfDate = $request->date ?? date('Y-m-d');
        $assets = Account::where('type', 'Asset')->where('current_balance', '!=', 0)->orderBy('account_code')->get();
        $liabilities = Account::where('type', 'Liability')->where('current_balance', '!=', 0)->orderBy('account_code')->get();
        $equity = Account::where('type', 'Equity')->where('current_balance', '!=', 0)->orderBy('account_code')->get();

        return view('panel.accounting.balance-sheet', compact('assets', 'liabilities', 'equity', 'asOfDate'));
    }

    public function incomeStatement(Request $request)
    {
        $dateFrom = $request->date_from ?? date('Y-01-01');
        $dateTo = $request->date_to ?? date('Y-m-d');

        $revenue = Account::where('type', 'Revenue')->where('current_balance', '!=', 0)->orderBy('account_code')->get();
        $expenses = Account::where('type', 'Expense')->where('current_balance', '!=', 0)->orderBy('account_code')->get();

        $totalRevenue = $revenue->sum('current_balance');
        $totalExpenses = $expenses->sum('current_balance');
        $netIncome = $totalRevenue - $totalExpenses;

        return view('panel.accounting.income-statement', compact('revenue', 'expenses', 'totalRevenue', 'totalExpenses', 'netIncome', 'dateFrom', 'dateTo'));
    }

    public function accountLedger($id, Request $request)
    {
        $account = Account::findOrFail($id);
        $transactions = AccountTransaction::where('account_id', $id)
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        return view('panel.accounting.account-ledger', compact('account', 'transactions'));
    }
}
