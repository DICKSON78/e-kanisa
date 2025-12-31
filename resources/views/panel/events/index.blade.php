@extends('layouts.app')

@section('title', 'Matukio - Mfumo wa Kanisa')
@section('page-title', 'Matukio')
@section('page-subtitle', 'Usimamizi kamili wa matukio ya kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Matukio ya Kanisa</h1>
            <p class="text-gray-600 mt-2">Usimamizi wa ratiba na matukio yote ya kanisa</p>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('events.index', ['filter' => 'upcoming']) }}"
               class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700">
                <i class="fas fa-calendar-alt"></i>
                <span class="font-medium">Yanayokuja</span>
            </a>
            <a href="{{ route('events.index', ['filter' => 'past']) }}"
               class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                <i class="fas fa-history"></i>
                <span class="font-medium">Yaliyopita</span>
            </a>
            <a href="{{ route('events.create') }}"
               class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800">
                <i class="fas fa-plus"></i>
                <span class="font-medium">Ongeza Tukio</span>
            </a>
        </div>
        @endif
    </div>

    @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
    <!-- ADMIN VIEW - Show everything -->

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Events -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumla ya Matukio</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEvents ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-xl text-primary-600"></i>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Yanayokuja</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $upcomingEvents ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Past Events -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Yaliyopita</p>
                    <p class="text-2xl font-bold text-green-600">{{ $pastEvents ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Yanayoendelea</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $activeEvents ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-running text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter text-primary-500 mr-2"></i> Chuja Matukio
            </h3>
        </div>
        <form method="GET" action="{{ route('events.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Event Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aina ya Tukio</label>
                    <select name="event_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Aina Zote</option>
                        <option value="Ibada" {{ request('event_type') === 'Ibada' ? 'selected' : '' }}>Ibada</option>
                        <option value="Semina" {{ request('event_type') === 'Semina' ? 'selected' : '' }}>Semina</option>
                        <option value="Mkutano" {{ request('event_type') === 'Mkutano' ? 'selected' : '' }}>Mkutano</option>
                        <option value="Sherehe" {{ request('event_type') === 'Sherehe' ? 'selected' : '' }}>Sherehe</option>
                        <option value="Kambi" {{ request('event_type') === 'Kambi' ? 'selected' : '' }}>Kambi</option>
                        <option value="Mkesha" {{ request('event_type') === 'Mkesha' ? 'selected' : '' }}>Mkesha</option>
                        <option value="Safari" {{ request('event_type') === 'Safari' ? 'selected' : '' }}>Safari</option>
                        <option value="Tamasha" {{ request('event_type') === 'Tamasha' ? 'selected' : '' }}>Tamasha</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Kuanzia</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Mwisho</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('events.index') }}"
                   class="px-6 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Futa Chujio</span>
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Tumia Chujio</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Events Grid (Visible to ALL users) -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-primary-500 mr-2"></i> Orodha ya Matukio
                    <span class="ml-3 text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $events->total() }} matukio
                    </span>
                </h3>
            </div>
            @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
            <div class="mt-3 sm:mt-0">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500"></i>
                    <span>Angalia au hariri tukio kwa kubofya vitendo</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Events Grid -->
        <div class="p-6">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
                        <!-- Event Header -->
                        <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-white">
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $event->event_type }}
                                </span>
                                <div class="flex items-center gap-2">
                                    @if($event->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Hai
                                    </span>
                                    @endif
                                    @if($event->event_date->isToday())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 animate-pulse">
                                        <i class="fas fa-bell mr-1"></i>
                                        Leo!
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>

                            <!-- Event Date Badge -->
                            <div class="flex items-center bg-white px-3 py-2 rounded-lg border border-gray-200">
                                <div class="text-center mr-3">
                                    <div class="text-2xl font-bold text-primary-600">{{ $event->event_date->format('d') }}</div>
                                    <div class="text-xs text-gray-600">{{ $event->event_date->format('M') }}</div>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $event->event_date->format('l') }}</div>
                                    <div class="text-sm text-gray-600">{{ $event->event_date->format('Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Event Details -->
                        <div class="p-5">
                            <div class="space-y-3 mb-4">
                                @if($event->start_time)
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-clock text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Muda</div>
                                        <div>{{ date('H:i', strtotime($event->start_time)) }} - {{ date('H:i', strtotime($event->end_time)) }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($event->venue)
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Mahali</div>
                                        <div class="line-clamp-1">{{ $event->venue }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($event->expected_attendance)
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-users text-purple-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Wahudhuriaji</div>
                                        <div>
                                            Watarajiwa: {{ $event->expected_attendance }}
                                            @if($event->actual_attendance)
                                            | Waliohudhuria: {{ $event->actual_attendance }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($event->description)
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-900 mb-1">Maelezo</div>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>
                            </div>
                            @endif

                            <!-- Action Buttons (Only for Admin) -->
                            @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                            <div class="flex gap-2 pt-4 border-t border-gray-200">
                                <a href="{{ route('events.show', $event->id) }}"
                                   class="flex-1 text-center px-3 py-2.5 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    <span>Angalia</span>
                                </a>
                                <a href="{{ route('events.edit', $event->id) }}"
                                   class="flex-1 text-center px-3 py-2.5 bg-primary-100 text-primary-700 font-medium rounded-lg hover:bg-primary-200 transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    <span>Hariri</span>
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="flex-1"
                                      onsubmit="return confirm('Je, una uhakika unataka kufuta tukio hili?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full px-3 py-2.5 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 transition-all duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        <span>Futa</span>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna Matukio Yaliyopatikana</h3>
                    <p class="text-gray-500 mb-6">Hakuna matukio yanayolingana na vichujio vyako.</p>
                    @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                    <a href="{{ route('events.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i> Ongeza Tukio la Kwanza
                    </a>
                    @endif
                </div>
            @endif

            <!-- Pagination -->
            @if($events->hasPages())
            <div class="mt-6 pt-6 border-t border-gray-200">
                {{ $events->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Add today's date to date inputs for convenience (only for admin)
@if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    if (startDateInput && !startDateInput.value) {
        startDateInput.value = today;
    }
    if (endDateInput && !endDateInput.value) {
        const nextMonth = new Date();
        nextMonth.setMonth(nextMonth.getMonth() + 1);
        endDateInput.value = nextMonth.toISOString().split('T')[0];
    }
});
@endif
</script>
@endpush
@endsection
