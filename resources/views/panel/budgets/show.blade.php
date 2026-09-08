@extends('layouts.app')
@section('title', 'Bajeti - ' . $budget->title)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('budgets.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-chart-pie" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $budget->title }}</h1>
            <p class="text-sm text-gray-500">Maelezo ya bajeti {{ $budget->budget_number }}</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('budgets.edit', $budget->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i> Hariri
            </a>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Icon Avatar -->
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <!-- Info -->
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold truncate">{{ $budget->title }}</h2>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 text-sm text-white/80">
                                    <i class="fas fa-hashtag text-xs"></i> {{ $budget->budget_number }}
                                </span>
                                @if($budget->status === 'Active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(34,197,94,0.2); color: #4ade80;">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @elseif($budget->status === 'Completed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(59,130,246,0.2); color: #60a5fa;">
                                        <i class="fas fa-check-double"></i> Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(107,114,128,0.2); color: #9ca3af;">
                                        <i class="fas fa-ban"></i> Cancelled
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Bar -->
        <div class="px-6 md:px-8 py-4 border-b border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-calendar" style="color: #3b82f6" class="text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mwaka</p>
                    <p class="text-sm font-medium text-gray-900">{{ $budget->year }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-calendar-day" style="color: #9333ea" class="text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mwezi</p>
                    <p class="text-sm font-medium text-gray-900">{{ $budget->month_name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-tags" style="color: #16a34a" class="text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Kundi</p>
                    <p class="text-sm font-medium text-gray-900">{{ $budget->category->name ?? 'Jumla' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-percentage" style="color: #efc120" class="text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Asilimia</p>
                    <p class="text-sm font-medium text-gray-900">{{ $budget->progress_percentage }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (Main Content) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Kiasi Kilichopangwa</p>
                            <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($budget->budgeted_amount) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                            <i class="fas fa-wallet" style="color: #3b82f6"></i>
                        </div>
                    </div>
                </div>
                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Matumizi Halisi</p>
                            <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($totalActual) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                            <i class="fas fa-money-bill-wave" style="color: #16a34a"></i>
                        </div>
                    </div>
                </div>
                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Yaliyobaki</p>
                            <p class="text-2xl font-bold {{ $budget->remaining_amount >= 0 ? 'text-gray-900' : 'text-red-600' }}">TZS {{ number_format($budget->remaining_amount) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: {{ $budget->remaining_amount >= 0 ? 'rgba(239,193,32,0.1)' : 'rgba(239,68,68,0.1)' }}">
                            <i class="fas fa-piggy-bank" style="color: {{ $budget->remaining_amount >= 0 ? '#efc120' : '#ef4444' }}"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-line text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Asilimia ya Matumizi</h3>
                </div>
                <div class="p-6">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="h-4 rounded-full {{ $budget->progress_percentage > 100 ? 'bg-red-500' : ($budget->progress_percentage > 80 ? 'bg-yellow-500' : 'bg-green-500') }}" style="width: {{ min($budget->progress_percentage, 100) }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">{{ $budget->progress_percentage }}% ya bajeti imetumika</p>
                </div>
            </div>

            <!-- Actual Expenses Table -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-receipt text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Matumizi Halisi</h3>
                    <span class="rx-badge rx-badge-green text-xs">{{ $expenses->count() }} rekodi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center"><i class="fas fa-calendar mr-2 text-gray-400"></i>Tarehe</div>
                                </th>
                                <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center"><i class="fas fa-tags mr-2 text-gray-400"></i>Kundi</div>
                                </th>
                                <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center"><i class="fas fa-coins mr-2 text-gray-400"></i>Kiasi</div>
                                </th>
                                <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center"><i class="fas fa-sticky-note mr-2 text-gray-400"></i>Maelezo</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-6 text-sm text-gray-800">{{ $expense->expense_date?->format('d/m/Y') ?? 'N/A' }}</td>
                                <td class="py-3 px-6 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-md flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-tag text-[10px]" style="color: #efc120"></i>
                                        </div>
                                        {{ $expense->category->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-sm font-semibold text-gray-900">TZS {{ number_format($expense->amount) }}</td>
                                <td class="py-3 px-6 text-sm text-gray-600">{{ $expense->notes ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="rx-empty">
                                        <div class="rx-empty-icon">
                                            <i class="fas fa-receipt text-2xl" style="color: #9ca3af"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-1">Hakuna Matumizi</h3>
                                        <p class="text-sm text-gray-500">Hakuna matumizi kwa bajeti hii bado.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column (Sidebar) -->
        <div class="space-y-6">
            <!-- Budget Details Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Bajeti</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-0">
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-hashtag w-4 text-center text-gray-400"></i> Nambari</span>
                            <span class="text-sm font-medium text-gray-900">{{ $budget->budget_number }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar w-4 text-center text-gray-400"></i> Mwaka</span>
                            <span class="text-sm font-medium text-gray-900">{{ $budget->year }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar-day w-4 text-center text-gray-400"></i> Mwezi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $budget->month_name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-tags w-4 text-center text-gray-400"></i> Kundi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $budget->category->name ?? 'Jumla' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-signal w-4 text-center text-gray-400"></i> Hali</span>
                            @if($budget->status === 'Active')
                                <span class="rx-badge rx-badge-green text-xs"><i class="fas fa-check-circle mr-1"></i> Active</span>
                            @elseif($budget->status === 'Completed')
                                <span class="rx-badge rx-badge-blue text-xs"><i class="fas fa-check-double mr-1"></i> Completed</span>
                            @else
                                <span class="rx-badge rx-badge-gray text-xs"><i class="fas fa-ban mr-1"></i> Cancelled</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-percentage w-4 text-center text-gray-400"></i> Asilimia</span>
                            <span class="text-sm font-medium text-gray-900">{{ $budget->progress_percentage }}%</span>
                        </div>
                    </div>
                    @if($budget->description)
                    <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Maelezo</p>
                        <p class="text-sm text-gray-700">{{ $budget->description }}</p>
                    </div>
                    @endif
                    @if($budget->notes)
                    <div class="mt-3 p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Maelezo ya Ziada</p>
                        <p class="text-sm text-gray-700">{{ $budget->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Vitendo</h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('budgets.edit', $budget->id) }}" class="rx-btn rx-btn-primary w-full justify-center">
                        <i class="fas fa-edit"></i> Hariri Bajeti
                    </a>
                    <a href="{{ route('budgets.index') }}" class="rx-btn rx-btn-secondary w-full justify-center">
                        <i class="fas fa-arrow-left"></i> Rudi Orodha
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
