@extends('layouts.app')

@section('title', 'Maombi ya Fedha - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Maombi ya Fedha</h1>
                <p class="text-sm text-gray-500">Usimamizi kamili wa maombi ya fedha za kanisa</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('requests.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Omba Fedha</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Maombi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-file-invoice-dollar" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

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

        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zimeidhinishwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zimekataliwa</p>
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
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tafuta</label>
                    <div class="rx-search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta namba ya ombi, kichwa, idara...">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Inasubiri" {{ request('status') == 'Inasubiri' ? 'selected' : '' }}>Zinasubiri</option>
                        <option value="Imeidhinishwa" {{ request('status') == 'Imeidhinishwa' ? 'selected' : '' }}>Zimeidhinishwa</option>
                        <option value="Imekataliwa" {{ request('status') == 'Imekataliwa' ? 'selected' : '' }}>Zimekataliwa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Idara</label>
                    <select name="department" id="departmentFilter" class="rx-select">
                        <option value="">Zote</option>
                        @if(isset($departments))
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Kuanzia</label>
                    <input type="date" name="date_from" id="dateFromFilter" value="{{ request('date_from') }}" class="rx-input rx-input-no-icon">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Hadi</label>
                    <input type="date" name="date_to" id="dateToFilter" value="{{ request('date_to') }}" class="rx-input rx-input-no-icon">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi (TSh)</label>
                    <select name="amount_range" id="amountRangeFilter" class="rx-select">
                        <option value="">Vyote</option>
                        <option value="0-500000" {{ request('amount_range') == '0-500000' ? 'selected' : '' }}>Chini ya 500K</option>
                        <option value="500000-1000000" {{ request('amount_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1M</option>
                        <option value="1000000-5000000" {{ request('amount_range') == '1000000-5000000' ? 'selected' : '' }}>1M - 5M</option>
                        <option value="5000000-999999999" {{ request('amount_range') == '5000000-999999999' ? 'selected' : '' }}>Zaidi ya 5M</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="clearFilters()" class="rx-btn rx-btn-secondary w-full flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-rotate-left text-xs"></i>
                        <span>Futa Chujio</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Requests Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="requestsTableContainer">
        @include('panel.requests._table')
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
<div id="requestAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="requestAlertModalContent">
        <div class="p-6 text-center">
            <div id="requestAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="requestAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="requestAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="requestAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeRequestAlertModal()" class="rx-btn rx-btn-primary w-full">
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
let currentRequestId = null;
let searchTimeout;
let currentPage = 1;

function confirmAction(action, requestId, requestNumber) {
    currentAction = action;
    currentRequestId = requestId;
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
        nameEl.textContent = 'Ombi: ' + requestNumber;
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
        currentRequestId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentRequestId) return;
    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');
    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = currentAction + '-form-' + currentRequestId;
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
        .then(async function(res) {
            var ct = res.headers.get('content-type');
            if (ct && ct.includes('application/json')) {
                var data = await res.json().catch(function() { return {}; });
                if (!res.ok) throw data;
                return data;
            } else {
                if (!res.ok) throw new Error('Hitilafu imetokea');
                return { success: true, message: 'Imefanikiwa' };
            }
        })
        .then(function(data) {
            showRequestAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(function() { filterRequests(); }, 500);
        })
        .catch(function(err) {
            var msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showRequestAlert('error', 'Hitilafu', msg);
        })
        .finally(function() {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showRequestAlert('error', 'Hitilafu', 'Fomu haijapatikana.');
        closeConfirmActionModal();
    }
}

function showRequestAlert(type, title, message) {
    var modal = document.getElementById('requestAlertModal');
    var content = document.getElementById('requestAlertModalContent');
    var iconContainer = document.getElementById('requestAlertIcon');
    var iconClass = document.getElementById('requestAlertIconClass');
    var titleEl = document.getElementById('requestAlertTitle');
    var messageEl = document.getElementById('requestAlertMessage');
    if (!modal) { alert(title + ': ' + message); return; }
    var configs = {
        'success': { bgColor: 'bg-green-100', iconColor: 'text-green-600', icon: 'fas fa-check-circle' },
        'error': { bgColor: 'bg-red-100', iconColor: 'text-red-600', icon: 'fas fa-times-circle' },
        'warning': { bgColor: 'bg-yellow-100', iconColor: 'text-yellow-600', icon: 'fas fa-exclamation-triangle' },
        'info': { bgColor: 'bg-blue-100', iconColor: 'text-blue-600', icon: 'fas fa-info-circle' }
    };
    var config = configs[type] || configs['info'];
    iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 ' + config.bgColor;
    iconClass.className = config.icon + ' text-3xl ' + config.iconColor;
    titleEl.textContent = title;
    messageEl.textContent = message;
    modal.classList.remove('hidden');
    setTimeout(function() {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeRequestAlertModal() {
    var modal = document.getElementById('requestAlertModal');
    var content = document.getElementById('requestAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(function() { modal.classList.add('hidden'); }, 200);
}

function filterRequests(page) {
    page = page || 1;
    clearTimeout(searchTimeout);
    currentPage = page;
    searchTimeout = setTimeout(function() {
        var params = new URLSearchParams();
        var search = document.getElementById('searchInput')?.value;
        var status = document.getElementById('statusFilter')?.value;
        var department = document.getElementById('departmentFilter')?.value;
        var dateFrom = document.getElementById('dateFromFilter')?.value;
        var dateTo = document.getElementById('dateToFilter')?.value;
        var amountRange = document.getElementById('amountRangeFilter')?.value;

        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (department) params.append('department', department);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (amountRange) params.append('amount_range', amountRange);
        if (page > 1) params.append('page', page);

        var container = document.getElementById('requestsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        var newUrl = '{{ route("requests.index") }}' + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newUrl);

        fetch(newUrl, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
        })
        .then(function(response) { return response.text(); })
        .then(function(html) {
            if (container) {
                container.innerHTML = html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                attachPaginationListeners();
            }
        })
        .catch(function() {
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
    document.getElementById('dateFromFilter').value = '';
    document.getElementById('dateToFilter').value = '';
    document.getElementById('amountRangeFilter').value = '';
    filterRequests();
}

function attachPaginationListeners() {
    document.querySelectorAll('#requestsTableContainer .pagination a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var url = new URL(this.href);
            var page = url.searchParams.get('page') || 1;
            filterRequests(parseInt(page));
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput')?.addEventListener('input', function() { filterRequests(); });
    document.getElementById('statusFilter')?.addEventListener('change', function() { filterRequests(); });
    document.getElementById('departmentFilter')?.addEventListener('change', function() { filterRequests(); });
    document.getElementById('dateFromFilter')?.addEventListener('change', function() { filterRequests(); });
    document.getElementById('dateToFilter')?.addEventListener('change', function() { filterRequests(); });
    document.getElementById('amountRangeFilter')?.addEventListener('change', function() { filterRequests(); });
    document.getElementById('filterForm')?.addEventListener('submit', function(e) { e.preventDefault(); });
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) { if (e.key === 'Enter') e.preventDefault(); });
    attachPaginationListeners();
});

document.getElementById('confirmActionModal')?.addEventListener('click', function(e) { if (e.target === this) closeConfirmActionModal(); });
document.getElementById('requestAlertModal')?.addEventListener('click', function(e) { if (e.target === this) closeRequestAlertModal(); });

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeRequestAlertModal();
    }
});

window.addEventListener('popstate', function() {
    var urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    document.getElementById('departmentFilter').value = urlParams.get('department') || '';
    document.getElementById('dateFromFilter').value = urlParams.get('date_from') || '';
    document.getElementById('dateToFilter').value = urlParams.get('date_to') || '';
    document.getElementById('amountRangeFilter').value = urlParams.get('amount_range') || '';
    filterRequests(parseInt(urlParams.get('page')) || 1);
});

@if(session('success'))
showRequestAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif
@if(session('error'))
showRequestAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif
@if(session('warning'))
showRequestAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
