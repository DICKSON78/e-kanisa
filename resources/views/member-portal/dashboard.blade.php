@extends('layouts.app')

@section('title', 'Portal ya Muumini')
@section('page-title', 'Portal ya Muumini')
@section('page-subtitle', 'Orodha ya taarifa zako binafsi na matumizi')

@section('content')
<div class="space-y-6">

    <!-- Profile Banner -->
    <div class="rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)">
        <div class="p-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                            <i class="fas fa-user text-2xl" style="color: #efc120"></i>
                        </div>
                        @if($member->is_active)
                        <div class="absolute -bottom-1 -right-1 h-5 w-5 bg-green-400 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-check text-xs text-white"></i>
                        </div>
                        @endif
                    </div>
                    <div class="text-white">
                        <h1 class="text-2xl font-bold mb-2">Karibu, {{ $member->full_name }}</h1>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                <i class="fas fa-id-card mr-2 text-xs" style="color: #efc120"></i>
                                <span class="text-sm font-medium">#{{ $member->member_number }}</span>
                            </div>
                            <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                <i class="fas fa-envelope mr-2 text-xs" style="color: #efc120"></i>
                                <span class="text-sm font-medium">Bahasha: {{ $member->envelope_number }}</span>
                            </div>
                            @if($member->phone)
                            <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                <i class="fas fa-phone mr-2 text-xs" style="color: #efc120"></i>
                                <span class="text-sm font-medium">{{ $member->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('member.profile.edit') }}" class="rx-btn rx-btn-primary shrink-0">
                    <i class="fas fa-user-edit"></i>
                    <span>Taarifa Zangu</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Ahadi -->
        <div class="rx-stat-card">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Jumla ya Ahadi</p>
                    <p class="text-2xl font-bold" style="color: #ca8a04">TZS {{ number_format($totalPledged, 0) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-handshake text-sm" style="color: #efc120"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Ahadi {{ $pledges->count() }} zilizofanywa
                </p>
            </div>
        </div>

        <!-- Yaliyolipwa -->
        <div class="rx-stat-card">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Yaliyolipwa</p>
                    <p class="text-2xl font-bold text-green-600">TZS {{ number_format($totalPaid, 0) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-check-circle text-sm" style="color: #efc120"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-money-bill-wave mr-1"></i>
                    Malipo {{ $recentPayments->count() }} ya hivi karibuni
                </p>
            </div>
        </div>

        <!-- Baki -->
        <div class="rx-stat-card">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Baki</p>
                    <p class="text-2xl font-bold text-orange-500">TZS {{ number_format($totalRemaining, 0) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-clock text-sm" style="color: #efc120"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-hourglass-half mr-1"></i>
                    Bado kulipa
                </p>
            </div>
        </div>

        <!-- Imekamilika -->
        <div class="rx-stat-card">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Imekamilika</p>
                    <p class="text-2xl font-bold" style="color: #7c3aed">{{ $completedPledges }} / {{ $pledges->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-trophy text-sm" style="color: #efc120"></i>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-percentage mr-1"></i>
                    {{ $pledges->count() > 0 ? round(($completedPledges/$pledges->count())*100, 1) : 0 }}% ya mafanikio
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="rx-card p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-rocket text-sm" style="color: #efc120"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Hatua za Haraka</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('member.contributions') }}" class="rx-card p-5 flex items-center gap-4 hover:border-yellow-300 hover:shadow-md transition-all duration-200">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-hand-holding-heart text-sm" style="color: #efc120"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-900">Michango Yangu</div>
                    <div class="text-sm text-gray-500 mt-1">Angalia historia ya michango</div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 shrink-0"></i>
            </a>

            <a href="{{ route('member.pledges') }}" class="rx-card p-5 flex items-center gap-4 hover:border-yellow-300 hover:shadow-md transition-all duration-200">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-handshake text-sm" style="color: #efc120"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-900">Ahadi Zangu</div>
                    <div class="text-sm text-gray-500 mt-1">Fuatilia ahadi na malipo</div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 shrink-0"></i>
            </a>

            <a href="{{ route('member.receipts') }}" class="rx-card p-5 flex items-center gap-4 hover:border-yellow-300 hover:shadow-md transition-all duration-200">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-file-invoice text-sm" style="color: #efc120"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-900">Risiti Zangu</div>
                    <div class="text-sm text-gray-500 mt-1">Pakua na angalia risiti</div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 shrink-0"></i>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Payments -->
        <div class="rx-card overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-money-bill-wave text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Orodha ya Malipo ya Hivi Karibuni</h3>
                        <span class="rx-badge rx-badge-gray text-xs mt-1">{{ $recentPayments->count() }} malipo</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if($recentPayments->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentPayments as $payment)
                            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition-all duration-200 group">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                                        <i class="fas fa-receipt text-xs" style="color: #efc120"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="rx-badge rx-badge-blue text-xs">{{ $payment->pledge->pledge_type }}</span>
                                            <span class="text-xs text-gray-400">{{ $payment->payment_date->format('d M Y') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate">Risiti: {{ $payment->receipt_number }}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 ml-3">
                                    <p class="font-bold text-green-600">TZS {{ number_format($payment->amount, 0) }}</p>
                                    <a href="{{ route('member.receipt.view', $payment->id) }}" class="text-xs text-blue-500 hover:text-blue-700 flex items-center justify-end gap-1 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-eye"></i>
                                        <span>Angalia</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <a href="{{ route('member.receipts') }}" class="rx-btn rx-btn-secondary w-full justify-center text-sm">
                            <span>Angalia Risiti Zote</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-inbox text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="rx-empty-title">Hakuna Malipo ya Hivi Karibuni</h3>
                        <p class="rx-empty-description">Hakuna malipo yaliyopatikana kwenye kipindi cha siku 30 zilizopita.</p>
                        <a href="{{ route('member.pledges') }}" class="rx-btn rx-btn-secondary mt-4 text-sm">
                            <span>Tazama Ahadi Zako</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Active Pledges -->
        <div class="rx-card overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-tasks text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        @php
                            $activePledges = $pledges->whereIn('status', ['Pending', 'Partial'])->take(5);
                        @endphp
                        <h3 class="text-lg font-semibold text-gray-900">Ahadi Zinazoendelea</h3>
                        <span class="rx-badge rx-badge-gray text-xs mt-1">{{ $activePledges->count() }} zinazoendelea</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if($activePledges->count() > 0)
                    <div class="space-y-4">
                        @foreach($activePledges as $pledge)
                            <div class="p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition-all duration-200">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="font-semibold text-gray-900">{{ $pledge->pledge_type }}</p>
                                    @if($pledge->status === 'Pending')
                                        <span class="rx-badge rx-badge-gray">
                                            <i class="fas fa-clock mr-1"></i>Bado
                                        </span>
                                    @else
                                        <span class="rx-badge rx-badge-yellow">
                                            <i class="fas fa-hourglass-half mr-1"></i>Nusu
                                        </span>
                                    @endif
                                </div>
                                <div class="space-y-1.5 mb-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Kiasi cha Ahadi</span>
                                        <span class="font-medium text-gray-900">TZS {{ number_format($pledge->amount, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Imelipwa</span>
                                        <span class="text-green-600 font-medium">TZS {{ number_format($pledge->paid_amount, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Baki</span>
                                        <span class="text-orange-500 font-medium">TZS {{ number_format($pledge->remaining_amount, 0) }}</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pledge->progress_percentage }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-500">{{ number_format($pledge->progress_percentage, 1) }}% Imekamilika</span>
                                    <a href="{{ route('member.pledges') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                                        <i class="fas fa-plus-circle mr-1"></i>Lipia
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <a href="{{ route('member.pledges') }}" class="rx-btn rx-btn-secondary w-full justify-center text-sm">
                            <span>Angalia Ahadi Zote</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <h3 class="rx-empty-title">Umekamilisha Ahadi Zote!</h3>
                        <p class="rx-empty-description">Hakuna ahadi zinazoendelea au zilizobaki kulipwa.</p>
                        <a href="{{ route('member.contributions') }}" class="rx-btn rx-btn-secondary mt-4 text-sm">
                            <span>Tazama Michango Yako</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
