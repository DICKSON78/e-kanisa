@extends('layouts.app')

@section('title', 'Mapato - Mfumo wa ROC')
@section('page-title', 'Mapato')
@section('page-subtitle', 'Rekodi na usimamizi wa mapato ya kanisa')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-chart-line" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Mapato</h1>
                <p class="text-sm text-gray-500">Rekodi na usimamizi wa mapato ya kanisa</p>
            </div>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex items-center gap-3">
            <button onclick="exportMapato()" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-file-excel"></i>
                <span class="hidden sm:inline">Export</span>
            </button>
            <a href="{{ route('income.bulk-entry') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">Ingiza Kwa Wingi</span>
            </a>
            <a href="{{ route('income.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Mapato</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Mapato -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Mapato</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total'] ?? $grandTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-chart-line" style="color: #360958"></i>
                </div>
            </div>
        </div>

        <!-- Mapato Ya Leo -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Mapato Ya Leo</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($stats['today'] ?? $todayTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-calendar-day" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Mwezi Huu -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Mwezi Huu</p>
                    <p class="text-2xl font-bold" style="color: #3b82f6">{{ number_format($stats['this_month'] ?? $thisMonthTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-calendar-alt" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Mwezi Uliopita -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Mwezi Uliopita</p>
                    <p class="text-2xl font-bold" style="color: #9333ea">{{ number_format($stats['last_month'] ?? $lastMonthTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-chart-bar" style="color: #9333ea"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta risiti, muumini, kiasi...">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Mapato</label>
                    <select name="category_id" id="categoryFilter" class="rx-select">
                        <option value="">Zote</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Member -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Muumini</label>
                    <div class="rx-search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                        <input type="text" name="member_search" id="memberSearchFilter" value="{{ request('member_search') }}" placeholder="Tafuta muumini...">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Year -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                    <select name="year" id="yearFilter" class="rx-select">
                        <option value="">Wote</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Month -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwezi</label>
                    <select name="month" id="monthFilter" class="rx-select">
                        <option value="">Wote</option>
                        <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>Machi</option>
                        <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>Aprili</option>
                        <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>Julai</option>
                        <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>Agosti</option>
                        <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>Septemba</option>
                        <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktoba</option>
                        <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>Novemba</option>
                        <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desemba</option>
                    </select>
                </div>

                <!-- Receipt Number -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Namba ya Risiti</label>
                    <input type="text" name="receipt_number" id="receiptFilter" value="{{ request('receipt_number') }}" class="rx-input" placeholder="Ingiza namba ya risiti...">
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

    <!-- Income Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="incomeTableContainer">
        @include('panel.income._table')
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
<div id="incomeAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="incomeAlertModalContent">
        <div class="p-6 text-center">
            <div id="incomeAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="incomeAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="incomeAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="incomeAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeIncomeAlertModal()" class="rx-btn rx-btn-primary w-full">
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
let currentIncomeId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, incomeId, itemName) {
    currentAction = action;
    currentIncomeId = incomeId;

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
        message.textContent = 'Je, una uhakika unataka kufuta rekodi hii ya mapato? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = itemName;
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
        currentIncomeId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentIncomeId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentIncomeId}`;
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
            showIncomeAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => filterIncome(), 500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showIncomeAlert('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showIncomeAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Alert Modal Functions
// ========================================
function showIncomeAlert(type, title, message) {
    const modal = document.getElementById('incomeAlertModal');
    const content = document.getElementById('incomeAlertModalContent');
    const iconContainer = document.getElementById('incomeAlertIcon');
    const iconClass = document.getElementById('incomeAlertIconClass');
    const titleEl = document.getElementById('incomeAlertTitle');
    const messageEl = document.getElementById('incomeAlertMessage');

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

function closeIncomeAlertModal() {
    const modal = document.getElementById('incomeAlertModal');
    const content = document.getElementById('incomeAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterIncome(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const categoryId = document.getElementById('categoryFilter')?.value;
        const memberSearch = document.getElementById('memberSearchFilter')?.value;
        const year = document.getElementById('yearFilter')?.value;
        const month = document.getElementById('monthFilter')?.value;
        const receiptNumber = document.getElementById('receiptFilter')?.value;

        if (search) params.append('search', search);
        if (categoryId) params.append('category_id', categoryId);
        if (memberSearch) params.append('member_search', memberSearch);
        if (year) params.append('year', year);
        if (month) params.append('month', month);
        if (receiptNumber) params.append('receipt_number', receiptNumber);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('incomeTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        // Update URL without reloading
        const newUrl = '{{ route("income.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering income:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('memberSearchFilter').value = '';
    document.getElementById('yearFilter').value = '';
    document.getElementById('monthFilter').value = '';
    document.getElementById('receiptFilter').value = '';
    filterIncome();
}

function attachPaginationListeners() {
    // Intercept pagination links for AJAX navigation
    document.querySelectorAll('#incomeTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterIncome(parseInt(page));
        });
    });
}

// ========================================
// Export Function
// ========================================
function exportMapato() {
    try {
        const year = document.getElementById('yearFilter')?.value || '';
        const month = document.getElementById('monthFilter')?.value || '';
        const categoryId = document.getElementById('categoryFilter')?.value || '';

        const params = new URLSearchParams();
        if (year) params.append('year', year);
        if (month) params.append('month', month);
        if (categoryId) params.append('category_id', categoryId);

        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inatengeneza...';
        button.disabled = true;

        const exportUrl = '{{ route("export.mapato") }}?' + params.toString();
        const link = document.createElement('a');
        link.href = exportUrl;
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    } catch (error) {
        showIncomeAlert('error', 'Hitilafu', 'Hitilafu wakati wa kutengeneza export: ' + error.message);
    }
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    document.getElementById('searchInput')?.addEventListener('input', () => filterIncome());

    // Filter changes
    document.getElementById('categoryFilter')?.addEventListener('change', () => filterIncome());
    document.getElementById('memberSearchFilter')?.addEventListener('input', () => filterIncome());
    document.getElementById('yearFilter')?.addEventListener('change', () => filterIncome());
    document.getElementById('monthFilter')?.addEventListener('change', () => filterIncome());
    document.getElementById('receiptFilter')?.addEventListener('input', () => filterIncome());

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
document.getElementById('incomeAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeIncomeAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeIncomeAlertModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('categoryFilter').value = urlParams.get('category_id') || '';
    document.getElementById('memberSearchFilter').value = urlParams.get('member_search') || '';
    document.getElementById('yearFilter').value = urlParams.get('year') || '';
    document.getElementById('monthFilter').value = urlParams.get('month') || '';
    document.getElementById('receiptFilter').value = urlParams.get('receipt_number') || '';
    filterIncome(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
showIncomeAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
showIncomeAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
showIncomeAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
