@extends('layouts.app')

@section('title', 'Mizani ya Majaribio - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.journal.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-balance-scale" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">Mizani ya Majaribio</h1>
            <p class="text-sm text-gray-500">Mizani ya majaribio kama tarehe {{ \Carbon\Carbon::parse($asOfDate)->format('d/m/Y') }}</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button onclick="window.print()" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-print"></i> Chapisha
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4">
        <form method="GET" action="{{ route('accounting.trial-balance') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Mizani</label>
                <input type="date" name="as_at" value="{{ $asOfDate }}" class="rx-input rx-input-no-icon">
            </div>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-search"></i> Tafuta
            </button>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Jumla ya Debit -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Debit</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($totals['debit'] ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-arrow-up" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Jumla ya Mikopo -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Mikopo</p>
                    <p class="text-2xl font-bold" style="color: #ef4444">{{ number_format($totals['credit'] ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-arrow-down" style="color: #ef4444"></i>
                </div>
            </div>
        </div>

        <!-- Tofauti -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Tofauti</p>
                    @php $diff = abs(($totals['debit'] ?? 0) - ($totals['credit'] ?? 0)); @endphp
                    <p class="text-2xl font-bold {{ ($totals['debit'] ?? 0) == ($totals['credit'] ?? 0) ? '' : 'text-red-600' }}" style="{{ ($totals['debit'] ?? 0) == ($totals['credit'] ?? 0) ? 'color: #16a34a' : '' }}">
                        {{ number_format($diff, 2) }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: {{ ($totals['debit'] ?? 0) == ($totals['credit'] ?? 0) ? 'rgba(22,163,74,0.1)' : 'rgba(239,68,68,0.1)' }}">
                    <i class="fas fa-{{ ($totals['debit'] ?? 0) == ($totals['credit'] ?? 0) ? 'check-circle' : 'exclamation-triangle' }}" style="color: {{ ($totals['debit'] ?? 0) == ($totals['credit'] ?? 0) ? '#16a34a' : '#ef4444' }}"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Trial Balance Content -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-balance-scale text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-900">Mizani ya Majaribio - {{ \Carbon\Carbon::parse($asOfDate)->format('d/m/Y') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Nambari</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Jina la Hesabu</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-layer-group text-xs" style="color: #efc120"></i>
                                <span>Aina</span>
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
                    </tr>
                </thead>
                <tbody>
                    @php
                        $debitAccounts = $accounts->filter(fn($a) => in_array($a->type, ['Asset', 'Expense']));
                        $creditAccounts = $accounts->filter(fn($a) => in_array($a->type, ['Liability', 'Equity', 'Revenue']));
                    @endphp

                    @if($debitAccounts->isNotEmpty())
                    <!-- Assets & Expenses (Debit balance) -->
                    <tr class="bg-gray-50/80">
                        <td colspan="5" class="py-2 px-6">
                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-arrow-up mr-1" style="color: #16a34a"></i>
                                MALI NA GHARAMA (Debit)
                            </span>
                        </td>
                    </tr>
                    @foreach($debitAccounts as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $account->name }}</span>
                        </td>
                        <td>
                            @php
                                $typeBadge = match($account->type) {
                                    'Asset' => 'rx-badge-green',
                                    'Expense' => 'rx-badge-gold',
                                    default => 'rx-badge'
                                };
                                $typeLabel = match($account->type) {
                                    'Asset' => 'Mali',
                                    'Expense' => 'Gharama',
                                    default => $account->type
                                };
                            @endphp
                            <span class="rx-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
                        </td>
                        <td class="text-right">
                            @if($account->debit_balance > 0)
                                <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->debit_balance, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($account->credit_balance > 0)
                                <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->credit_balance, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif

                    @if($creditAccounts->isNotEmpty())
                    <!-- Liabilities, Equity & Revenue (Credit balance) -->
                    <tr class="bg-gray-50/80">
                        <td colspan="5" class="py-2 px-6">
                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-arrow-down mr-1" style="color: #ef4444"></i>
                                DENI, HISA NA MAPATO (Credit)
                            </span>
                        </td>
                    </tr>
                    @foreach($creditAccounts as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $account->name }}</span>
                        </td>
                        <td>
                            @php
                                $typeBadge = match($account->type) {
                                    'Liability' => 'rx-badge-red',
                                    'Equity' => 'rx-badge-blue',
                                    'Revenue' => 'rx-badge-green',
                                    default => 'rx-badge'
                                };
                                $typeLabel = match($account->type) {
                                    'Liability' => 'Deni',
                                    'Equity' => 'Hisa',
                                    'Revenue' => 'Mapato',
                                    default => $account->type
                                };
                            @endphp
                            <span class="rx-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
                        </td>
                        <td class="text-right">
                            @if($account->debit_balance > 0)
                                <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->debit_balance, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($account->credit_balance > 0)
                                <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->credit_balance, 2) }}</span>
                            @else
                                <span class="text-sm font-mono text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif

                    <!-- Totals Row -->
                    <tr class="border-t-2 border-gray-300 bg-gray-100/80 font-bold">
                        <td colspan="3" class="py-4 px-6 text-sm text-gray-900">JUMLA</td>
                        <td class="py-4 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-green-600">{{ number_format($totals['debit'] ?? 0, 2) }}</span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-red-600">{{ number_format($totals['credit'] ?? 0, 2) }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if(($totals['debit'] ?? 0) == ($totals['total_credit'] ?? 0))
        <div class="px-6 py-3 bg-green-50 border-t border-green-200 text-sm text-green-700 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> Mizani iko sawa. Debit na Mikopo ni sawa.
        </div>
        @else
        <div class="px-6 py-3 bg-red-50 border-t border-red-200 text-sm text-red-700 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i> Mizani haipo sawa. Tofauti: {{ number_format(abs(($totals['debit'] ?? 0) - ($totals['credit'] ?? 0)), 2) }}
        </div>
        @endif
    </div>
</div>

<style>
    @media print {
        .sidebar, .header, .rx-btn, .rx-card form { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; }
        .content-area { padding: 0 !important; }
        .rx-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
</style>
@endsection
