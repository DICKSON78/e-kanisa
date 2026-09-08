@extends('layouts.app')

@section('title', 'Hariri Taarifa Zangu')
@section('page-title', 'Hariri Taarifa Zangu')
@section('page-subtitle', 'Sasisha taarifa za muumini')

@section('content')
<div class="space-y-6">

    <!-- Back Button -->
    <a href="{{ route('member.portal') }}" class="rx-btn rx-btn-secondary w-fit">
        <i class="fas fa-arrow-left"></i>
        <span>Rudi Nyumbani</span>
    </a>

    <!-- Page Header -->
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-user-edit" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hariri Taarifa Zangu</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za muumini</p>
        </div>
    </div>

    <!-- Profile Banner -->
    <div class="rx-card overflow-hidden">
        <div class="rounded-2xl" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                        <i class="fas fa-user text-3xl" style="color: #efc120"></i>
                    </div>
                    <div class="flex-1 text-white">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold">{{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}</h2>
                                <div class="flex items-center gap-3 mt-2 flex-wrap">
                                    <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                        <i class="fas fa-hashtag mr-2 text-xs" style="color: #efc120"></i>
                                        <span class="text-sm font-medium">Namba: {{ $member->member_number }}</span>
                                    </div>
                                    @if($member->is_active)
                                        <span class="rx-badge rx-badge-green text-xs">
                                            <i class="fas fa-check-circle mr-1"></i>Muumini Hai
                                        </span>
                                    @else
                                        <span class="rx-badge rx-badge-red text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Asiyetumika
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white/60 text-sm">Tarehe ya Uanachama</p>
                                <p class="text-lg font-bold">{{ \Carbon\Carbon::parse($member->membership_date)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Flash Messages -->
    @if(session('success'))
        <div class="rx-card p-4 border-l-4 border-green-500 bg-green-50">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="rx-card p-4 border-l-4 border-red-500 bg-red-50">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span class="text-sm font-semibold text-red-800">Kuna makosa yafuatayo:</span>
            </div>
            <ul class="list-disc list-inside ml-8">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('members.update', $member->id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <!-- Section 1: Taarifa za Kibinafsi -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-user text-sm" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Taarifa za Kibinafsi</h3>
                            <p class="text-sm text-gray-500">Sasisha taarifa za mtu binafsi</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Jina la Kwanza <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" required
                                   class="rx-input rx-input-no-icon @error('first_name') border-red-500 @enderror"
                                   placeholder="Jina la kwanza">
                            @error('first_name')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Jina la Kati
                            </label>
                            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $member->middle_name) }}"
                                   class="rx-input rx-input-no-icon @error('middle_name') border-red-500 @enderror"
                                   placeholder="Jina la kati">
                            @error('middle_name')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Jina la Ukoo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" required
                                   class="rx-input rx-input-no-icon @error('last_name') border-red-500 @enderror"
                                   placeholder="Jina la ukoo">
                            @error('last_name')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Tarehe ya Kuzaliwa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth) }}" required
                                   class="rx-input rx-input-no-icon @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jinsia <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                    <input type="radio" name="gender" value="Mme" {{ old('gender', $member->gender) == 'Mme' ? 'checked' : '' }} required
                                           class="h-4 w-4 border-gray-300" style="accent-color: #360958">
                                    <div class="ml-3 flex items-center">
                                        <i class="fas fa-male text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-sm text-gray-700 font-medium">Mwanaume</span>
                                    </div>
                                </label>
                                <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                    <input type="radio" name="gender" value="Mke" {{ old('gender', $member->gender) == 'Mke' ? 'checked' : '' }} required
                                           class="h-4 w-4 border-gray-300" style="accent-color: #360958">
                                    <div class="ml-3 flex items-center">
                                        <i class="fas fa-female text-pink-500 mr-2 text-sm"></i>
                                        <span class="text-sm text-gray-700 font-medium">Mwanamke</span>
                                    </div>
                                </label>
                            </div>
                            @error('gender')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Hali ya Ndoa <span class="text-red-500">*</span>
                            </label>
                            <select id="marital_status" name="marital_status" required
                                    class="rx-select @error('marital_status') border-red-500 @enderror">
                                <option value="">Chagua Hali ya Ndoa</option>
                                <option value="Hajaoa/Hajaolewa" {{ old('marital_status', $member->marital_status) == 'Hajaoa/Hajaolewa' ? 'selected' : '' }}>Hajaoa/Hajaolewa</option>
                                <option value="Ameoa/Ameolewa" {{ old('marital_status', $member->marital_status) == 'Ameoa/Ameolewa' ? 'selected' : '' }}>Ameoa/Ameolewa</option>
                                <option value="Mjane/Mgane" {{ old('marital_status', $member->marital_status) == 'Mjane/Mgane' ? 'selected' : '' }}>Mjane/Mgane</option>
                                <option value="Talaka" {{ old('marital_status', $member->marital_status) == 'Talaka' ? 'selected' : '' }}>Talaka</option>
                            </select>
                            @error('marital_status')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Number -->
                        <div>
                            <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Namba ya Kitambulisho
                            </label>
                            <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $member->id_number) }}"
                                   class="rx-input rx-input-no-icon @error('id_number') border-red-500 @enderror"
                                   placeholder="Namba ya kitambulisho">
                            @error('id_number')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Occupation -->
                        <div>
                            <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Kazi
                            </label>
                            <input type="text" id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}"
                                   class="rx-input rx-input-no-icon @error('occupation') border-red-500 @enderror"
                                   placeholder="Kazi yako">
                            @error('occupation')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Taarifa za Mawasiliano -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-phone-alt text-sm" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Taarifa za Mawasiliano</h3>
                            <p class="text-sm text-gray-500">Sasisha mawasiliano na anwani</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Namba ya Simu <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required
                                   class="rx-input rx-input-no-icon @error('phone') border-red-500 @enderror"
                                   placeholder="0712345678">
                            @error('phone')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Barua pepe
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                                   class="rx-input rx-input-no-icon @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Anwani
                            </label>
                            <textarea id="address" name="address" rows="2"
                                      class="rx-input rx-input-no-icon @error('address') border-red-500 @enderror"
                                      placeholder="Anwani kamili">{{ old('address', $member->address) }}</textarea>
                            @error('address')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Jiji
                            </label>
                            <input type="text" id="city" name="city" value="{{ old('city', $member->city) }}"
                                   class="rx-input rx-input-no-icon @error('city') border-red-500 @enderror"
                                   placeholder="Jiji">
                            @error('city')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Mkoa
                            </label>
                            <input type="text" id="region" name="region" value="{{ old('region', $member->region) }}"
                                   class="rx-input rx-input-no-icon @error('region') border-red-500 @enderror"
                                   placeholder="Mkoa">
                            @error('region')
                                <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Maelezo Mengine -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-sticky-note text-sm" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Maelezo Mengine</h3>
                            <p class="text-sm text-gray-500">Ongeza au sasisha maelezo mengine muhimu</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Maelezo (Hiari)
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="rx-input rx-input-no-icon @error('notes') border-red-500 @enderror"
                              placeholder="Andika maelezo yoyote mengine muhimu...">{{ old('notes', $member->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Notice -->
            <div class="rx-card p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Taarifa Muhimu</h4>
                        <p class="text-sm text-gray-600">
                            Namba ya Muumini haibadiliki. Imehifadhiwa kikamilifu katika mfumo. Tafadhali hakikisha kwamba taarifa zote
                            ulizoweka ni sahihi na za sasa. Mabadiliko yoyote yataakisiwa mara moja katika mfumo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-lg px-6 py-4 flex justify-end gap-3" style="z-index: 50;">
                <a href="{{ route('member.portal') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Sasisha Taarifa</span>
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    /* Toggle Switch Style */
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
        if (isActiveCheckbox) {
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
