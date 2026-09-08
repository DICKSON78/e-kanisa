<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Ahadi na Malipo
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $ahadi->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $ahadi->firstItem() }} - {{ $ahadi->lastItem() }} ya {{ $ahadi->total() }}
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
                        <span>Muumini</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                        <span>Aina ya Ahadi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-hand-holding-usd text-xs" style="color: #efc120"></i>
                        <span>Ahadi (TZS)</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-check-circle text-xs" style="color: #efc120"></i>
                        <span>Imelipwa (TZS)</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-clock text-xs" style="color: #efc120"></i>
                        <span>Salio (TZS)</span>
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
            @forelse($ahadi as $record)
            @php
                $salio = $record->amount - $record->amount_paid;
                $statusBadge = $salio == 0 ? 'rx-badge-success' : ($salio > 0 ? 'rx-badge-warning' : 'rx-badge-danger');
                $statusText = $salio == 0 ? 'Imekamilika' : ($salio > 0 ? 'Sehemu' : 'Bado');
                $memberName = $record->member->full_name ?? 'N/A';
            @endphp
            <tr class="transition-colors">
                <!-- Member -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(54,9,88,0.08)">
                            <span class="text-sm font-medium" style="color: #360958">{{ substr($memberName, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $memberName }}</p>
                            <p class="text-xs text-gray-500">{{ $record->member->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </td>

                <!-- Type -->
                <td>
                    <span class="text-sm text-gray-900">{{ $record->pledge_type ?? 'N/A' }}</span>
                </td>

                <!-- Pledge Amount -->
                <td>
                    <span class="text-lg font-bold" style="color: #360958">{{ number_format($record->amount, 0) }}</span>
                </td>

                <!-- Paid Amount -->
                <td>
                    <span class="text-lg font-bold" style="color: #16a34a">{{ number_format($record->amount_paid, 0) }}</span>
                </td>

                <!-- Balance -->
                <td>
                    <span class="text-lg font-bold" style="color: {{ $salio > 0 ? '#ca8a04' : '#16a34a' }}">{{ number_format($salio, 0) }}</span>
                </td>

                <!-- Status -->
                <td>
                    <span class="rx-badge {{ $statusBadge }}">{{ $statusText }}</span>
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick="viewAhadiDetails('{{ $record->id }}')" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                        <button onclick="confirmAction('delete', '{{ $record->id }}', '{{ $memberName }} - {{ $record->pledge_type }}', 'ahadi')" class="rx-icon-btn rx-icon-btn-red" title="Futa Ahadi">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 7 : 6 }}" class="text-center py-16">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-hands-praying"></i>
                        </div>
                        <h3 class="rx-empty-title">Hakuna rekodi za ahadi</h3>
                        <p class="rx-empty-description">Hakuna rekodi zilizopatikana kwenye kipindi kilichochaguliwa.</p>
                        <a href="{{ route('offerings.index') }}?tab=ahadi" class="rx-btn rx-btn-primary mt-4 inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i> Ongeza Ahadi
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($ahadi->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $ahadi->links() }}
</div>
@endif
