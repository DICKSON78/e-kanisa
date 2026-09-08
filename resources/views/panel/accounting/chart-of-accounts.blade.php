@extends('layouts.app')

@section('title', 'Kitabu cha Hesabu - Mfumo wa E-Kanisa')
@section('page-title', 'Kitabu cha Hesabu')
@section('page-subtitle', 'Simamia hesabu zote za kitabu')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-book" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kitabu cha Hesabu</h1>
                <p class="text-sm text-gray-500">Simamia hesabu zote za kitabu</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openAddAccountModal()" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Hesabu</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Assets -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Hesabu za Mali</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($summary['asset'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-university" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Liabilities -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Hesabu za Deni</p>
                    <p class="text-2xl font-bold" style="color: #ef4444">{{ number_format($summary['liability'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-file-invoice-dollar" style="color: #ef4444"></i>
                </div>
            </div>
        </div>

        <!-- Equity -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Hesabu ya Hisa</p>
                    <p class="text-2xl font-bold" style="color: #3b82f6">{{ number_format($summary['equity'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-balance-scale" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Hesabu ya Mapato</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ number_format($summary['revenue'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-chart-line" style="color: #16a34a"></i>
                </div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Hesabu ya Gharama</p>
                    <p class="text-2xl font-bold" style="color: #f59e0b">{{ number_format($summary['expense'] ?? 0, 0) }} TSh</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.1)">
                    <i class="fas fa-receipt" style="color: #f59e0b"></i>
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
                        <input type="text" name="search" id="searchInput" value="{{ $filters['search'] ?? '' }}" placeholder="Tafuta nambari ya hesabu au jina...">
                    </div>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Hesabu</label>
                    <select name="type" id="typeFilter" class="rx-select">
                        <option value="">Yote</option>
                        <option value="Asset" {{ ($filters['type'] ?? '') == 'Asset' ? 'selected' : '' }}>Mali (Asset)</option>
                        <option value="Liability" {{ ($filters['type'] ?? '') == 'Liability' ? 'selected' : '' }}>Deni (Liability)</option>
                        <option value="Equity" {{ ($filters['type'] ?? '') == 'Equity' ? 'selected' : '' }}>Hisa (Equity)</option>
                        <option value="Revenue" {{ ($filters['type'] ?? '') == 'Revenue' ? 'selected' : '' }}>Mapato (Revenue)</option>
                        <option value="Expense" {{ ($filters['type'] ?? '') == 'Expense' ? 'selected' : '' }}>Gharama (Expense)</option>
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

    <!-- Accounts Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="accountsTableContainer">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list" style="color: #efc120"></i>
                Orodha ya Hesabu
                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">{{ $accounts->total() }} total</span>
            </h3>
            <p class="text-sm text-gray-500">
                Kuonyesha {{ $accounts->firstItem() }} - {{ $accounts->lastItem() }} ya {{ $accounts->total() }}
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Nambari ya Hesabu</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Jina</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-layer-group text-xs" style="color: #efc120"></i>
                                <span>Aina</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-folder text-xs" style="color: #efc120"></i>
                                <span>Aina ndogo</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-calculator text-xs" style="color: #efc120"></i>
                                <span>Salio</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                                <span>Hali</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                                <span>Vitendo</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr class="transition-colors">
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $account->account_code }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                                    <i class="fas fa-book-open text-xs" style="color: #efc120"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">{{ $account->name }}</span>
                                    @if($account->description)
                                        <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ $account->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $typeBadge = match($account->type) {
                                    'Asset' => 'rx-badge-green',
                                    'Liability' => 'rx-badge-red',
                                    'Equity' => 'rx-badge-blue',
                                    'Revenue' => 'rx-badge-green',
                                    'Expense' => 'rx-badge-gold',
                                    default => 'rx-badge'
                                };
                                $typeLabel = match($account->type) {
                                    'Asset' => 'Mali',
                                    'Liability' => 'Deni',
                                    'Equity' => 'Hisa',
                                    'Revenue' => 'Mapato',
                                    'Expense' => 'Gharama',
                                    default => $account->type
                                };
                            @endphp
                            <span class="rx-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600">{{ $account->sub_type ?? '-' }}</span>
                        </td>
                        <td class="text-right">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ number_format($account->balance ?? 0, 2) }}</span>
                        </td>
                        <td>
                            @if($account->is_active)
                                <span class="rx-badge rx-badge-green">
                                    <i class="fas fa-check-circle mr-1"></i>Hai
                                </span>
                            @else
                                <span class="rx-badge" style="background: #f3f4f6; color: #6b7280;">
                                    <i class="fas fa-times-circle mr-1"></i>Imesimamishwa
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button"
                                        onclick="openEditAccountModal({{ $account->id }}, '{{ $account->account_code }}', '{{ addslashes($account->name) }}', '{{ addslashes($account->description ?? '') }}', '{{ $account->type }}', '{{ $account->sub_type ?? '' }}', {{ $account->opening_balance ?? 0 }}, {{ $account->parent_account_id ?? 'null' }})"
                                        class="rx-icon-btn rx-icon-btn-gold"
                                        title="Hariri">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </button>
                                @if($account->is_active)
                                <button type="button"
                                        onclick="confirmDeactivate({{ $account->id }}, '{{ addslashes($account->name) }}')"
                                        class="rx-icon-btn rx-icon-btn-red"
                                        title="Simamisha">
                                    <i class="fas fa-ban text-xs"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-book text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna hesabu zilizopatikana</p>
                                <p class="text-xs text-gray-400 mb-4">Hesabu hazijapatikana kulingana na vichujio vyako.</p>
                                <button onclick="openAddAccountModal()" class="rx-btn rx-btn-primary">
                                    <i class="fas fa-plus"></i> Ongeza Hesabu Mpya
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($accounts->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $accounts->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Add Account Modal -->
<div id="addAccountModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-100 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-plus-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Ongeza Hesabu Mpya</h3>
                        <p class="text-xs text-gray-500">Jaza taarifa za hesabu mpya</p>
                    </div>
                </div>
                <button onclick="closeAddAccountModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('accounting.accounts.store') }}" class="p-6">
            @csrf
            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nambari ya Hesabu <span class="text-red-500">*</span></label>
                        <input type="text" name="account_code" required class="rx-input rx-input-no-icon" placeholder="mfano: 1001">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Jina la Hesabu <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="rx-input rx-input-no-icon" placeholder="Jina la hesabu">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo</label>
                    <input type="text" name="description" class="rx-input rx-input-no-icon" placeholder="Maelezo ya hesabu (hiari)">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Hesabu <span class="text-red-500">*</span></label>
                        <select name="type" id="addTypeSelect" required class="rx-select">
                            <option value="">Chagua aina...</option>
                            <option value="Asset">Mali (Asset)</option>
                            <option value="Liability">Deni (Liability)</option>
                            <option value="Equity">Hisa (Equity)</option>
                            <option value="Revenue">Mapato (Revenue)</option>
                            <option value="Expense">Gharama (Expense)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina Ndogo</label>
                        <select name="sub_type" id="addSubTypeSelect" class="rx-select">
                            <option value="">Chagua aina ndogo...</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Salio la Uanzishaji</label>
                        <input type="number" name="opening_balance" step="0.01" class="rx-input rx-input-no-icon" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hesabu ya Mzazi</label>
                        <select name="parent_account_id" class="rx-select">
                            <option value="">Hakuna mzazi</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->account_code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100 flex justify-end gap-3 mt-6 -mx-6 -mb-6">
                <button type="button" onclick="closeAddAccountModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Hifadhi Hesabu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Account Modal -->
<div id="editAccountModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-100 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-edit" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Hariri Hesabu</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za hesabu</p>
                    </div>
                </div>
                <button onclick="closeEditAccountModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <form method="POST" id="editAccountForm" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nambari ya Hesabu <span class="text-red-500">*</span></label>
                        <input type="text" name="account_code" id="editAccountCode" required class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Jina la Hesabu <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="editName" required class="rx-input rx-input-no-icon">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo</label>
                    <input type="text" name="description" id="editDescription" class="rx-input rx-input-no-icon">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Hesabu <span class="text-red-500">*</span></label>
                        <select name="type" id="editTypeSelect" required class="rx-select">
                            <option value="Asset">Mali (Asset)</option>
                            <option value="Liability">Deni (Liability)</option>
                            <option value="Equity">Hisa (Equity)</option>
                            <option value="Revenue">Mapato (Revenue)</option>
                            <option value="Expense">Gharama (Expense)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina Ndogo</label>
                        <select name="sub_type" id="editSubTypeSelect" class="rx-select">
                            <option value="">Chagua aina ndogo...</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Salio la Uanzishaji</label>
                        <input type="number" name="opening_balance" id="editOpeningBalance" step="0.01" class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hesabu ya Mzazi</label>
                        <select name="parent_account_id" id="editParentAccount" class="rx-select">
                            <option value="">Hakuna mzazi</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->account_code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100 flex justify-end gap-3 mt-6 -mx-6 -mb-6">
                <button type="button" onclick="closeEditAccountModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Sasisha Hesabu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Deactivate Modal -->
<div id="deactivateModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="deactivateModalContent">
        <div class="p-6 text-center">
            <div class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100">
                <i class="fas fa-ban text-3xl text-red-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Simamisha Hesabu</h3>
            <p class="text-gray-500 text-sm mb-2">Je, una uhakika unataka kusimamisha hesabu hii?</p>
            <p class="text-lg font-semibold mb-6" id="deactivateAccountName" style="color: #ef4444"></p>
            <div class="flex gap-3">
                <button onclick="closeDeactivateModal()" class="rx-btn rx-btn-secondary flex-1">
                    <i class="fas fa-xmark mr-1"></i> Ghairi
                </button>
                <button onclick="executeDeactivate()" class="rx-btn flex-1 text-sm font-medium text-white rounded-xl transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700">
                    <i class="fas fa-ban"></i> Simamisha
                </button>
            </div>
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
// Sub-type Options
// ========================================
const subTypeOptions = {
    'Asset': ['Cash', 'Receivable', 'Inventory', 'Prepaid', 'Depreciable', 'Other'],
    'Liability': ['Current', 'LongTerm'],
    'Equity': ['Retained', 'Donations'],
    'Revenue': ['Tithes', 'Offerings', 'Sales', 'Interest'],
    'Expense': ['Expenses']
};

function updateSubTypes(typeSelectId, subTypeSelectId) {
    const type = document.getElementById(typeSelectId).value;
    const subTypeSelect = document.getElementById(subTypeSelectId);
    subTypeSelect.innerHTML = '<option value="">Chagua aina ndogo...</option>';

    if (subTypeOptions[type]) {
        subTypeOptions[type].forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            subTypeSelect.appendChild(option);
        });
    }
}

document.getElementById('addTypeSelect')?.addEventListener('change', function() {
    updateSubTypes('addTypeSelect', 'addSubTypeSelect');
});

document.getElementById('editTypeSelect')?.addEventListener('change', function() {
    updateSubTypes('editTypeSelect', 'editSubTypeSelect');
});

// ========================================
// Add Account Modal
// ========================================
function openAddAccountModal() {
    const modal = document.getElementById('addAccountModal');
    const content = modal.querySelector('.bg-white');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeAddAccountModal() {
    const modal = document.getElementById('addAccountModal');
    const content = modal.querySelector('.bg-white');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Edit Account Modal
// ========================================
function openEditAccountModal(id, code, name, description, type, subType, openingBalance, parentId) {
    const form = document.getElementById('editAccountForm');
    form.action = '/panel/accounting/chart-of-accounts/' + id;

    document.getElementById('editAccountCode').value = code;
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editTypeSelect').value = type;
    document.getElementById('editOpeningBalance').value = openingBalance;
    document.getElementById('editParentAccount').value = parentId || '';

    updateSubTypes('editTypeSelect', 'editSubTypeSelect');
    setTimeout(() => { document.getElementById('editSubTypeSelect').value = subType; }, 0);

    const modal = document.getElementById('editAccountModal');
    const content = modal.querySelector('.bg-white');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeEditAccountModal() {
    const modal = document.getElementById('editAccountModal');
    const content = modal.querySelector('.bg-white');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// ========================================
// Deactivate Modal
// ========================================
let deactivateAccountId = null;

function confirmDeactivate(id, name) {
    deactivateAccountId = id;
    document.getElementById('deactivateAccountName').textContent = name;
    const modal = document.getElementById('deactivateModal');
    const content = document.getElementById('deactivateModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeDeactivateModal() {
    const modal = document.getElementById('deactivateModal');
    const content = document.getElementById('deactivateModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); deactivateAccountId = null; }, 200);
}

function executeDeactivate() {
    if (!deactivateAccountId) return;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    fetch('/panel/accounting/chart-of-accounts/' + deactivateAccountId + '/deactivate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Hesabu imesimamishwa', 'success');
            closeDeactivateModal();
            setTimeout(() => filterAccounts(), 500);
        } else {
            showNotification(data.message || 'Hitilafu imetokea', 'error');
        }
    })
    .catch(() => showNotification('Hitilafu imetokea. Tafadhali jaribu tena.', 'error'));
}

// ========================================
// Filter & Search Functions (AJAX without page reload)
// ========================================
function filterAccounts(page = 1) {
    clearTimeout(searchTimeout);
    currentPage = page;

    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();

        const search = document.getElementById('searchInput')?.value;
        const type = document.getElementById('typeFilter')?.value;

        if (search) params.append('search', search);
        if (type) params.append('type', type);
        if (page > 1) params.append('page', page);

        const container = document.getElementById('accountsTableContainer');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        const newUrl = '{{ route("accounting.chart-of-accounts") }}' + (params.toString() ? '?' + params.toString() : '');
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
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const newContainer = tempDiv.querySelector('#accountsTableContainer');
                container.innerHTML = newContainer ? newContainer.innerHTML : html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error filtering accounts:', error);
            if (container) {
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            }
        });
    }, 300);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    filterAccounts();
}

function attachPaginationListeners() {
    document.querySelectorAll('#accountsTableContainer .pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            filterAccounts(parseInt(page));
        });
    });
}

// ========================================
// Event Listeners
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Live search
    document.getElementById('searchInput')?.addEventListener('input', () => filterAccounts());

    // Filter changes
    document.getElementById('typeFilter')?.addEventListener('change', () => filterAccounts());

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
['addAccountModal', 'editAccountModal', 'deactivateModal'].forEach(id => {
    document.getElementById(id)?.addEventListener('click', function(e) {
        if (e.target === this) {
            if (id === 'addAccountModal') closeAddAccountModal();
            else if (id === 'editAccountModal') closeEditAccountModal();
            else closeDeactivateModal();
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAddAccountModal();
        closeEditAccountModal();
        closeDeactivateModal();
    }
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('searchInput').value = urlParams.get('search') || '';
    document.getElementById('typeFilter').value = urlParams.get('type') || '';
    filterAccounts(parseInt(urlParams.get('page')) || 1);
});

// Show flash messages
@if(session('success'))
    showNotification('{{ session("success") }}', 'success');
@endif
@if(session('error'))
    showNotification('{{ session("error") }}', 'error');
@endif
</script>
@endsection
