@extends('layouts.app')

@section('title', 'Sunday School - Mfumo wa E-Kanisa')
@section('page-title', 'Sunday School')
@section('page-subtitle', 'Usimamizi wa madarasa ya watoto')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-child" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Sunday School</h1>
                <p class="text-sm text-gray-500">Usimamizi wa madarasa ya watoto na walimu wao</p>
            </div>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex items-center gap-3">
            <a href="{{ route('children.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Darasa</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Madarasa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Madarasa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $total_classes ?? $classes->total() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-chalkboard" style="color: #efc120"></i>
                </div>
            </div>
        </div>

        <!-- Madarasa Inayofanya Kazi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Madarasa Inayofanya Kazi</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $active_classes ?? $classes->where('is_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Jumla ya Wanafunzi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Wanafunzi</p>
                    <p class="text-2xl font-bold" style="color: #2563eb">{{ $total_students ?? $classes->sum('students_count') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(37,99,235,0.1)">
                    <i class="fas fa-child" style="color: #2563eb"></i>
                </div>
            </div>
        </div>

        <!-- Jumla ya Walimu -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Walimu</p>
                    <p class="text-2xl font-bold" style="color: #7c3aed">{{ $total_teachers ?? $classes->sum('teachers_count') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(124,58,237,0.1)">
                    <i class="fas fa-chalkboard-teacher" style="color: #7c3aed"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta darasa kwa jina...">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Wote</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Inafanya kazi</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Haifanyi kazi</option>
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

    <!-- Children Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="childrenTableContainer">
        @include('panel.children._table')
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
<div id="childAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="childAlertModalContent">
        <div class="p-6 text-center">
            <div id="childAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="childAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="childAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="childAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeChildAlertModal()" class="rx-btn rx-btn-primary w-full">
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
let currentChildId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, childId, childName) {
    currentAction = action;
    currentChildId = childId;

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
        message.textContent = 'Je, una uhakika unataka kufuta darasa hili? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = childName;
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
        currentChildId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentChildId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentChildId}`;
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
            showChildAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => filterChildren(), 500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showChildAlert('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showChildAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Alert Modal Functions
// ========================================
function showChildAlert(type, title, message) {
    const modal = document.getElementById('childAlertModal');
    const content = document.getElementById('childAlertModalContent');
    const iconContainer = document.getElementById('childAlertIcon');
    const iconClass = document.getElementById('childAlertIconClass');
    const titleEl = document.getElementById('childAlertTitle');
    const messageEl = document.getElementById('childAlertMessage');

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

function closeChildAlertModal() {
    const modal = document.getElementById('childAlertModal');
    const content = document.getElementById('childAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterChildren(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const status = document.getElementById('statusFilter')?.value;

        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('childrenTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("children.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering children:', error);
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
    filterChildren();
}

function attachPaginationListeners() {
    document.querySelectorAll('#childrenTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterChildren(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput')?.addEventListener('input', () => filterChildren());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterChildren());

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
document.getElementById('childAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeChildAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeChildAlertModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    filterChildren(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
showChildAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
showChildAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
showChildAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
