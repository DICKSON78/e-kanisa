@extends('layouts.app')

@section('title', 'Maombi ya Idhini - Mfumo wa E-Kanisa')
@section('page-title', 'Maombi ya Idhini')
@section('page-subtitle', 'Simamia maombi ya idhini ya idara')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-file-signature" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Maombi ya Idhini</h1>
                <p class="text-sm text-gray-500">Simamia maombi ya idhini ya idara</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('approvals.thresholds') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-sliders-h"></i>
                <span class="hidden sm:inline">Kiwango</span>
            </a>
            <a href="{{ route('approvals.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Omba Idhini</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Maombi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Maombi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-file-signature" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Inasubiri -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Inasubiri</p>
                    <p class="text-2xl font-bold" style="color: #ca8a04">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(202,138,4,0.1)">
                    <i class="fas fa-clock" style="color: #ca8a04"></i>
                </div>
            </div>
        </div>

        <!-- Yaliyoidhinishwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Yaliyoidhinishwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Yaliyokataliwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Yaliyokataliwa</p>
                    <p class="text-2xl font-bold" style="color: #ef4444">{{ $stats['rejected'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-times-circle" style="color: #ef4444"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta namba ya ombi, kichwa...">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Yote</option>
                        <option value="Inasubiri" {{ request('status') == 'Inasubiri' ? 'selected' : '' }}>Inasubiri</option>
                        <option value="Yakifuata Hatua" {{ request('status') == 'Yakifuata Hatua' ? 'selected' : '' }}>Yakifuata Hatua</option>
                        <option value="Yaidhinishwa" {{ request('status') == 'Yaidhinishwa' ? 'selected' : '' }}>Yaidhinishwa</option>
                        <option value="Yakataliwa" {{ request('status') == 'Yakataliwa' ? 'selected' : '' }}>Yakataliwa</option>
                    </select>
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Idara</label>
                    <select name="department_id" id="departmentFilter" class="rx-select">
                        <option value="">Zote</option>
                        @if(isset($departments))
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Priority -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kipaumbele</label>
                    <select name="priority" id="priorityFilter" class="rx-select">
                        <option value="">Yote</option>
                        <option value="Dharura" {{ request('priority') == 'Dharura' ? 'selected' : '' }}>Dharura</option>
                        <option value="Ya Juu" {{ request('priority') == 'Ya Juu' ? 'selected' : '' }}>Ya Juu</option>
                        <option value="Ya Kawaida" {{ request('priority') == 'Ya Kawaida' ? 'selected' : '' }}>Ya Kawaida</option>
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

    <!-- Approvals Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="approvalsTableContainer">
        @include('panel.approvals._table')
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
<div id="alertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="alertModalContent">
        <div class="p-6 text-center">
            <div id="alertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="alertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="alertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="alertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeAlertModal()" class="rx-btn rx-btn-primary w-full">
                <i class="fas fa-check mr-1"></i> Sawa, Nimeelewa
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
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, approvalId, approvalTitle) {
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
        message.textContent = 'Je, una uhakika unataka kufuta ombi hili? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = approvalTitle;
        nameEl.className = 'text-lg font-semibold mb-6 text-red-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700';
        btnIcon.className = 'fas fa-trash';
        btnText.textContent = 'Futa';
    }

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
    }, 200);
}

// ========================================
// Notification Modal Functions
// ========================================
function showNotification(type, title, message) {
    const modal = document.getElementById('alertModal');
    const content = document.getElementById('alertModalContent');
    const iconContainer = document.getElementById('alertIcon');
    const iconClass = document.getElementById('alertIconClass');
    const titleEl = document.getElementById('alertTitle');
    const messageEl = document.getElementById('alertMessage');

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

function closeAlertModal() {
    const modal = document.getElementById('alertModal');
    const content = document.getElementById('alertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterApprovals(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const departmentId = document.getElementById('departmentFilter')?.value;
        const priority = document.getElementById('priorityFilter')?.value;

        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (departmentId) params.append('department_id', departmentId);
        if (priority) params.append('priority', priority);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('approvalsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("approvals.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering approvals:', error);
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
    document.getElementById('departmentFilter').value = '';
    document.getElementById('priorityFilter').value = '';
    filterApprovals();
}

function attachPaginationListeners() {
    document.querySelectorAll('#approvalsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterApprovals(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput')?.addEventListener('input', () => filterApprovals());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterApprovals());
    document.getElementById('departmentFilter')?.addEventListener('change', () => filterApprovals());
    document.getElementById('priorityFilter')?.addEventListener('change', () => filterApprovals());

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
document.getElementById('alertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeAlertModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('departmentFilter').value = urlParams.get('department_id') || '';
    document.getElementById('priorityFilter').value = urlParams.get('priority') || '';
    filterApprovals(parseInt(urlParams.get('page')) || 1);
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
