@extends('layouts.app')

@section('title', 'Ripoti ya Huduma za Kichungaji - Mfumo wa ROC')
@section('page-title', 'Ripoti ya Huduma za Kichungaji')
@section('page-subtitle', 'Takwimu na muhtasari wa huduma kwa mwaka {{ $year }}')

@section('styles')
<style>
    .report-hero {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem 2.5rem;
        color: #111827;
        position: relative;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .report-hero-stat {
        background: #f9fafb;
        border: 1px solid #f0f0f0;
        border-radius: 1rem;
        padding: 1.25rem;
        transition: all 0.3s;
    }
    .report-hero-stat:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .chart-card {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .chart-card:hover {
        box-shadow: 0 8px 25px rgba(54,9,88,0.08);
        transform: translateY(-2px);
    }
    .chart-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .chart-body { padding: 1.5rem; }
    .chart-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-mini-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 1rem;
        padding: 1.25rem;
        transition: all 0.3s;
    }
    .stat-mini-card:hover {
        border-color: #e5e7eb;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .progress-ring {
        width: 80px;
        height: 80px;
        position: relative;
    }
    .progress-ring svg {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dashoffset 1s ease-out;
    }
    .progress-ring-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 16px;
        font-weight: 700;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .animate-fade-in {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .glass-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    canvas { max-width: 100%; }
</style>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Hero Banner -->
    <div class="report-hero">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-chart-bar text-2xl" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Ripoti ya Huduma za Kichungaji</h1>
                    <p class="text-sm text-gray-500 mt-1">Muhtasari kamili wa takwimu za huduma — Mwaka {{ $year }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pastoral-services.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Rudi
                </a>
                <button onclick="openModal('exportModal')" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Hero Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <div class="report-hero-stat">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-calendar-week text-gray-400 text-sm"></i>
                    <span class="text-xs text-gray-500 font-medium">Wiki Hii</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $weeklyStats['total'] }}</p>
                <div class="flex gap-3 mt-2">
                    <span class="text-xs text-green-600"><i class="fas fa-check mr-1"></i>{{ $weeklyStats['completed'] }}</span>
                    <span class="text-xs text-yellow-600"><i class="fas fa-clock mr-1"></i>{{ $weeklyStats['pending'] }}</span>
                </div>
            </div>
            <div class="report-hero-stat">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                    <span class="text-xs text-gray-500 font-medium">Mwezi Huu</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $monthlyStats['total'] }}</p>
                <div class="flex gap-3 mt-2">
                    <span class="text-xs text-green-600"><i class="fas fa-check mr-1"></i>{{ $monthlyStats['completed'] }}</span>
                    <span class="text-xs text-yellow-600"><i class="fas fa-clock mr-1"></i>{{ $monthlyStats['pending'] }}</span>
                </div>
            </div>
            <div class="report-hero-stat">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-calendar text-gray-400 text-sm"></i>
                    <span class="text-xs text-gray-500 font-medium">Mwaka {{ $year }}</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $yearlyStats['total'] }}</p>
                <div class="flex gap-3 mt-2">
                    <span class="text-xs text-green-600"><i class="fas fa-check mr-1"></i>{{ $yearlyStats['completed'] }}</span>
                    <span class="text-xs text-yellow-600"><i class="fas fa-clock mr-1"></i>{{ $yearlyStats['pending'] }}</span>
                </div>
            </div>
            <div class="report-hero-stat">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-chart-line text-gray-400 text-sm"></i>
                    <span class="text-xs text-gray-500 font-medium">Kiwango cha Ukamilifu</span>
                </div>
                @php
                    $overallTotal = $yearlyStats['total'] ?: 1;
                    $overallRate = round(($yearlyStats['completed'] / $overallTotal) * 100);
                @endphp
                <p class="text-3xl font-bold" style="color: #16a34a">{{ $overallRate }}%</p>
                <div class="mt-2">
                    <div class="w-full rounded-full h-1.5" style="background: #e5e7eb">
                        <div class="h-1.5 rounded-full" style="width: {{ $overallRate }}%; background: #16a34a; transition: width 1s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1: Bar + Doughnut -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Bar Chart -->
        <div class="chart-card lg:col-span-2 animate-fade-in" style="animation-delay: 0.1s">
            <div class="chart-header">
                <div class="flex items-center gap-3">
                    <div class="chart-icon-box" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-chart-column" style="color: #3b82f6"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Huduma kwa Mwezi</h3>
                        <p class="text-xs text-gray-500">Jumla dhidi ya zilizokamilika</p>
                    </div>
                </div>
            </div>
            <div class="chart-body" style="height: 300px;">
                <canvas id="monthlyBarChart"></canvas>
            </div>
        </div>

        <!-- Type Doughnut -->
        <div class="chart-card animate-fade-in" style="animation-delay: 0.2s">
            <div class="chart-header">
                <div class="flex items-center gap-3">
                    <div class="chart-icon-box" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-pie" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Aina za Huduma</h3>
                        <p class="text-xs text-gray-500">Mwaka {{ $year }}</p>
                    </div>
                </div>
            </div>
            <div class="chart-body flex flex-col items-center">
                <div style="height: 200px; width: 200px;">
                    <canvas id="typeDoughnutChart"></canvas>
                </div>
                <div class="mt-4 w-full space-y-1">
                    @php
                        $chartColors = [
                            'Ubatizo' => '#3b82f6', 'Uthibitisho' => '#16a34a', 'Ndoa' => '#ec4899',
                            'Wakfu' => '#ca8a04', 'Mazishi' => '#6b7280', 'Ushauri wa Kichungaji' => '#7c3aed', 'Nyingine' => '#6366f1',
                        ];
                    @endphp
                    @forelse($servicesByType as $type)
                        <div class="legend-item">
                            <span class="legend-dot" style="background: {{ $chartColors[$type->service_type] ?? '#9ca3af' }}"></span>
                            <span class="text-xs text-gray-600 flex-1">{{ $type->service_type }}</span>
                            <span class="text-xs font-bold text-gray-900">{{ $type->total }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Hakuna data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Line Trend + Status Doughnut + Completion Ring -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Trend Line Chart -->
        <div class="chart-card lg:col-span-2 animate-fade-in" style="animation-delay: 0.3s">
            <div class="chart-header">
                <div class="flex items-center gap-3">
                    <div class="chart-icon-box" style="background: rgba(124,58,237,0.1)">
                        <i class="fas fa-wave-square" style="color: #7c3aed"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Mwenendo wa Huduma</h3>
                        <p class="text-xs text-gray-500">Mpaka wa mwezi kwa mwezi</p>
                    </div>
                </div>
            </div>
            <div class="chart-body" style="height: 280px;">
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>

        <!-- Status + Completion -->
        <div class="space-y-6">
            <!-- Status Breakdown -->
            <div class="chart-card animate-fade-in" style="animation-delay: 0.4s">
                <div class="chart-header">
                    <div class="flex items-center gap-3">
                        <div class="chart-icon-box" style="background: rgba(54,9,88,0.08)">
                            <i class="fas fa-signal" style="color: #360958"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Hali ya Huduma</h3>
                            <p class="text-xs text-gray-500">Mwaka {{ $year }}</p>
                        </div>
                    </div>
                </div>
                <div class="chart-body">
                    @php
                        $statusCounts = [
                            'Imekamilika' => $yearlyStats['completed'],
                            'Inasubiri' => $yearlyStats['pending'],
                            'Imeidhinishwa' => $yearlyStats['approved'],
                        ];
                        $statusColors = ['Imekamilika' => '#16a34a', 'Inasubiri' => '#ca8a04', 'Imeidhinishwa' => '#3b82f6'];
                        $statusIcons = ['Imekamilika' => 'fa-check-circle', 'Inasubiri' => 'fa-clock', 'Imeidhinishwa' => 'fa-shield-halved'];
                    @endphp
                    <div class="space-y-3">
                        @foreach($statusCounts as $label => $count)
                            @php
                                $pct = $yearlyStats['total'] > 0 ? round(($count / $yearlyStats['total']) * 100) : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <i class="fas {{ $statusIcons[$label] }} text-xs" style="color: {{ $statusColors[$label] }}"></i>
                                        <span class="text-xs font-medium text-gray-600">{{ $label }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900">{{ $count }} <span class="text-gray-400 font-normal">({{ $pct }}%)</span></span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all duration-1000 ease-out" style="width: {{ $pct }}%; background: {{ $statusColors[$label] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Completion Ring -->
            <div class="chart-card animate-fade-in" style="animation-delay: 0.5s">
                <div class="chart-body flex flex-col items-center py-6">
                    <div class="progress-ring">
                        <svg width="80" height="80" viewBox="0 0 80 80">
                            <circle cx="40" cy="40" r="34" fill="none" stroke="#f3f4f6" stroke-width="8"/>
                            <circle cx="40" cy="40" r="34" fill="none" stroke="#16a34a" stroke-width="8"
                                stroke-linecap="round"
                                stroke-dasharray="{{ 2 * 3.14159 * 34 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 34 * (1 - $overallRate / 100) }}"
                                class="progress-ring-circle"/>
                        </svg>
                        <span class="progress-ring-text" style="color: #16a34a">{{ $overallRate }}%</span>
                    </div>
                    <p class="text-xs font-bold text-gray-900 mt-3">Ukamilifu wa Jumla</p>
                    <p class="text-[11px] text-gray-500">{{ $yearlyStats['completed'] }} kati ya {{ $yearlyStats['total'] }} huduma</p>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Export PDF Modal -->
<div id="exportModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                        <i class="fas fa-file-pdf" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Export Ripoti (PDF)</h3>
                        <p class="text-xs text-gray-500">Chagua kipindi cha ripoti</p>
                    </div>
                </div>
                <button onclick="closeModal('exportModal')" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <form id="exportForm" action="{{ route('pastoral-services.export') }}" method="GET">
            <input type="hidden" name="format" value="pdf">
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kipindi cha Ripoti</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="week" class="peer sr-only">
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(59,130,246,0.1)"><i class="fas fa-calendar-week" style="color: #3b82f6"></i></div>
                                <span class="text-xs font-medium text-gray-700">Wiki Hii</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="month" class="peer sr-only" checked>
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(22,163,74,0.1)"><i class="fas fa-calendar-alt" style="color: #16a34a"></i></div>
                                <span class="text-xs font-medium text-gray-700">Mwezi Huu</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="year" class="peer sr-only">
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(124,58,237,0.1)"><i class="fas fa-calendar" style="color: #7c3aed"></i></div>
                                <span class="text-xs font-medium text-gray-700">Mwaka Huu</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Huduma (Hiari)</label>
                    <select name="service_type" class="rx-select">
                        <option value="">Huduma Zote</option>
                        @foreach($serviceTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali (Hiari)</label>
                    <select name="status" class="rx-select">
                        <option value="">Hali Zote</option>
                        <option value="Inasubiri">Zinasubiri</option>
                        <option value="Imeidhinishwa">Zimeidhinishwa</option>
                        <option value="Imekamilika">Zimekamilika</option>
                        <option value="Imekataliwa">Zimekataliwa</option>
                    </select>
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('exportModal')" class="rx-btn rx-btn-secondary">Ghairi</button>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i>
                    <span>Download PDF</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Bar Chart
    const barCtx = document.getElementById('monthlyBarChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($monthlyData)->pluck('name')) !!},
                datasets: [
                    {
                        label: 'Jumla',
                        data: {!! json_encode(collect($monthlyData)->pluck('total')) !!},
                        backgroundColor: 'rgba(54, 9, 88, 0.75)',
                        borderColor: '#360958',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Zimekamilika',
                        data: {!! json_encode(collect($monthlyData)->pluck('completed')) !!},
                        backgroundColor: 'rgba(22, 163, 74, 0.75)',
                        borderColor: '#16a34a',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rectRounded',
                            padding: 20,
                            font: { size: 12, family: 'Inter, system-ui, sans-serif' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Type Doughnut Chart
    const doughnutCtx = document.getElementById('typeDoughnutChart');
    if (doughnutCtx) {
        const typeLabels = {!! json_encode($servicesByType->pluck('service_type')) !!};
        const typeData = {!! json_encode($servicesByType->pluck('total')) !!};
        const typeColors = {
            'Ubatizo': '#3b82f6', 'Uthibitisho': '#16a34a', 'Ndoa': '#ec4899',
            'Wakfu': '#ca8a04', 'Mazishi': '#6b7280', 'Ushauri wa Kichungaji': '#7c3aed', 'Nyingine': '#6366f1'
        };
        const colors = typeLabels.map(l => typeColors[l] || '#9ca3af');

        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeData,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverBorderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? Math.round((ctx.parsed / total) * 100) : 0;
                                return ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Trend Line Chart
    const lineCtx = document.getElementById('trendLineChart');
    if (lineCtx) {
        const monthNames = {!! json_encode(collect($monthlyData)->pluck('name')) !!};
        const totalData = {!! json_encode(collect($monthlyData)->pluck('total')) !!};
        const completedData = {!! json_encode(collect($monthlyData)->pluck('completed')) !!};
        const pendingData = totalData.map((t, i) => t - completedData[i]);

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [
                    {
                        label: 'Jumla',
                        data: totalData,
                        borderColor: '#360958',
                        backgroundColor: 'rgba(54, 9, 88, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#360958',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Zimekamilika',
                        data: completedData,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#16a34a',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Zinasubiri',
                        data: pendingData,
                        borderColor: '#ca8a04',
                        backgroundColor: 'rgba(202, 138, 4, 0.05)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: '#ca8a04',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { size: 12, family: 'Inter, system-ui, sans-serif' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }
});

function openModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() { modal.querySelector('div').classList.remove('scale-95'); }, 10);
    }
}

function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(function() { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }, 200);
    }
}

document.querySelectorAll('[id$="Modal"]').forEach(function(m) {
    m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.querySelectorAll('[id$="Modal"]:not(.hidden)').forEach(function(m) { closeModal(m.id); });
});

function quickExport(period) {
    window.location.href = '{{ route("pastoral-services.export") }}?period=' + period + '&format=pdf';
}
</script>
@endsection