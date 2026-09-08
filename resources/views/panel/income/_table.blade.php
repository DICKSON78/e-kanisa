<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Mapato
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $incomes->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $incomes->firstItem() }} - {{ $incomes->lastItem() }} ya {{ $incomes->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
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
                        <i class="fas fa-money-bill-wave text-xs" style="color: #efc120"></i>
                        <span>Kiasi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Muumini</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-receipt text-xs" style="color: #efc120"></i>
                        <span>Risiti</span>
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
            @forelse($incomes as $income)
            <tr class="transition-colors">

                <!-- Tarehe -->
                <td>
                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($income->collection_date)->format('d/m/Y') }}</div>
                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($income->collection_date)->format('l') }}</div>
                </td>

                <!-- Aina -->
                <td>
                    <span class="rx-badge rx-badge-purple text-xs">
                        <i class="fas fa-tag mr-1"></i> {{ $income->category->name ?? '-' }}
                    </span>
                </td>

                <!-- Kiasi -->
                <td>
                    <span class="text-sm font-bold" style="color: #16a34a">{{ number_format($income->amount, 0) }} TSh</span>
                </td>

                <!-- Muumini -->
                <td>
                    @if($income->member)
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900">{{ $income->member->first_name }} {{ $income->member->last_name }}</span>
                            <div class="text-xs text-gray-500">{{ $income->member->member_number }}</div>
                        </div>
                    </div>
                    @else
                    <span class="text-sm text-gray-400 italic">-</span>
                    @endif
                </td>

                <!-- Risiti -->
                <td>
                    @if($income->receipt_number)
                    <span class="font-mono bg-gray-100 px-2 py-1 rounded-lg text-xs">{{ $income->receipt_number }}</span>
                    @else
                    <span class="text-sm text-gray-400">-</span>
                    @endif
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- Edit -->
                        <a href="{{ route('income.edit', $income->id) }}"
                           class="rx-icon-btn rx-icon-btn-purple"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $income->id }}, '{{ $income->category->name ?? '' }} - {{ number_format($income->amount, 0) }} TSh')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $income->id }}" action="{{ route('income.destroy', $income->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 6 : 5 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-chart-bar text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna mapato yaliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna rekodi za mapato zilizolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('income.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Mapato
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
@if($incomes->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $incomes->links() }}
</div>
@endif

<script>
// Ensure these functions are available when the partial is loaded via AJAX
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
