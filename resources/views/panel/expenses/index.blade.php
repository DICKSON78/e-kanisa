@extends('layouts.app')

@section('title', 'Matumizi - Mfumo wa Kanisa')
@section('page-title', 'Matumizi')
@section('page-subtitle', 'Rekodi na usimamizi wa matumizi ya kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Matumizi ya Kanisa</h1>
            <p class="text-gray-600 mt-2">Usimamizi kamili wa rekodi za matumizi ya kanisa</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="exportMatumizi()" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                <i class="fas fa-file-excel"></i>
                <span class="font-medium">Export Excel</span>
            </button>
            <a href="{{ route('expenses.create') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800">
                <i class="fas fa-plus"></i>
                <span class="font-medium">Ongeza Matumizi</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumla ya Matumizi {{ $year }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($grandTotal, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-xl text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Wastani wa Mwezi</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($grandTotal / 12, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-bar text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Idadi ya Aina</p>
                    <p class="text-2xl font-bold text-green-600">{{ $categories->count() }}</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Matumizi Ya Leo</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($todayTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Year Selector & Help Text -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Year Selector -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center mb-4">
                    <i class="fas fa-calendar-alt text-primary-500 mr-2"></i> Chagua Mwaka
                </h3>
                <form method="GET" action="{{ route('expenses.index') }}" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mwaka</label>
                        <select name="year" onchange="this.form.submit()" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @for($y = 2030; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="w-full px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i>
                        <span>Tumia Chujio</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Help Text -->
        <div class="lg:col-span-2">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Maelekezo ya Matumizi</h3>
                        <p class="text-gray-700 mb-2">
                            <strong>Bofya kwenye kiasi chochote cha mwezi</strong> kuhariri rekodi ya matumizi.
                        </p>
                        <p class="text-gray-700">
                            Tumia kitufe cha <strong>"Ongeza Matumizi"</strong> kuongeza rekodi mpya za matumizi ya kanisa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Grid View -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-table text-primary-500 mr-2"></i> Gridi ya Matumizi ya Mwaka {{ $year }}
                    <span class="ml-3 text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $categories->count() }} aina za matumizi
                    </span>
                </h3>
            </div>
            <div class="mt-3 sm:mt-0">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-mouse-pointer text-primary-500"></i>
                    <span>Bofya kiasi kuhariri</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-primary-600 text-white text-sm">
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider sticky left-0 bg-primary-600">
                            <div class="flex items-center">
                                <i class="fas fa-tags mr-2"></i>
                                Aina ya Matumizi
                            </div>
                        </th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Jan</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Feb</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Mac</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Apr</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Mei</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Jun</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Jul</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Ago</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Sep</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Okt</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Nov</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider">Des</th>
                        <th class="py-4 px-3 text-center font-semibold uppercase tracking-wider bg-green-600">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-calculator mr-2"></i>
                                Jumla
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($gridData as $row)
                    <tr class="bg-white hover:bg-gray-50 transition-all duration-200">
                        <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tag text-gray-600"></i>
                                </div>
                                <span>{{ $row['category']->name }}</span>
                            </div>
                        </td>

                        @for($month = 1; $month <= 12; $month++)
                            @php
                                $monthData = $row['months'][$month];
                                $expense = $monthData['expense'];
                                $amount = $monthData['amount'];
                            @endphp
                            <td class="py-4 px-3 text-center text-sm {{ $expense ? 'cursor-pointer hover:bg-blue-50' : 'text-gray-400' }}"
                                @if($expense)
                                    onclick="window.location.href='{{ route('expenses.edit', $expense->id) }}'"
                                    title="Bofya kuhariri matumizi"
                                @endif>
                                @if($expense)
                                    <div class="text-gray-900 font-medium">{{ number_format($amount, 0) }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-edit text-primary-500"></i>
                                    </div>
                                @else
                                    <div class="text-gray-400">-</div>
                                @endif
                            </td>
                        @endfor

                        <td class="py-4 px-3 text-center text-sm font-bold bg-gray-50">
                            <div class="text-gray-900">{{ number_format($row['total'], 0) }}</div>
                            <div class="text-xs text-gray-500">TSh</div>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Monthly Totals Row -->
                    <tr class="bg-gray-100 font-bold">
                        <td class="py-4 px-6 text-sm text-gray-900 sticky left-0 bg-gray-100">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calculator text-primary-600"></i>
                                </div>
                                <span>JUMLA YA MWEZI</span>
                            </div>
                        </td>
                        @for($month = 1; $month <= 12; $month++)
                            <td class="py-4 px-3 text-center text-sm text-gray-900">
                                <div class="text-gray-900">{{ number_format($monthlyTotals[$month], 0) }}</div>
                                <div class="text-xs text-gray-500">TSh</div>
                            </td>
                        @endfor
                        <td class="py-4 px-3 text-center text-sm text-white bg-green-600">
                            <div class="font-bold text-lg">{{ number_format($grandTotal, 0) }}</div>
                            <div class="text-xs text-green-100">TSh</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Information -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                    Jumla ya matumizi ya mwaka {{ $year }}:
                    <span class="font-bold text-gray-900">{{ number_format($grandTotal, 0) }} TSh</span>
                </div>
                <div class="text-sm text-gray-600">
                    Wastani kwa mwezi:
                    <span class="font-bold text-gray-900">{{ number_format($grandTotal / 12, 0) }} TSh</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportMatumizi() {
    // Get current year
    const year = '{{ $year }}';

    // Redirect to export endpoint
    window.location.href = '{{ route("export.matumizi") }}?year=' + year;
}
</script>
@endpush
@endsection
