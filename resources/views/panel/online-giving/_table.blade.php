<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Malipo ya Mtandaoni
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $transactions->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} ya {{ $transactions->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Tarehe</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        <span>Mwanachama</span>
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
                        <i class="fas fa-mobile-alt text-xs" style="color: #efc120"></i>
                        <span>Njia ya Malipo</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-bullseye text-xs" style="color: #efc120"></i>
                        <span>Lengo</span>
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
            @forelse($transactions as $transaction)
            <tr class="transition-colors">
                <!-- Date -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        <div>
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</div>
                        </div>
                    </div>
                </td>

                <!-- Member -->
                <td>
                    @if($transaction->member)
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-xs" style="color: #efc120"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $transaction->member->first_name }} {{ $transaction->member->last_name }}</div>
                            <div class="text-xs text-gray-400">{{ $transaction->member->member_number }}</div>
                        </div>
                    </div>
                    @else
                    <span class="text-xs text-gray-400 italic">Nje ya mfumo</span>
                    @endif
                </td>

                <!-- Amount -->
                <td>
                    <div class="text-sm font-bold" style="color: #16a34a">{{ number_format($transaction->amount, 0) }} TSh</div>
                </td>

                <!-- Payment Method -->
                <td>
                    @php
                        $methodBadge = ['M-Pesa' => 'rx-badge-green', 'Tigo Pesa' => 'rx-badge-red', 'Airtel Money' => 'rx-badge-blue', 'Bank Transfer' => 'rx-badge-purple'];
                        $methodIcons = ['M-Pesa' => 'fas fa-mobile-alt', 'Tigo Pesa' => 'fas fa-mobile-alt', 'Airtel Money' => 'fas fa-mobile-alt', 'Bank Transfer' => 'fas fa-university'];
                    @endphp
                    <span class="rx-badge {{ $methodBadge[$transaction->payment_method] ?? 'rx-badge-default' }} text-[10px]">
                        <i class="{{ $methodIcons[$transaction->payment_method] ?? 'fas fa-credit-card' }} mr-1"></i>
                        {{ $transaction->payment_method }}
                    </span>
                </td>

                <!-- Purpose -->
                <td>
                    <span class="text-sm text-gray-600">{{ $transaction->purpose }}</span>
                </td>

                <!-- Status -->
                <td>
                    @php
                        $statusBadge = ['Inasubiri' => 'rx-badge-yellow', 'Imekamilika' => 'rx-badge-green', 'Imeshindwa' => 'rx-badge-red', 'Imerejeshwa' => 'rx-badge-blue'];
                    @endphp
                    <span class="rx-badge {{ $statusBadge[$transaction->status] ?? 'rx-badge-default' }} text-[10px]">
                        @if($transaction->status === 'Inasubiri')
                            <i class="fas fa-clock mr-1 text-[9px]"></i>
                        @elseif($transaction->status === 'Imekamilika')
                            <i class="fas fa-check-circle mr-1 text-[9px]"></i>
                        @elseif($transaction->status === 'Imeshindwa')
                            <i class="fas fa-times-circle mr-1 text-[9px]"></i>
                        @elseif($transaction->status === 'Imerejeshwa')
                            <i class="fas fa-undo mr-1 text-[9px]"></i>
                        @endif
                        {{ $transaction->status }}
                    </span>
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('online-giving.show', $transaction->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        @if($transaction->status === 'Inasubiri')
                        <!-- Approve -->
                        <button type="button"
                                onclick="confirmAction('approve', {{ $transaction->id }}, '{{ $transaction->member->first_name ?? "Nje ya mfumo" }} {{ $transaction->member->last_name ?? "" }} - {{ number_format($transaction->amount, 0) }} TSh')"
                                class="rx-icon-btn rx-icon-btn-gold"
                                title="Thibitisha">
                            <i class="fas fa-check text-xs"></i>
                        </button>

                        <!-- Reject -->
                        <button type="button"
                                onclick="confirmAction('reject', {{ $transaction->id }}, '{{ $transaction->member->first_name ?? "Nje ya mfumo" }} {{ $transaction->member->last_name ?? "" }} - {{ number_format($transaction->amount, 0) }} TSh')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Kataa">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 7 : 6 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-mobile-alt text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna malipo yaliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna malipo ya mtandaoni yalinganayo na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('online-giving.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Malipo
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
@if($transactions->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $transactions->links() }}
</div>
@endif

<!-- Hidden Forms for AJAX -->
@foreach($transactions as $transaction)
@if($transaction->status === 'Inasubiri')
<form id="approve-form-{{ $transaction->id }}" action="{{ route('online-giving.approve', $transaction->id) }}" method="POST" class="hidden">
    @csrf
</form>
<form id="reject-form-{{ $transaction->id }}" action="{{ route('online-giving.reject', $transaction->id) }}" method="POST" class="hidden">
    @csrf
</form>
@endif
@endforeach
