@extends('layouts.app')

@section('title', 'Hariri Muumini - Mfumo wa ROC')
@section('page-title', 'Hariri Muumini')
@section('page-subtitle', 'Sasisha taarifa za muumini')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('members.show', $member->id) }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-user-edit" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Hariri Muumini</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za {{ $member->full_name }}</p>
        </div>
    </div>

    <!-- Form Container -->
    <form method="POST" action="{{ route('members.update', $member->id) }}">
        @csrf
        @method('PUT')

        <!-- Personal Information Section -->
        <div class="rx-card rounded-2xl mb-6">
            <div class="flex items-center gap-3 p-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-user" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Taarifa za Kibinafsi</h3>
                    <p class="text-sm text-gray-500">Sasisha taarifa za mtu binafsi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pb-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-gray-900 mb-2">
                        Jina la Kwanza <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" required
                           class="rx-input w-full" placeholder="Jina la kwanza">
                    @error('first_name')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div>
                    <label for="middle_name" class="block text-sm font-semibold text-gray-900 mb-2">
                        Jina la Kati
                    </label>
                    <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $member->middle_name) }}"
                           class="rx-input w-full" placeholder="Jina la kati">
                    @error('middle_name')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-gray-900 mb-2">
                        Jina la Ukoo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" required
                           class="rx-input w-full" placeholder="Jina la ukoo">
                    @error('last_name')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-semibold text-gray-900 mb-2">
                        Tarehe ya Kuzaliwa <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth) }}" required
                           class="rx-input w-full">
                    @error('date_of_birth')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Jinsia <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <input type="radio" name="gender" value="Mme" {{ old('gender', $member->gender) == 'Mme' ? 'checked' : '' }} required
                                   class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300">
                            <div class="ml-3 flex items-center">
                                <i class="fas fa-male text-blue-600 mr-2"></i>
                                <span class="text-gray-700 font-medium">Mwanaume</span>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <input type="radio" name="gender" value="Mke" {{ old('gender', $member->gender) == 'Mke' ? 'checked' : '' }} required
                                   class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300">
                            <div class="ml-3 flex items-center">
                                <i class="fas fa-female text-pink-600 mr-2"></i>
                                <span class="text-gray-700 font-medium">Mwanamke</span>
                            </div>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- ID Number -->
                <div>
                    <label for="id_number" class="block text-sm font-semibold text-gray-900 mb-2">
                        Namba ya Kitambulisho
                    </label>
                    <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $member->id_number) }}"
                           class="rx-input w-full" placeholder="Namba ya kitambulisho">
                    @error('id_number')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="rx-card rounded-2xl mb-6">
            <div class="flex items-center gap-3 p-6 border-t border-gray-100">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-phone-alt" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Taarifa za Mawasiliano</h3>
                    <p class="text-sm text-gray-500">Sasisha mawasiliano na anwani</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pb-6">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                        Namba ya Simu <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required
                           class="rx-input w-full" placeholder="0712345678">
                    @error('phone')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                        Barua pepe
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                           class="rx-input w-full" placeholder="email@example.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">
                        Anwani
                    </label>
                    <textarea id="address" name="address" rows="2"
                              class="rx-input w-full"
                              placeholder="Anwani kamili">{{ old('address', $member->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-semibold text-gray-900 mb-2">
                        Jiji
                    </label>
                    <input type="text" id="city" name="city" value="{{ old('city', $member->city) }}"
                           class="rx-input w-full" placeholder="Jiji">
                    @error('city')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Region -->
                <div>
                    <label for="region" class="block text-sm font-semibold text-gray-900 mb-2">
                        Mkoa
                    </label>
                    <input type="text" id="region" name="region" value="{{ old('region', $member->region) }}"
                           class="rx-input w-full" placeholder="Mkoa">
                    @error('region')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Occupation -->
                <div>
                    <label for="occupation" class="block text-sm font-semibold text-gray-900 mb-2">
                        Kazi
                    </label>
                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}"
                           class="rx-input w-full" placeholder="Kazi yako">
                    @error('occupation')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Christian Information Section -->
        <div class="rx-card rounded-2xl mb-6">
            <div class="flex items-center gap-3 p-6 border-t border-gray-100">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-church" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Taarifa za Kikristo</h3>
                    <p class="text-sm text-gray-500">Sasisha taarifa za uanachama na ibada</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pb-6">
                <!-- Baptism Date -->
                <div>
                    <label for="baptism_date" class="block text-sm font-semibold text-gray-900 mb-2">
                        Tarehe ya Ubatizo
                    </label>
                    <input type="date" id="baptism_date" name="baptism_date" value="{{ old('baptism_date', $member->baptism_date) }}"
                           class="rx-input w-full">
                    @error('baptism_date')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation Date -->
                <div>
                    <label for="confirmation_date" class="block text-sm font-semibold text-gray-900 mb-2">
                        Tarehe ya Uthibitisho
                    </label>
                    <input type="date" id="confirmation_date" name="confirmation_date" value="{{ old('confirmation_date', $member->confirmation_date) }}"
                           class="rx-input w-full">
                    @error('confirmation_date')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Membership Date -->
                <div>
                    <label for="membership_date" class="block text-sm font-semibold text-gray-900 mb-2">
                        Tarehe ya Ujumbe <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="membership_date" name="membership_date" value="{{ old('membership_date', $member->membership_date) }}" required
                           class="rx-input w-full">
                    @error('membership_date')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Marital Status -->
                <div>
                    <label for="marital_status" class="block text-sm font-semibold text-gray-900 mb-2">
                        Hali ya Ndoa <span class="text-red-500">*</span>
                    </label>
                    <select id="marital_status" name="marital_status" required
                            class="rx-select w-full">
                        <option value="">Chagua Hali ya Ndoa</option>
                        <option value="Hajaoa/Hajaolewa" {{ old('marital_status', $member->marital_status) == 'Hajaoa/Hajaolewa' ? 'selected' : '' }}>Hajaoa/Hajaolewa</option>
                        <option value="Ameoa/Ameolewa" {{ old('marital_status', $member->marital_status) == 'Ameoa/Ameolewa' ? 'selected' : '' }}>Ameoa/Ameolewa</option>
                        <option value="Mjane/Mgane" {{ old('marital_status', $member->marital_status) == 'Mjane/Mgane' ? 'selected' : '' }}>Mjane/Mgane</option>
                        <option value="Talaka" {{ old('marital_status', $member->marital_status) == 'Talaka' ? 'selected' : '' }}>Talaka</option>
                    </select>
                    @error('marital_status')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Member Status -->
                <div class="md:col-span-2">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="sr-only">
                                <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                            </div>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Muumini Hai</span>
                                <p class="text-xs text-gray-600 mt-1">
                                    Weka kuwa hai ikiwa muumini bado anahudhuria kanisa
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="rx-card rounded-2xl mb-6">
            <div class="flex items-center gap-3 p-6 border-t border-gray-100">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-sticky-note" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Maelezo Mengine</h3>
                    <p class="text-sm text-gray-500">Ongeza au sasisha maelezo mengine muhimu</p>
                </div>
            </div>

            <div class="px-6 pb-6">
                <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                    Maelezo (Hiari)
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="rx-input w-full"
                          placeholder="Andika maelezo yoyote mengine muhimu...">{{ old('notes', $member->notes) }}</textarea>
                @error('notes')
                    <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sticky Form Footer -->
        <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
            <a href="{{ route('members.show', $member->id) }}" class="rx-btn rx-btn-secondary">
                <i class="fas fa-times"></i> Ghairi
            </a>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-save"></i> Sasisha
            </button>
        </div>
    </form>
</div>

<style>
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: #360958;
    }
    input:checked ~ .block {
        background-color: #360958;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isActiveCheckbox = document.getElementById('is_active');
        const toggleSwitch = isActiveCheckbox.parentElement.parentElement;

        isActiveCheckbox.addEventListener('change', function() {
            const dot = toggleSwitch.querySelector('.dot');
            const block = toggleSwitch.querySelector('.block');

            if (this.checked) {
                dot.style.backgroundColor = '#360958';
                block.style.backgroundColor = '#4c1d95';
            } else {
                dot.style.backgroundColor = '#fff';
                block.style.backgroundColor = '#d1d5db';
            }
        });

        if (isActiveCheckbox.checked) {
            const dot = toggleSwitch.querySelector('.dot');
            const block = toggleSwitch.querySelector('.block');
            dot.style.backgroundColor = '#360958';
            block.style.backgroundColor = '#4c1d95';
        }

        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            if (input.value) {
                const date = new Date(input.value);
                if (!isNaN(date.getTime())) {
                    input.value = date.toISOString().split('T')[0];
                }
            }
        });
    });
</script>
@endsection
