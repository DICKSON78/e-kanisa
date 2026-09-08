@extends('layouts.app')

@section('title', 'Ushuru - Mfumo wa E-Kanisa')
@section('page-title', 'Ushuru')
@section('page-subtitle', 'Simamia Mishahara ya Wafanyakazi')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-money-check-alt" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ushuru</h1>
                <p class="text-sm text-gray-500">Simamia Mishahara ya Wafanyakazi</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('payroll.create-period') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Kipindi Kipya</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Vikundi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Vikundi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_periods'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-layer-group" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Imekamilika -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Imekamilika</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Imelipwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Imelipwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['paid'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-money-bill-wave" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Jumla ya Umelipwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Umelipwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($stats['total_paid'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-coins" style="color: #16a34a"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4 mb-2">
        <form id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tafuta</label>
                    <div class="rx-search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta kwa jina la kipindi...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Rasimu</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Inachakatwa</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Imekamilika</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Imelipwa</option>
                    </select>
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

    <!-- Periods Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="periodsTableContainer">
        @include('payroll._periods-table')
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
function filterPeriods(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const status = document.getElementById('statusFilter')?.value;

        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('periodsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("payroll.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
                const newContainer = tempDiv.querySelector('#periodsTableContainer');
                container.innerHTML = newContainer ? newContainer.innerHTML : html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering periods:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    filterPeriods();
}

function attachPaginationListeners() {
    document.querySelectorAll('#periodsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterPeriods(parseInt(page));
        });
    });
}

// ========================================
// Confirmation Functions
// ========================================
function confirmProcess(periodId, periodName) {
    if (typeof showConfirmModal === 'function') {
        showConfirmModal({
            title: 'Chakata Kipindi',
            message: 'Je, unataka kuchakata kipindi "' + periodName + '"? Mishahara itahesabiwa upya.',
            type: 'warning',
            onConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/panel/payroll/' + periodId + '/process';
                form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
                document.body.appendChild(form);
                form.submit();
            }
        });
    } else {
        if (confirm('Chakata kipindi "' + periodName + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/panel/payroll/' + periodId + '/process';
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
            document.body.appendChild(form);
            form.submit();
        }
    }
}

function confirmApprove(periodId, periodName) {
    if (typeof showConfirmModal === 'function') {
        showConfirmModal({
            title: 'Idhinisha Kipindi',
            message: 'Je, unataka kuidhinisha kipindi "' + periodName + '"? Baada ya kuidhinisha, litaweza kulipwa.',
            type: 'warning',
            onConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/panel/payroll/' + periodId + '/approve';
                form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
                document.body.appendChild(form);
                form.submit();
            }
        });
    } else {
        if (confirm('Idhinisha kipindi "' + periodName + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/panel/payroll/' + periodId + '/approve';
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
            document.body.appendChild(form);
            form.submit();
        }
    }
}

function confirmPay(periodId, periodName) {
    if (typeof showConfirmModal === 'function') {
        showConfirmModal({
            title: 'Weka Alama ya Malipo',
            message: 'Je, unataka kuweka alama ya malipo kwa kipindi "' + periodName + '"? Taarifa hii ya malipo itahifadhiwa.',
            type: 'warning',
            onConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/panel/payroll/' + periodId + '/pay';
                form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
                document.body.appendChild(form);
                form.submit();
            }
        });
    } else {
        if (confirm('Weka alama ya malipo kwa kipindi "' + periodName + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/panel/payroll/' + periodId + '/pay';
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="POST">';
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    document.getElementById('searchInput')?.addEventListener('input', () => filterPeriods());

    // Filter changes
    document.getElementById('statusFilter')?.addEventListener('change', () => filterPeriods());

    // Prevent form submission
    document.getElementById('filterForm')?.addEventListener('submit', e => e.preventDefault());

    // Prevent Enter key submission in search
    document.getElementById('searchInput')?.addEventListener('keypress', e => {
        if (e.key === 'Enter') e.preventDefault();
    });

    // Attach pagination listeners
    attachPaginationListeners();
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    filterPeriods(parseInt(urlParams.get('page')) || 1);
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
