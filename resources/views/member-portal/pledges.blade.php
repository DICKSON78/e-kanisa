@extends('layouts.app')

@section('title', 'Ahadi Zangu')
@section('page-title', 'Ahadi Zangu')
@section('page-subtitle', 'Fuatilia ahadi zako na maendeleo ya malipo')

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
            <i class="fas fa-handshake" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ahadi Zangu</h1>
            <p class="text-sm text-gray-500">Fuatilia ahadi zako na maendeleo ya malipo</p>
        </div>
    </div>

    @if($pledges->count() > 0)
        <!-- Summary Stats -->
        @php
            $totalPledged = $pledges->sum('amount');
            $totalPaid = $pledges->sum('amount_paid');
            $totalRemaining = $pledges->sum('remaining_amount');
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rx-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jumla ya Ahadi</p>
                        <p class="text-2xl font-bold text-blue-600">TZS {{ number_format($totalPledged, 0) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-handshake text-sm" style="color: #efc120"></i>
                    </div>
                </div>
            </div>

            <div class="rx-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Yaliyolipwa</p>
                        <p class="text-2xl font-bold text-green-600">TZS {{ number_format($totalPaid, 0) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-check-circle text-sm" style="color: #efc120"></i>
                    </div>
                </div>
            </div>

            <div class="rx-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Yaliyobaki</p>
                        <p class="text-2xl font-bold text-orange-500">TZS {{ number_format($totalRemaining, 0) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-clock text-sm" style="color: #efc120"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pledges List -->
        <div class="space-y-6">
            @foreach($pledges as $pledge)
                <div class="rx-card rounded-2xl overflow-hidden">
                    <!-- Pledge Header Banner -->
                    <div class="rounded-t-2xl" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                                        <i class="fas fa-handshake text-xl" style="color: #efc120"></i>
                                    </div>
                                    <div class="text-white">
                                        <h3 class="text-xl font-bold">{{ $pledge->pledge_type }}</h3>
                                        <p class="text-sm text-white/70 mt-1 flex items-center gap-3">
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                Tarehe: {{ $pledge->pledge_date->format('d M Y') }}
                                            </span>
                                            @if($pledge->due_date)
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar-check mr-1"></i>
                                                    Mwisho: {{ $pledge->due_date->format('d M Y') }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($pledge->status === 'Completed')
                                    <span class="rx-badge rx-badge-green">
                                        <i class="fas fa-check-circle mr-1.5"></i>Imekamilika
                                    </span>
                                @elseif($pledge->status === 'Partial')
                                    <span class="rx-badge rx-badge-yellow">
                                        <i class="fas fa-hourglass-half mr-1.5"></i>Inaendelea
                                    </span>
                                @else
                                    <span class="rx-badge rx-badge-gray">
                                        <i class="fas fa-clock mr-1.5"></i>Bado
                                    </span>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-6">
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-white/80 font-medium flex items-center">
                                        <i class="fas fa-chart-line mr-2" style="color: #efc120"></i>
                                        Maendeleo ya Malipo
                                    </span>
                                    <span class="text-white font-bold">{{ number_format($pledge->progress_percentage, 1) }}%</span>
                                </div>
                                <div class="w-full bg-white/20 rounded-full h-3">
                                    <div class="h-3 rounded-full transition-all duration-500
                                        {{ $pledge->progress_percentage >= 100 ? 'bg-green-400' : ($pledge->progress_percentage >= 50 ? 'bg-yellow-400' : 'bg-white/80') }}"
                                         style="width: {{ min($pledge->progress_percentage, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                <div class="bg-white/10 rounded-xl p-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-coins mr-2 text-xs" style="color: #efc120"></i>
                                        <p class="text-xs text-white/60">Jumla ya Ahadi</p>
                                    </div>
                                    <p class="text-lg font-bold text-white">TZS {{ number_format($pledge->amount, 0) }}</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-check mr-2 text-xs text-green-400"></i>
                                        <p class="text-xs text-white/60">Kiasi Kilicholipwa</p>
                                    </div>
                                    <p class="text-lg font-bold text-green-400">TZS {{ number_format($pledge->amount_paid, 0) }}</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-hourglass-half mr-2 text-xs text-orange-400"></i>
                                        <p class="text-xs text-white/60">Kiasi Kilichobaki</p>
                                    </div>
                                    <p class="text-lg font-bold text-orange-400">TZS {{ number_format($pledge->remaining_amount, 0) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                <i class="fas fa-history text-sm" style="color: #efc120"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Historia ya Malipo</h4>
                                <p class="text-sm text-gray-500">Malipo yaliyofanywa kwa ahadi hii</p>
                            </div>
                        </div>

                        @if($pledge->payments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="rx-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                                    Tarehe
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
                                                    <i class="fas fa-receipt mr-2 text-gray-400"></i>
                                                    Namba ya Risiti
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
                                        @foreach($pledge->payments as $payment)
                                            <tr>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                                            <i class="fas fa-calendar-day text-xs" style="color: #efc120"></i>
                                                        </div>
                                                        <span class="text-sm text-gray-900">{{ $payment->payment_date->format('d M Y') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-sm font-bold text-green-600">TZS {{ number_format($payment->amount, 0) }}</span>
                                                </td>
                                                <td>
                                                    <span class="rx-badge rx-badge-gray">{{ $payment->payment_method ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-sm text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">{{ $payment->receipt_number }}</span>
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
                        @else
                            <div class="rx-empty py-8">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-inbox text-gray-400 text-lg"></i>
                                </div>
                                <p class="rx-empty-description">Hakuna malipo bado kwa ahadi hii</p>
                            </div>
                        @endif

                        @if($pledge->notes)
                            <div class="mt-4 p-4 rounded-xl border border-blue-100 bg-blue-50/50">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-sticky-note text-blue-400 mt-0.5"></i>
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Maelezo:</span> {{ $pledge->notes }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rx-card p-12">
            <div class="rx-empty">
                <div class="rx-empty-icon">
                    <i class="fas fa-handshake text-gray-400 text-2xl"></i>
                </div>
                <h3 class="rx-empty-title">Hakuna Ahadi</h3>
                <p class="rx-empty-description">Bado hujaweka ahadi yoyote</p>
                <a href="{{ route('member.portal') }}" class="rx-btn rx-btn-primary mt-4 text-sm">
                    <i class="fas fa-home"></i>
                    <span>Rudi Nyumbani</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
