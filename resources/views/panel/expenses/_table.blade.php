<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Matumizi
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $categories->count() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Mwaka {{ $year }} &middot; {{ number_format($grandTotal, 0) }} TSh
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    @if(count($gridData) > 0)
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-tags text-xs" style="color: #efc120"></i>
                        <span>Aina ya Matumizi</span>
                    </div>
                </th>
                @for($month = 1; $month <= 12; $month++)
                    <th>
                        <div class="flex items-center justify-center gap-1.5">
                            <span>{{ ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ago','Sep','Okt','Nov','Des'][$month-1] }}</span>
                        </div>
                    </th>
                @endfor
                <th>
                    <div class="flex items-center justify-center gap-1.5" style="color: #16a34a">
                        <i class="fas fa-calculator text-xs"></i>
                        <span>Jumla</span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($gridData as $row)
            <tr class="transition-colors">
                <!-- Category Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $row['category']->name }}</span>
                    </div>
                </td>

                @for($month = 1; $month <= 12; $month++)
                    @php
                        $monthData = $row['months'][$month];
                        $expenses = $monthData['expenses'];
                        $expenseCount = $monthData['expense_count'];
                        $amount = $monthData['amount'];
                    @endphp
                    <td class="py-3 px-3 text-center text-sm {{ $expenses ? 'cursor-pointer hover:bg-blue-50' : 'text-gray-400' }}"
                        @if($expenses)
                            onclick="window.location.href='{{ route('expenses.monthly', ['year' => $year, 'month' => $month]) }}'"
                            title="Bofya kuona matumizi ya mwezi huu"
                        @endif>
                        @if($expenses)
                            <div class="text-sm font-medium text-gray-900">{{ number_format($amount, 0) }}</div>
                            <div class="text-xs mt-1">
                                @if($expenseCount > 1)
                                    <span class="rx-badge rx-badge-info text-xs">{{ $expenseCount }} rekodi</span>
                                @else
                                    <i class="fas fa-eye" style="color: #efc120"></i>
                                @endif
                            </div>
                        @else
                            <div class="text-gray-400">-</div>
                        @endif
                    </td>
                @endfor

                <!-- Category Total -->
                <td class="py-3 px-3 text-center text-sm font-bold bg-gray-50/80">
                    <div class="text-gray-900">{{ number_format($row['total'], 0) }}</div>
                    <div class="text-xs text-gray-500">TSh</div>
                </td>
            </tr>
            @endforeach

            <!-- Monthly Totals Row -->
            <tr class="bg-gray-100/80 font-bold border-t-2 border-gray-200">
                <td class="py-3 px-6 text-sm text-gray-900">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(54,9,88,0.08)">
                            <i class="fas fa-calculator text-xs" style="color: #360958"></i>
                        </div>
                        <span>JUMLA YA MWEZI</span>
                    </div>
                </td>
                @for($month = 1; $month <= 12; $month++)
                    <td class="py-3 px-3 text-center text-sm text-gray-900">
                        <div>{{ number_format($monthlyTotals[$month], 0) }}</div>
                        <div class="text-xs text-gray-500">TSh</div>
                    </td>
                @endfor
                <td class="py-3 px-3 text-center text-sm text-white" style="background: #16a34a">
                    <div class="font-bold text-lg">{{ number_format($grandTotal, 0) }}</div>
                    <div class="text-xs opacity-80">TSh</div>
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="rx-empty">
        <div class="rx-empty-icon">
            <i class="fas fa-money-bill-wave text-gray-300 text-2xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna matumizi yaliyopatikana</p>
        <p class="text-xs text-gray-400 mb-4">Hakuna aina za matumizi zilizowekwa kwa mwaka huu.</p>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <a href="{{ route('expenses.create') }}" class="rx-btn rx-btn-primary">
            <i class="fas fa-plus"></i> Ongeza Matumizi
        </a>
        @endif
    </div>
    @endif
</div>

<!-- Footer -->
@if(count($gridData) > 0)
<div class="px-6 py-4 border-t border-gray-200">
    <div class="flex items-center justify-between text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <i class="fas fa-info-circle" style="color: #efc120"></i>
            Jumla ya matumizi ya mwaka {{ $year }}: <span class="font-bold text-gray-900">{{ number_format($grandTotal, 0) }} TSh</span>
        </div>
        <div>Wastani kwa mwezi: <span class="font-bold text-gray-900">{{ number_format($grandTotal / 12, 0) }} TSh</span></div>
    </div>
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
