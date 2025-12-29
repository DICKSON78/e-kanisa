@extends('layouts.app')

@section('title', 'Dashboard - Mfumo wa Kanisa')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Takwimu za jumla za kanisa')

@section('content')
@php
// Helper function to format money with M, B, K
function formatMoney($amount) {
    if ($amount >= 1000000000) { // Billions
        return number_format($amount / 1000000000, 2) . 'B';
    } elseif ($amount >= 1000000) { // Millions
        return number_format($amount / 1000000, 2) . 'M';
    } elseif ($amount >= 1000) { // Thousands
        return number_format($amount / 1000, 1) . 'K';
    } else {
        return number_format($amount, 0);
    }
}
@endphp
<!-- Stats Cards -->
<div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Jumla ya Waumini</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ number_format($totalMembers) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-users"></i></span>
                    <span>{{ number_format($activeMembers) }} hai</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                <i class="fas fa-users text-primary-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Mapato ya Mwezi</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ formatMoney($monthlyIncome) }} TSh</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-green-600 mr-1"><i class="fas fa-arrow-up"></i></span>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-hand-holding-usd text-green-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Matukio Yanayokuja</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-gray-900">{{ count($upcomingEvents) }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-blue-500 mr-1"><i class="fas fa-calendar-alt"></i></span>
                    <span>Yaliyopangwa</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700">Maombi ya Fedha</p>
                <p class="mt-1 text-2xl md:text-3xl font-semibold text-yellow-600">{{ $pendingRequests }}</p>
                <p class="mt-1 text-xs md:text-sm text-gray-500 flex items-center">
                    <span class="text-orange-500 mr-1"><i class="fas fa-clock"></i></span>
                    <span>Yanasubiri</span>
                </p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-secondary-100 flex items-center justify-center">
                <i class="fas fa-paper-plane text-secondary-500 text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-6 md:mb-8">
    <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
        <i class="fas fa-bolt text-secondary-500 mr-2"></i> Vitendo Vya Haraka
    </h3>
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
        <!-- Add Member -->
        <a href="{{ route('members.create') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-primary-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-user-plus text-primary-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm md:text-base">Ongeza Muumini</h4>
                    <p class="text-xs md:text-sm text-gray-500">Sajili muumini mpya</p>
                </div>
            </div>
        </a>

        <!-- Record Income -->
        <a href="{{ route('income.create') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-hand-holding-usd text-green-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm md:text-base">Rekodi Mapato</h4>
                    <p class="text-xs md:text-sm text-gray-500">Andika mapato mapya</p>
                </div>
            </div>
        </a>

        <!-- Add Offering -->
        <a href="{{ route('offerings.create') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-gift text-blue-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm md:text-base">Ongeza Sadaka</h4>
                    <p class="text-xs md:text-sm text-gray-500">Rekodi sadaka mpya</p>
                </div>
            </div>
        </a>

        <!-- Create Event -->
        <a href="{{ route('events.create') }}" class="card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-4 md:p-6 cursor-pointer block">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3 md:mr-4">
                    <i class="fas fa-calendar-plus text-purple-500 text-lg md:text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm md:text-base">Tengeneza Tukio</h4>
                    <p class="text-xs md:text-sm text-gray-500">Ongeza tukio jipya</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Charts and Recent Activity -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6 md:mb-8">
    <!-- Mapato Chart -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6">
        <div class="flex flex-col gap-3 mb-4">
            <!-- Header with Title and Total -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <h3 class="text-lg font-medium text-gray-700 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-primary-500"></i>
                    Mapato ya Miezi 6 Iliyopita
                </h3>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-coins mr-1"></i>
                    Jumla: <span id="chartTotal" class="font-semibold text-primary-600">{{ formatMoney(collect($monthlyIncomeData)->sum('amount')) }} TSh</span>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center gap-2">
                    <label for="yearFilter" class="text-sm text-gray-600">Mwaka:</label>
                    <select id="yearFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @php
                            $currentYear = date('Y');
                            $startYear = 2020; // Start from 2020 or adjust as needed
                        @endphp
                        @for($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label for="periodFilter" class="text-sm text-gray-600">Kipindi:</label>
                    <select id="periodFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="last_6_months" selected>Miezi 6 Iliyopita</option>
                        <option value="this_year">Mwaka Huu</option>
                        <option value="custom_year">Mwaka Mzima</option>
                    </select>
                </div>

                <span id="loadingIndicator" class="text-xs text-gray-500 hidden">
                    <i class="fas fa-spinner fa-spin"></i> Inapakia...
                </span>
            </div>
        </div>
        <div class="h-48 md:h-64 relative">
            @php
                $hasData = collect($monthlyIncomeData)->sum('amount') > 0;
            @endphp
            @if($hasData)
                <canvas id="incomeLineChart"></canvas>
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500 text-sm">Hakuna data ya mapato</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card bg-white rounded-xl border border-gray-200 shadow-sm p-4 md:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2">
            <h3 class="text-lg font-medium text-gray-700 flex items-center">
                <i class="fas fa-history mr-2 text-primary-500"></i>
                Shughuli Za Hivi Karibuni
            </h3>
        </div>
        <div class="space-y-3 md:space-y-4">
            @forelse($recentMembers->take(2) as $member)
            <div class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                    <i class="fas fa-user-plus text-sm md:text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm md:text-base truncate">Muumini mpya: {{ $member->full_name }}</p>
                    <p class="text-xs md:text-sm text-gray-500">{{ $member->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            @endforelse

            @forelse($recentIncomes->take(1) as $income)
            <div class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                    <i class="fas fa-hand-holding-usd text-sm md:text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm md:text-base truncate">
                        Mapato ya {{ $income->category->name ?? 'Bila aina' }}: {{ formatMoney($income->amount) }} TSh
                    </p>
                    <p class="text-xs md:text-sm text-gray-500">{{ $income->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            @endforelse

            @forelse($recentEvents->take(1) as $event)
            <div class="flex items-start hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                    <i class="fas fa-calendar-plus text-sm md:text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm md:text-base truncate">Tukio: {{ $event->name }}</p>
                    <p class="text-xs md:text-sm text-gray-500">{{ $event->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            @endforelse

            @if($recentMembers->isEmpty() && $recentIncomes->isEmpty() && $recentEvents->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500 text-sm">Hakuna shughuli za hivi karibuni</p>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded successfully');

        // Add hover effects to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)';
            });
        });

        // Format money helper for JavaScript
        function formatMoneyJS(amount) {
            if (amount >= 1000000000) {
                return (amount / 1000000000).toFixed(2) + 'M';
            } else if (amount >= 1000000) {
                return (amount / 1000000).toFixed(2) + 'M';
            } else if (amount >= 1000) {
                return (amount / 1000).toFixed(1) + 'K';
            } else {
                return amount.toLocaleString();
            }
        }

        // Auto-refresh dashboard statistics
        function refreshDashboardStats() {
            fetch('/api/dashboard-stats')
                .then(response => response.json())
                .then(data => {
                    // Update stats cards - find by the card content structure
                    const statsCards = document.querySelectorAll('.card');

                    statsCards.forEach(card => {
                        const label = card.querySelector('p.text-sm');
                        const value = card.querySelector('p.text-2xl, p.text-3xl');

                        if (label && value) {
                            const labelText = label.textContent.trim();

                            // Update each stat based on label
                            if (labelText === 'Jumla ya Waumini') {
                                value.textContent = data.total_members.toLocaleString();
                            } else if (labelText === 'Mapato ya Mwezi') {
                                value.textContent = formatMoneyJS(data.monthly_income) + ' TSh';
                            } else if (labelText === 'Maombi ya Fedha') {
                                value.textContent = data.pending_requests;
                            } else if (labelText === 'Matukio Yanayokuja') {
                                value.textContent = data.upcoming_events;
                            }
                        }
                    });

                    console.log('Dashboard stats updated:', data);
                })
                .catch(error => {
                    console.error('Error refreshing dashboard stats:', error);
                });
        }

        // Refresh stats every 30 seconds
        setInterval(refreshDashboardStats, 30000);

        // Also refresh when page becomes visible (user switches back to tab)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                refreshDashboardStats();
            }
        });

        // Initialize Line Chart for Monthly Income
        const incomeChartCanvas = document.getElementById('incomeLineChart');
        if (incomeChartCanvas) {
            // Data from Laravel
            const monthlyData = @json($monthlyIncomeData);

            // Format money function for chart
            function formatChartMoney(amount) {
                if (amount >= 1000000000) {
                    return (amount / 1000000000).toFixed(2) + 'B';
                } else if (amount >= 1000000) {
                    return (amount / 1000000).toFixed(2) + 'M';
                } else if (amount >= 1000) {
                    return (amount / 1000).toFixed(1) + 'K';
                } else {
                    return amount.toFixed(0);
                }
            }

            // Extract labels and data
            const labels = monthlyData.map(item => item.month);
            const amounts = monthlyData.map(item => item.amount);

            // Get canvas context
            const ctx = incomeChartCanvas.getContext('2d');

            // Initialize Chart
            const incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Mapato',
                        data: amounts,
                        borderColor: '#360958',                    // Primary color
                        backgroundColor: 'rgba(54, 9, 88, 0.08)',  // Solid light purple background
                        borderWidth: 3,
                        fill: true,                                // Enable fill
                        tension: 0.4,                              // Smooth curves
                        pointRadius: 5,
                        pointBackgroundColor: '#360958',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#360958',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#360958',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
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
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return formatChartMoney(value);
                                },
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            // Auto-filter functionality
            const yearFilter = document.getElementById('yearFilter');
            const periodFilter = document.getElementById('periodFilter');
            const loadingIndicator = document.getElementById('loadingIndicator');

            // Function to update chart
            function updateChart() {
                const year = yearFilter.value;
                const period = periodFilter.value;

                // Show loading indicator
                if (loadingIndicator) {
                    loadingIndicator.classList.remove('hidden');
                }

                // Fetch filtered data
                fetch(`/api/filtered-income?year=${year}&period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update chart data
                        const newLabels = data.data.map(item => item.month);
                        const newAmounts = data.data.map(item => item.amount);

                        incomeChart.data.labels = newLabels;
                        incomeChart.data.datasets[0].data = newAmounts;
                        incomeChart.update();

                        // Update total
                        const chartTotal = document.getElementById('chartTotal');
                        if (chartTotal) {
                            chartTotal.textContent = formatChartMoney(data.total) + ' TSh';
                        }

                        // Hide loading indicator
                        if (loadingIndicator) {
                            loadingIndicator.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chart data:', error);
                        alert('Kuna tatizo la kupata data. Tafadhali jaribu tena.');

                        // Hide loading indicator
                        if (loadingIndicator) {
                            loadingIndicator.classList.add('hidden');
                        }
                    });
            }

            // Add change event listeners to both filters
            if (yearFilter && periodFilter) {
                yearFilter.addEventListener('change', updateChart);
                periodFilter.addEventListener('change', updateChart);
            }
        }
    });
</script>
@endsection
