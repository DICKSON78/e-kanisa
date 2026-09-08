@extends('layouts.app')

@section('title', $entry->entry_number . ' - Ingizo la Kitabu - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.journal.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-file-alt" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">{{ $entry->entry_number }}</h1>
            <p class="text-sm text-gray-500">{{ $entry->description }}</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            @if($entry->status === 'Draft')
            <form action="{{ route('accounting.journal.post', $entry->id) }}" method="POST" id="postForm">
                @csrf
                <button type="button" onclick="confirmPost()" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> Chapisha
                </button>
            </form>
            @endif
            @if($entry->status === 'Posted')
            <form action="{{ route('accounting.journal.void', $entry->id) }}" method="POST" id="voidForm">
                @csrf
                <button type="button" onclick="confirmVoid()" class="rx-btn rx-btn-danger flex items-center gap-2">
                    <i class="fas fa-ban"></i> Futa
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Profile Banner -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold truncate">{{ $entry->entry_number }}</h2>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.8);">
                                    <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}
                                </span>
                                @php
                                    $statusBadge = match($entry->status) {
                                        'Draft' => 'background: rgba(107,114,128,0.2); color: #9ca3af;',
                                        'Posted' => 'background: rgba(34,197,94,0.2); color: #4ade80;',
                                        'Voided' => 'background: rgba(239,68,68,0.2); color: #f87171;',
                                        default => ''
                                    };
                                    $statusLabel = match($entry->status) {
                                        'Draft' => 'Rasimu',
                                        'Posted' => 'Imechapishwa',
                                        'Voided' => 'Imefutwa',
                                        default => $entry->status
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="{{ $statusBadge }}">
                                    @if($entry->status === 'Draft')
                                        <i class="fas fa-file"></i>
                                    @elseif($entry->status === 'Posted')
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($entry->status === 'Voided')
                                        <i class="fas fa-ban"></i>
                                    @endif
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Bar -->
        <div class="px-6 md:px-8 py-4 border-b border-gray-100 grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Tarehe</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-arrow-up text-green-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Debit</p>
                    <p class="text-sm font-mono font-medium text-gray-900">{{ number_format($entry->total_debit, 2) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-arrow-down text-red-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mikopo</p>
                    <p class="text-sm font-mono font-medium text-gray-900">{{ number_format($entry->total_credit, 2) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user text-purple-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mdadisi</p>
                    <p class="text-sm font-medium text-gray-900">{{ $entry->creator->name ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Imechapishwa</p>
                    <p class="text-sm font-medium text-gray-900">{{ $entry->posted_at ? \Carbon\Carbon::parse($entry->posted_at)->format('d/m/Y H:i') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Lines -->
        <div class="lg:col-span-2">
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-list text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Mistari ya Hesabu</h3>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">{{ $entry->lines->count() }} mistari</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="rx-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-book text-xs" style="color: #efc120"></i>
                                        <span>Hesabu</span>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entry->lines as $line)
                            <tr class="transition-colors">
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-book-open text-xs" style="color: #efc120"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-mono text-gray-500">{{ $line->account->account_code ?? '' }}</span>
                                            <span class="text-sm font-medium text-gray-900 ml-1">{{ $line->account->name ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-gray-600">{{ $line->description ?? '-' }}</span>
                                </td>
                                <td class="text-right">
                                    @if($line->debit > 0)
                                        <span class="text-sm font-mono font-medium text-green-600">{{ number_format($line->debit, 2) }}</span>
                                    @else
                                        <span class="text-sm font-mono text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($line->credit > 0)
                                        <span class="text-sm font-mono font-medium text-red-600">{{ number_format($line->credit, 2) }}</span>
                                    @else
                                        <span class="text-sm font-mono text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-300 bg-gray-50">
                                <td colspan="2" class="py-3 px-6 text-sm font-bold text-gray-900">JUMLA</td>
                                <td class="py-3 px-6 text-right">
                                    <span class="text-sm font-mono font-bold text-green-600">{{ number_format($entry->total_debit, 2) }}</span>
                                </td>
                                <td class="py-3 px-6 text-right">
                                    <span class="text-sm font-mono font-bold text-red-600">{{ number_format($entry->total_credit, 2) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Taarifa -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-hashtag w-4 text-center text-gray-400"></i> Nambari</span>
                            <span class="text-sm font-mono font-medium text-gray-900">{{ $entry->entry_number }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-align-left w-4 text-center text-gray-400"></i> Maelezo</span>
                            <span class="text-sm font-medium text-gray-900 text-right max-w-[180px]">{{ $entry->description }}</span>
                        </div>
                        @if($entry->reference_type)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-link w-4 text-center text-gray-400"></i> Viungo</span>
                            <span class="text-sm font-medium text-gray-900">{{ $entry->reference_type }} {{ $entry->reference_id }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-circle w-4 text-center text-gray-400"></i> Hali</span>
                            @php
                                $statusBadgeClass = match($entry->status) {
                                    'Draft' => '',
                                    'Posted' => 'rx-badge-green',
                                    'Voided' => 'rx-badge-red',
                                    default => ''
                                };
                                $statusLabel = match($entry->status) {
                                    'Draft' => 'Rasimu',
                                    'Posted' => 'Imechapishwa',
                                    'Voided' => 'Imefutwa',
                                    default => $entry->status
                                };
                            @endphp
                            <span class="rx-badge {{ $statusBadgeClass }}" @if($entry->status === 'Draft') style="background:#f3f4f6;color:#6b7280;" @endif>{{ $statusLabel }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar w-4 text-center text-gray-400"></i> Tarehe</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user w-4 text-center text-gray-400"></i> Mdadisi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $entry->creator->name ?? '-' }}</span>
                        </div>
                        @if($entry->posted_at)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Ilichapishwa</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($entry->posted_at)->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                        @if($entry->poster)
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-check w-4 text-center text-gray-400"></i> Mchapishaji</span>
                            <span class="text-sm font-medium text-gray-900">{{ $entry->poster->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            @if($entry->notes)
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sticky-note text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Maelezo</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $entry->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Post Confirmation Modal -->
<div id="postModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="postModalContent">
        <div class="p-6 text-center">
            <div class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100">
                <i class="fas fa-paper-plane text-3xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Chapisha Ingizo</h3>
            <p class="text-gray-500 text-sm mb-2">Je, una uhakika unataka kuchapisha ingizo hili?</p>
            <p class="text-lg font-semibold mb-6" style="color: #16a34a">{{ $entry->entry_number }}</p>
            <div class="flex gap-3">
                <button onclick="closePostModal()" class="rx-btn rx-btn-secondary flex-1">
                    <i class="fas fa-xmark mr-1"></i> Ghairi
                </button>
                <button onclick="document.getElementById('postForm').submit()" class="rx-btn flex-1 text-sm font-medium text-white rounded-xl transition-all flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700">
                    <i class="fas fa-paper-plane"></i> Chapisha
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Void Confirmation Modal -->
<div id="voidModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="voidModalContent">
        <div class="p-6 text-center">
            <div class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100">
                <i class="fas fa-ban text-3xl text-red-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Futa Ingizo</h3>
            <p class="text-gray-500 text-sm mb-2">Je, una uhakika unataka kufuta ingizo hili? Hatua hii haiwezi kutenduliwa.</p>
            <p class="text-lg font-semibold mb-6" style="color: #ef4444">{{ $entry->entry_number }}</p>
            <div class="flex gap-3">
                <button onclick="closeVoidModal()" class="rx-btn rx-btn-secondary flex-1">
                    <i class="fas fa-xmark mr-1"></i> Ghairi
                </button>
                <button onclick="document.getElementById('voidForm').submit()" class="rx-btn flex-1 text-sm font-medium text-white rounded-xl transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700">
                    <i class="fas fa-ban"></i> Futa
                </button>
            </div>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
function confirmPost() {
    const modal = document.getElementById('postModal');
    const content = document.getElementById('postModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closePostModal() {
    const modal = document.getElementById('postModal');
    const content = document.getElementById('postModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

function confirmVoid() {
    const modal = document.getElementById('voidModal');
    const content = document.getElementById('voidModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeVoidModal() {
    const modal = document.getElementById('voidModal');
    const content = document.getElementById('voidModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

['postModal', 'voidModal'].forEach(id => {
    document.getElementById(id)?.addEventListener('click', function(e) {
        if (e.target === this) {
            if (id === 'postModal') closePostModal();
            else closeVoidModal();
        }
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closePostModal(); closeVoidModal(); }
});

@if(session('success'))
    showNotification('{{ session("success") }}', 'success');
@endif
@if(session('error'))
    showNotification('{{ session("error") }}', 'error');
@endif
</script>
@endsection
