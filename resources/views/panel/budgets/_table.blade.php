<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Bajeti
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $budgets->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $budgets->firstItem() }} - {{ $budgets->lastItem() }} ya {{ $budgets->total() }}
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
                        <span>Nambari</span>
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
                        <i class="fas fa-tags text-xs" style="color: #efc120"></i>
                        <span>Kundi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
                        <span>Mwezi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-coins text-xs" style="color: #efc120"></i>
                        <span>Bajeti</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-receipt text-xs" style="color: #efc120"></i>
                        <span>Halisi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-balance-scale text-xs" style="color: #efc120"></i>
                        <span>Taslimu</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-signal text-xs" style="color: #efc120"></i>
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
            @forelse($budgets as $budget)
            <tr class="transition-colors">

                <!-- Budget Number -->
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $budget->budget_number }}</span>
                </td>

                <!-- Title -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(59,130,246,0.1)">
                            <i class="fas fa-heading text-xs" style="color: #3b82f6"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $budget->title }}</span>
                    </div>
                </td>

                <!-- Category -->
                <td>
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-md flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-tag text-[10px]" style="color: #efc120"></i>
                        </div>
                        <span class="text-sm text-gray-600">{{ $budget->category->name ?? 'Jumla' }}</span>
                    </div>
                </td>

                <!-- Month -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar text-gray-400 text-xs"></i>
                        {{ $budget->month_name }}
                    </div>
                </td>

                <!-- Budgeted Amount -->
                <td>
                    <span class="text-sm font-semibold text-gray-900">TZS {{ number_format($budget->budgeted_amount) }}</span>
                </td>

                <!-- Actual Amount -->
                <td>
                    <span class="text-sm text-gray-900">TZS {{ number_format($budget->actual_amount) }}</span>
                </td>

                <!-- Remaining -->
                <td>
                    <span class="text-sm font-semibold {{ $budget->remaining_amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        TZS {{ number_format($budget->remaining_amount) }}
                    </span>
                </td>

                <!-- Status -->
                <td>
                    @if($budget->status === 'Active')
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Active
                        </span>
                    @elseif($budget->status === 'Completed')
                        <span class="rx-badge rx-badge-blue">
                            <i class="fas fa-check-double mr-1"></i>Completed
                        </span>
                    @else
                        <span class="rx-badge rx-badge-gray">
                            <i class="fas fa-ban mr-1"></i>Cancelled
                        </span>
                    @endif
                </td>

                <!-- Actions -->
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('budgets.show', $budget->id) }}"
                           class="rx-icon-btn rx-icon-btn-purple"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('budgets.edit', $budget->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Hariri">
                            <i class="fas fa-edit text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $budget->id }}, '{{ addslashes($budget->title) }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $budget->id }}" action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-chart-pie text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna bajeti zilizopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna bajeti zinazolingana na vichujio vyako.</p>
                        <a href="{{ route('budgets.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Bajeti
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($budgets->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $budgets->links() }}
</div>
@endif

<script>
// Ensure these functions are available when the partial is loaded via AJAX
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
