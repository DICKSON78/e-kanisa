@extends('layouts.app')

@section('title', 'Ongeza Malipo ya Mtandaoni - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('online-giving.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-mobile-alt" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ongeza Malipo ya Mtandaoni</h1>
                <p class="text-sm text-gray-500">Jaza taarifa za malipo yaliyofanywa kupitia mitandao ya simu</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('online-giving.store') }}">
            @csrf

            <!-- Taarifa za Malipo -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-mobile-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Malipo</h3>
                        <p class="text-xs text-gray-500">Jaza taarifa za kimsingi za malipo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwanachama <span class="text-red-500">*</span></label>
                        <select name="member_id" required class="rx-select @error('member_id') !border-red-500 @enderror">
                            <option value="">Chagua Mwanachama</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_number }} - {{ $member->first_name }} {{ $member->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi (TSh) <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required placeholder="0.00" class="@error('amount') !border-red-500 @enderror">
                        </div>
                        @error('amount')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Njia ya Malipo <span class="text-red-500">*</span></label>
                        <select name="payment_method" required class="rx-select @error('payment_method') !border-red-500 @enderror">
                            <option value="">Chagua Njia ya Malipo</option>
                            <option value="M-Pesa" {{ old('payment_method') == 'M-Pesa' ? 'selected' : '' }}>M-Pesa</option>
                            <option value="Tigo Pesa" {{ old('payment_method') == 'Tigo Pesa' ? 'selected' : '' }}>Tigo Pesa</option>
                            <option value="Airtel Money" {{ old('payment_method') == 'Airtel Money' ? 'selected' : '' }}>Airtel Money</option>
                            <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Namba ya Rejea <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="text" name="reference_number" value="{{ old('reference_number') }}" required placeholder="QGE4R2F7L0" class="@error('reference_number') !border-red-500 @enderror">
                        </div>
                        @error('reference_number')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nambari ya Simu <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" required placeholder="0712 345 678" class="@error('phone_number') !border-red-500 @enderror">
                        </div>
                        @error('phone_number')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Malengo <span class="text-red-500">*</span></label>
                        <select name="purpose" required class="rx-select @error('purpose') !border-red-500 @enderror">
                            <option value="">Chagua Lengo</option>
                            <option value="Sadaka" {{ old('purpose') == 'Sadaka' ? 'selected' : '' }}>Sadaka</option>
                            <option value="Ahadi" {{ old('purpose') == 'Ahadi' ? 'selected' : '' }}>Ahadi</option>
                            <option value="Kodi ya Kiwanja" {{ old('purpose') == 'Kodi ya Kiwanja' ? 'selected' : '' }}>Kodi ya Kiwanja</option>
                            <option value="Nyingine" {{ old('purpose') == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                        </select>
                        @error('purpose')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Mapato <span class="text-red-500">*</span></label>
                        <select name="income_category_id" required class="rx-select @error('income_category_id') !border-red-500 @enderror">
                            <option value="">Chagua Aina ya Mapato</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('income_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('income_category_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo</h3>
                        <p class="text-xs text-gray-500">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo (Hiari)</label>
                    <textarea name="description" rows="4" class="rx-input rx-input-no-icon @error('description') !border-red-500 @enderror" placeholder="Andika maelezo yoyote muhimu kuhusu malipo haya...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('online-giving.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi Malipo</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
