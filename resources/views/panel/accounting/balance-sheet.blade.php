@extends('layouts.app')

@section('title', 'Ripoti ya Hali ya Fedha - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.journal.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">Ripoti ya Hali ya Fedha</h1>
            <p class="text-sm text-gray-500">Hali ya fedha kama tarehe {{ \Carbon\Carbon::parse($asOfDate)->format('d/m/Y') }}</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button onclick="window.print()" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-print"></i> Chapisha
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4">
        <form method="GET" action="{{ route('accounting.balance-sheet') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe</label>
                <input type="date" name="as_at" value="{{ $asOfDate }}" class="rx-input rx-input-no-icon">
            </div>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-search"></i> Tafuta
            </button>
        </form>
    </div>

    <!-- Balance Sheet Content -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-file-invoice-dollar text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-900">Ripoti ya Hali ya Fedha - {{ \Carbon\Carbon::parse($asOfDate)->format('d/m/Y') }}</h3>
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
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-calculator text-xs" style="color: #efc120"></i>
                                <span>Kiasi</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ASSETS SECTION -->
                    <tr class="bg-green-50/80">
                        <td colspan="3" class="py-3 px-6">
                            <span class="text-xs font-bold text-green-700 uppercase tracking-wider">
                                <i class="fas fa-university mr-1"></i> MALI (Assets)
                            </span>
                        </td>
                    </tr>
                    @forelse($assets as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900 pl-4">{{ $account->name }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->balance, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 px-6 text-sm text-gray-400 text-center">Hakuna hesabu za mali</td>
                    </tr>
                    @endforelse
                    <tr class="bg-green-100/60 border-t-2 border-green-200">
                        <td colspan="2" class="py-3 px-6 text-sm font-bold text-green-800">JUMLA YA MALI</td>
                        <td class="py-3 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-green-700">{{ number_format($totals['assets'] ?? 0, 2) }}</span>
                        </td>
                    </tr>

                    <!-- LIABILITIES SECTION -->
                    <tr class="bg-red-50/80">
                        <td colspan="3" class="py-3 px-6 mt-4">
                            <span class="text-xs font-bold text-red-700 uppercase tracking-wider">
                                <i class="fas fa-file-invoice-dollar mr-1"></i> DENI (Liabilities)
                            </span>
                        </td>
                    </tr>
                    @forelse($liabilities as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900 pl-4">{{ $account->name }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->balance, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 px-6 text-sm text-gray-400 text-center">Hakuna deni</td>
                    </tr>
                    @endforelse
                    <tr class="bg-red-100/60 border-t-2 border-red-200">
                        <td colspan="2" class="py-3 px-6 text-sm font-bold text-red-800">JUMLA YA DENI</td>
                        <td class="py-3 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-red-700">{{ number_format($totals['liabilities'] ?? 0, 2) }}</span>
                        </td>
                    </tr>

                    <!-- EQUITY SECTION -->
                    <tr class="bg-blue-50/80">
                        <td colspan="3" class="py-3 px-6 mt-4">
                            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">
                                <i class="fas fa-balance-scale mr-1"></i> HISA (Equity)
                            </span>
                        </td>
                    </tr>
                    @forelse($equity as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <span class="text-sm font-medium text-gray-900 pl-4">{{ $account->name }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->balance, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 px-6 text-sm text-gray-400 text-center">Hakuna hesabu za hisa</td>
                    </tr>
                    @endforelse
                    <tr class="bg-blue-100/60 border-t-2 border-blue-200">
                        <td colspan="2" class="py-3 px-6 text-sm font-bold text-blue-800">JUMLA YA HISA</td>
                        <td class="py-3 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-blue-700">{{ number_format($totals['equity'] ?? 0, 2) }}</span>
                        </td>
                    </tr>

                    <!-- GRAND TOTALS -->
                    <tr class="border-t-2 border-gray-300 bg-gray-100/80 font-bold">
                        <td colspan="2" class="py-4 px-6 text-sm text-gray-900">JUMLA DENI + HISA</td>
                        <td class="py-4 px-6 text-right">
                            <span class="text-sm font-mono font-bold text-gray-900">{{ number_format(($totals['liabilities'] ?? 0) + ($totals['equity'] ?? 0), 2) }}</span>
                        </td>
                    </tr>
                    <tr class="bg-gray-200/80 font-bold border-t-4 border-gray-400">
                        <td colspan="2" class="py-4 px-6 text-base text-gray-900">JUMLA YA MALI</td>
                        <td class="py-4 px-6 text-right">
                            <span class="text-base font-mono font-bold" style="color: #360958">{{ number_format($totals['assets'] ?? 0, 2) }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if(($totals['assets'] ?? 0) == (($totals['liabilities'] ?? 0) + ($totals['equity'] ?? 0)))
        <div class="px-6 py-3 bg-green-50 border-t border-green-200 text-sm text-green-700 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> Ripoti iko sawa. Mali = Deni + Hisa
        </div>
        @else
        <div class="px-6 py-3 bg-red-50 border-t border-red-200 text-sm text-red-700 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i> Ripoti haipo sawa. Tofauti: {{ number_format(abs(($totals['assets'] ?? 0) - (($totals['liabilities'] ?? 0) + ($totals['equity'] ?? 0))), 2) }}
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
