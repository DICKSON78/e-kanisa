<?php

namespace App\Http\Controllers;

use App\Models\OnlineTransaction;
use App\Models\Member;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class OnlineGivingController extends Controller
{
    public function index(Request $request)
    {
        $query = OnlineTransaction::with('member');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($mq) => $mq->where('full_name', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $stats = [
            'total' => OnlineTransaction::count(),
            'completed' => OnlineTransaction::completed()->sum('amount'),
            'pending' => OnlineTransaction::pending()->count(),
            'today' => OnlineTransaction::whereDate('created_at', today())->sum('amount'),
        ];

        if ($request->ajax()) {
            return view('panel.online-giving._table', compact('transactions'));
        }

        return view('panel.online-giving.index', compact('transactions', 'stats'));
    }

    public function create()
    {
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        $categories = IncomeCategory::active()->orderBy('name')->get();

        return view('panel.online-giving.create', compact('members', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:M-Pesa,Tigo Pesa,Airtel Money,Bank Transfer',
            'reference_number' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'purpose' => 'required|in:Sadaka,Ahadi,Kodi ya Kiwanja,Nyingine',
            'income_category_id' => 'nullable|exists:income_categories,id',
            'description' => 'nullable|string|max:500',
        ], [
            'member_id.required' => 'Tafadhali chagua muumini',
            'amount.required' => 'Tafadhali ingiza kiasi',
            'amount.min' => 'Kiasi kidogo ni TZS 100',
            'payment_method.required' => 'Tafadhali chagua njia ya malipo',
            'reference_number.required' => 'Tafadhali ingiza nambari ya rejea',
            'phone_number.required' => 'Tafadhali ingiza nambari ya simu',
            'purpose.required' => 'Tafadhali chagua lengo la malipo',
        ]);

        $validated['recorded_by'] = auth()->id();
        $validated['status'] = 'Inasubiri';

        OnlineTransaction::create($validated);

        return redirect()->route('online-giving.index')
            ->with('success', 'Malipo yamerekodwa na yanasubiri uthibitisho');
    }

    public function show($id)
    {
        $transaction = OnlineTransaction::with(['member', 'recorder'])->findOrFail($id);
        return view('panel.online-giving.show', compact('transaction'));
    }

    public function approve($id)
    {
        $transaction = OnlineTransaction::findOrFail($id);

        if ($transaction->status !== 'Inasubiri') {
            return redirect()->back()->with('error', 'Malipo haya hayawezi kuthibitishwa');
        }

        $transaction->update([
            'status' => 'Imekamilika',
            'processed_at' => now(),
        ]);

        // Create income record
        $incomeCategory = null;
        if ($transaction->income_category_id) {
            $incomeCategory = $transaction->income_category_id;
        } else {
            // Auto-assign based on purpose
            $purposeMap = [
                'Sadaka' => 'Sadaka',
                'Ahadi' => 'Ahadi',
                'Kodi ya Kiwanja' => 'Kodi ya Kiwanja',
            ];
            if (isset($purposeMap[$transaction->purpose])) {
                $cat = \App\Models\IncomeCategory::where('name', 'like', "%{$purposeMap[$transaction->purpose]}%")->first();
                $incomeCategory = $cat?->id;
            }
        }

        \App\Models\Income::create([
            'income_category_id' => $incomeCategory,
            'collection_date' => $transaction->created_at->toDateString(),
            'amount' => $transaction->amount,
            'notes' => "Malipo ya Mtandaoni: {$transaction->transaction_number} - {$transaction->payment_method} - {$transaction->reference_number}",
            'member_id' => $transaction->member_id,
            'receipt_number' => $transaction->transaction_number,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Malipo yamethibitishwa na mapato yameongezwa');
    }

    public function reject($id)
    {
        $transaction = OnlineTransaction::findOrFail($id);

        if ($transaction->status !== 'Inasubiri') {
            return redirect()->back()->with('error', 'Malipo haya hayawezi kukataliwa');
        }

        $transaction->update([
            'status' => 'Imeshindwa',
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Malipo yamekataliwa');
    }

    public function callback(Request $request)
    {
        // M-Pesa / Tigo Pesa callback endpoint
        // This would be called by the payment gateway
        $validated = $request->validate([
            'transaction_number' => 'required|string',
            'status' => 'required|string',
            'reference_number' => 'nullable|string',
        ]);

        $transaction = OnlineTransaction::where('transaction_number', $validated['transaction_number'])->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($validated['status'] === 'completed') {
            $transaction->update([
                'status' => 'Imekamilika',
                'processed_at' => now(),
                'metadata' => array_merge($transaction->metadata ?? [], $request->all()),
            ]);
        } else {
            $transaction->update([
                'status' => 'Imeshindwa',
                'processed_at' => now(),
                'metadata' => array_merge($transaction->metadata ?? [], $request->all()),
            ]);
        }

        return response()->json(['success' => true]);
    }
}
