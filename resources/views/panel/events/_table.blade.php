<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Matukio
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $events->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $events->firstItem() }} - {{ $events->lastItem() }} ya {{ $events->total() }}
    </p>
</div>

<!-- Events Grid -->
<div class="p-6">
    @forelse($events as $event)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 mb-4">
            <!-- Event Header -->
            <div class="p-5 border-b border-gray-100">
                <div class="flex justify-between items-start mb-3">
                    <span class="rx-badge rx-badge-purple text-xs">
                        <i class="fas fa-calendar mr-1"></i> {{ $event->event_type }}
                    </span>
                    <div class="flex items-center gap-2">
                        @if($event->is_active)
                            <span class="rx-badge rx-badge-success text-xs"><i class="fas fa-check-circle mr-1"></i> Hai</span>
                        @endif
                        @if($event->event_date->isToday())
                            <span class="rx-badge rx-badge-info text-xs animate-pulse"><i class="fas fa-bell mr-1"></i> Leo!</span>
                        @endif
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->title }}</h3>
                <div class="flex items-center bg-gray-50 px-3 py-2 rounded-xl border border-gray-100">
                    <div class="text-center mr-3">
                        <div class="text-2xl font-bold" style="color: #360958">{{ $event->event_date->format('d') }}</div>
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
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(59,130,246,0.1)">
                            <i class="fas fa-clock" style="color: #3b82f6"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Muda</div>
                            <div>{{ date('H:i', strtotime($event->start_time)) }} - {{ date('H:i', strtotime($event->end_time)) }}</div>
                        </div>
                    </div>
                    @endif
                    @if($event->venue)
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(22,163,74,0.1)">
                            <i class="fas fa-map-marker-alt" style="color: #16a34a"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Mahali</div>
                            <div class="line-clamp-1">{{ $event->venue }}</div>
                        </div>
                    </div>
                    @endif
                    @if($event->expected_attendance)
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(147,51,234,0.1)">
                            <i class="fas fa-users" style="color: #9333ea"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Wahudhuriaji</div>
                            <div>Watarajiwa: {{ $event->expected_attendance }}@if($event->actual_attendance) | Waliohudhuria: {{ $event->actual_attendance }}@endif</div>
                        </div>
                    </div>
                    @endif
                </div>

                @if($event->description)
                <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $event->description }}</p>
                @endif

                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <div class="flex gap-2 pt-4 border-t border-gray-100">
                    <!-- View -->
                    <a href="{{ route('events.show', $event->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                        <i class="fas fa-eye text-xs"></i>
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('events.edit', $event->id) }}" class="rx-icon-btn rx-icon-btn-gold" title="Hariri">
                        <i class="fas fa-pencil-alt text-xs"></i>
                    </a>

                    <!-- Delete -->
                    <button type="button"
                            onclick="confirmAction('delete', {{ $event->id }}, '{{ addslashes($event->title) }}')"
                            class="rx-icon-btn rx-icon-btn-red"
                            title="Futa">
                        <i class="fas fa-trash text-xs"></i>
                    </button>

                    <!-- Hidden Form -->
                    <form id="delete-form-{{ $event->id }}" action="{{ route('events.destroy', $event->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @endif
            </div>
        </div>
    @empty
        <div class="rx-empty">
            <div class="rx-empty-icon">
                <i class="fas fa-calendar-times text-gray-300 text-2xl"></i>
            </div>
            <p class="text-sm font-medium text-gray-900 mb-1">Hakuna matukio yaliyopatikana</p>
            <p class="text-xs text-gray-400 mb-4">Hakuna matukio yanayolingana na vichujio vyako.</p>
            @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
            <a href="{{ route('events.create') }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-plus"></i> Ongeza Tukio la Kwanza
            </a>
            @endif
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($events->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $events->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
