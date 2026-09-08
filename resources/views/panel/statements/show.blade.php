@extends('layouts.app')

@section('title', 'Taarifa ya Mwaka - ' . $member->full_name)

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('statements.index', ['year' => $year]) }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-file-invoice" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Taarifa ya Mwaka</h1>
                    <p class="text-sm text-gray-500">Michango ya {{ $member->full_name }} mwaka {{ $year }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('statements.print', ['member' => $member->id, 'year' => $year]) }}" target="_blank" class="rx-btn rx-btn-primary flex items-center gap-2" style="background: #16a34a; color: white;">
            <i class="fas fa-print"></i>
            <span class="hidden sm:inline">Print</span>
        </a>
    </div>

    <!-- Gradient Profile Banner -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15)">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $member->full_name }}</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-hashtag"></i>
                                    <span>{{ $member->member_number }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $member->phone }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Mwaka {{ $year }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rx-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Jumla ya Michango</p>
                    <p class="text-2xl font-bold" style="color: #360958">TZS {{ number_format($totalGiving, 0) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-coins" style="color: #360958"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Aina za Mchango</p>
                    <p class="text-2xl font-bold" style="color: #efc120">{{ $byCategory->count() }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-tags" style="color: #efc120"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contributions by Category -->
    @forelse($byCategory as $category => $details)
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Category Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-tag" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">{{ $category }}</h3>
                        <p class="text-xs text-gray-500">{{ $details['count'] }} mchango{{ $details['count'] > 1 ? '' : '' }}</p>
                    </div>
                </div>
                <span class="rx-badge rx-badge-green text-sm font-bold">TZS {{ number_format($details['total'], 0) }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="rx-table">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th>Tarehe</th>
                        <th class="text-right">Kiasi (TZS)</th>
                        <th>Namba ya Risiti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details['items'] as $item)
                    <tr class="rx-table-row-hover">
                        <td>
                            <span class="rx-badge rx-badge-gray text-xs">{{ $loop->iteration }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-day text-xs" style="color: #efc120"></i>
                                <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->collection_date)->format('d/m/Y') }}</span>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-bold text-gray-900">{{ number_format($item->amount, 0) }}</span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600">{{ $item->receipt_number ?? '-' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">
                            <span class="text-sm font-bold text-gray-900">Jumla ya {{ $category }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-bold" style="color: #360958">{{ number_format($details['total'], 0) }}</span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @empty
    <div class="rx-card rounded-2xl p-12">
        <div class="rx-empty">
            <div class="rx-empty-icon">
                <i class="fas fa-file-invoice"></i>
            </div>
            <p class="rx-empty-title">Hakuna michango</p>
            <p class="rx-empty-desc">Muumini hana michango kwa mwaka {{ $year }}</p>
        </div>
    </div>
    @endforelse
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
