<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Wageni
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $visitors->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $visitors->firstItem() }} - {{ $visitors->lastItem() }} ya {{ $visitors->total() }}
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
                        <span>Jina</span>
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
                        <i class="fas fa-venus-mars text-xs" style="color: #efc120"></i>
                        <span>Jinsia</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe ya Ziara</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-church text-xs" style="color: #efc120"></i>
                        <span>Aina ya Ibada</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Ufuatiliaji</span>
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
            @forelse($visitors as $visitor)
            <tr class="transition-colors"
                data-name="{{ strtolower($visitor->first_name . ' ' . $visitor->last_name) }}"
                data-phone="{{ strtolower($visitor->phone ?? '') }}"
                data-email="{{ strtolower($visitor->email ?? '') }}"
                data-gender="{{ $visitor->gender }}"
                data-status="{{ $visitor->status ?? '' }}"
                data-follow-up="{{ $visitor->follow_up_status ?? '' }}">

                <!-- Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</div>
                            @if($visitor->email)
                                <div class="text-xs text-gray-500 truncate max-w-[160px]" title="{{ $visitor->email }}">{{ $visitor->email }}</div>
                            @endif
                        </div>
                    </div>
                </td>

                <!-- Phone -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                        {{ $visitor->phone }}
                    </div>
                </td>

                <!-- Email -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600 max-w-[180px]">
                        <i class="fas fa-envelope text-gray-400 text-xs flex-shrink-0"></i>
                        @if($visitor->email)
                            <span class="truncate" title="{{ $visitor->email }}">{{ $visitor->email }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                </td>

                <!-- Gender -->
                <td>
                    @if($visitor->gender == 'Mme')
                        <span class="rx-badge rx-badge-blue">
                            <i class="fas fa-male mr-1"></i> Mme
                        </span>
                    @else
                        <span class="rx-badge" style="background: #fce7f3; color: #be185d;">
                            <i class="fas fa-female mr-1"></i> Mke
                        </span>
                    @endif
                </td>

                <!-- Visit Date -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ \Carbon\Carbon::parse($visitor->visit_date)->format('d/m/Y') }}
                    </div>
                </td>

                <!-- Service Type -->
                <td>
                    <span class="rx-badge rx-badge-purple">{{ $visitor->service_type }}</span>
                </td>

                <!-- Follow Up Status -->
                <td>
                    @switch($visitor->follow_up_status)
                        @case('Inasubiri')
                            <span class="rx-badge rx-badge-yellow whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>Inasubiri
                            </span>
                            @break
                        @case('Imeanzishwa')
                            <span class="rx-badge rx-badge-blue whitespace-nowrap">
                                <i class="fas fa-play mr-1"></i>Imeanzishwa
                            </span>
                            @break
                        @case('Imekamilika')
                            <span class="rx-badge rx-badge-green whitespace-nowrap">
                                <i class="fas fa-check-circle mr-1"></i>Imekamilika
                            </span>
                            @break
                        @default
                            <span class="rx-badge rx-badge-gray whitespace-nowrap">
                                {{ $visitor->follow_up_status ?? 'Haijafikiwa' }}
                            </span>
                    @endswitch
                </td>

                <!-- Actions -->
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('visitors.show', $visitor->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('visitors.edit', $visitor->id) }}"
                           class="rx-icon-btn rx-icon-btn-gold"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $visitor->id }}, '{{ $visitor->first_name }} {{ $visitor->last_name }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $visitor->id }}" action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" class="hidden">
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
                            <i class="fas fa-user-friends text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna wageni waliopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna wageni wanaolingana na vichujio vyako.</p>
                        <a href="{{ route('visitors.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-user-plus"></i> Ongeza Mgeni Mpya
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($visitors->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $visitors->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
