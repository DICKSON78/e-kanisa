@extends('layouts.app')

@section('title', 'Hariri Mapato - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('income.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hariri Mapato</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za mapato</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('income.update', $income->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Mapato -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-hand-holding-usd" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mapato</h3>
                        <p class="text-sm text-gray-500">Sasisha taarifa za kimsingi za mapato</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="income_category_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Aina ya Mapato <span class="text-red-500">*</span>
                        </label>
                        <select id="income_category_id" name="income_category_id" required class="rx-select @error('income_category_id') border-red-500 @enderror">
                            <option value="">Chagua Aina ya Mapato</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('income_category_id', $income->income_category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('income_category_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="collection_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kukusanya <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="collection_date" name="collection_date" value="{{ old('collection_date', $income->collection_date) }}" required
                               class="rx-input @error('collection_date') border-red-500 @enderror">
                        @error('collection_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kiasi (TSh) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $income->amount) }}" step="0.01" min="0" required
                               class="rx-input @error('amount') border-red-500 @enderror" placeholder="0.00">
                        @error('amount')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
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
                        <label for="member_id" class="block text-sm font-semibold text-gray-900 mb-2">Muumini (Hiari)</label>
                        <select id="member_id" name="member_id" class="rx-select @error('member_id') border-red-500 @enderror">
                            <option value="">Chagua Muumini</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ (old('member_id', $income->member_id) == $member->id) ? 'selected' : '' }}>
                                    {{ $member->member_number }} - {{ $member->first_name }} {{ $member->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="receipt_number" class="block text-sm font-semibold text-gray-900 mb-2">Namba ya Risiti (Hiari)</label>
                        <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $income->receipt_number) }}"
                               class="rx-input @error('receipt_number') border-red-500 @enderror" placeholder="REC-001">
                        @error('receipt_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">Maelezo (Hiari)</label>
                        <textarea id="notes" name="notes" rows="4"
                                  class="rx-input @error('notes') border-red-500 @enderror"
                                  placeholder="Andika maelezo yoyote muhimu...">{{ old('notes', $income->notes) }}</textarea>
                        @error('notes')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('income.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Sasisha Mapato
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
