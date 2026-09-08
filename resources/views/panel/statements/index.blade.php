@extends('layouts.app')

@section('title', 'Taarifa za Mwaka - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-file-invoice" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Taarifa za Mwaka</h1>
            <p class="text-sm text-gray-500">Jumla ya michango ya waumini kwa mwaka husika</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="rx-card rounded-2xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Waumini Waliotoa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $yearlyStats['total_members'] ?? 0 }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-users" style="color: #efc120"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Jumla ya Michango</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">TZS {{ number_format($yearlyStats['total_giving'] ?? 0, 0) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-hand-holding-usd" style="color: #16a34a"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Mwaka</p>
                    <p class="text-2xl font-bold" style="color: #360958">{{ $year }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-calendar-alt" style="color: #360958"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter + Actions -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-filter" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Chuja kwa Mwaka</h3>
                        <p class="text-xs text-gray-500">Chagua mwaka wa kutafuta</p>
                    </div>
                </div>
                <a href="{{ route('statements.bulk-print', ['year' => $year]) }}" target="_blank" class="rx-btn rx-btn-primary flex items-center gap-2" style="background: #16a34a; color: white;">
                    <i class="fas fa-print"></i>
                    <span>Print Zote</span>
                </a>
            </div>
            <form method="GET" action="{{ route('statements.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                    <select name="year" class="rx-select">
                        @for($y = date('Y'); $y >= date('Y') - 10; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        <span>Tafuta</span>
                    </button>
                    <a href="{{ route('statements.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                        <i class="fas fa-redo"></i>
                        <span>Futa</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list" style="color: #efc120"></i>
                Orodha ya Michango
                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
                    {{ $members->count() }} waumini
                </span>
            </h3>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Namba</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-user text-xs" style="color: #efc120"></i>
                                <span>Jina Kamili</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-phone text-xs" style="color: #efc120"></i>
                                <span>Simu</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-hand-holding-usd text-xs" style="color: #efc120"></i>
                                <span>Jumla ya Michango</span>
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
                    @forelse($members as $m)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $m['member_number'] }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                                    <i class="fas fa-user text-xs" style="color: #efc120"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $m['full_name'] }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-phone text-gray-400 text-xs"></i>
                                {{ $m['phone'] }}
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-bold text-gray-900">TZS {{ number_format($m['total'] ?? 0, 0) }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('statements.show', ['member' => $m['id'], 'year' => $year]) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Taarifa">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-file-invoice text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna taarifa</p>
                                <p class="text-xs text-gray-400">Hakuna waumini walio na michango kwa mwaka huu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($members->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">
                            <span class="text-sm font-bold text-gray-900">JUMLA KUU</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-bold" style="color: #360958">TZS {{ number_format($yearlyStats['total_giving'] ?? 0, 0) }}</span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showFlashNotification(message, type) {
    var notification = document.createElement('div');
    var colors = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-times-circle';
    notification.className = 'fixed top-4 right-4 z-[10001] px-5 py-3 rounded-xl border shadow-lg flex items-center gap-2 ' + colors;
    notification.innerHTML = '<i class="fas ' + icon + '"></i> <span class="text-sm font-medium">' + message + '</span>';
    document.body.appendChild(notification);
    setTimeout(function() {
        notification.style.transition = 'opacity 0.3s';
        notification.style.opacity = '0';
        setTimeout(function() { notification.remove(); }, 300);
    }, 4000);
}

@if(session('success'))
showFlashNotification('{{ session('success') }}', 'success');
@endif
@if(session('error'))
showFlashNotification('{{ session('error') }}', 'error');
@endif
</script>
@endsection
