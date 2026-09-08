@extends('layouts.app')

@section('title', 'Risiti Zangu')
@section('page-title', 'Risiti Zangu')
@section('page-subtitle', 'Angalia na pakua risiti zako zote')

@section('content')
<div class="space-y-6">

    <!-- Back Button -->
    <a href="{{ route('member.portal') }}" class="rx-btn rx-btn-secondary w-fit">
        <i class="fas fa-arrow-left"></i>
        <span>Rudi Nyumbani</span>
    </a>

    <!-- Page Header -->
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-file-invoice" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Risiti Zangu</h1>
            <p class="text-sm text-gray-500">Angalia na pakua risiti zako zote</p>
        </div>
    </div>

    <!-- Receipts Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-file-invoice text-sm" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Orodha ya Risiti</h3>
                    <p class="text-sm text-gray-500">Risiti zote za malipo yako</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-0">
                <span class="rx-badge rx-badge-gold">{{ $payments->total() }} risiti</span>
            </div>
        </div>

        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="rx-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag mr-2 text-gray-400"></i>
                                    Namba ya Risiti
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    Tarehe
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-handshake mr-2 text-gray-400"></i>
                                    Ahadi
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                                    Kiasi
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-credit-card mr-2 text-gray-400"></i>
                                    Njia ya Malipo
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-2 text-gray-400"></i>
                                    Hatua
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                        </div>
                                        <span class="text-sm font-mono font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $payment->receipt_number }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-calendar-day text-xs" style="color: #efc120"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $payment->payment_date->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="rx-badge rx-badge-blue">{{ $payment->pledge->pledge_type }}</span>
                                </td>
                                <td>
                                    <span class="text-sm font-bold text-green-600">TZS {{ number_format($payment->amount, 0) }}</span>
                                </td>
                                <td>
                                    <span class="rx-badge rx-badge-gray">{{ $payment->payment_method ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('member.receipt.view', $payment->id) }}"
                                           class="rx-icon-btn rx-icon-btn-blue"
                                           title="Angalia Risiti">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('member.receipt.download', $payment->id) }}"
                                           class="rx-icon-btn rx-icon-btn-green"
                                           title="Pakua Risiti">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
            @endif
        @else
            <div class="rx-empty">
                <div class="rx-empty-icon">
                    <i class="fas fa-file-invoice text-gray-400 text-2xl"></i>
                </div>
                <h3 class="rx-empty-title">Hakuna Risiti</h3>
                <p class="rx-empty-description">Bado huna risiti zozote za malipo</p>
                <a href="{{ route('member.portal') }}" class="rx-btn rx-btn-primary mt-4 text-sm">
                    <i class="fas fa-home"></i>
                    <span>Rudi Nyumbani</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="rx-card p-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-info-circle text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-1">Kidokezo</h4>
                <p class="text-sm text-gray-600">
                    Unaweza ku-download risiti zako wakati wowote. Risiti hizi zinaweza kuwa na umuhimu kwa madhumuni ya hesabu zako binafsi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
