@extends('layouts.app')

@section('title', 'Sadaka na Ahadi - Mfumo wa ROC')
@section('page-title', 'Sadaka na Ahadi')
@section('page-subtitle', 'Rekodi na usimamizi wa sadaka na ahadi za kanisa')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Sadaka na Ahadi</h1>
                <p class="text-sm text-gray-500">Rekodi na usimamizi wa sadaka na ahadi za kanisa</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('offerings.types') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">Aina za Sadaka</span>
            </a>
            <a href="{{ route('offerings.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Rekodi</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jumla ya Sadaka -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Sadaka {{ date('Y') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSadaka, 0) }} TZS</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
                </div>
            </div>
        </div>

        <!-- Jumla ya Ahadi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Ahadi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalAhadi, 0) }} TZS</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-hands-praying" style="color: #360958"></i>
                </div>
            </div>
        </div>

        <!-- Imelipwa -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Imelipwa</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($totalMalipo, 0) }} TZS</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Salio la Ahadi -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Salio la Ahadi</p>
                    <p class="text-2xl font-bold" style="color: #ca8a04">{{ number_format($totalAhadi - $totalMalipo, 0) }} TZS</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(202,138,4,0.1)">
                    <i class="fas fa-clock" style="color: #ca8a04"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="border-b border-gray-100">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button id="sadakaTab" class="px-4 py-3 text-sm font-medium border-b-2 border-primary-500 text-primary-600 transition-all" role="tab" aria-selected="true" aria-controls="sadakaContainer">
                    <i class="fas fa-hand-holding-heart mr-2"></i> Sadaka za Wiki
                </button>
                <button id="ahadiTab" class="px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all" role="tab" aria-selected="false" aria-controls="ahadiContainer">
                    <i class="fas fa-hands-praying mr-2"></i> Ahadi na Malipo
                </button>
            </nav>
        </div>

        <!-- Sadaka Tab Content -->
        <div id="sadakaContainer" class="tab-content">
            <!-- Filter Bar -->
            <div class="px-6 py-4 border-b border-gray-100">
                <form id="sadakaFilterForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tafuta</label>
                            <div class="rx-search">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                                <input type="text" name="search" id="sadakaSearchInput" value="{{ request('search') }}" placeholder="Tafuta kwa tarehe au aina...">
                            </div>
                        </div>

                        <!-- Year -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                            <select name="year" id="sadakaYearFilter" class="rx-select">
                                @for($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Month -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwezi</label>
                            <select name="month" id="sadakaMonthFilter" class="rx-select">
                                <option value="">Zote</option>
                                @foreach(['Januari', 'Februari', 'Machi', 'Aprili', 'Mei', 'Juni', 'Julai', 'Agosti', 'Septemba', 'Oktoba', 'Novemba', 'Desemba'] as $index => $monthName)
                                    <option value="{{ $index + 1 }}" {{ $selectedMonth == ($index + 1) ? 'selected' : '' }}>{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Clear Filters -->
                        <div class="flex items-end">
                            <button type="button" onclick="clearSadakaFilters()" class="rx-btn rx-btn-secondary w-full flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-rotate-left text-xs"></i>
                                <span>Futa Chujio</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sadaka Table Container -->
            <div id="sadakaTableContainer">
                @include('panel.sadaka._sadaka-table')
            </div>
        </div>

        <!-- Ahadi Tab Content -->
        <div id="ahadiContainer" class="tab-content hidden">
            <!-- Filter Bar -->
            <div class="px-6 py-4 border-b border-gray-100">
                <form id="ahadiFilterForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tafuta</label>
                            <div class="rx-search">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                                <input type="text" name="search" id="ahadiSearchInput" value="{{ request('search') }}" placeholder="Tafuta kwa jina au aina...">
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                            <select name="status" id="ahadiStatusFilter" class="rx-select">
                                <option value="">Zote</option>
                                <option value="Pending">Inasubiri</option>
                                <option value="Partial">Sehemu</option>
                                <option value="Completed">Imekamilika</option>
                            </select>
                        </div>

                        <!-- Pledge Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Ahadi</label>
                            <select name="pledge_type" id="ahadiTypeFilter" class="rx-select">
                                <option value="">Zote</option>
                                <option value="Kiwanja">Kiwanja</option>
                                <option value="Usiku wa Agape">Usiku wa Agape</option>
                                <option value="Mavuno">Mavuno</option>
                                <option value="Ujenzi">Ujenzi</option>
                                <option value="Nyingine">Nyingine</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Clear Filters -->
                        <div class="flex items-end">
                            <button type="button" onclick="clearAhadiFilters()" class="rx-btn rx-btn-secondary w-full flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-rotate-left text-xs"></i>
                                <span>Futa Chujio</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ahadi Table Container -->
            <div id="ahadiTableContainer">
                @include('panel.sadaka._ahadi-table')
            </div>
        </div>
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

<!-- Calculator Modal -->
<div id="calculatorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95" id="calculatorModalContent">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-100 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                        <i class="fas fa-calculator" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Kikokotoo cha Noti na Sarafu</h3>
                        <p class="text-xs text-gray-500">Hesabu jumla ya sadaka</p>
                    </div>
                </div>
                <button type="button" onclick="closeCalculatorModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 10,000</label>
                    <input type="number" id="note_10000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 5,000</label>
                    <input type="number" id="note_5000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 2,000</label>
                    <input type="number" id="note_2000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 1,000</label>
                    <input type="number" id="note_1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 500</label>
                    <input type="number" id="coin_500" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 200</label>
                    <input type="number" id="coin_200" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 100</label>
                    <input type="number" id="coin_100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">TZS 50</label>
                    <input type="number" id="coin_50" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" value="0" onchange="calculateTotal()">
                </div>
            </div>
            <div class="rounded-xl p-4 text-center" style="background: rgba(54,9,88,0.05); border: 2px solid rgba(54,9,88,0.1)">
                <p class="text-sm text-gray-600 mb-1">Jumla</p>
                <p class="text-2xl font-bold" style="color: #360958" id="calculatorTotal">TZS 0</p>
            </div>
        </div>
        <div class="sticky bottom-0 flex justify-end gap-3 px-6 py-5 bg-gray-50 rounded-b-2xl border-t border-gray-100">
            <button type="button" onclick="resetCalculator()" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-redo"></i>
                <span>Safisha</span>
            </button>
            <button type="button" onclick="copyToSadaka()" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-copy"></i>
                <span>Nakili kwa Sadaka</span>
            </button>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

<script>
// ========================================
// Global Variables
// ========================================
let sadakaSearchTimeout;
let ahadiSearchTimeout;
let sadakaCurrentPage = 1;
let ahadiCurrentPage = 1;

// ========================================
// Tab Switching
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'sadaka';
    switchTab(activeTab);

    // Tab click events
    document.getElementById('sadakaTab')?.addEventListener('click', (e) => {
        e.preventDefault();
        switchTab('sadaka');
    });
    document.getElementById('ahadiTab')?.addEventListener('click', (e) => {
        e.preventDefault();
        switchTab('ahadi');
    });

    // Live search
    document.getElementById('sadakaSearchInput')?.addEventListener('input', () => filterSadaka());
    document.getElementById('sadakaYearFilter')?.addEventListener('change', () => filterSadaka());
    document.getElementById('sadakaMonthFilter')?.addEventListener('change', () => filterSadaka());

    document.getElementById('ahadiSearchInput')?.addEventListener('input', () => filterAhadi());
    document.getElementById('ahadiStatusFilter')?.addEventListener('change', () => filterAhadi());
    document.getElementById('ahadiTypeFilter')?.addEventListener('change', () => filterAhadi());

    // Prevent form submission
    document.getElementById('sadakaFilterForm')?.addEventListener('submit', e => e.preventDefault());
    document.getElementById('ahadiFilterForm')?.addEventListener('submit', e => e.preventDefault());

    // Prevent Enter key submission
    document.getElementById('sadakaSearchInput')?.addEventListener('keypress', e => { if (e.key === 'Enter') e.preventDefault(); });
    document.getElementById('ahadiSearchInput')?.addEventListener('keypress', e => { if (e.key === 'Enter') e.preventDefault(); });

    // Initialize date pickers
    initializeDatePickers();

    // Initialize calculator totals if calculator exists
    if (document.getElementById('note_10000')) {
        updateNoteTotals();
    }

    // Show flash messages
    @if(session('success'))
        showAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
    @endif
    @if(session('error'))
        showAlert('error', 'Hitilafu!', '{{ session('error') }}');
    @endif
    @if(session('warning'))
        showAlert('warning', 'Onyo!', '{{ session('warning') }}');
    @endif
});

function switchTab(tabName) {
    // Hide all containers
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));

    // Reset all tabs
    document.querySelectorAll('[role="tab"]').forEach(t => {
        t.classList.remove('border-primary-500', 'text-primary-600');
        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        t.setAttribute('aria-selected', 'false');
    });

    // Activate selected tab and container
    const activeContainer = document.getElementById(tabName + 'Container');
    const activeTab = document.getElementById(tabName + 'Tab');

    if (activeContainer && activeTab) {
        activeContainer.classList.remove('hidden');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        activeTab.classList.add('border-primary-500', 'text-primary-600');
        activeTab.setAttribute('aria-selected', 'true');
    }

    // Update URL without page reload
    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.replaceState({}, '', url);
}

// ========================================
// Confirm Action Modal Functions
// ========================================
let currentAction = null;
let currentRecordId = null;

function confirmAction(action, recordId, recordName, type = 'sadaka') {
    currentAction = action;
    currentRecordId = recordId;

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
        message.textContent = 'Je, una uhakika unataka kufuta rekodi hii? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = recordName;
        nameEl.className = 'text-lg font-semibold mb-6 text-red-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700';
        btnIcon.className = 'fas fa-trash';
        btnText.textContent = 'Futa';
    }

    btn.onclick = () => executeAction(type);
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
        currentRecordId = null;
    }, 200);
}

function executeAction(type) {
    if (!currentAction || !currentRecordId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    let url = '';
    if (type === 'sadaka') {
        url = '/panel/offerings/' + currentRecordId;
    } else if (type === 'ahadi') {
        url = '/panel/ahadi/' + currentRecordId;
    }

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(async (res) => {
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        return data;
    })
    .then((data) => {
        showAlert('success', 'Imefanikiwa', data.message || 'Rekodi imefutwa kikamilifu!');
        closeConfirmActionModal();
        setTimeout(() => {
            if (type === 'sadaka') filterSadaka();
            else filterAhadi();
        }, 500);
    })
    .catch((err) => {
        showAlert('error', 'Hitilafu', err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.');
    })
    .finally(() => {
        btn.disabled = false;
        btnIcon.className = 'fas fa-check';
        btnText.textContent = 'Thibitisha';
    });
}

// ========================================
// Alert Modal Functions
// ========================================
function showAlert(type, title, message) {
    const modal = document.getElementById('alertModal');
    const content = document.getElementById('alertModalContent');
    const iconContainer = document.getElementById('alertIcon');
    const iconClass = document.getElementById('alertIconClass');
    const titleEl = document.getElementById('alertTitle');
    const messageEl = document.getElementById('alertMessage');

    if (!modal) { alert(title + ': ' + message); return; }

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
// Filter Sadaka (AJAX)
// ========================================
function filterSadaka(page = 1) {
    clearTimeout(sadakaSearchTimeout);
    sadakaCurrentPage = page;

    sadakaSearchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('sadakaSearchInput')?.value;
        const year = document.getElementById('sadakaYearFilter')?.value;
        const month = document.getElementById('sadakaMonthFilter')?.value;

        params.append('tab', 'sadaka');
        if (search) params.append('search', search);
        if (year) params.append('year', year);
        if (month) params.append('month', month);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('sadakaTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("offerings.index") }}' + '?' + params.toString();
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
                attachSadakaPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering sadaka:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearSadakaFilters() {
    document.getElementById('sadakaSearchInput').value = '';
    document.getElementById('sadakaYearFilter').value = '{{ date("Y") }}';
    document.getElementById('sadakaMonthFilter').value = '';
    filterSadaka();
}

function attachSadakaPaginationListeners() {
    document.querySelectorAll('#sadakaTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterSadaka(parseInt(page));
        });
    });
}

// ========================================
// Filter Ahadi (AJAX)
// ========================================
function filterAhadi(page = 1) {
    clearTimeout(ahadiSearchTimeout);
    ahadiCurrentPage = page;

    ahadiSearchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('ahadiSearchInput')?.value;
        const status = document.getElementById('ahadiStatusFilter')?.value;
        const pledgeType = document.getElementById('ahadiTypeFilter')?.value;

        params.append('tab', 'ahadi');
        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (pledgeType) params.append('pledge_type', pledgeType);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('ahadiTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("offerings.index") }}' + '?' + params.toString();
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
                attachAhadiPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering ahadi:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearAhadiFilters() {
    document.getElementById('ahadiSearchInput').value = '';
    document.getElementById('ahadiStatusFilter').value = '';
    document.getElementById('ahadiTypeFilter').value = '';
    filterAhadi();
}

function attachAhadiPaginationListeners() {
    document.querySelectorAll('#ahadiTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterAhadi(parseInt(page));
        });
    });
}

// ========================================
// Calculator Modal Functions
// ========================================
function openCalculatorModal() {
    const modal = document.getElementById('calculatorModal');
    const content = document.getElementById('calculatorModalContent');
    resetCalculator();
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeCalculatorModal() {
    const modal = document.getElementById('calculatorModal');
    const content = document.getElementById('calculatorModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        resetCalculator();
    }, 200);
}

function resetCalculator() {
    const inputIds = ['note_10000', 'note_5000', 'note_2000', 'note_1000', 'note_500', 'coin_500', 'coin_200', 'coin_100', 'coin_50'];
    inputIds.forEach(id => {
        const input = document.getElementById(id);
        if (input) input.value = 0;
    });

    const calculatorTotal = document.getElementById('calculatorTotal');
    if (calculatorTotal) calculatorTotal.textContent = 'TZS 0';

    window.calculatorTotalValue = 0;
    updateNoteTotals();
}

function calculateTotal() {
    const note10000 = parseInt(document.getElementById('note_10000')?.value) || 0;
    const note5000 = parseInt(document.getElementById('note_5000')?.value) || 0;
    const note2000 = parseInt(document.getElementById('note_2000')?.value) || 0;
    const note1000 = parseInt(document.getElementById('note_1000')?.value) || 0;
    const note500 = parseInt(document.getElementById('note_500')?.value) || 0;
    const coin500 = parseInt(document.getElementById('coin_500')?.value) || 0;
    const coin200 = parseInt(document.getElementById('coin_200')?.value) || 0;
    const coin100 = parseInt(document.getElementById('coin_100')?.value) || 0;
    const coin50 = parseInt(document.getElementById('coin_50')?.value) || 0;

    const total = (note10000 * 10000) + (note5000 * 5000) + (note2000 * 2000) +
                  (note1000 * 1000) + (note500 * 500) + (coin500 * 500) +
                  (coin200 * 200) + (coin100 * 100) + (coin50 * 50);

    const calculatorTotal = document.getElementById('calculatorTotal');
    if (calculatorTotal) {
        calculatorTotal.textContent = 'TZS ' + total.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    }

    window.calculatorTotalValue = total;
    updateNoteTotals();
}

function updateNoteTotals() {
    const notes = [
        { id: 'note_10000', value: 10000 },
        { id: 'note_5000', value: 5000 },
        { id: 'note_2000', value: 2000 },
        { id: 'note_1000', value: 1000 },
        { id: 'note_500', value: 500 },
        { id: 'coin_500', value: 500 },
        { id: 'coin_200', value: 200 },
        { id: 'coin_100', value: 100 },
        { id: 'coin_50', value: 50 }
    ];

    notes.forEach(note => {
        const input = document.getElementById(note.id);
        if (input) {
            const count = parseInt(input.value) || 0;
            // No individual total elements in simplified calculator
        }
    });
}

function copyToSadaka() {
    const total = window.calculatorTotalValue || 0;
    if (total <= 0) {
        showAlert('warning', 'Onyo', 'Tafadhali ingiza noti au sarafu kwanza.');
        return;
    }

    closeCalculatorModal();

    // Show alert with the total
    showAlert('success', 'Kiasi Kimenakiliwa', 'Kiasi cha TZS ' + total.toLocaleString() + ' kimehifadhiwa. Tafadhali ingiza kiasi kwenye fomu ya sadaka.');
}

// ========================================
// Date Pickers
// ========================================
function initializeDatePickers() {
    const dateInputs = [
        { id: 'tarehe', options: { dateFormat: "Y-m-d", locale: "sw" } },
        { id: 'tarehe_ahadi', options: { dateFormat: "Y-m-d", locale: "sw" } },
        { id: 'tarehe_malipo', options: { dateFormat: "Y-m-d", locale: "sw" } }
    ];

    dateInputs.forEach(item => {
        const el = document.getElementById(item.id);
        if (el) flatpickr(el, item.options);
    });
}

// ========================================
// View/Edit Functions
// ========================================
function viewSadakaDetails(id) {
    window.location.href = '/panel/offerings/' + id;
}

function editSadaka(id) {
    window.location.href = '/panel/offerings/' + id + '/edit';
}

function viewAhadiDetails(id) {
    window.location.href = '/panel/ahadi/' + id;
}

// ========================================
// Modal Backdrop/Escape Close
// ========================================
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('alertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAlertModal();
});
document.getElementById('calculatorModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeCalculatorModal();
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeAlertModal();
        closeCalculatorModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || 'sadaka';
    switchTab(tab);

    if (tab === 'sadaka') {
        document.getElementById('sadakaSearchInput').value = urlParams.get('search') || '';
        document.getElementById('sadakaYearFilter').value = urlParams.get('year') || '{{ date("Y") }}';
        document.getElementById('sadakaMonthFilter').value = urlParams.get('month') || '';
        filterSadaka(parseInt(urlParams.get('page')) || 1);
    } else {
        document.getElementById('ahadiSearchInput').value = urlParams.get('search') || '';
        document.getElementById('ahadiStatusFilter').value = urlParams.get('status') || '';
        document.getElementById('ahadiTypeFilter').value = urlParams.get('pledge_type') || '';
        filterAhadi(parseInt(urlParams.get('page')) || 1);
    }
});
</script>

<style>
    /* Calculator input number hide arrows */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endsection
