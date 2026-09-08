@extends('layouts.app')

@section('title', 'Hariri Matumizi - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('expenses.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hariri Matumizi</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za matumizi</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('expenses.update', $expense->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Matumizi -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Matumizi</h3>
                        <p class="text-sm text-gray-500">Sasisha taarifa za kimsingi za matumizi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="expense_category_id" class="block text-sm font-semibold text-gray-900 mb-2">Aina ya Matumizi <span class="text-red-500">*</span></label>
                        <select id="expense_category_id" name="expense_category_id" required class="rx-select @error('expense_category_id') border-red-500 @enderror">
                            <option value="">Chagua Aina ya Matumizi</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('expense_category_id', $expense->expense_category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-900 mb-2">Mwaka <span class="text-red-500">*</span></label>
                        <select id="year" name="year" required class="rx-select @error('year') border-red-500 @enderror">
                            <option value="">Chagua Mwaka</option>
                            @for($y = 2030; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ (old('year', $expense->year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('year')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="month" class="block text-sm font-semibold text-gray-900 mb-2">Mwezi <span class="text-red-500">*</span></label>
                        <select id="month" name="month" required class="rx-select @error('month') border-red-500 @enderror">
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
                        @error('month')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="expense_date" class="block text-sm font-semibold text-gray-900 mb-2">Tarehe ya Matumizi <span class="text-red-500">*</span></label>
                        <input type="date" id="expense_date" name="expense_date"
                               value="{{ old('expense_date', $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}" required
                               class="rx-input @error('expense_date') border-red-500 @enderror">
                        @error('expense_date')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">Kiasi (TSh) <span class="text-red-500">*</span></label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0" required
                               class="rx-input @error('amount') border-red-500 @enderror" placeholder="0.00">
                        @error('amount')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Taarifa za Ziada -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Ziada</h3>
                        <p class="text-sm text-gray-500">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="payee" class="block text-sm font-semibold text-gray-900 mb-2">Mpokeaji (Hiari)</label>
                        <input type="text" id="payee" name="payee" value="{{ old('payee', $expense->payee) }}" class="rx-input @error('payee') border-red-500 @enderror" placeholder="Jina la mpokeaji">
                        @error('payee')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="receipt_number" class="block text-sm font-semibold text-gray-900 mb-2">Namba ya Risiti (Hiari)</label>
                        <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $expense->receipt_number) }}" class="rx-input @error('receipt_number') border-red-500 @enderror" placeholder="EXP-001">
                        @error('receipt_number')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">Maelezo (Hiari)</label>
                        <textarea id="notes" name="notes" rows="4" class="rx-input @error('notes') border-red-500 @enderror" placeholder="Andika maelezo yoyote muhimu...">{{ old('notes', $expense->notes) }}</textarea>
                        @error('notes')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-between items-center rounded-b-2xl">
                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rx-btn rx-btn-danger"><i class="fas fa-trash"></i> Futa</button>
                </form>
                <div class="flex space-x-4">
                    <a href="{{ route('expenses.index') }}" class="rx-btn rx-btn-secondary"><i class="fas fa-times"></i> Ghairi</a>
                    <button type="submit" class="rx-btn rx-btn-primary"><i class="fas fa-save"></i> Sasisha Matumizi</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
