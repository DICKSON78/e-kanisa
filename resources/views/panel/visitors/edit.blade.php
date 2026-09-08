@extends('layouts.app')

@section('title', 'Hariri Mgeni - Mfumo wa E-Kanisa')
@section('page-title', 'Hariri Mgeni')
@section('page-subtitle', 'Sasisha taarifa za mgeni')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('visitors.index') }}" class="rx-btn rx-btn-secondary !px-3">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                <i class="fas fa-user-edit text-secondary-500"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Hariri Mgeni</h1>
                <div class="flex items-center gap-1.5">
                    <p class="text-sm text-gray-500">Sasisha taarifa za</p>
                    <span class="text-sm font-semibold text-secondary-500">{{ $visitor->first_name }} {{ $visitor->last_name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card overflow-hidden">
        <form method="POST" action="{{ route('visitors.update', $visitor->id) }}" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-user text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Kibinafsi</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za mtu binafsi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Jina la Kwanza <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $visitor->first_name) }}" required
                                   class="rx-input @error('first_name') !border-red-500 @enderror"
                                   placeholder="Jina la kwanza">
                        </div>
                        @error('first_name')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Jina la Ukoo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $visitor->last_name) }}" required
                                   class="rx-input @error('last_name') !border-red-500 @enderror"
                                   placeholder="Jina la ukoo">
                        </div>
                        @error('last_name')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">
                            Jinsia <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3 mt-1">
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                <input type="radio" name="gender" value="Mme" {{ old('gender', $visitor->gender) == 'Mme' ? 'checked' : '' }} required
                                       class="h-4 w-4 text-secondary-500 focus:ring-secondary-500 border-gray-300">
                                <div class="ml-3 flex items-center">
                                    <i class="fas fa-male text-blue-500 mr-2 text-sm"></i>
                                    <span class="text-sm text-gray-700 font-medium">Mme</span>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                <input type="radio" name="gender" value="Mke" {{ old('gender', $visitor->gender) == 'Mke' ? 'checked' : '' }} required
                                       class="h-4 w-4 text-secondary-500 focus:ring-secondary-500 border-gray-300">
                                <div class="ml-3 flex items-center">
                                    <i class="fas fa-female text-pink-500 mr-2 text-sm"></i>
                                    <span class="text-sm text-gray-700 font-medium">Mke</span>
                                </div>
                            </label>
                        </div>
                        @error('gender')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-phone-alt text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Mawasiliano</h3>
                        <p class="text-xs text-gray-500">Sasisha mawasiliano na anwani</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Namba ya Simu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-alt text-gray-400 text-sm"></i>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $visitor->phone) }}" required
                                   class="rx-input @error('phone') !border-red-500 @enderror"
                                   placeholder="0712345678">
                        </div>
                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Barua pepe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 text-sm"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $visitor->email) }}"
                                   class="rx-input @error('email') !border-red-500 @enderror"
                                   placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Anwani
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                            </div>
                            <textarea id="address" name="address" rows="2"
                                      class="rx-input !pl-10 @error('address') !border-red-500 @enderror"
                                      placeholder="Anwani kamili">{{ old('address', $visitor->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Jiji
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-city text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" id="city" name="city" value="{{ old('city', $visitor->city) }}"
                                   class="rx-input @error('city') !border-red-500 @enderror"
                                   placeholder="Jiji">
                        </div>
                        @error('city')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Visit Information Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-church text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ziara</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za ziara na ibada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Church From -->
                    <div>
                        <label for="church_from" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Kanisa Alilokitoka
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-church text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" id="church_from" name="church_from" value="{{ old('church_from', $visitor->church_from) }}"
                                   class="rx-input @error('church_from') !border-red-500 @enderror"
                                   placeholder="Jina la kanisa">
                        </div>
                        @error('church_from')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visit Date -->
                    <div>
                        <label for="visit_date" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Tarehe ya Ziara <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                            </div>
                            <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', $visitor->visit_date) }}" required
                                   class="rx-input @error('visit_date') !border-red-500 @enderror">
                        </div>
                        @error('visit_date')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Aina ya Ibada <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-praying-hands text-gray-400 text-sm"></i>
                            </div>
                            <select id="service_type" name="service_type" required
                                    class="rx-input rx-select !pl-10 @error('service_type') !border-red-500 @enderror">
                                <option value="">Chagua Aina ya Ibada</option>
                                <option value="Ibada Kuu" {{ old('service_type', $visitor->service_type) == 'Ibada Kuu' ? 'selected' : '' }}>Ibada Kuu</option>
                                <option value="Ibada ya Jumapili" {{ old('service_type', $visitor->service_type) == 'Ibada ya Jumapili' ? 'selected' : '' }}>Ibada ya Jumapili</option>
                                <option value="Kikao" {{ old('service_type', $visitor->service_type) == 'Kikao' ? 'selected' : '' }}>Kikao</option>
                                <option value="Nyingine" {{ old('service_type', $visitor->service_type) == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                            </select>
                        </div>
                        @error('service_type')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Referred By -->
                    <div>
                        <label for="referred_by" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Aliyemkaribisha
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tag text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" id="referred_by" name="referred_by" value="{{ old('referred_by', $visitor->referred_by) }}"
                                   class="rx-input @error('referred_by') !border-red-500 @enderror"
                                   placeholder="Jina la mtu aliyemkaribisha">
                        </div>
                        @error('referred_by')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Assignment & Notes Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-user-tie text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Utekelezaji na Maelezo</h3>
                        <p class="text-xs text-gray-500">Sasisha mtu wa kufuatilia na maelezo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Assigned To -->
                    <div>
                        <label for="assigned_to" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Aliyeteuliwa Kufuatilia
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-check text-gray-400 text-sm"></i>
                            </div>
                            <select id="assigned_to" name="assigned_to"
                                    class="rx-input rx-select !pl-10 @error('assigned_to') !border-red-500 @enderror">
                                <option value="">Chagua Mtumishi</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $visitor->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-1.5">
                            <i class="fas fa-info-circle text-secondary-500 mr-1"></i>
                            Mtumishi aliyeteuliwa kufuatilia mgeni huyu
                        </p>
                        @error('assigned_to')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Hali ya Mgeni
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-flag text-gray-400 text-sm"></i>
                            </div>
                            <select id="status" name="status"
                                    class="rx-input rx-select !pl-10 @error('status') !border-red-500 @enderror">
                                <option value="Mgeni" {{ old('status', $visitor->status) == 'Mgeni' ? 'selected' : '' }}>Mgeni</option>
                                <option value="Mfuatiliaji" {{ old('status', $visitor->status) == 'Mfuatiliaji' ? 'selected' : '' }}>Mfuatiliaji</option>
                                <option value="Mwanachama" {{ old('status', $visitor->status) == 'Mwanachama' ? 'selected' : '' }}>Mwanachama</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Follow Up Status -->
                    <div>
                        <label for="follow_up_status" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Hali ya Ufuatiliaji
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-headset text-gray-400 text-sm"></i>
                            </div>
                            <select id="follow_up_status" name="follow_up_status"
                                    class="rx-input rx-select !pl-10 @error('follow_up_status') !border-red-500 @enderror">
                                <option value="Inasubiri" {{ old('follow_up_status', $visitor->follow_up_status) == 'Inasubiri' ? 'selected' : '' }}>Inasubiri</option>
                                <option value="Imeanzishwa" {{ old('follow_up_status', $visitor->follow_up_status) == 'Imeanzishwa' ? 'selected' : '' }}>Imeanzishwa</option>
                                <option value="Imekamilika" {{ old('follow_up_status', $visitor->follow_up_status) == 'Imekamilika' ? 'selected' : '' }}>Imekamilika</option>
                            </select>
                        </div>
                        @error('follow_up_status')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-xs font-medium text-gray-500 mb-1.5">
                            Maelezo (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-sticky-note text-gray-400 text-sm"></i>
                            </div>
                            <textarea id="notes" name="notes" rows="3"
                                      class="rx-input !pl-10 @error('notes') !border-red-500 @enderror"
                                      placeholder="Andika maelezo yoyote mengine muhimu...">{{ old('notes', $visitor->notes) }}</textarea>
                        </div>
                        @error('notes')
                            <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('visitors.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Sasisha Taarifa</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
