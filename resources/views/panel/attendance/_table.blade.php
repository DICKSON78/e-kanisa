<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Uhudhuriaji
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $attendances->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $attendances->firstItem() }} - {{ $attendances->lastItem() }} ya {{ $attendances->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                        <span>#</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-id-card text-xs" style="color: #efc120"></i>
                        <span>Namba ya Muumini</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Jina</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-church text-xs" style="color: #efc120"></i>
                        <span>Aina ya Huduma</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Hali</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                        <span>Vitendo</span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
            <tr class="transition-colors">

                <!-- Iteration -->
                <td>
                    <span class="text-sm text-gray-500">{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}</span>
                </td>

                <!-- Member Number -->
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $attendance->member->member_number ?? 'N/A' }}</span>
                </td>

                <!-- Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $attendance->member->full_name ?? 'N/A' }}</span>
                    </div>
                </td>

                <!-- Date -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ $attendance->attendance_date->format('d/m/Y') }}
                    </div>
                </td>

                <!-- Service Type -->
                <td>
                    <span class="text-sm text-gray-600">{{ $attendance->service_type }}</span>
                </td>

                <!-- Status -->
                <td>
                    @if($attendance->status === 'Hudhuria')
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Hudhuria
                        </span>
                    @elseif($attendance->status === 'Kuchukuliwa')
                        <span class="rx-badge rx-badge-yellow">
                            <i class="fas fa-clock mr-1"></i>Kuchukuliwa
                        </span>
                    @else
                        <span class="rx-badge rx-badge-red">
                            <i class="fas fa-times-circle mr-1"></i>Kutohudhuria
                        </span>
                    @endif
                </td>

                <!-- Actions -->
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $attendance->id }}, '{{ addslashes($attendance->member->full_name ?? 'N/A') }} - {{ $attendance->attendance_date->format('d/m/Y') }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Form -->
                        <form id="delete-form-{{ $attendance->id }}" action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-clipboard-check text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna Rekodi</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna rekodi za uhudhuriaji zinazolingana na vichujio vyako.</p>
                        <button onclick="openAddAttendanceModal()" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Uhudhuriaji
                        </button>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($attendances->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $attendances->links() }}
</div>
@endif

<script>
// Ensure these functions are available when the partial is loaded via AJAX
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
