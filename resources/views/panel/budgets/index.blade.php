@extends('layouts.app')

@section('title', 'Bajeti - Mfumo wa E-Kanisa')
@section('page-title', 'Bajeti')
@section('page-subtitle', 'Kusimamia bajeti na matumizi')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-chart-pie" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Bajeti</h1>
                <p class="text-sm text-gray-500">Kusimamia bajeti na matumizi</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('budgets.update-actuals') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <button type="submit" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-sync"></i>
                    <span class="hidden sm:inline">Sasisha Halisi</span>
                </button>
            </form>
            <a href="{{ route('budgets.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Bajeti</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Bajeti Jumla -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Bajeti Jumla</p>
                    <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($stats['total_budget']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-wallet" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Matumizi Halisi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Matumizi Halisi</p>
                    <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($stats['total_actual']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-money-bill-wave" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Yaliyobaki -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Yaliyobaki</p>
                    <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($stats['remaining']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-piggy-bank" style="color: #efc120"></i>
                </div>
            </div>
        </div>

        <!-- Idadi ya Bajeti -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Idadi ya Bajeti</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['budget_count'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-list-ol" style="color: #9333ea"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta nambari, kichwa, kundi...">
                    </div>
                </div>

                <!-- Year -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                    <select name="year" id="yearFilter" class="rx-select">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kundi</label>
                    <select name="category" id="categoryFilter" class="rx-select">
                        <option value="">Zote</option>
                        @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                        @endif
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

    <!-- Budgets Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="budgetsTableContainer">
        @include('panel.budgets._table')
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
let currentAction = null;
let currentBudgetId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, budgetId, budgetName) {
    currentAction = action;
    currentBudgetId = budgetId;

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
        message.textContent = 'Je, una uhakika unataka kufuta bajeti hii? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = budgetName;
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
        currentBudgetId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentBudgetId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentBudgetId}`;
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
            setTimeout(() => filterBudgets(), 500);
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
// Alert / Notification Modal Functions
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
function filterBudgets(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const year = document.getElementById('yearFilter')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const category = document.getElementById('categoryFilter')?.value;

        if (search) params.append('search', search);
        if (year) params.append('year', year);
        if (status) params.append('status', status);
        if (category) params.append('category', category);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('budgetsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        // Update URL without reloading
        const newUrl = '{{ route("budgets.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering budgets:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('yearFilter').value = '{{ $year }}';
    document.getElementById('statusFilter').value = '';
    document.getElementById('categoryFilter').value = '';
    filterBudgets();
}

function attachPaginationListeners() {
    document.querySelectorAll('#budgetsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterBudgets(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    document.getElementById('searchInput')?.addEventListener('input', () => filterBudgets());

    // Filter changes
    document.getElementById('yearFilter')?.addEventListener('change', () => filterBudgets());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterBudgets());
    document.getElementById('categoryFilter')?.addEventListener('change', () => filterBudgets());

    // Prevent form submission
    document.getElementById('filterForm')?.addEventListener('submit', e => e.preventDefault());

    // Prevent Enter key submission in search
    document.getElementById('searchInput')?.addEventListener('keypress', e => {
        if (e.key === 'Enter') e.preventDefault();
    });

    // Attach pagination listeners
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
    document.getElementById('yearFilter').value = urlParams.get('year') || '{{ $year }}';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('categoryFilter').value = urlParams.get('category') || '';
    filterBudgets(parseInt(urlParams.get('page')) || 1);
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
