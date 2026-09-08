@extends('layouts.app')

@section('title', 'Taarifa za Tukio - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-calendar" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Taarifa za Tukio</h1>
            <p class="text-sm text-gray-500">Angalia maelezo kamili ya tukio</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('events.edit', $event->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i> Hariri
            </a>
        </div>
    </div>

    <!-- Event Profile Header -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-3xl md:text-4xl flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold">{{ $event->title }}</h2>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="rx-badge text-xs" style="background: rgba(255,255,255,0.2); color: white;">
                                    <i class="fas fa-tag mr-1"></i> {{ $event->event_type }}
                                </span>
                                @if($event->is_active)
                                    <span class="rx-badge text-xs" style="background: rgba(34,197,94,0.3); color: #4ade80;">
                                        <i class="fas fa-check-circle mr-1"></i> Hai
                                    </span>
                                @else
                                    <span class="rx-badge text-xs" style="background: rgba(239,68,68,0.3); color: #f87171;">
                                        <i class="fas fa-times-circle mr-1"></i> Si Hai
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
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-calendar" style="color: #360958"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Tarehe</p>
                    <p class="text-sm font-medium text-gray-900">{{ $event->event_date->format('d/m/Y') }}</p>
                </div>
            </div>
            @if($event->start_time)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Muda</p>
                    <p class="text-sm font-medium text-gray-900">{{ date('H:i', strtotime($event->start_time)) }} - {{ date('H:i', strtotime($event->end_time)) }}</p>
                </div>
            </div>
            @endif
            @if($event->venue)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-emerald-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mahali</p>
                    <p class="text-sm font-medium text-gray-900">{{ $event->venue }}</p>
                </div>
            </div>
            @endif
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Iliyoandikwa na</p>
                    <p class="text-sm font-medium text-gray-900">{{ $event->creator->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            @if($event->description)
            <!-- Description -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Maelezo ya Tukio</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $event->description }}</p>
                </div>
            </div>
            @endif

            @if($event->notes)
            <!-- Notes -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-sticky-note text-xs text-blue-500"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Maelezo Mengine</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $event->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Budget Card -->
            @if($event->budget)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-money-bill-wave text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Bajeti</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Jumla ya Bajeti</span>
                        <span class="text-lg font-bold" style="color: #16a34a">TZS {{ number_format($event->budget, 2) }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Attendance Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-users text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Mahudhurio</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($event->expected_attendance)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-friends w-4 text-center text-gray-400"></i> Watarajiwa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $event->expected_attendance }}</span>
                    </div>
                    @endif
                    @if($event->actual_attendance)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-check w-4 text-center text-gray-400"></i> Waliohudhuria</span>
                        <span class="text-sm font-bold" style="color: #360958">{{ $event->actual_attendance }}</span>
                    </div>
                    @if($event->expected_attendance)
                    <div class="bg-gray-50 rounded-xl p-4 mt-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Asilimia ya Mahudhurio</span>
                            <span class="text-lg font-bold" style="color: #360958">{{ round(($event->actual_attendance / $event->expected_attendance) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full" style="background: linear-gradient(90deg, #360958, #efc120); width: {{ min(($event->actual_attendance / $event->expected_attendance) * 100, 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                    @endif
                    @if(!$event->expected_attendance && !$event->actual_attendance)
                    <div class="text-center py-4">
                        <div class="rx-empty" style="padding: 1rem;">
                            <div class="rx-empty-icon" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;"><i class="fas fa-users-slash"></i></div>
                            <p class="text-gray-500 text-sm">Hakuna taarifa za mahudhurio</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-pie text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Takwimu</h3>
                </div>
                <div class="p-6 space-y-1">
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Muda</span>
                        <span class="text-sm font-medium text-gray-900">{{ $event->event_date->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                        <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar w-4 text-center text-gray-400"></i> Iliandikwa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $event->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2.5">
                        <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar-check w-4 text-center text-gray-400"></i> Tarehe</span>
                        <span class="text-sm font-medium text-gray-900">{{ $event->event_date->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
