<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Waumini
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $members->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $members->firstItem() }} - {{ $members->lastItem() }} ya {{ $members->total() }}
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
                        <span>Jina</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-venus-mars text-xs" style="color: #efc120"></i>
                        <span>Jinsia</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-phone text-xs" style="color: #efc120"></i>
                        <span>Simu</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-envelope text-xs" style="color: #efc120"></i>
                        <span>Email</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Uanachama</span>
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
            @forelse($members as $index => $member)
            <tr class="transition-colors"
                data-name="{{ strtolower($member->first_name . ' ' . ($member->middle_name ?? '') . ' ' . $member->last_name) }}"
                data-phone="{{ strtolower($member->phone ?? '') }}"
                data-email="{{ strtolower($member->email ?? '') }}"
                data-member-number="{{ strtolower($member->member_number ?? '') }}"
                data-gender="{{ $member->gender }}"
                data-age-group="{{ $member->age_group ?? '' }}"
                data-special-group="{{ $member->special_group ?? '' }}"
                data-marital-status="{{ $member->marital_status ?? '' }}"
                data-is-active="{{ $member->is_active ? '1' : '0' }}">

                <!-- Member Number -->
                <td>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $member->member_number }}</span>
                        <button onclick="viewQrCode('{{ $member->id }}', '{{ $member->member_number }}')"
                                class="rx-icon-btn rx-icon-btn-purple"
                                title="Angalia QR Code">
                            <i class="fas fa-qrcode text-xs"></i>
                        </button>
                    </div>
                </td>

                <!-- Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->middle_name ?? '' }} {{ $member->last_name }}</span>
                    </div>
                </td>

                <!-- Gender -->
                <td>
                    @if($member->gender == 'Mme')
                        <span class="rx-badge rx-badge-blue">
                            <i class="fas fa-male mr-1"></i> Me
                        </span>
                    @else
                        <span class="rx-badge" style="background: #fce7f3; color: #be185d;">
                            <i class="fas fa-female mr-1"></i> Ke
                        </span>
                    @endif
                </td>

                <!-- Phone -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                        {{ $member->phone }}
                    </div>
                </td>

                <!-- Email -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600 max-w-[180px]">
                        <i class="fas fa-envelope text-gray-400 text-xs flex-shrink-0"></i>
                        @if($member->email)
                            <span class="truncate" title="{{ $member->email }}">{{ $member->email }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                </td>

                <!-- Membership Date -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ \Carbon\Carbon::parse($member->membership_date)->format('d/m/Y') }}
                    </div>
                </td>

                <!-- Status -->
                <td>
                    @if($member->is_active)
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Hai
                        </span>
                    @else
                        <span class="rx-badge rx-badge-yellow">
                            <i class="fas fa-clock mr-1"></i>Inasubiri
                        </span>
                    @endif
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('members.show', $member->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('members.edit', $member->id) }}"
                           class="rx-icon-btn rx-icon-btn-gold"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Activate/Deactivate -->
                        @if($member->is_active)
                        <button type="button"
                                onclick="confirmAction('deactivate', {{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')"
                                class="rx-icon-btn rx-icon-btn-purple"
                                title="Simamisha">
                            <i class="fas fa-user-slash text-xs"></i>
                        </button>
                        @else
                        <button type="button"
                                onclick="confirmAction('activate', {{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')"
                                class="rx-icon-btn" style="color: #16a34a; background: rgba(22,163,74,0.1);"
                                onmouseover="this.style.background='rgba(22,163,74,0.2)'"
                                onmouseout="this.style.background='rgba(22,163,74,0.1)'"
                                title="Anzisha">
                            <i class="fas fa-user-check text-xs"></i>
                        </button>
                        @endif

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="deactivate-form-{{ $member->id }}" action="{{ route('members.deactivate', $member->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <form id="activate-form-{{ $member->id }}" action="{{ route('members.activate', $member->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <form id="delete-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 8 : 7 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-users text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna waumini waliopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna waumini wanaolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('members.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-user-plus"></i> Sajili Muumini Mpya
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
@if($members->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $members->links() }}
</div>
@endif

<script>
// Ensure these functions are available when the partial is loaded via AJAX
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
