@extends('layouts.app')

@section('title', 'Ripoti ya Mapato na Gharama - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.journal.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-chart-line" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">Ripoti ya Mapato na Gharama</h1>
            <p class="text-sm text-gray-500">Ripoti ya mapato na gharama kwa kipindi</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4">
        <form method="GET" action="{{ route('accounting.income-statement') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Kuanzia</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="rx-input rx-input-no-icon">
            </div>
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Kumalizia</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="rx-input rx-input-no-icon">
            </div>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-search"></i> Tafuta
            </button>
            <button type="button" onclick="window.print()" class="rx-btn rx-btn-secondary">
                <i class="fas fa-print"></i> Chapisha
            </button>
        </form>
    </div>

    <!-- Revenue Section -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-arrow-up text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Mapato</h3>
                <p class="text-xs text-gray-500">Mapato yote kwa kipindi hiki</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if($revenue->isNotEmpty())
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Nambari ya Hesabu</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Jina</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-calculator text-xs" style="color: #efc120"></i>
                                <span>Kiasi</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revenue as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $account->name }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-green-600">{{ number_format($account->current_balance, 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50 border-t-2 border-gray-300 font-bold">
                        <td colspan="2" class="py-3 px-6 text-sm text-gray-900">Jumla ya Mapato</td>
                        <td class="py-3 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-green-700">{{ number_format($totalRevenue, 2) }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="rx-empty">
                <div class="rx-empty-icon">
                    <i class="fas fa-arrow-up text-gray-300 text-2xl"></i>
                </div>
                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna mapato katika kipindi hiki</p>
                <p class="text-xs text-gray-400">Mapato hayajapatikana kwa kipindi ulichochagua.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Expenses Section -->
    <div class="rx-card rounded-2xl overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-arrow-down text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Gharama</h3>
                <p class="text-xs text-gray-500">Gharama zote kwa kipindi hiki</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if($expenses->isNotEmpty())
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Nambari ya Hesabu</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Jina</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-calculator text-xs" style="color: #efc120"></i>
                                <span>Kiasi</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $account->name }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-red-600">{{ number_format($account->current_balance, 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50 border-t-2 border-gray-300 font-bold">
                        <td colspan="2" class="py-3 px-6 text-sm text-gray-900">Jumla ya Gharama</td>
                        <td class="py-3 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-red-700">{{ number_format($totalExpenses, 2) }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="rx-empty">
                <div class="rx-empty-icon">
                    <i class="fas fa-arrow-down text-gray-300 text-2xl"></i>
                </div>
                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna gharama katika kipindi hiki</p>
                <p class="text-xs text-gray-400">Gharama hazijapatikana kwa kipindi ulichochagua.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Net Income Summary -->
    <div class="rx-card rounded-2xl overflow-hidden mt-6">
        <div class="p-8">
            <div class="text-center">
                @if($netIncome >= 0)
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-arrow-up text-2xl" style="color: #16a34a"></i>
                </div>
                @else
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-arrow-down text-2xl" style="color: #ef4444"></i>
                </div>
                @endif
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Mapato Halisi</p>
                <p class="text-4xl font-bold mb-2" style="color: {{ $netIncome >= 0 ? '#16a34a' : '#ef4444' }}">
                    {{ number_format($netIncome, 2) }}
                </p>
                @if($netIncome >= 0)
                <span class="rx-badge rx-badge-green text-sm">
                    <i class="fas fa-check-circle mr-1"></i> Faida
                </span>
                @else
                <span class="rx-badge rx-badge-danger text-sm">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Hasara
                </span>
                @endif
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        <span class="font-mono">{{ number_format($totalRevenue, 2) }}</span>
                        <span class="mx-2 text-gray-400">-</span>
                        <span class="font-mono">{{ number_format($totalExpenses, 2) }}</span>
                        <span class="mx-2 text-gray-400">=</span>
                        <span class="font-mono font-bold" style="color: {{ $netIncome >= 0 ? '#16a34a' : '#ef4444' }}">{{ number_format($netIncome, 2) }}</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Mapato - Gharama = Mapato Halisi</p>
                </div>
            </div>
        </div>
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
