@php
function formatRequestMoney($amount) {
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
        Orodha ya Maombi
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">{{ $requests->total() }} total</span>
    </h3>
    <p class="text-sm text-gray-500">Kuonyesha {{ $requests->firstItem() }} - {{ $requests->lastItem() }} ya {{ $requests->total() }}</p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th><div class="flex items-center gap-1.5"><i class="fas fa-hashtag text-xs" style="color: #efc120"></i><span>Namba</span></div></th>
                <th><div class="flex items-center gap-1.5"><i class="fas fa-heading text-xs" style="color: #efc120"></i><span>Kichwa/Idara</span></div></th>
                <th><div class="flex items-center gap-1.5"><i class="fas fa-coins text-xs" style="color: #efc120"></i><span>Kiasi</span></div></th>
                <th><div class="flex items-center gap-1.5"><i class="fas fa-route text-xs" style="color: #efc120"></i><span>Idhinishaji</span></div></th>
                <th><div class="flex items-center gap-1.5"><i class="fas fa-circle text-xs" style="color: #efc120"></i><span>Hali</span></div></th>
                <th class="hidden md:table-cell"><div class="flex items-center gap-1.5"><i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i><span>Tarehe</span></div></th>
                <th class="text-right"><div class="flex items-center justify-end gap-1.5"><i class="fas fa-cogs text-xs" style="color: #efc120"></i><span>Vitendo</span></div></th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr class="transition-colors">
                <td>
                    <span class="text-xs font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $req->request_number }}</span>
                </td>
                <td>
                    <div class="text-sm text-gray-900 font-medium truncate max-w-[200px]">{{ $req->title }}</div>
                    <span class="rx-badge rx-badge-purple text-[10px] mt-1">{{ $req->department }}</span>
                </td>
                <td>
                    <div class="text-sm font-bold text-gray-900">{{ formatRequestMoney($req->amount_requested) }}</div>
                    @if($req->amount_approved)
                        <div class="text-xs mt-0.5" style="color: #16a34a">
                            <i class="fas fa-check text-[10px]"></i> {{ formatRequestMoney($req->amount_approved) }}
                        </div>
                    @endif
                </td>
                <td>
                    @if($req->max_level > 0 && $req->steps->count() > 0)
                        <div class="flex items-center gap-1">
                            @foreach($req->steps->sortBy('level') as $step)
                                @if($step->acted_at)
                                    @if($step->decision === 'approved')
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center" style="background: rgba(22,163,74,0.1); border: 1.5px solid #16a34a;" title="{{ $step->role_required }}: Imekubaliwa">
                                            <i class="fas fa-check text-[7px]" style="color: #16a34a"></i>
                                        </div>
                                    @else
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center" style="background: rgba(239,68,68,0.1); border: 1.5px solid #ef4444;" title="{{ $step->role_required }}: Imekataliwa">
                                            <i class="fas fa-times text-[7px]" style="color: #ef4444"></i>
                                        </div>
                                    @endif
                                @elseif($step->level == $req->current_level && $req->status === 'Inasubiri')
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center animate-pulse" style="background: rgba(239,193,32,0.15); border: 1.5px solid #efc120;" title="{{ $step->role_required }}: Inasubiri">
                                        <i class="fas fa-clock text-[7px]" style="color: #d4a81c"></i>
                                    </div>
                                @else
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center" style="background: #f3f4f6; border: 1.5px solid #d1d5db;" title="{{ $step->role_required }}: Inasubiri">
                                        <i class="fas fa-lock text-[7px] text-gray-400"></i>
                                    </div>
                                @endif
                                @if(!$loop->last)
                                    @if($step->acted_at && $step->decision === 'approved')
                                        <div class="w-2 h-0.5" style="background: #16a34a;"></div>
                                    @else
                                        <div class="w-2 h-0.5 bg-gray-200"></div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $req->steps->whereNotNull('acted_at')->count() }}/{{ $req->max_level }} hatua</div>
                    @else
                        <span class="text-xs text-gray-400">&mdash;</span>
                    @endif
                </td>
                <td>
                    @if($req->status == 'Inasubiri')
                        <span class="rx-badge rx-badge-yellow text-[10px]"><i class="fas fa-clock mr-1 text-[9px]"></i> Inasubiri</span>
                    @elseif($req->status == 'Imeidhinishwa')
                        <span class="rx-badge rx-badge-green text-[10px]"><i class="fas fa-check mr-1 text-[9px]"></i> Imeidhinishwa</span>
                    @elseif($req->status == 'Imekataliwa')
                        <span class="rx-badge rx-badge-red text-[10px]"><i class="fas fa-times mr-1 text-[9px]"></i> Imekataliwa</span>
                    @endif
                </td>
                <td class="hidden md:table-cell">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ \Carbon\Carbon::parse($req->requested_date)->format('d/m/Y') }}
                    </div>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('requests.show', $req->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        @if($req->status == 'Inasubiri')
                        <a href="{{ route('requests.edit', $req->id) }}" class="rx-icon-btn rx-icon-btn-purple" title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>
                        @endif
                        <button type="button" onclick="confirmAction('delete', {{ $req->id }}, '{{ $req->request_number }}')" class="rx-icon-btn rx-icon-btn-red" title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                        <form id="delete-form-{{ $req->id }}" action="{{ route('requests.destroy', $req->id) }}" method="POST" class="hidden">
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
                            <i class="fas fa-file-invoice-dollar text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna maombi yaliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna maombi yanayolingana na vichujio vyako.</p>
                        <a href="{{ route('requests.create') }}" class="rx-btn rx-btn-primary"><i class="fas fa-plus"></i> Ongeza Ombi Jipya</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($requests->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $requests->links() }}
</div>
@endif
