@php
function formatApprovalMoney($amount) {
    if ($amount >= 1000000000) { return number_format($amount / 1000000000, 2) . 'B'; }
    elseif ($amount >= 1000000) { return number_format($amount / 1000000, 2) . 'M'; }
    elseif ($amount >= 1000) { return number_format($amount / 1000, 1) . 'K'; }
    else { return number_format($amount, 0); }
}
@endphp

<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Maombi ya Idhini
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $approvals->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $approvals->firstItem() }} - {{ $approvals->lastItem() }} ya {{ $approvals->total() }}
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
                        <i class="fas fa-heading text-xs" style="color: #efc120"></i>
                        <span>Kichwa</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-building text-xs" style="color: #efc120"></i>
                        <span>Idara</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-coins text-xs" style="color: #efc120"></i>
                        <span>Kiasi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-xs" style="color: #efc120"></i>
                        <span>Kiwango</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-flag text-xs" style="color: #efc120"></i>
                        <span>Kipaumbele</span>
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
            @forelse($approvals as $index => $approval)
            <tr class="transition-colors">
                <!-- Approval Number -->
                <td>
                    <span class="text-xs font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $approval->approval_number }}</span>
                </td>

                <!-- Title -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-file-signature text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 truncate max-w-[200px]">{{ $approval->title }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $approval->requested_date ? $approval->requested_date->format('d/m/Y') : '-' }}</div>
                        </div>
                    </div>
                </td>

                <!-- Department -->
                <td>
                    <span class="rx-badge rx-badge-purple text-[10px]">{{ $approval->department->name ?? '-' }}</span>
                </td>

                <!-- Amount -->
                <td>
                    <div class="text-sm font-bold text-gray-900">TZS {{ formatApprovalMoney($approval->amount_requested) }}</div>
                    @if($approval->amount_approved)
                        <div class="text-xs mt-0.5" style="color: #16a34a">
                            <i class="fas fa-check text-[10px]"></i> TZS {{ formatApprovalMoney($approval->amount_approved) }}
                        </div>
                    @endif
                </td>

                <!-- Level -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-layer-group text-gray-400 text-xs"></i>
                        {{ $approval->current_level }}/{{ $approval->max_level }}
                    </div>
                </td>

                <!-- Priority -->
                <td>
                    @if($approval->priority == 'Dharura')
                        <span class="rx-badge rx-badge-red text-[10px]">
                            <i class="fas fa-exclamation-triangle mr-1 text-[9px]"></i> Dharura
                        </span>
                    @elseif($approval->priority == 'Ya Juu')
                        <span class="rx-badge rx-badge-yellow text-[10px]">
                            <i class="fas fa-arrow-up mr-1 text-[9px]"></i> Ya Juu
                        </span>
                    @else
                        <span class="rx-badge rx-badge-gray text-[10px]">
                            <i class="fas fa-minus mr-1 text-[9px]"></i> Ya Kawaida
                        </span>
                    @endif
                </td>

                <!-- Status -->
                <td>
                    @if($approval->status == 'Inasubiri')
                        <span class="rx-badge rx-badge-yellow text-[10px]">
                            <i class="fas fa-clock mr-1 text-[9px]"></i> Inasubiri
                        </span>
                    @elseif(in_array($approval->status, ['Mapitio ya Mhasibu', 'Imeidhinishwa na Mchungaji', 'Yakifuata Hatua']))
                        <span class="rx-badge rx-badge-blue text-[10px]">
                            <i class="fas fa-spinner mr-1 text-[9px]"></i> Yakifuata Hatua
                        </span>
                    @elseif($approval->status == 'Imekamilika')
                        <span class="rx-badge rx-badge-green text-[10px]">
                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Yaidhinishwa
                        </span>
                    @elseif($approval->status == 'Imekataliwa')
                        <span class="rx-badge rx-badge-red text-[10px]">
                            <i class="fas fa-times-circle mr-1 text-[9px]"></i> Yakataliwa
                        </span>
                    @else
                        <span class="rx-badge rx-badge-gray text-[10px]">{{ $approval->status }}</span>
                    @endif
                </td>

                <!-- Actions -->
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('approvals.show', $approval->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        @if($approval->status !== 'Imekataliwa' && $approval->status !== 'Imekamilika')
                            @if(auth()->user() && $approval->canBeApprovedBy(auth()->user()))
                            <a href="{{ route('approvals.show', $approval->id) }}#approve" class="rx-icon-btn rx-icon-btn-gold" title="Idhini">
                                <i class="fas fa-check text-xs"></i>
                            </a>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-file-signature text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna maombi yaliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna maombi yanayolingana na vichujio vyako.</p>
                        <a href="{{ route('approvals.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Omba Idhini Mpya
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($approvals->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $approvals->links() }}
</div>
@endif
