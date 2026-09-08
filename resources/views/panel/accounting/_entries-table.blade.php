<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Ingizo
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $entries->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $entries->firstItem() ?? 0 }} - {{ $entries->lastItem() ?? 0 }} ya {{ $entries->total() }}
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
                        <i class="fas fa-file-alt text-xs" style="color: #efc120"></i>
                        <span>Nambari</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-align-left text-xs" style="color: #efc120"></i>
                        <span>Maelezo</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-arrow-up text-xs" style="color: #efc120"></i>
                        <span>Debit</span>
                    </div>
                </th>
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-arrow-down text-xs" style="color: #efc120"></i>
                        <span>Mikopo</span>
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
            @forelse($entries as $index => $entry)
            <tr class="transition-colors">
                <td>
                    <span class="text-sm text-gray-500">{{ $entries->firstItem() + $index }}</span>
                </td>
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $entry->entry_number }}</span>
                </td>
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}
                    </div>
                </td>
                <td>
                    <div class="max-w-[250px]">
                        <span class="text-sm text-gray-900 truncate block">{{ $entry->description }}</span>
                    </div>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($entry->total_debit, 2) }}</span>
                </td>
                <td class="text-right">
                    <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($entry->total_credit, 2) }}</span>
                </td>
                <td>
                    @php
                        $statusBadge = match($entry->status) {
                            'Draft' => 'rx-badge',
                            'Posted' => 'rx-badge-green',
                            'Voided' => 'rx-badge-red',
                            default => 'rx-badge'
                        };
                        $statusStyle = match($entry->status) {
                            'Draft' => 'background: #f3f4f6; color: #6b7280;',
                            default => ''
                        };
                        $statusLabel = match($entry->status) {
                            'Draft' => 'Rasimu',
                            'Posted' => 'Imechapishwa',
                            'Voided' => 'Imefutwa',
                            default => $entry->status
                        };
                    @endphp
                    <span class="rx-badge {{ $statusBadge }}" @if($statusStyle) style="{{ $statusStyle }}" @endif>
                        @if($entry->status === 'Draft')
                            <i class="fas fa-file mr-1"></i>
                        @elseif($entry->status === 'Posted')
                            <i class="fas fa-check-circle mr-1"></i>
                        @elseif($entry->status === 'Voided')
                            <i class="fas fa-ban mr-1"></i>
                        @endif
                        {{ $statusLabel }}
                    </span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('accounting.journal.show', $entry->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        @if($entry->status === 'Draft')
                        <form action="{{ route('accounting.journal.post', $entry->id) }}" method="POST" class="inline" id="post-form-{{ $entry->id }}">
                            @csrf
                        </form>
                        <button type="button"
                                onclick="confirmPost({{ $entry->id }}, '{{ $entry->entry_number }}')"
                                class="rx-icon-btn rx-icon-btn-gold"
                                title="Chapisha">
                            <i class="fas fa-paper-plane text-xs"></i>
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
                            <i class="fas fa-book-open text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna ingizo zilizopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Ingizo hazijapatikana kulingana na vichujio vyako.</p>
                        <a href="{{ route('accounting.journal.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Unda Ingizo Jipya
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($entries->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $entries->links() }}
</div>
@endif

<script>
function confirmPost(id, number) {
    if (typeof showConfirmModal === 'function') {
        showConfirmModal({
            title: 'Chapisha Ingizo',
            message: 'Je, una uhakika unataka kuchapisha ingizo ' + number + '?',
            type: 'warning',
            onConfirm: () => {
                document.getElementById('post-form-' + id).submit();
            }
        });
    } else {
        if (confirm('Chapisha ingizo ' + number + '?')) {
            document.getElementById('post-form-' + id).submit();
        }
    }
}
</script>
