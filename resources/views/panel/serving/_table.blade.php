<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Ratiba
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $schedules->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $schedules->firstItem() }} - {{ $schedules->lastItem() }} ya {{ $schedules->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-heading text-xs" style="color: #efc120"></i>
                        <span>Kichwa</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                        <span>Aina ya Huduma</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-users text-xs" style="color: #efc120"></i>
                        <span>Waliopangwa</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Hali</span>
                    </div>
                </th>
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                        <span>Vitendo</span>
                    </div>
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
            <tr class="transition-colors"
                data-title="{{ strtolower($schedule->title) }}"
                data-description="{{ strtolower($schedule->description ?? '') }}"
                data-service-type="{{ $schedule->service_type }}"
                data-status="{{ $schedule->status }}">

                <!-- Date -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        <div>
                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('l') }}</div>
                        </div>
                    </div>
                </td>

                <!-- Title -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-calendar-check text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <a href="{{ route('serving.show', $schedule->id) }}" class="text-sm font-medium hover:underline" style="color: #360958">{{ $schedule->title }}</a>
                            @if($schedule->description)
                                <div class="text-xs text-gray-400 mt-1 max-w-[200px] truncate">{{ $schedule->description }}</div>
                            @endif
                        </div>
                    </div>
                </td>

                <!-- Service Type -->
                <td>
                    <span class="rx-badge rx-badge-purple">{{ $schedule->service_type }}</span>
                </td>

                <!-- Assignments -->
                <td>
                    <span class="rx-badge rx-badge-blue">
                        <i class="fas fa-users mr-1"></i>{{ $schedule->assignments_count ?? $schedule->assignments->count() }}
                    </span>
                </td>

                <!-- Status -->
                <td>
                    @php
                        $statusClass = match($schedule->status) {
                            'Inayokuja' => 'rx-badge-blue',
                            'Inaendelea' => 'rx-badge-green',
                            'Imekamilika' => 'rx-badge-gray',
                            'Imesitishwa' => 'rx-badge-red',
                            default => 'rx-badge-yellow',
                        };
                        $statusIcon = match($schedule->status) {
                            'Inayokuja' => 'fa-clock',
                            'Inaendelea' => 'fa-spinner',
                            'Imekamilika' => 'fa-check-circle',
                            'Imesitishwa' => 'fa-times-circle',
                            default => 'fa-question-circle',
                        };
                    @endphp
                    <span class="rx-badge {{ $statusClass }}">
                        <i class="fas {{ $statusIcon }} mr-1 text-[10px]"></i>{{ $schedule->status }}
                    </span>
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('serving.show', $schedule->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('serving.edit', $schedule->id) }}"
                           class="rx-icon-btn rx-icon-btn-gold"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $schedule->id }}, '{{ addslashes($schedule->title) }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $schedule->id }}" action="{{ route('serving.destroy', $schedule->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 6 : 5 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-calendar-times text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna Ratiba Zilizopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna ratiba zinazolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('serving.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Ratiba ya Kwanza
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($schedules->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $schedules->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
