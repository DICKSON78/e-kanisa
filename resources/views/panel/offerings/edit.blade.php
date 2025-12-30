@extends('layouts.app')

@section('title', 'Hariri Sadaka - Mfumo wa Kanisa')
@section('page-title', 'Hariri Sadaka')
@section('page-subtitle', 'Sasisha taarifa za sadaka')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('offerings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Rudi Orodhani
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Hariri Sadaka</h1>
            </div>
            <p class="text-gray-600">Sasisha taarifa za sadaka</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('offerings.update', $income->id) }}" class="divide-y divide-gray-200">
            @csrf
            @method('PUT')

            <!-- Income Details Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-hand-holding-usd text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Sadaka</h3>
                        <p class="text-sm text-gray-600">Sasisha taarifa za kimsingi za sadaka</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Income Category -->
                    <div class="md:col-span-2">
                        <label for="income_category_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Aina ya Sadaka <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list-alt text-gray-400"></i>
                            </div>
                            <select id="income_category_id" name="income_category_id" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('income_category_id') border-red-500 @enderror">
                                <option value="">Chagua Aina ya Sadaka</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('income_category_id', $income->income_category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('income_category_id')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Collection Date -->
                    <div>
                        <label for="collection_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kukusanya <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-check text-gray-400"></i>
                            </div>
                            <input type="date" id="collection_date" name="collection_date" value="{{ old('collection_date', $income->collection_date) }}" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('collection_date') border-red-500 @enderror">
                        </div>
                        @error('collection_date')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kiasi (TSh) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                            </div>
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $income->amount) }}" step="0.01" min="0" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('amount') border-red-500 @enderror" placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Member -->
                    <div>
                        <label for="member_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwanachama (Si Lazima)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <select id="member_id" name="member_id"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('member_id') border-red-500 @enderror">
                                <option value="">Chagua Mwanachama</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ (old('member_id', $income->member_id) == $member->id) ? 'selected' : '' }}>
                                        {{ $member->full_name }} ({{ $member->member_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('member_id')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Receipt Number -->
                    <div>
                        <label for="receipt_number" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Risiti
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-receipt text-gray-400"></i>
                            </div>
                            <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $income->receipt_number) }}" maxlength="50"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('receipt_number') border-red-500 @enderror" placeholder="Ingiza namba ya risiti">
                        </div>
                        @error('receipt_number')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                            Maelezo
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('notes') border-red-500 @enderror" placeholder="Andika maelezo yoyote kuhusu sadaka hii...">{{ old('notes', $income->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="p-6 bg-gray-50 flex justify-end gap-3">
                <a href="{{ route('offerings.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200">
                    Ghairi
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Hifadhi Mabadiliko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

