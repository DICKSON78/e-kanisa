<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Uhamisho
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $transfers->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $transfers->firstItem() }} - {{ $transfers->lastItem() }} ya {{ $transfers->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Muumini</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-exchange-alt text-xs" style="color: #efc120"></i>
                        <span>Aina</span>
                    </div>
                </th>
                <th class="hidden md:table-cell">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-church text-xs" style="color: #efc120"></i>
                        <span>Kutoka/Kwenda</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Hali</span>
                    </div>
                </th>
                <th class="hidden md:table-cell">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
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
            @forelse($transfers as $transfer)
            <tr class="transition-colors">
                <!-- Member Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900">{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}</span>
                            @if($transfer->member?->member_number)
                                <div class="text-xs font-mono text-gray-500">{{ $transfer->member->member_number }}</div>
                            @endif
                        </div>
                    </div>
                </td>

                <!-- Transfer Type -->
                <td>
                    @if($transfer->transfer_type == 'Kuingia')
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-sign-in-alt mr-1"></i> Kuingia
                        </span>
                    @else
                        <span class="rx-badge" style="background: #fff7ed; color: #c2410c;">
                            <i class="fas fa-sign-out-alt mr-1"></i> Kutoka
                        </span>
                    @endif
                </td>

                <!-- From/To Church -->
                <td class="hidden md:table-cell">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-church text-gray-400 text-xs"></i>
                        @if($transfer->transfer_type == 'Kuingia')
                            <span>Kutoka: <strong class="text-gray-900">{{ $transfer->from_church ?? '-' }}</strong></span>
                        @else
                            <span>Kwenda: <strong class="text-gray-900">{{ $transfer->to_church ?? '-' }}</strong></span>
                        @endif
                    </div>
                </td>

                <!-- Status -->
                <td>
                    @if($transfer->status == 'Inasubiri')
                        <span class="rx-badge rx-badge-warning">
                            <i class="fas fa-clock mr-1"></i> Inasubiri
                        </span>
                    @elseif($transfer->status == 'Imeidhinishwa')
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i> Imeidhinishwa
                        </span>
                    @elseif($transfer->status == 'Imekataliwa')
                        <span class="rx-badge rx-badge-danger">
                            <i class="fas fa-times-circle mr-1"></i> Imekataliwa
                        </span>
                    @endif
                </td>

                <!-- Date -->
                <td class="hidden md:table-cell">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d/m/Y') }}
                    </div>
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('transfers.show', $transfer->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        @if($transfer->status == 'Inasubiri')
                        <!-- Approve -->
                        <button type="button"
                                onclick="confirmAction('approve', {{ $transfer->id }}, '{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}')"
                                class="rx-icon-btn" style="color: #16a34a; background: rgba(22,163,74,0.1);"
                                onmouseover="this.style.background='rgba(22,163,74,0.2)'"
                                onmouseout="this.style.background='rgba(22,163,74,0.1)'"
                                title="Idhinisha">
                            <i class="fas fa-check text-xs"></i>
                        </button>

                        <!-- Reject -->
                        <button type="button"
                                onclick="confirmAction('reject', {{ $transfer->id }}, '{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Kataa">
                            <i class="fas fa-times text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="approve-form-{{ $transfer->id }}" action="{{ route('transfers.approve', $transfer->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <form id="reject-form-{{ $transfer->id }}" action="{{ route('transfers.reject', $transfer->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 6 : 5 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-exchange-alt text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna uhamisho uliopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna uhamisho unaolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('transfers.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Uhamisho Mpya
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
@if($transfers->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $transfers->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
