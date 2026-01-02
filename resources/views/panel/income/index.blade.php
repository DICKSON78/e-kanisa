@extends('layouts.app')

@section('title', 'Mapato - Mfumo wa Kanisa')
@section('page-title', 'Mapato')
@section('page-subtitle', 'Rekodi na usimamizi wa mapato ya kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mapato ya Kanisa</h1>
            <p class="text-gray-600 mt-2">Usimamizi kamili wa rekodi za mapato ya kanisa</p>
        </div>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <div class="flex flex-wrap gap-3">
            <button onclick="exportMapato()" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                <i class="fas fa-file-excel"></i>
                <span class="font-medium">Export Excel</span>
            </button>
            <a href="{{ route('income.bulk-entry') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700">
                <i class="fas fa-list"></i>
                <span class="font-medium">Ingiza Kwa Wingi</span>
            </a>
            <a href="{{ route('income.create') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800">
                <i class="fas fa-plus"></i>
                <span class="font-medium">Ongeza Mapato</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumla ya Mapato</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($grandTotal, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-xl text-primary-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Mapato Ya Leo</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($todayTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Weka Hivi Sasa</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($thisMonthTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Weka Zamani</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($lastMonthTotal ?? 0, 0) }} TSh</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-bar text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter text-primary-500 mr-2"></i> Chuja Mapato
            </h3>
        </div>
        <form method="GET" action="{{ route('income.index') }}" data-auto-filter="true" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Kuanzia</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Mwisho</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aina ya Mapato</label>
                    <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Zote</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Member Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Muumini</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="member_search" value="{{ request('member_search') }}" class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Tafuta muumini...">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Year -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mwaka</label>
                    <select name="year" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Month -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mwezi</label>
                    <select name="month" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Namba ya Risiti</label>
                    <input type="text" name="receipt_number" value="{{ request('receipt_number') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ingiza namba ya risiti...">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('income.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Futa Chujio</span>
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Tumia Chujio</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Income Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-primary-500 mr-2"></i> Orodha ya Mapato
                    <span class="ml-3 text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $incomes->total() }} rekodi
                    </span>
                </h3>
            </div>
            <div class="mt-3 sm:mt-0">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500"></i>
                    <span>Angalia au hariri rekodi kwa kubofya vitendo</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-primary-600 text-white text-sm">
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                Tarehe
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2"></i>
                                Aina ya Mapato
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Kiasi
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Muumini
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-receipt mr-2"></i>
                                Namba ya Risiti
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider sticky right-0 bg-primary-600">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                Vitendo
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($incomes as $income)
                    <tr class="bg-white hover:bg-gray-50 transition-all duration-200">
                        <!-- Date -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($income->collection_date)->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($income->collection_date)->format('l') }}
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $income->category->name }}
                            </span>
                        </td>

                        <!-- Amount -->
                        <td class="py-4 px-6">
                            <div class="text-lg font-bold text-green-600">
                                {{ number_format($income->amount, 0) }} TSh
                            </div>
                        </td>

                        <!-- Member -->
                        <td class="py-4 px-6">
                            @if($income->member)
                            <div class="text-sm text-gray-900">
                                {{ $income->member->first_name }} {{ $income->member->last_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $income->member->member_number }}
                            </div>
                            @else
                            <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <!-- Receipt Number -->
                        <td class="py-4 px-6">
                            @if($income->receipt_number)
                            <div class="flex items-center gap-2">
                                <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $income->receipt_number }}</span>
                                @if($income->receipt_number)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Imetumwa
                                </span>
                                @endif
                            </div>
                            @else
                            <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-6 text-sm sticky right-0 bg-white">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('income.edit', $income->id) }}"
                                   class="h-8 w-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center hover:bg-primary-200 transition-all duration-200"
                                   title="Hariri">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <button type="button"
                                        onclick="confirmDelete({{ $income->id }}, '{{ $income->category->name }}', '{{ number_format($income->amount, 0) }}')"
                                        class="h-8 w-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-all duration-200"
                                        title="Futa">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna Mapato Yaliyopatikana</h3>
                            <p class="text-gray-500 mb-6">Hakuna rekodi za mapato zilizopatikana kwa mujibu wa chujio lako.</p>
                            <a href="{{ route('income.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i> Ongeza Mapato
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($incomes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Inaonyesha <span class="font-semibold">{{ $incomes->firstItem() }}</span> hadi
                    <span class="font-semibold">{{ $incomes->lastItem() }}</span> ya
                    <span class="font-semibold">{{ $incomes->total() }}</span> matokeo
                </div>
                <div>
                    {{ $incomes->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="deleteModalContent">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Thibitisha Kufuta</h3>
                        <p class="text-sm text-gray-600">Hatua hii haiwezi kurudishwa</p>
                    </div>
                </div>
                <button type="button" onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <div class="p-6">
            <p class="text-gray-700 mb-2">Je, una uhakika unataka kufuta rekodi hii ya mapato?</p>
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm text-gray-600">Aina: <span class="font-semibold text-gray-900" id="deleteCategory"></span></p>
                <p class="text-sm text-gray-600">Kiasi: <span class="font-bold text-green-600" id="deleteAmount"></span> TSh</p>
            </div>
            <p class="text-sm text-red-600">
                <i class="fas fa-warning mr-1"></i>
                Taarifa zote za mapato haya zitafutwa kabisa.
            </p>
        </div>

        <div class="sticky bottom-0 bg-gray-50 px-6 py-5 rounded-b-2xl border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-xl hover:bg-gray-300 transition-all duration-200">
                Ghairi
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>Futa Mapato</span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Delete modal functions
function confirmDelete(incomeId, category, amount) {
    document.getElementById('deleteCategory').textContent = category;
    document.getElementById('deleteAmount').textContent = amount;
    document.getElementById('deleteForm').action = '/panel/income/' + incomeId;

    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    content.classList.remove('scale-100');
    content.classList.add('scale-95');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close modal when clicking outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('deleteModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});

function exportMapato() {
    // Get current filter values
    const startDate = document.querySelector('input[name="start_date"]').value;
    const endDate = document.querySelector('input[name="end_date"]').value;
    const year = document.querySelector('select[name="year"]').value;
    const month = document.querySelector('select[name="month"]').value;
    const categoryId = document.querySelector('select[name="category_id"]').value;
    const memberSearch = document.querySelector('input[name="member_search"]').value;
    const receiptNumber = document.querySelector('input[name="receipt_number"]').value;

    // Build query string
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);
    if (year) params.append('year', year);
    if (month) params.append('month', month);
    if (categoryId) params.append('category_id', categoryId);
    if (memberSearch) params.append('member_search', memberSearch);
    if (receiptNumber) params.append('receipt_number', receiptNumber);

    // Redirect to export endpoint
    window.location.href = '{{ route("export.mapato") }}?' + params.toString();
}
</script>
@endpush
@endsection
