@extends('layouts.app')

@section('title', 'Ingizo la Kitabu - Mfumo wa ROC')
@section('page-title', 'Ingizo la Kitabu')
@section('page-subtitle', 'Simamia ingizo za kila siku')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-book-open" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ingizo la Kitabu</h1>
                <p class="text-sm text-gray-500">Simamia ingizo za kila siku</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('accounting.journal.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ingizo Jipya</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Ingizo</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-file-alt" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Rasimu -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Rasimu</p>
                    <p class="text-2xl font-bold" style="color: #6b7280">{{ $stats['draft'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(107,114,128,0.1)">
                    <i class="fas fa-file" style="color: #6b7280"></i>
                </div>
            </div>
        </div>

        <!-- Imechapishwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Imechapishwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['posted'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Imefutwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Imefutwa</p>
                    <p class="text-2xl font-bold" style="color: #ef4444">{{ $stats['voided'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-ban" style="color: #ef4444"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4 mb-2">
        <form id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Yote</option>
                        <option value="Draft" {{ ($filters['status'] ?? '') == 'Draft' ? 'selected' : '' }}>Rasimu</option>
                        <option value="Posted" {{ ($filters['status'] ?? '') == 'Posted' ? 'selected' : '' }}>Imechapishwa</option>
                        <option value="Voided" {{ ($filters['status'] ?? '') == 'Voided' ? 'selected' : '' }}>Imefutwa</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kuanzia Tarehe</label>
                    <input type="date" name="date_from" id="dateFrom" value="{{ $filters['date_from'] ?? '' }}" class="rx-input rx-input-no-icon">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hadi Tarehe</label>
                    <input type="date" name="date_to" id="dateTo" value="{{ $filters['date_to'] ?? '' }}" class="rx-input rx-input-no-icon">
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <button type="button" onclick="clearFilters()" class="rx-btn rx-btn-secondary w-full flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-rotate-left text-xs"></i>
                        <span>Futa Chujio</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Journal Entries Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="journalTableContainer">
        @include('panel.accounting._entries-table')
    </div>

</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
// ========================================
// Global Variables
// ========================================
let searchTimeout;
let currentPage = 1;

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterEntries(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const status = document.getElementById('statusFilter')?.value;
        const dateFrom = document.getElementById('dateFrom')?.value;
        const dateTo = document.getElementById('dateTo')?.value;

        if (status) params.append('status', status);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('journalTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("accounting.journal.index") }}' + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newUrl);

        fetch(newUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (container) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const newContainer = tempDiv.querySelector('#journalTableContainer');
                container.innerHTML = newContainer ? newContainer.innerHTML : html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering entries:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    filterEntries();
}

function attachPaginationListeners() {
    document.querySelectorAll('#journalTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterEntries(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Filter changes
    document.getElementById('statusFilter')?.addEventListener('change', () => filterEntries());
    document.getElementById('dateFrom')?.addEventListener('change', () => filterEntries());
    document.getElementById('dateTo')?.addEventListener('change', () => filterEntries());

    // Prevent form submission
    document.getElementById('filterForm')?.addEventListener('submit', e => e.preventDefault());

    // Attach pagination listeners
    attachPaginationListeners();
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('dateFrom').value = urlParams.get('date_from') || '';
    document.getElementById('dateTo').value = urlParams.get('date_to') || '';
    filterEntries(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
    showNotification('{{ session("success") }}', 'success');
@endif
@if(session('error'))
    showNotification('{{ session("error") }}', 'error');
@endif
</script>
@endsection
