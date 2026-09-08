@extends('layouts.app')

@section('title', 'Matumizi - Mfumo wa ROC')
@section('page-title', 'Matumizi')
@section('page-subtitle', 'Usimamizi kamili wa rekodi za matumizi ya kanisa')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-money-bill-wave" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Matumizi</h1>
                <p class="text-sm text-gray-500">Usimamizi kamili wa rekodi za matumizi ya kanisa</p>
            </div>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex items-center gap-3">
            <button onclick="openExportModal()" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-file-excel"></i>
                <span class="hidden sm:inline">Export</span>
            </button>
            <a href="{{ route('expenses.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Matumizi</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Matumizi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Matumizi {{ $year }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($grandTotal, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-money-bill-wave" style="color: #ef4444"></i>
                </div>
            </div>
        </div>

        <!-- Wastani wa Mwezi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Wastani wa Mwezi</p>
                    <p class="text-2xl font-bold" style="color: #3b82f6">{{ number_format($grandTotal / 12, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-chart-bar" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Idadi ya Aina -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Idadi ya Aina</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $categories->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-list" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Matumizi Ya Leo -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Matumizi Ya Leo</p>
                    <p class="text-2xl font-bold" style="color: #9333ea">{{ number_format($todayTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-calendar-day" style="color: #9333ea"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rx-card rounded-xl p-4 mb-2">
        <form id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Year -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                    <select name="year" id="yearFilter" class="rx-select">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
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
        <div class="mt-3 flex items-start gap-2 text-sm text-gray-600">
            <i class="fas fa-info-circle mt-0.5" style="color: #efc120"></i>
            <p><strong>Bofya kwenye kiasi chochote cha mwezi</strong> kuona orodha ya matumizi yote ya mwezi huo.</p>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="expensesTableContainer">
        @include('panel.expenses._table')
    </div>

</div>

<!-- Confirm Action Modal -->
<div id="confirmActionModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="confirmActionModalContent">
        <div class="p-6 text-center">
            <div id="confirmActionIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="confirmActionIconClass" class="text-3xl"></i>
            </div>
            <h3 id="confirmActionTitle" class="text-xl font-bold text-gray-900 mb-2">Thibitisha</h3>
            <p id="confirmActionMessage" class="text-gray-500 text-sm mb-2">Je, una uhakika?</p>
            <p id="confirmActionName" class="text-lg font-semibold mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeConfirmActionModal()" class="rx-btn rx-btn-secondary flex-1">
                    <i class="fas fa-xmark mr-1"></i> Ghairi
                </button>
                <button id="confirmActionBtn" class="rx-btn flex-1 text-sm font-medium text-white rounded-xl transition-all flex items-center justify-center gap-2">
                    <i id="confirmActionBtnIcon" class="fas fa-check"></i>
                    <span id="confirmActionBtnText">Thibitisha</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div id="expenseNotificationModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="expenseNotificationModalContent">
        <div class="p-6 text-center">
            <div id="expenseNotificationIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="expenseNotificationIconClass" class="text-3xl"></i>
            </div>
            <h3 id="expenseNotificationTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="expenseNotificationMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeNotificationModal()" class="rx-btn rx-btn-primary w-full">
                <i class="fas fa-check mr-1"></i> Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="fixed inset-0 bg-black/50 hidden z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95" id="exportModalContent">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: rgba(22,163,74,0.1)">
                <i class="fas fa-file-excel text-xl" style="color: #16a34a"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Export Matumizi</h3>
            <p class="text-sm text-gray-500 mb-4">Chagua kipindi cha ripoti</p>
        </div>
        <form id="exportForm" action="{{ route('export.matumizi') }}" method="GET" class="px-6 pb-6 space-y-4">
            <input type="hidden" name="year" id="yearHidden" value="{{ $year }}">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka wa Kuanzia</label>
                    <select name="start_year" id="startYear" class="rx-select">
                        @for($y = 2030; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwezi wa Kuanzia</label>
                    <select name="start_month" id="startMonth" class="rx-select">
                        <option value="1">Januari</option><option value="2">Februari</option><option value="3">Machi</option>
                        <option value="4">Aprili</option><option value="5">Mei</option><option value="6">Juni</option>
                        <option value="7">Julai</option><option value="8">Agosti</option><option value="9" selected>Septemba</option>
                        <option value="10">Oktoba</option><option value="11">Novemba</option><option value="12">Desemba</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka wa Kuishia</label>
                    <select name="end_year" id="endYear" class="rx-select">
                        @for($y = 2030; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwezi wa Kuishia</label>
                    <select name="end_month" id="endMonth" class="rx-select">
                        <option value="1">Januari</option><option value="2">Februari</option><option value="3">Machi</option>
                        <option value="4" selected>Aprili</option><option value="5">Mei</option><option value="6">Juni</option>
                        <option value="7">Julai</option><option value="8">Agosti</option><option value="9">Septemba</option>
                        <option value="10">Oktoba</option><option value="11">Novemba</option><option value="12">Desemba</option>
                    </select>
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i> Chagua kipindi cha ripoti. Mfano: Septemba 2023 hadi Aprili 2024
            </div>
        </form>
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
            <button type="button" onclick="closeExportModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
            <button type="submit" form="exportForm" id="exportBtn" class="rx-btn rx-btn-primary" style="background: #16a34a;">
                <i class="fas fa-download"></i> Download Excel
            </button>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
// ========================================
// Global Variables
// ========================================
let currentAction = null;
let currentExpenseId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, expenseId, expenseName) {
    currentAction = action;
    currentExpenseId = expenseId;

    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    const iconContainer = document.getElementById('confirmActionIcon');
    const iconClass = document.getElementById('confirmActionIconClass');
    const title = document.getElementById('confirmActionTitle');
    const message = document.getElementById('confirmActionMessage');
    const nameEl = document.getElementById('confirmActionName');
    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    if (action === 'delete') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100';
        iconClass.className = 'fas fa-trash-alt text-3xl text-red-600';
        title.textContent = 'Thibitisha Kufuta';
        message.textContent = 'Je, una uhakika unataka kufuta matumizi haya? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = expenseName;
        nameEl.className = 'text-lg font-semibold mb-6 text-red-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700';
        btnIcon.className = 'fas fa-trash';
        btnText.textContent = 'Futa';
    }

    btn.onclick = executeAction;
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeConfirmActionModal() {
    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        currentAction = null;
        currentExpenseId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentExpenseId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentExpenseId}`;
    const form = document.getElementById(formId);

    if (form) {
        const formData = new FormData(form);
        const csrf = form.querySelector('input[name="_token"]')?.value;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {})
            },
            body: formData
        })
        .then(async (res) => {
            const contentType = res.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw data;
                return data;
            } else {
                if (!res.ok) throw new Error('Hitilafu imetokea');
                return { success: true, message: 'Imefanikiwa' };
            }
        })
        .then((data) => {
            showNotification('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => filterExpenses(), 500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showNotification('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showNotification('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Notification Modal Functions
// ========================================
function showNotification(type, title, message) {
    const modal = document.getElementById('expenseNotificationModal');
    const content = document.getElementById('expenseNotificationModalContent');
    const iconContainer = document.getElementById('expenseNotificationIcon');
    const iconClass = document.getElementById('expenseNotificationIconClass');
    const titleEl = document.getElementById('expenseNotificationTitle');
    const messageEl = document.getElementById('expenseNotificationMessage');

    if (!modal) {
        alert(title + ': ' + message);
        return;
    }

    const configs = {
        'success': { bgColor: 'bg-green-100', iconColor: 'text-green-600', icon: 'fas fa-check-circle' },
        'error': { bgColor: 'bg-red-100', iconColor: 'text-red-600', icon: 'fas fa-times-circle' },
        'warning': { bgColor: 'bg-yellow-100', iconColor: 'text-yellow-600', icon: 'fas fa-exclamation-triangle' },
        'info': { bgColor: 'bg-blue-100', iconColor: 'text-blue-600', icon: 'fas fa-info-circle' }
    };

    const config = configs[type] || configs['info'];
    iconContainer.className = `h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 ${config.bgColor}`;
    iconClass.className = `${config.icon} text-3xl ${config.iconColor}`;
    titleEl.textContent = title;
    messageEl.textContent = message;

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeNotificationModal() {
    const modal = document.getElementById('expenseNotificationModal');
    const content = document.getElementById('expenseNotificationModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterExpenses(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const year = document.getElementById('yearFilter')?.value;

        if (year) params.append('year', year);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('expensesTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("expenses.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
                container.innerHTML = html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering expenses:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('yearFilter').value = '{{ date("Y") }}';
    filterExpenses();
}

function attachPaginationListeners() {
    document.querySelectorAll('#expensesTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterExpenses(parseInt(page));
        });
    });
}

// ========================================
// Export Modal Functions
// ========================================
function openExportModal() {
    const modal = document.getElementById('exportModal');
    const content = document.getElementById('exportModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeExportModal() {
    const modal = document.getElementById('exportModal');
    const content = document.getElementById('exportModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Filter changes
    document.getElementById('yearFilter')?.addEventListener('change', () => filterExpenses());

    // Prevent form submission
    document.getElementById('filterForm')?.addEventListener('submit', e => e.preventDefault());

    // Attach pagination listeners
    attachPaginationListeners();

    // Export modal listeners
    document.getElementById('startYear')?.addEventListener('change', function() {
        document.getElementById('yearHidden').value = this.value;
    });

    document.getElementById('exportForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('exportBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Inatengeneza...</span>';
        setTimeout(() => { closeExportModal(); btn.innerHTML = '<i class="fas fa-download"></i> <span>Download Excel</span>'; }, 1500);
    });
});

// Close modals on backdrop click
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('expenseNotificationModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeNotificationModal();
});
document.getElementById('exportModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeExportModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeNotificationModal();
        closeExportModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('yearFilter').value = urlParams.get('year') || '{{ date("Y") }}';
    filterExpenses(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
    showNotification('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
    showNotification('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
