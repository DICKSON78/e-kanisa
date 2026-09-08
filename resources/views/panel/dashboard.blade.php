@extends('layouts.app')

@section('title', 'Dashboard - Mfumo wa ROC')

@section('content')
@php
function formatMoney($amount) {
    if ($amount >= 1000000000) {
        return number_format($amount / 1000000000, 2) . 'B';
    } elseif ($amount >= 1000000) {
        return number_format($amount / 1000000, 2) . 'M';
    } elseif ($amount >= 1000) {
        return number_format($amount / 1000, 1) . 'K';
    } else {
        return number_format($amount, 0);
    }
}
@endphp

<!-- Page Header -->
<div class="flex items-center justify-between mb-8 pt-2 pb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-th-large" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-sm text-gray-500">MFUMO WA ROC — Overview ya kanisa, wanachama na shughuli</p>
        </div>
    </div>
    <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
        <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
        {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-lg group">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Jumla ya Wanachama</p>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                <i class="fas fa-users text-sm" style="color: #360958"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($totalMembers) }}</p>
        <p class="text-xs text-gray-400">+0 wanachama wapya mwezi huu</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-lg group">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Wanachama Hai</p>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50">
                <i class="fas fa-user-check text-sm text-emerald-500"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($activeMembers) }}</p>
        <p class="text-xs text-gray-400">Kati ya {{ number_format($totalMembers) }} wanachama</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-lg group">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Mapato ya Mwezi</p>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-50">
                <i class="fas fa-hand-holding-usd text-sm text-blue-500"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">TZS {{ formatMoney($monthlyIncome) }}</p>
        <p class="text-xs text-gray-400">Jumla mpaka sasa</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-lg group">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Matukio Yanayokuja</p>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-purple-50">
                <i class="fas fa-calendar-alt text-sm text-purple-500"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ count($upcomingEvents) }}</p>
        <p class="text-xs text-gray-400">Yaliyopangwa</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-lg group">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Maombi ya Fedha</p>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                <i class="fas fa-paper-plane text-sm text-amber-500"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ $pendingRequests }}</p>
        <p class="text-xs text-gray-400">Yanasubiri majibu</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-bolt text-sm" style="color: #efc120"></i>
            </div>
            Vitendo Vya Haraka
        </h3>
        <span class="text-xs text-gray-400">Fanya kazi kwa haraka</span>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('members.create') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-[0_10px_25px_rgba(0,0,0,0.08)] hover:-translate-y-2 group cursor-pointer block">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-lg text-blue-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Ongeza Muumini</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Sajili muumini mpya</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('income.create') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-[0_10px_25px_rgba(0,0,0,0.08)] hover:-translate-y-2 group cursor-pointer block">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hand-holding-usd text-lg text-emerald-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Rekodi Mapato</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Andika mapato mapya</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('offerings.create') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-[0_10px_25px_rgba(0,0,0,0.08)] hover:-translate-y-2 group cursor-pointer block">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gift text-lg text-amber-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Ongeza Sadaka</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Rekodi sadaka mpya</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('events.create') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 transition-all duration-300 hover:shadow-[0_10px_25px_rgba(0,0,0,0.08)] hover:-translate-y-2 group cursor-pointer block">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-plus text-lg text-purple-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Tengeneza Tukio</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Ongeza tukio jipya</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Charts + Activity Row -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <!-- Income Chart -->
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-chart-area text-sm" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Mapato ya Miezi</h3>
                    <p class="text-xs text-gray-400">Mpangilio wa mapato kwa mwezi</p>
                </div>
            </div>
            <span id="chartTotal" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-900">{{ formatMoney(collect($monthlyIncomeData)->sum('amount')) }} TSh</span>
        </div>
        <div class="p-6">
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2 mb-5">
                <div class="flex items-center gap-1.5 bg-gray-100 rounded-lg px-2 py-1">
                    <i class="fas fa-calendar text-[10px] text-gray-400"></i>
                    <select id="yearFilter" class="bg-transparent text-xs font-medium text-gray-700 border-none outline-none cursor-pointer">
                        @php
                            $currentYear = date('Y');
                            $startYear = 2020;
                        @endphp
                        @for($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-center gap-1.5 bg-gray-100 rounded-lg px-2 py-1">
                    <select id="periodFilter" class="bg-transparent text-xs font-medium text-gray-700 border-none outline-none cursor-pointer">
                        <option value="last_6_months" selected>Miezi 6</option>
                        <option value="this_year">Mwaka Huu</option>
                        <option value="custom_year">Mwaka Mzima</option>
                    </select>
                </div>
                <span id="loadingIndicator" class="text-[10px] text-gray-400 hidden">
                    <i class="fas fa-spinner fa-spin"></i> Inapakia...
                </span>
            </div>

            <div class="h-72 relative">
                @php
                    $hasData = collect($monthlyIncomeData)->sum('amount') > 0;
                @endphp
                @if($hasData)
                    <canvas id="incomeLineChart"></canvas>
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-chart-line text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900 mb-1">Hakuna data ya mapato</p>
                            <p class="text-xs text-gray-400">Data itaonekana baada ya kurekodi mapato</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity Timeline -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-history text-sm" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Shughuli</h3>
            </div>
            <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Hivi Karibuni</span>
        </div>
        <div class="p-6">
            @php
                $timelineItems = collect();
                foreach($recentMembers->take(2) as $m) {
                    $timelineItems->push(['type' => 'member', 'title' => 'Muumini mpya: ' . $m->full_name, 'time' => $m->created_at, 'icon' => 'fa-user-plus', 'color' => 'emerald']);
                }
                foreach($recentIncomes->take(2) as $i) {
                    $timelineItems->push(['type' => 'income', 'title' => 'Mapato: ' . ($i->category->name ?? 'Bila aina') . ' - ' . formatMoney($i->amount) . ' TSh', 'time' => $i->created_at, 'icon' => 'fa-hand-holding-usd', 'color' => 'blue']);
                }
                foreach($recentEvents->take(1) as $e) {
                    $timelineItems->push(['type' => 'event', 'title' => 'Tukio: ' . $e->name, 'time' => $e->created_at, 'icon' => 'fa-calendar-plus', 'color' => 'purple']);
                }
                $timelineItems = $timelineItems->sortByDesc('time')->take(6);
            @endphp

            @if($timelineItems->count() > 0)
            <div class="space-y-0">
                @foreach($timelineItems as $index => $item)
                <div class="relative pl-8 {{ !$loop->last ? 'pb-6' : '' }}">
                    @if(!$loop->last)
                    <div class="absolute left-[11px] top-6 bottom-0 w-px bg-gray-200"></div>
                    @endif
                    <div class="absolute left-0 top-0.5 w-6 h-6 rounded-full flex items-center justify-center
                        @if($item['color'] === 'emerald') bg-emerald-50
                        @elseif($item['color'] === 'blue') bg-blue-50
                        @elseif($item['color'] === 'purple') bg-purple-50
                        @else bg-gray-50 @endif z-10">
                        <i class="fas {{ $item['icon'] }} text-[10px]
                            @if($item['color'] === 'emerald') text-emerald-500
                            @elseif($item['color'] === 'blue') text-blue-500
                            @elseif($item['color'] === 'purple') text-purple-500
                            @else text-gray-400 @endif"></i>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $item['title'] }}</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $item['time']->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-inbox text-xl text-gray-300"></i>
                </div>
                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna shughuli</p>
                <p class="text-xs text-gray-400">Shughuli zitaonekana hapa</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bottom Row: Upcoming Events + Recent Members -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Upcoming Events -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-calendar-alt text-sm" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Matukio Yanayokuja</h3>
            </div>
            <a href="{{ route('events.index') }}" class="text-xs font-medium hover:underline" style="color: #efc120">Tazama Zote</a>
        </div>
        <div class="p-6">
            @forelse($upcomingEvents->take(4) as $event)
            <div class="flex items-start gap-4 {{ !$loop->last ? 'pb-4 mb-4 border-b border-gray-100' : '' }}">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex flex-col items-center justify-center flex-shrink-0">
                    <span class="text-[10px] font-bold text-purple-600 uppercase">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('M') }}</span>
                    <span class="text-base font-bold text-purple-700 -mt-0.5">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $event->name }}</h4>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i>{{ $event->event_time ?? '10:00' }}</span>
                        <span class="text-xs text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->venue ?? 'Kanisa' }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-plus text-xl text-gray-300"></i>
                </div>
                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna matukio</p>
                <p class="text-xs text-gray-400 mb-3">Matukio yajayo yataonekana hapa</p>
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white" style="background: #360958">
                    <i class="fas fa-plus"></i> Tengeneza Tukio
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Members -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-user-plus text-sm" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Wanachama Wapya</h3>
            </div>
            <a href="{{ route('members.index') }}" class="text-xs font-medium hover:underline" style="color: #efc120">Tazama Zote</a>
        </div>
        <div class="p-6">
            @forelse($recentMembers->take(4) as $member)
            <div class="flex items-center gap-4 {{ !$loop->last ? 'pb-4 mb-4 border-b border-gray-100' : '' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $member->full_name }}</h4>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $member->created_at->diffForHumans() }} • {{ $member->member_number }}</p>
                </div>
                <a href="{{ route('members.show', $member->id) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-all">
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-users text-xl text-gray-300"></i>
                </div>
                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna wanachama wapya</p>
                <p class="text-xs text-gray-400 mb-3">Wanachama wapya wataonekana hapa</p>
                <a href="{{ route('members.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white" style="background: #360958">
                    <i class="fas fa-plus"></i> Sajili Mwanachama
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatMoneyJS(amount) {
            if (amount >= 1000000000) { return (amount / 1000000000).toFixed(2) + 'B'; }
            else if (amount >= 1000000) { return (amount / 1000000).toFixed(2) + 'M'; }
            else if (amount >= 1000) { return (amount / 1000).toFixed(1) + 'K'; }
            else { return amount.toLocaleString(); }
        }

        function refreshDashboardStats() {
            fetch('/api/dashboard-stats')
                .then(response => response.json())
                .then(data => {
                    const statsCards = document.querySelectorAll('.group');
                    statsCards.forEach(card => {
                        const label = card.querySelector('.uppercase');
                        const value = card.querySelector('.text-3xl');
                        if (label && value) {
                            const labelText = label.textContent.trim();
                            if (labelText === 'Jumla ya Waumini') { value.textContent = data.total_members.toLocaleString(); }
                            else if (labelText === 'Mapato ya Mwezi') { value.textContent = formatMoneyJS(data.monthly_income) + ' TSh'; }
                            else if (labelText === 'Maombi ya Fedha') { value.textContent = data.pending_requests; }
                            else if (labelText === 'Matukio Yanayokuja') { value.textContent = data.upcoming_events; }
                        }
                    });
                })
                .catch(error => console.error('Error refreshing stats:', error));
        }

        setInterval(refreshDashboardStats, 30000);
        document.addEventListener('visibilitychange', function() { if (!document.hidden) refreshDashboardStats(); });

        const incomeChartCanvas = document.getElementById('incomeLineChart');
        if (incomeChartCanvas) {
            const monthlyData = @json($monthlyIncomeData);

            function formatChartMoney(amount) {
                if (amount >= 1000000000) { return (amount / 1000000000).toFixed(2) + 'B'; }
                else if (amount >= 1000000) { return (amount / 1000000).toFixed(2) + 'M'; }
                else if (amount >= 1000) { return (amount / 1000).toFixed(1) + 'K'; }
                else { return amount.toFixed(0); }
            }

            const labels = monthlyData.map(item => item.month);
            const amounts = monthlyData.map(item => item.amount);
            const ctx = incomeChartCanvas.getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(54, 9, 88, 0.25)');
            gradient.addColorStop(0.5, 'rgba(54, 9, 88, 0.08)');
            gradient.addColorStop(1, 'rgba(54, 9, 88, 0.01)');

            const incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Mapato',
                        data: amounts,
                        borderColor: '#360958',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#360958',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#efc120',
                        pointHoverBorderColor: '#360958',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#efc120',
                            borderWidth: 1,
                            padding: 14,
                            cornerRadius: 12,
                            displayColors: false,
                            titleFont: { weight: '600', size: 13 },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    return 'Mapato: ' + formatChartMoney(context.parsed.y) + ' TSh';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                            ticks: {
                                callback: function(value) { return formatChartMoney(value); },
                                color: '#9ca3af',
                                font: { size: 11, weight: '500' },
                                padding: 8
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 11, weight: '500' }, padding: 8 }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' }
                }
            });

            const yearFilter = document.getElementById('yearFilter');
            const periodFilter = document.getElementById('periodFilter');
            const loadingIndicator = document.getElementById('loadingIndicator');

            function updateChart() {
                const year = yearFilter.value;
                const period = periodFilter.value;
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');

                fetch(`/api/filtered-income?year=${year}&period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        incomeChart.data.labels = data.data.map(item => item.month);
                        incomeChart.data.datasets[0].data = data.data.map(item => item.amount);
                        incomeChart.update('active');
                        const chartTotal = document.getElementById('chartTotal');
                        if (chartTotal) chartTotal.textContent = formatChartMoney(data.total) + ' TSh';
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    });
            }

            if (yearFilter) yearFilter.addEventListener('change', updateChart);
            if (periodFilter) periodFilter.addEventListener('change', updateChart);
        }
    });
</script>
@endsection
