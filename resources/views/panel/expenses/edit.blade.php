@extends('layouts.app')

@section('title', 'Hariri Matumizi - Mfumo wa Kanisa')
@section('page-title', 'Hariri Matumizi')
@section('page-subtitle', 'Sasisha taarifa za matumizi')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Rudi Orodhani
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Hariri Matumizi</h1>
            </div>
            <p class="text-gray-600">Sasisha taarifa za matumizi</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('expenses.update', $expense->id) }}" class="divide-y divide-gray-200">
            @csrf
            @method('PUT')

            <!-- Expense Details Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-file-invoice-dollar text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Matumizi</h3>
                        <p class="text-sm text-gray-600">Sasisha taarifa za kimsingi za matumizi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Expense Category -->
                    <div class="md:col-span-2">
                        <label for="expense_category_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Aina ya Matumizi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list-alt text-gray-400"></i>
                            </div>
                            <select id="expense_category_id" name="expense_category_id" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('expense_category_id') border-red-500 @enderror">
                                <option value="">Chagua Aina ya Matumizi</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('expense_category_id', $expense->expense_category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('expense_category_id')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwaka <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <select id="year" name="year" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('year') border-red-500 @enderror">
                                <option value="">Chagua Mwaka</option>
                                @for($y = 2030; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ (old('year', $expense->year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('year')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Month -->
                    <div>
                        <label for="month" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwezi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                            <select id="month" name="month" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('month') border-red-500 @enderror">
                                <option value="">Chagua Mwezi</option>
                                <option value="1" {{ (old('month', $expense->month) == '1') ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ (old('month', $expense->month) == '2') ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ (old('month', $expense->month) == '3') ? 'selected' : '' }}>Machi</option>
                                <option value="4" {{ (old('month', $expense->month) == '4') ? 'selected' : '' }}>Aprili</option>
                                <option value="5" {{ (old('month', $expense->month) == '5') ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ (old('month', $expense->month) == '6') ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ (old('month', $expense->month) == '7') ? 'selected' : '' }}>Julai</option>
                                <option value="8" {{ (old('month', $expense->month) == '8') ? 'selected' : '' }}>Agosti</option>
                                <option value="9" {{ (old('month', $expense->month) == '9') ? 'selected' : '' }}>Septemba</option>
                                <option value="10" {{ (old('month', $expense->month) == '10') ? 'selected' : '' }}>Oktoba</option>
                                <option value="11" {{ (old('month', $expense->month) == '11') ? 'selected' : '' }}>Novemba</option>
                                <option value="12" {{ (old('month', $expense->month) == '12') ? 'selected' : '' }}>Desemba</option>
                            </select>
                        </div>
                        @error('month')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expense Date -->
                    <div class="md:col-span-2">
                        <label for="expense_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Matumizi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-day text-gray-400"></i>
                            </div>
                            <input type="date" id="expense_date" name="expense_date"
                                   value="{{ old('expense_date', $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('expense_date') border-red-500 @enderror">
                        </div>
                        @error('expense_date')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="md:col-span-2">
                        <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kiasi (TSh) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                            </div>
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('amount') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="p-6 bg-gray-50">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Ziada</h3>
                        <p class="text-sm text-gray-600">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Payee -->
                    <div>
                        <label for="payee" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mpokeaji (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            <input type="text" id="payee" name="payee" value="{{ old('payee', $expense->payee) }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('payee') border-red-500 @enderror"
                                   placeholder="Jina la mpokeaji">
                        </div>
                        @error('payee')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Receipt Number -->
                    <div>
                        <label for="receipt_number" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Risiti (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-receipt text-gray-400"></i>
                            </div>
                            <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $expense->receipt_number) }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('receipt_number') border-red-500 @enderror"
                                   placeholder="EXP-001">
                        </div>
                        @error('receipt_number')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                            Maelezo (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-sticky-note text-gray-400"></i>
                            </div>
                            <textarea id="notes" name="notes" rows="4"
                                      class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('notes') border-red-500 @enderror"
                                      placeholder="Andika maelezo yoyote muhimu...">{{ old('notes', $expense->notes) }}</textarea>
                        </div>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-between items-center">
                <!-- Delete Button (Left) -->
                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Futa</span>
                    </button>
                </form>

                <!-- Cancel & Save Buttons (Right) -->
                <div class="flex space-x-4">
                    <a href="{{ route('expenses.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        <span>Ghairi</span>
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-primary-600 text-white font-bold rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="fas fa-save"></i>
                        <span>Sasisha Matumizi</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
