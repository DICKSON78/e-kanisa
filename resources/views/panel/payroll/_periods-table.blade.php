<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Vikundi vya Mishahara
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $periods->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $periods->firstItem() }} - {{ $periods->lastItem() }} ya {{ $periods->total() }}
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
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Jina la Kipindi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
                        <span>Tarehe ya Malipo</span>
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
                        <i class="fas fa-arrow-up text-xs" style="color: #efc120"></i>
                        <span>Jumla ya GROSS</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-arrow-down text-xs" style="color: #efc120"></i>
                        <span>Jumla ya Kodi</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-coins text-xs" style="color: #efc120"></i>
                        <span>Jumla ya NET</span>
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
            @forelse($periods as $period)
            <tr class="transition-colors">
                <td>
                    <span class="text-sm text-gray-500">{{ $periods->firstItem() + $loop->index }}</span>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-calendar-check text-xs" style="color: #efc120"></i>
                        </div>
                        <a href="{{ route('payroll.show', $period->id) }}" class="text-sm font-semibold hover:underline" style="color: #360958">{{ $period->name }}</a>
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ $period->pay_date ? \Carbon\Carbon::parse($period->pay_date)->format('d/m/Y') : '-' }}
                    </div>
                </td>
                <td>
                    @if($period->status === 'Draft')
                        <span class="rx-badge" style="background: #f3f4f6; color: #6b7280;">
                            <i class="fas fa-file mr-1"></i>Rasimu
                        </span>
                    @elseif($period->status === 'Processing')
                        <span class="rx-badge rx-badge-blue">
                            <i class="fas fa-spinner mr-1"></i>Inachakatwa
                        </span>
                    @elseif($period->status === 'Completed')
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Imekamilika
                        </span>
                    @elseif($period->status === 'Paid')
                        <span class="rx-badge" style="background: #fef3c7; color: #92400e;">
                            <i class="fas fa-money-bill mr-1"></i>Imelipwa
                        </span>
                    @else
                        <span class="rx-badge" style="background: #f3f4f6; color: #6b7280;">
                            <i class="fas fa-question-circle mr-1"></i>{{ $period->status }}
                        </span>
                    @endif
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($period->total_gross ?? 0, 0) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($period->total_deductions ?? 0, 0) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-bold" style="color: #16a34a">{{ number_format($period->total_net ?? 0, 0) }}</span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('payroll.show', $period->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        @if($period->status === 'Draft')
                        <button type="button" onclick="confirmProcess({{ $period->id }}, '{{ addslashes($period->name) }}')" class="rx-icon-btn" style="color: #16a34a; background: rgba(22,163,74,0.1);" title="Chaksha">
                            <i class="fas fa-cogs text-xs"></i>
                        </button>
                        @endif
                        @if($period->status === 'Processing')
                        <button type="button" onclick="confirmApprove({{ $period->id }}, '{{ addslashes($period->name) }}')" class="rx-icon-btn rx-icon-btn-purple" title="Idhini">
                            <i class="fas fa-check-double text-xs"></i>
                        </button>
                        @endif
                        @if($period->status === 'Completed')
                        <button type="button" onclick="confirmPay({{ $period->id }}, '{{ addslashes($period->name) }}')" class="rx-icon-btn rx-icon-btn-gold" title="Lipa">
                            <i class="fas fa-hand-holding-usd text-xs"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-money-check-alt text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna Vikundi vya Mishahara</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna vipindi vya mishahara vilivyopo. Anza kwa kuunda kipindi kipya.</p>
                        <a href="{{ route('payroll.create-period') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Kipindi Kipya
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($periods->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $periods->links() }}
</div>
@endif
