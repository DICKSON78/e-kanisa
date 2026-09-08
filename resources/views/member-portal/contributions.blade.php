@extends('layouts.app')

@section('title', 'Michango Yangu')
@section('page-title', 'Michango Yangu')
@section('page-subtitle', 'Historia kamili ya michango yako (isipokuwa shukrani ya wiki)')

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
            <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Michango Yangu</h1>
            <p class="text-sm text-gray-500">Historia kamili ya michango yako (isipokuwa shukrani ya wiki)</p>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="rx-card overflow-hidden">
        <div class="rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="text-white">
                        <p class="text-white/70 mb-2 flex items-center gap-2 text-sm font-medium">
                            <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
                            Jumla ya Michango
                        </p>
                        <p class="text-4xl font-bold">TZS {{ number_format($totalContributions, 0) }}</p>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 bg-white/10 text-white rounded-full text-sm font-medium">
                                <i class="fas fa-receipt mr-1.5" style="color: #efc120"></i>{{ $contributions->total() }} Michango
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                            <i class="fas fa-hand-holding-heart text-2xl" style="color: #efc120"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contributions Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-list text-sm" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Orodha ya Michango</h3>
                    <p class="text-sm text-gray-500">Historia kamili ya michango yako</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-0">
                <span class="rx-badge rx-badge-gold">{{ $contributions->total() }} michango</span>
            </div>
        </div>

        @if($contributions->count() > 0)
            <div class="overflow-x-auto">
                <table class="rx-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    Tarehe
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2 text-gray-400"></i>
                                    Aina ya Sadaka
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
                                    <i class="fas fa-receipt mr-2 text-gray-400"></i>
                                    Namba ya Risiti
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center">
                                    <i class="fas fa-sticky-note mr-2 text-gray-400"></i>
                                    Maelezo
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contributions as $contribution)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-calendar-day text-xs" style="color: #efc120"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($contribution->collection_date)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="rx-badge rx-badge-purple">{{ $contribution->category->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm font-bold text-green-600">TZS {{ number_format($contribution->amount, 0) }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">{{ $contribution->receipt_number ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-gray-600">{{ $contribution->notes ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($contributions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $contributions->links() }}
                </div>
            @endif
        @else
            <div class="rx-empty">
                <div class="rx-empty-icon">
                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                </div>
                <h3 class="rx-empty-title">Hakuna Michango</h3>
                <p class="rx-empty-description">Bado hujaweka michango yoyote</p>
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
                    Ukurasa huu unaonyesha michango yako yote isipokuwa shukrani ya wiki. Kwa maelezo zaidi, wasiliana na ofisi ya kanisa.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
