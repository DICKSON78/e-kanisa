<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Sadaka
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $sadaka->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $sadaka->firstItem() }} - {{ $sadaka->lastItem() }} ya {{ $sadaka->total() }}
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
                        <span>Aina ya Sadaka</span>
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
                        <i class="fas fa-money-bill-wave text-xs" style="color: #efc120"></i>
                        <span>Kiasi (TZS)</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                        <span>Maelezo</span>
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
            @forelse($sadaka as $record)
            <tr class="transition-colors">
                <!-- Date -->
                <td>
                    <span class="text-sm text-gray-900">{{ $record->collection_date ? $record->collection_date->format('d/m/Y') : 'N/A' }}</span>
                </td>

                <!-- Type -->
                <td>
                    <span class="rx-badge rx-badge-purple">
                        <i class="fas fa-tag mr-1"></i>{{ $record->category->name ?? 'N/A' }}
                    </span>
                </td>

                <!-- Member -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <span class="text-sm font-medium" style="color: #d4a81c">{{ substr($record->member->full_name ?? 'J', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $record->member->full_name ?? 'Jumla' }}</p>
                            @if($record->member && $record->member->phone)
                                <p class="text-xs text-gray-500">{{ $record->member->phone }}</p>
                            @endif
                        </div>
                    </div>
                </td>

                <!-- Amount -->
                <td>
                    <span class="text-lg font-bold" style="color: #16a34a">{{ number_format($record->amount ?? 0, 0) }}</span>
                </td>

                <!-- Notes -->
                <td>
                    <span class="text-sm text-gray-600 max-w-xs truncate block">{{ $record->notes ?? '-' }}</span>
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick="viewSadakaDetails('{{ $record->id }}')" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                        <button onclick="editSadaka('{{ $record->id }}')" class="rx-icon-btn rx-icon-btn-purple" title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </button>
                        <button onclick="confirmAction('delete', '{{ $record->id }}', '{{ $record->category->name ?? "Rekodi" }}', 'sadaka')" class="rx-icon-btn rx-icon-btn-red" title="Futa Rekodi">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 6 : 5 }}" class="text-center py-16">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="rx-empty-title">Hakuna rekodi za sadaka</h3>
                        <p class="rx-empty-description">Hakuna rekodi zilizopatikana kwenye kipindi kilichochaguliwa.</p>
                        <a href="{{ route('offerings.create') }}" class="rx-btn rx-btn-primary mt-4 inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i> Ongeza Rekodi
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($sadaka->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $sadaka->links() }}
</div>
@endif
