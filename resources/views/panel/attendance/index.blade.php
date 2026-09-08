@extends('layouts.app')

@section('title', 'Uhudhuriaji - Mfumo wa ROC')
@section('page-title', 'Uhudhuriaji')
@section('page-subtitle', 'Kufatilia uhudhuriaji wa wanachama kwa ibada')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-clipboard-check" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Uhudhuriaji</h1>
                <p class="text-sm text-gray-500">Kufatilia uhudhuriaji wa wanachama kwa ibada</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('attendance.report') }}?year={{ $selectedDate->year }}&month={{ $selectedDate->month }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-chart-bar"></i>
                <span class="hidden sm:inline">Ripoti</span>
            </a>
            <button onclick="openAddAttendanceModal()" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Uhudhuriaji</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Wanachama Wote -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Wanachama Wote</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-users" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Waliohudhuria -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Waliohudhuria</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $stats['present_today'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Waliokosekana -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Waliokosekana</p>
                    <p class="text-2xl font-bold" style="color: #ef4444">{{ $stats['absent_today'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-times-circle" style="color: #ef4444"></i>
                </div>
            </div>
        </div>

        <!-- Rekodi za Leo -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Rekodi za Leo</p>
                    <p class="text-2xl font-bold" style="color: #9333ea">{{ $stats['total_records'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-clipboard-list" style="color: #9333ea"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tafuta jina, namba ya muumini...">
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe</label>
                    <input type="date" name="date" id="dateFilter" value="{{ $selectedDate->format('Y-m-d') }}" class="rx-input rx-input-no-icon">
                </div>

                <!-- Service Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Huduma</label>
                    <select name="service_type" id="serviceTypeFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Ibada Kuu" {{ request('service_type') == 'Ibada Kuu' ? 'selected' : '' }}>Ibada Kuu</option>
                        <option value="Ibada ya Jumapili" {{ request('service_type') == 'Ibada ya Jumapili' ? 'selected' : '' }}>Ibada ya Jumapili</option>
                        <option value="Kikao" {{ request('service_type') == 'Kikao' ? 'selected' : '' }}>Kikao</option>
                        <option value="Nyingine" {{ request('service_type') == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                    <select name="status" id="statusFilter" class="rx-select">
                        <option value="">Zote</option>
                        <option value="Hudhuria" {{ request('status') == 'Hudhuria' ? 'selected' : '' }}>Hudhuria</option>
                        <option value="Kuchukuliwa" {{ request('status') == 'Kuchukuliwa' ? 'selected' : '' }}>Kuchukuliwa</option>
                        <option value="Kutohudhuria" {{ request('status') == 'Kutohudhuria' ? 'selected' : '' }}>Kutohudhuria</option>
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

    <!-- Attendance Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="attendanceTableContainer">
        @include('panel.attendance._table')
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

<!-- Add Attendance Modal -->
<div id="addAttendanceModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95" id="addAttendanceModalContent">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-plus" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Ongeza Uhudhuriaji</h3>
                </div>
                <button onclick="closeAddAttendanceModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe *</label>
                        <input type="date" name="attendance_date" value="{{ $selectedDate->format('Y-m-d') }}" required class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Huduma *</label>
                        <select name="service_type" required class="rx-select">
                            <option value="Ibada Kuu">Ibada Kuu</option>
                            <option value="Ibada ya Jumapili">Ibada ya Jumapili</option>
                            <option value="Kikao">Kikao</option>
                            <option value="Nyingine">Nyingine</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali *</label>
                        <select name="status" required class="rx-select">
                            <option value="Hudhuria">Hudhuria</option>
                            <option value="Kuchukuliwa">Kuchukuliwa</option>
                            <option value="Kutohudhuria">Kutohudhuria</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo</label>
                        <input type="text" name="notes" class="rx-input rx-input-no-icon">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Chagua Wanachama *</label>
                    <div class="border border-gray-200 rounded-xl p-3 max-h-60 overflow-y-auto bg-gray-50" id="memberSelection">
                        <div class="mb-2 pb-2 border-b border-gray-200">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="selectAll" class="rounded" onclick="toggleAll(this)">
                                <span class="text-sm font-medium text-gray-700">Chagua Wote</span>
                            </label>
                        </div>
                        @php
                            $activeMembers = \App\Models\Member::active()->orderBy('first_name')->get();
                        @endphp
                        @foreach($activeMembers as $member)
                        <label class="flex items-center gap-2 py-1.5 hover:bg-white rounded-lg px-2 cursor-pointer">
                            <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" class="member-checkbox rounded">
                            <span class="text-sm text-gray-700">{{ $member->full_name }} ({{ $member->member_number }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeAddAttendanceModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2"><i class="fas fa-save"></i> Hifadhi</button>
            </div>
        </form>
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
let currentAttendanceId = null;
let searchTimeout;
let currentPage = 1;

// ========================================
// Add Attendance Modal Functions
// ========================================
function openAddAttendanceModal() {
    const modal = document.getElementById('addAttendanceModal');
    const content = document.getElementById('addAttendanceModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeAddAttendanceModal() {
    const modal = document.getElementById('addAttendanceModal');
    const content = document.getElementById('addAttendanceModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

function toggleAll(source) {
    document.querySelectorAll('.member-checkbox').forEach(cb => cb.checked = source.checked);
}

// ========================================
// Confirm Action Modal Functions
// ========================================
function confirmAction(action, attendanceId, attendanceName) {
    currentAction = action;
    currentAttendanceId = attendanceId;

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
        message.textContent = 'Je, una uhakika unataka kufuta rekodi hii ya uhudhuriaji? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = attendanceName;
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
        currentAttendanceId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentAttendanceId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentAttendanceId}`;
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
            setTimeout(() => filterAttendance(), 500);
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
function filterAttendance(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const date = document.getElementById('dateFilter')?.value;
        const serviceType = document.getElementById('serviceTypeFilter')?.value;
        const status = document.getElementById('statusFilter')?.value;

        if (search) params.append('search', search);
        if (date) params.append('date', date);
        if (serviceType) params.append('service_type', serviceType);
        if (status) params.append('status', status);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('attendanceTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        // Update URL without reloading
        const newUrl = '{{ route("attendance.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
            console.error('Error filtering attendance:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('dateFilter').value = '{{ $selectedDate->format("Y-m-d") }}';
    document.getElementById('serviceTypeFilter').value = '';
    document.getElementById('statusFilter').value = '';
    filterAttendance();
}

function attachPaginationListeners() {
    document.querySelectorAll('#attendanceTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterAttendance(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    document.getElementById('searchInput')?.addEventListener('input', () => filterAttendance());

    // Filter changes
    document.getElementById('dateFilter')?.addEventListener('change', () => filterAttendance());
    document.getElementById('serviceTypeFilter')?.addEventListener('change', () => filterAttendance());
    document.getElementById('statusFilter')?.addEventListener('change', () => filterAttendance());

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
document.getElementById('addAttendanceModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAddAttendanceModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeAlertModal();
        closeAddAttendanceModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('dateFilter').value = urlParams.get('date') || '{{ $selectedDate->format("Y-m-d") }}';
    document.getElementById('serviceTypeFilter').value = urlParams.get('service_type') || '';
    document.getElementById('statusFilter').value = urlParams.get('status') || '';
    filterAttendance(parseInt(urlParams.get('page')) || 1);
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
