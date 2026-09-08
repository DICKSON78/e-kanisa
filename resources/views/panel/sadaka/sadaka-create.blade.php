@extends('layouts.app')

@section('title', 'Ongeza Sadaka - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('offerings.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Ongeza Sadaka Mpya</h1>
            <p class="text-sm text-gray-500">Jaza fomu ili kuongeza rekodi mpya ya sadaka</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('offerings.store') }}">
            @csrf

            <!-- Offering Details Section -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Sadaka</h3>
                        <p class="text-sm text-gray-500">Jaza taarifa za sadaka mpya</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Collection Date -->
                    <div>
                        <label for="collection_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kukusanya <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="collection_date" name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required
                                   class="rx-input @error('collection_date') border-red-500 @enderror">
                        </div>
                        @error('collection_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="income_category_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Aina ya Sadaka <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select id="income_category_id" name="income_category_id" required
                                    class="rx-input rx-select @error('income_category_id') border-red-500 @enderror">
                                <option value="">Chagua Aina ya Sadaka</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('income_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('income_category_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kiasi (TZS) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                            </div>
                            <input type="number" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0" min="0" step="1" required
                                   class="rx-input @error('amount') border-red-500 @enderror" style="font-size: 1.125rem; font-weight: 700; color: #360958;">
                        </div>
                        @error('amount')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Member (Optional) -->
                    <div>
                        <label for="member_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Muumini (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <select id="member_id" name="member_id"
                                    class="rx-input rx-select">
                                <option value="">Chagua Muumini (Hiari)</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->full_name }} {{ $member->phone ? '- ' . $member->phone : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                            Maelezo (Hiari)
                        </label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Maelezo ya ziada kuhusu sadaka hii..."
                                  class="rx-input @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('offerings.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi Sadaka</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
