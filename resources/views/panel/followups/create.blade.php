@extends('layouts.app')

@section('title', 'Ongeza Ufuatiliaji - Mfumo wa E-Kanisa')
@section('page-title', 'Ongeza Ufuatiliaji')
@section('page-subtitle', 'Jaza fomu hapa chini kuongeza ufuatiliaji mpya')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('followups.index') }}" class="rx-btn rx-btn-secondary rx-btn-sm">
            <i class="fas fa-arrow-left text-xs"></i> Rudi
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-headset" style="color: #360958"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Ongeza Ufuatiliaji</h1>
            <p class="text-sm text-gray-500">Jaza taarifa za ufuatiliaji mpya</p>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card">
        <form method="POST" action="{{ route('followups.store') }}">
            @csrf

            <!-- Taarifa za Mwanachama -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Mwanachama</h3>
                        <p class="text-xs text-gray-500">Chagua mwanachama wa kufuatilia</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Mwanachama <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                            <input type="text" readonly placeholder="Chagua mwanachama...">
                        </div>
                        <select id="member_id" name="member_id" required class="rx-select mt-2 @error('member_id') border-red-500 @enderror">
                            <option value="">-- Chagua Mwanachama --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $preselectedMember ?? '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->full_name }} ({{ $member->member_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Aina ya Ufuatiliaji <span class="text-red-500">*</span></label>
                        <select id="follow_up_type" name="follow_up_type" required class="rx-select @error('follow_up_type') border-red-500 @enderror">
                            <option value="">-- Chagua Aina --</option>
                            <option value="Kutokuwepo" {{ old('follow_up_type') == 'Kutokuwepo' ? 'selected' : '' }}>Kutokuwepo</option>
                            <option value="Mtihani" {{ old('follow_up_type') == 'Mtihani' ? 'selected' : '' }}>Mtihani</option>
                            <option value="Shida ya Kiafya" {{ old('follow_up_type') == 'Shida ya Kiafya' ? 'selected' : '' }}>Shida ya Kiafya</option>
                            <option value="Nyingine" {{ old('follow_up_type') == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                        </select>
                        @error('follow_up_type')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Kipaumbele <span class="text-red-500">*</span></label>
                        <select id="priority" name="priority" required class="rx-select @error('priority') border-red-500 @enderror">
                            <option value="">-- Chagua Kipaumbele --</option>
                            <option value="Ya Dharura" {{ old('priority') == 'Ya Dharura' ? 'selected' : '' }}>Ya Dharura</option>
                            <option value="Ya Juu" {{ old('priority') == 'Ya Juu' ? 'selected' : '' }}>Ya Juu</option>
                            <option value="Ya Kawaida" {{ old('priority') == 'Ya Kawaida' ? 'selected' : '' }}>Ya Kawaida</option>
                        </select>
                        @error('priority')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            <div class="p-6 bg-gray-50/50 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Maelezo ya Ufuatiliaji</h3>
                        <p class="text-xs text-gray-500">Eleza kwa undani kuhusu ufuatiliaji</p>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Kichwa <span class="text-red-500">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="rx-input rx-input-no-icon @error('subject') border-red-500 @enderror" placeholder="Kwa mfano: Mtihani wa mwisho, Shida ya afya...">
                        @error('subject')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Maelezo</label>
                        <textarea id="description" name="description" rows="4" class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror" placeholder="Eleza kwa undani kuhusu ufuatiliaji huu...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tarehe na Utekelezaji -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar-alt" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Tarehe na Utekelezaji</h3>
                        <p class="text-xs text-gray-500">Weka tarehe na mtu wa kutekeleza</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tarehe ya Kuanza <span class="text-red-500">*</span></label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="rx-input rx-input-no-icon @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tarehe ya Kufuatilia <span class="text-red-500">*</span></label>
                        <input type="date" id="follow_up_date" name="follow_up_date" value="{{ old('follow_up_date') }}" required class="rx-input rx-input-no-icon @error('follow_up_date') border-red-500 @enderror">
                        @error('follow_up_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Mtendaji <span class="text-red-500">*</span></label>
                        <select id="assigned_to" name="assigned_to" required class="rx-select @error('assigned_to') border-red-500 @enderror">
                            <option value="">-- Chagua Mtendaji --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                <a href="{{ route('followups.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times text-xs"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save text-xs"></i> Hifadhi Ufuatiliaji
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
