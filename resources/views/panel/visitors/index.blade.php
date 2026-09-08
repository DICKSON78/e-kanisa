@extends('layouts.app')

@section('title', 'Wageni - Mfumo wa E-Kanisa')
@section('page-title', 'Wageni')
@section('page-subtitle', 'Usimamizi wa taarifa za wageni wa kanisa')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-user-plus" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Wageni wa Kanisa</h1>
                <p class="text-sm text-gray-500">Usimamizi kamili wa orodha ya wageni na wapyaoshiriki</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('visitors.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-user-plus"></i>
                <span class="hidden sm:inline">Ongeza Mgeni</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Wageni</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-user-friends" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Mwezi Huu -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Mwezi Huu</p>
                    <p class="text-2xl font-bold" style="color: #360958">{{ $stats['this_month'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-calendar-check" style="color: #360958"></i>
                </div>
            </div>
        </div>

        <!-- Ufuatiliaji Unasubiri (clickable) -->
        <a href="javascript:void(0)" onclick="filterByFollowUp('Inasubiri')" class="rx-stat-card rounded-2xl block {{ request('follow_up_status') === 'Inasubiri' ? '!border-yellow-400 !shadow-md ring-2 ring-yellow-400/20' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Ufuatiliaji Unasubiri</p>
                    <p class="text-2xl font-bold" style="color: #ca8a04">{{ $stats['pending_followup'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(202,138,4,0.1)">
                    <i class="fas fa-headset" style="color: #ca8a04"></i>
                </div>
            </div>
        </a>

        <!-- Waliobadilishwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Waliobadilishwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['converted'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-user-check" style="color: #16a34a"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta jina, simu, email...">
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Ziara</label>
                    <input type="date" name="date" id="dateFilter" value="{{ request('date') }}" class="rx-input rx-input-no-icon">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Wote</option>
                        <option value="Mgeni" {{ request('status') == 'Mgeni' ? 'selected' : '' }}>Mgeni</option>
                        <option value="Mfuatiliaji" {{ request('status') == 'Mfuatiliaji' ? 'selected' : '' }}>Mfuatiliaji</option>
                        <option value="Mwanachama" {{ request('status') == 'Mwanachama' ? 'selected' : '' }}>Mwanachama</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Follow Up Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali ya Ufuatiliaji</label>
                    <select name="follow_up_status" id="followUpFilter" class="rx-select">
                        <option value="">Wote</option>
                        <option value="Inasubiri" {{ request('follow_up_status') == 'Inasubiri' ? 'selected' : '' }}>Inasubiri</option>
                        <option value="Imeanzishwa" {{ request('follow_up_status') == 'Imeanzishwa' ? 'selected' : '' }}>Imeanzishwa</option>
                        <option value="Imekamilika" {{ request('follow_up_status') == 'Imekamilika' ? 'selected' : '' }}>Imekamilika</option>
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

    <!-- Visitors Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="visitorsTableContainer">
        @include('panel.visitors._table')
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

<!-- Alert Modal -->
<div id="visitorAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="visitorAlertModalContent">
        <div class="p-6 text-center">
            <div id="visitorAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="visitorAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="visitorAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="visitorAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeVisitorAlertModal()" class="rx-btn rx-btn-primary w-full">
                <i class="fas fa-check mr-1"></i> Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
let currentAction = null;
let currentVisitorId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, visitorId, visitorName) {
    currentAction = action;
    currentVisitorId = visitorId;

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
        message.textContent = 'Je, una uhakika unataka kufuta mgeni huyu? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = visitorName;
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
        currentVisitorId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentVisitorId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentVisitorId}`;
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
            showVisitorAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => filterVisitors(), 500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showVisitorAlert('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showVisitorAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Alert Modal Functions
// ========================================
function showVisitorAlert(type, title, message) {
    const modal = document.getElementById('visitorAlertModal');
    const content = document.getElementById('visitorAlertModalContent');
    const iconContainer = document.getElementById('visitorAlertIcon');
    const iconClass = document.getElementById('visitorAlertIconClass');
    const titleEl = document.getElementById('visitorAlertTitle');
    const messageEl = document.getElementById('visitorAlertMessage');

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

function closeVisitorAlertModal() {
    const modal = document.getElementById('visitorAlertModal');
    const content = document.getElementById('visitorAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterVisitors(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const date = document.getElementById('dateFilter')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const followUpStatus = document.getElementById('followUpFilter')?.value;

        if (search) params.append('search', search);
        if (date) params.append('date', date);
        if (status) params.append('status', status);
        if (followUpStatus) params.append('follow_up_status', followUpStatus);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('visitorsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("visitors.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering visitors:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function filterByFollowUp(status) {
    const followUpFilter = document.getElementById('followUpFilter');
    if (followUpFilter) {
        followUpFilter.value = status;
        filterVisitors();
    }
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('dateFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('followUpFilter').value = '';
    filterVisitors();
}

function attachPaginationListeners() {
    document.querySelectorAll('#visitorsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterVisitors(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput')?.addEventListener('input', () => filterVisitors());
    document.getElementById('dateFilter')?.addEventListener('change', () => filterVisitors());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterVisitors());
    document.getElementById('followUpFilter')?.addEventListener('change', () => filterVisitors());

    document.getElementById('filterForm')?.addEventListener('submit', e => e.preventDefault());

    document.getElementById('searchInput')?.addEventListener('keypress', e => {
        if (e.key === 'Enter') e.preventDefault();
    });

    attachPaginationListeners();
});

// Close modals on backdrop click
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('visitorAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeVisitorAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeVisitorAlertModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('dateFilter').value = urlParams.get('date') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('followUpFilter').value = urlParams.get('follow_up_status') || '';
    filterVisitors(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
showVisitorAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
showVisitorAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
showVisitorAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
