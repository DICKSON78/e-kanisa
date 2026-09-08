<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Ufuatiliaji
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $followups->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $followups->firstItem() }} - {{ $followups->lastItem() }} ya {{ $followups->total() }}
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
                        <span>Namba</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Mwanachama</span>
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
                        <span>Aina</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-arrow-up text-xs" style="color: #efc120"></i>
                        <span>Kipaumbele</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Hali</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe ya Kufuatilia</span>
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
            @forelse($followups as $followup)
            @php
                $followUpDate = \Carbon\Carbon::parse($followup->follow_up_date);
                $isOverdue = $followUpDate->isPast() && $followup->status !== 'Imekamilika';
            @endphp
            <tr class="transition-colors {{ $isOverdue ? 'border-l-2 border-red-400' : '' }}"
                data-member="{{ strtolower($followup->member->full_name ?? '') }}"
                data-subject="{{ strtolower($followup->subject) }}"
                data-type="{{ $followup->follow_up_type }}"
                data-priority="{{ $followup->priority }}"
                data-status="{{ $followup->status }}">

                <!-- Number -->
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $loop->iteration + ($followups->currentPage() - 1) * $followups->perPage() }}</span>
                </td>

                <!-- Member -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $followup->member->full_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $followup->member->member_number ?? '' }}</div>
                        </div>
                    </div>
                </td>

                <!-- Subject -->
                <td>
                    <a href="{{ route('followups.show', $followup->id) }}" class="text-sm font-medium hover:underline" style="color: #360958">{{ $followup->subject }}</a>
                </td>

                <!-- Type -->
                <td>
                    <span class="rx-badge rx-badge-purple">{{ $followup->follow_up_type }}</span>
                </td>

                <!-- Priority -->
                <td>
                    @if($followup->priority === 'Ya Dharura')
                        <span class="rx-badge rx-badge-red"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>Ya Dharura</span>
                    @elseif($followup->priority === 'Ya Juu')
                        <span class="rx-badge rx-badge-gold"><i class="fas fa-arrow-up mr-1 text-[10px]"></i>Ya Juu</span>
                    @else
                        <span class="rx-badge rx-badge-blue"><i class="fas fa-minus mr-1 text-[10px]"></i>Ya Kawaida</span>
                    @endif
                </td>

                <!-- Status -->
                <td>
                    @if($followup->status === 'Inasubiri')
                        <span class="rx-badge rx-badge-yellow"><i class="fas fa-clock mr-1 text-[10px]"></i>Inasubiri</span>
                    @elseif($followup->status === 'Imeanzishwa')
                        <span class="rx-badge rx-badge-blue"><i class="fas fa-play-circle mr-1 text-[10px]"></i>Imeanzishwa</span>
                    @else
                        <span class="rx-badge rx-badge-green"><i class="fas fa-check-circle mr-1 text-[10px]"></i>Imekamilika</span>
                    @endif
                </td>

                <!-- Follow Up Date -->
                <td>
                    <span class="text-sm {{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-600' }}">{{ $followUpDate->format('d/m/Y') }}</span>
                    @if($isOverdue)
                        <span class="text-[10px] text-red-500 block"><i class="fas fa-exclamation-triangle"></i> imepita muda</span>
                    @endif
                </td>

                <!-- Actions -->
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('followups.show', $followup->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('followups.edit', $followup->id) }}"
                           class="rx-icon-btn rx-icon-btn-gold"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $followup->id }}, '{{ addslashes($followup->subject) }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $followup->id }}" action="{{ route('followups.destroy', $followup->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-headset text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna ufuatiliaji uliopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna ufutiliaji unaolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('followups.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Ufuatiliaji Mpya
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
@if($followups->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $followups->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
