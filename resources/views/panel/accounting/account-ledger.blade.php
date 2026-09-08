@extends('layouts.app')

@section('title', $account->name . ' - Kitabu cha Hesabu - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.chart-of-accounts') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-history" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">{{ $account->name }}</h1>
            <p class="text-sm text-gray-500">{{ $account->account_code }}</p>
        </div>
    </div>

    <!-- Quick Info Bar -->
    <div class="rx-card rounded-2xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-layer-group text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Aina</p>
                @php
                    $typeBadge = match($account->type) {
                        'Asset' => 'rx-badge-success',
                        'Liability' => 'rx-badge-danger',
                        'Equity' => 'rx-badge-info',
                        'Revenue' => 'rx-badge-success',
                        'Expense' => 'rx-badge-warning',
                        default => 'rx-badge-default'
                    };
                    $typeLabel = match($account->type) {
                        'Asset' => 'Mali',
                        'Liability' => 'Deni',
                        'Equity' => 'Hisa',
                        'Revenue' => 'Mapato',
                        'Expense' => 'Gharama',
                        default => $account->type
                    };
                @endphp
                <span class="rx-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-folder text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Aina Ndogo</p>
                <span class="rx-badge rx-badge-default">{{ $account->sub_type ?? '-' }}</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-door-open text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Salio la Kufungua</p>
                <p class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->opening_balance, 2) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-calculator text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Salio la Sasa</p>
                @php
                    $balanceColor = match($account->type) {
                        'Asset', 'Expense' => $account->current_balance >= 0 ? '#16a34a' : '#ef4444',
                        'Liability', 'Equity', 'Revenue' => $account->current_balance >= 0 ? '#16a34a' : '#ef4444',
                        default => '#111827'
                    };
                @endphp
                <p class="text-sm font-mono font-bold" style="color: {{ $balanceColor }}">{{ number_format($account->current_balance, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4">
        <form method="GET" action="{{ route('accounting.ledger', $account->id) }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Kuanzia</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rx-input rx-input-no-icon">
            </div>
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Kumalizia</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rx-input rx-input-no-icon">
            </div>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-search"></i> Tafuta
            </button>
            <button type="button" onclick="window.print()" class="rx-btn rx-btn-secondary">
                <i class="fas fa-print"></i> Chapisha
            </button>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-history text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-900">Historia ya Miamala</h3>
        </div>

        @if($transactions->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
                                <span>Tarehe</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-file-alt text-xs" style="color: #efc120"></i>
                                <span>Ingizo</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-align-left text-xs" style="color: #efc120"></i>
                                <span>Maelezo</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-arrow-up text-xs" style="color: #efc120"></i>
                                <span>Debit</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-arrow-down text-xs" style="color: #efc120"></i>
                                <span>Mikopo</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-calculator text-xs" style="color: #efc120"></i>
                                <span>Salio</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm text-gray-900">{{ $tx->transaction_date->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            @if($tx->journal)
                            <a href="{{ route('accounting.journal.show', $tx->journal_entry_id) }}" class="text-sm font-mono text-purple-700 hover:text-purple-900 hover:underline font-medium">
                                {{ $tx->journal->entry_number }}
                            </a>
                            @else
                            <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-sm text-gray-600">{{ $tx->description ?? '-' }}</span>
                        </td>
                        <td class="text-right">
                            @if($tx->debit > 0)
                                <span class="text-sm font-mono font-medium text-green-600">{{ number_format($tx->debit, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($tx->credit > 0)
                                <span class="text-sm font-mono font-medium text-red-600">{{ number_format($tx->credit, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @php
                                $balanceSignColor = $tx->balance >= 0 ? '#111827' : '#ef4444';
                            @endphp
                            <span class="text-sm font-mono font-semibold" style="color: {{ $balanceSignColor }}">{{ number_format($tx->balance, 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @endif

        @else
        <div class="rx-empty">
            <div class="rx-empty-icon">
                <i class="fas fa-history text-gray-300 text-2xl"></i>
            </div>
            <p class="text-sm font-medium text-gray-900 mb-1">Hakuna miamala katika hesabu hii</p>
            <p class="text-xs text-gray-400">Miamala haijapatikana kwa hesabu hii.</p>
        </div>
        @endif
    </div>
</div>

<style>
    @media print {
        .no-print, .sidebar, .header, .rx-btn { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; }
        .content-area { padding: 0 !important; }
        body { background: white !important; }
        .rx-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Basic form submission is handled by the form's default behavior
});
</script>
@endsection
