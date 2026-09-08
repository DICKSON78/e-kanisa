<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Miundo
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $structures->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $structures->firstItem() }} - {{ $structures->lastItem() }} ya {{ $structures->total() }}
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
                        <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                        <span>Nambari</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Jina</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-money-bill text-xs" style="color: #efc120"></i>
                        <span>Mshahara wa Msingi</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-gift text-xs" style="color: #efc120"></i>
                        <span>Allowances</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-arrow-down text-xs" style="color: #efc120"></i>
                        <span>Kodi</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-coins text-xs" style="color: #efc120"></i>
                        <span>NET</span>
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
            @forelse($structures as $index => $structure)
            @php
                $allowances = ($structure->allowance_housing ?? 0) + ($structure->allowance_transport ?? 0) + ($structure->allowance_food ?? 0) + ($structure->allowance_other ?? 0);
                $totalDeductions = ($structure->nssf_employee ?? 0) + ($structure->nhif_amount ?? 0) + ($structure->paye_amount ?? 0) + ($structure->other_deductions ?? 0);
                $gross = ($structure->basic_salary ?? 0) + $allowances;
                $net = $gross - $totalDeductions;
            @endphp
            <tr class="transition-colors">
                <td>
                    <span class="text-sm text-gray-500">{{ $structures->firstItem() + $index }}</span>
                </td>
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $structure->member->member_number ?? '-' }}</span>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $structure->member->first_name ?? '' }} {{ $structure->member->last_name ?? '' }}</span>
                    </div>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($structure->basic_salary ?? 0, 0) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($allowances, 0) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium" style="color: #ef4444">{{ number_format($totalDeductions, 0) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-bold" style="color: #16a34a">{{ number_format($net, 0) }}</span>
                </td>
                <td>
                    @if($structure->is_active)
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Hai
                        </span>
                    @else
                        <span class="rx-badge" style="background: #f3f4f6; color: #6b7280;">
                            <i class="fas fa-times-circle mr-1"></i>Imesimamishwa
                        </span>
                    @endif
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('payroll.show-structure', $structure->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('payroll.edit-structure', $structure->id) }}" class="rx-icon-btn rx-icon-btn-gold" title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-sitemap text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna Miundo Iliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna miundo ya mishahara iliyopatikana. Anza kwa kuunda muundo mpya.</p>
                        <a href="{{ route('payroll.create-structure') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Muundo Mpya
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($structures->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $structures->links() }}
</div>
@endif
