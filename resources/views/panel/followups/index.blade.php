@extends('layouts.app')

@section('title', 'Ufuatiliaji wa Wanachama - Mfumo wa E-Kanisa')
@section('page-title', 'Ufuatiliaji wa Wanachama')
@section('page-subtitle', 'Usimamizi wa ufuatiliaji wa wanachama')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-headset" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ufuatiliaji wa Wanachama</h1>
                <p class="text-sm text-gray-500">Usimamizi kamili wa ufuatiliaji</p>
            </div>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex items-center gap-3">
            <a href="{{ route('followups.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Ufuatiliaji</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-headset" style="color: #efc120"></i>
                </div>
            </div>
        </div>

        <!-- Zinasubiri -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zinasubiri</p>
                    <p class="text-2xl font-bold" style="color: #ca8a04">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(202,138,4,0.1)">
                    <i class="fas fa-clock" style="color: #ca8a04"></i>
                </div>
            </div>
        </div>

        <!-- Zimepita Muda -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zimepita Muda</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['overdue'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444"></i>
                </div>
            </div>
        </div>

        <!-- Zimekamilika -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zimekamilika</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta jina la mwanachama, kichwa...">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Inasubiri" {{ request('status') == 'Inasubiri' ? 'selected' : '' }}>Inasubiri</option>
                        <option value="Imeanzishwa" {{ request('status') == 'Imeanzishwa' ? 'selected' : '' }}>Imeanzishwa</option>
                        <option value="Imekamilika" {{ request('status') == 'Imekamilika' ? 'selected' : '' }}>Imekamilika</option>
                    </select>
                </div>

                <!-- Follow Up Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Ufuatiliaji</label>
                    <select name="follow_up_type" id="followUpTypeFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Kutokuwepo" {{ request('follow_up_type') == 'Kutokuwepo' ? 'selected' : '' }}>Kutokuwepo</option>
                        <option value="Mtihani" {{ request('follow_up_type') == 'Mtihani' ? 'selected' : '' }}>Mtihani</option>
                        <option value="Shida ya Kiafya" {{ request('follow_up_type') == 'Shida ya Kiafya' ? 'selected' : '' }}>Shida ya Kiafya</option>
                        <option value="Nyingine" {{ request('follow_up_type') == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Priority -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kipaumbele</label>
                    <select name="priority" id="priorityFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Ya Dharura" {{ request('priority') == 'Ya Dharura' ? 'selected' : '' }}>Ya Dharura</option>
                        <option value="Ya Juu" {{ request('priority') == 'Ya Juu' ? 'selected' : '' }}>Ya Juu</option>
                        <option value="Ya Kawaida" {{ request('priority') == 'Ya Kawaida' ? 'selected' : '' }}>Ya Kawaida</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Kuanzia</label>
                    <input type="date" name="date_from" id="dateFromFilter" value="{{ request('date_from') }}" class="rx-input rx-input-no-icon">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Hadi</label>
                    <input type="date" name="date_to" id="dateToFilter" value="{{ request('date_to') }}" class="rx-input rx-input-no-icon">
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

    <!-- Followups Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="followupsTableContainer">
        @include('panel.followups._table')
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
<div id="followupAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="followupAlertModalContent">
        <div class="p-6 text-center">
            <div id="followupAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="followupAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="followupAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="followupAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeFollowupAlertModal()" class="rx-btn rx-btn-primary w-full">
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
let currentFollowupId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, followupId, followupName) {
    currentAction = action;
    currentFollowupId = followupId;

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
        message.textContent = 'Je, una uhakika unataka kufuta ufuatiliaji huu? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = followupName;
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
        currentFollowupId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentFollowupId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentFollowupId}`;
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
            showFollowupAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => filterFollowups(), 500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showFollowupAlert('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showFollowupAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Alert Modal Functions
// ========================================
function showFollowupAlert(type, title, message) {
    const modal = document.getElementById('followupAlertModal');
    const content = document.getElementById('followupAlertModalContent');
    const iconContainer = document.getElementById('followupAlertIcon');
    const iconClass = document.getElementById('followupAlertIconClass');
    const titleEl = document.getElementById('followupAlertTitle');
    const messageEl = document.getElementById('followupAlertMessage');

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

function closeFollowupAlertModal() {
    const modal = document.getElementById('followupAlertModal');
    const content = document.getElementById('followupAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterFollowups(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const followUpType = document.getElementById('followUpTypeFilter')?.value;
        const priority = document.getElementById('priorityFilter')?.value;
        const dateFrom = document.getElementById('dateFromFilter')?.value;
        const dateTo = document.getElementById('dateToFilter')?.value;

        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (followUpType) params.append('follow_up_type', followUpType);
        if (priority) params.append('priority', priority);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('followupsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("followups.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering followups:', error);
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
    document.getElementById('followUpTypeFilter').value = '';
    document.getElementById('priorityFilter').value = '';
    document.getElementById('dateFromFilter').value = '';
    document.getElementById('dateToFilter').value = '';
    filterFollowups();
}

function attachPaginationListeners() {
    document.querySelectorAll('#followupsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterFollowups(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput')?.addEventListener('input', () => filterFollowups());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterFollowups());
    document.getElementById('followUpTypeFilter')?.addEventListener('change', () => filterFollowups());
    document.getElementById('priorityFilter')?.addEventListener('change', () => filterFollowups());
    document.getElementById('dateFromFilter')?.addEventListener('change', () => filterFollowups());
    document.getElementById('dateToFilter')?.addEventListener('change', () => filterFollowups());

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
document.getElementById('followupAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeFollowupAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeFollowupAlertModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('followUpTypeFilter').value = urlParams.get('follow_up_type') || '';
    document.getElementById('priorityFilter').value = urlParams.get('priority') || '';
    document.getElementById('dateFromFilter').value = urlParams.get('date_from') || '';
    document.getElementById('dateToFilter').value = urlParams.get('date_to') || '';
    filterFollowups(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
showFollowupAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
showFollowupAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
showFollowupAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
