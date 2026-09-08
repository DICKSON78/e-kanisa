@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('members.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-user-plus" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Sajili Muumini Mpya</h1>
            <p class="text-sm text-gray-500">Jaza taarifa zote za muumini wa kanisa</p>
        </div>
        <!-- Member Number Badge -->
        <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-3">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-hashtag" style="color: #efc120"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Namba ya Muumini/Bahasha:</p>
                    <p class="text-lg font-bold text-gray-900">{{ $nextMemberNumber }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('members.store') }}">
            @csrf

            <!-- Personal Information Section -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kibinafsi</h3>
                        <p class="text-sm text-gray-500">Jaza taarifa za mtu binafsi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Kwanza <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                                   class="rx-input @error('first_name') border-red-500 @enderror"
                                   placeholder="Jina la kwanza">
                        </div>
                        @error('first_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="middle_name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Kati
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-circle text-gray-400"></i>
                            </div>
                            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                   class="rx-input @error('middle_name') border-red-500 @enderror"
                                   placeholder="Jina la kati">
                        </div>
                        @error('middle_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Ukoo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                   class="rx-input @error('last_name') border-red-500 @enderror"
                                   placeholder="Jina la ukoo">
                        </div>
                        @error('last_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kuzaliwa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-birthday-cake text-gray-400"></i>
                            </div>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                   class="rx-input @error('date_of_birth') border-red-500 @enderror">
                        </div>
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
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                <input type="radio" name="gender" value="Mme" {{ old('gender') == 'Mme' ? 'checked' : '' }} required
                                       class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <div class="ml-3 flex items-center">
                                    <i class="fas fa-male text-blue-600 mr-2"></i>
                                    <span class="text-gray-700 font-medium">Mwanaume</span>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                <input type="radio" name="gender" value="Mke" {{ old('gender') == 'Mke' ? 'checked' : '' }} required
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
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}"
                                   class="rx-input @error('id_number') border-red-500 @enderror"
                                   placeholder="Namba ya kitambulisho">
                        </div>
                        @error('id_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-phone-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mawasiliano</h3>
                        <p class="text-sm text-gray-500">Jaza mawasiliano na anwani</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Simu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-alt text-gray-400"></i>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   class="rx-input @error('phone') border-red-500 @enderror"
                                   placeholder="0712345678">
                        </div>
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                            Barua pepe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="rx-input @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">
                            Anwani
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea id="address" name="address" rows="2"
                                      class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#efc120]/30 focus:border-[#efc120] text-gray-900 text-sm transition-all duration-200 @error('address') border-red-500 @enderror"
                                      placeholder="Anwani kamili">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- House Number -->
                    <div>
                        <label for="house_number" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Nyumba
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-home text-gray-400"></i>
                            </div>
                            <input type="text" id="house_number" name="house_number" value="{{ old('house_number') }}"
                                   class="rx-input @error('house_number') border-red-500 @enderror"
                                   placeholder="A123">
                        </div>
                        @error('house_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Block Number -->
                    <div>
                        <label for="block_number" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Block
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" id="block_number" name="block_number" value="{{ old('block_number') }}"
                                   class="rx-input @error('block_number') border-red-500 @enderror"
                                   placeholder="Block 5">
                        </div>
                        @error('block_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jiji
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-city text-gray-400"></i>
                            </div>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                   class="rx-input @error('city') border-red-500 @enderror"
                                   placeholder="Jiji">
                        </div>
                        @error('city')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Region -->
                    <div>
                        <label for="region" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mkoa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map text-gray-400"></i>
                            </div>
                            <input type="text" id="region" name="region" value="{{ old('region') }}"
                                   class="rx-input @error('region') border-red-500 @enderror"
                                   placeholder="Mkoa">
                        </div>
                        @error('region')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Christian Information Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-church" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kikristo</h3>
                        <p class="text-sm text-gray-500">Taarifa za uanachama na ibada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Baptism Date -->
                    <div>
                        <label for="baptism_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Ubatizo
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-water text-gray-400"></i>
                            </div>
                            <input type="date" id="baptism_date" name="baptism_date" value="{{ old('baptism_date') }}"
                                   class="rx-input @error('baptism_date') border-red-500 @enderror">
                        </div>
                        @error('baptism_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation Date -->
                    <div>
                        <label for="confirmation_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Uthibitisho
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hands-praying text-gray-400"></i>
                            </div>
                            <input type="date" id="confirmation_date" name="confirmation_date" value="{{ old('confirmation_date') }}"
                                   class="rx-input @error('confirmation_date') border-red-500 @enderror">
                        </div>
                        @error('confirmation_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Membership Date -->
                    <div>
                        <label for="membership_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Ujumbe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-check text-gray-400"></i>
                            </div>
                            <input type="date" id="membership_date" name="membership_date" value="{{ old('membership_date', date('Y-m-d')) }}" required
                                   class="rx-input @error('membership_date') border-red-500 @enderror">
                        </div>
                        @error('membership_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Marital Status -->
                    <div>
                        <label for="marital_status" class="block text-sm font-semibold text-gray-900 mb-2">
                            Hali ya Ndoa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-heart text-gray-400"></i>
                            </div>
                            <select id="marital_status" name="marital_status"
                                    class="pl-10 rx-select @error('marital_status') border-red-500 @enderror">
                                <option value="">Chagua Hali ya Ndoa</option>
                                <option value="Hajaoa/Hajaolewa" {{ old('marital_status') == 'Hajaoa/Hajaolewa' ? 'selected' : '' }}>Hajaoa/Hajaolewa</option>
                                <option value="Ameoa/Ameolewa" {{ old('marital_status') == 'Ameoa/Ameolewa' ? 'selected' : '' }}>Ameoa/Ameolewa</option>
                                <option value="Mjane/Mgane" {{ old('marital_status') == 'Mjane/Mgane' ? 'selected' : '' }}>Mjane/Mgane</option>
                                <option value="Talaka" {{ old('marital_status') == 'Talaka' ? 'selected' : '' }}>Talaka</option>
                            </select>
                        </div>
                        @error('marital_status')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Special Group -->
                    <div>
                        <label for="special_group" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kundi Maalum
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input type="text" id="special_group" name="special_group" value="{{ old('special_group') }}"
                                   class="rx-input @error('special_group') border-red-500 @enderror"
                                   placeholder="Kwaya, Fellowship, etc.">
                        </div>
                        @error('special_group')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Occupation -->
                    <div>
                        <label for="occupation" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kazi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}"
                                   class="rx-input @error('occupation') border-red-500 @enderror"
                                   placeholder="Kazi yako">
                        </div>
                        @error('occupation')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Spouse Information Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-ring" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mwenzi/Mke</h3>
                        <p class="text-sm text-gray-500">Jaza ikiwa muumini ameoa/ameolewa</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Spouse Name -->
                    <div>
                        <label for="spouse_name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Mwenzi/Mke
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-friends text-gray-400"></i>
                            </div>
                            <input type="text" id="spouse_name" name="spouse_name" value="{{ old('spouse_name') }}"
                                   class="rx-input @error('spouse_name') border-red-500 @enderror"
                                   placeholder="Jina la mwenzi/mke">
                        </div>
                        @error('spouse_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Spouse Phone -->
                    <div>
                        <label for="spouse_phone" class="block text-sm font-semibold text-gray-900 mb-2">
                            Simu ya Mwenzi/Mke
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-alt text-gray-400"></i>
                            </div>
                            <input type="tel" id="spouse_phone" name="spouse_phone" value="{{ old('spouse_phone') }}"
                                   class="rx-input @error('spouse_phone') border-red-500 @enderror"
                                   placeholder="0712345678">
                        </div>
                        @error('spouse_phone')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Neighbor Information Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-people-arrows" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Jirani</h3>
                        <p class="text-sm text-gray-500">Jaza jirani wa karibu kwa dharura</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Neighbor Name -->
                    <div>
                        <label for="neighbor_name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Jirani
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            <input type="text" id="neighbor_name" name="neighbor_name" value="{{ old('neighbor_name') }}"
                                   class="rx-input @error('neighbor_name') border-red-500 @enderror"
                                   placeholder="Jina la jirani">
                        </div>
                        @error('neighbor_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Neighbor Phone -->
                    <div>
                        <label for="neighbor_phone" class="block text-sm font-semibold text-gray-900 mb-2">
                            Simu ya Jirani
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" id="neighbor_phone" name="neighbor_phone" value="{{ old('neighbor_phone') }}"
                                   class="rx-input @error('neighbor_phone') border-red-500 @enderror"
                                   placeholder="0712345678">
                        </div>
                        @error('neighbor_phone')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Church Leadership Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user-tie" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Uongozi wa Kanisa</h3>
                        <p class="text-sm text-gray-500">Jaza ikiwa muumini ana jukumu maalum</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Church Elder -->
                    <div>
                        <label for="church_elder" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mzee wa Kanisa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-graduate text-gray-400"></i>
                            </div>
                            <input type="text" id="church_elder" name="church_elder" value="{{ old('church_elder') }}"
                                   class="rx-input @error('church_elder') border-red-500 @enderror"
                                   placeholder="Jina la mzee wa kanisa">
                        </div>
                        @error('church_elder')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pledge Number -->
                    <div>
                        <label for="pledge_number" class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Ahadi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-handshake text-gray-400"></i>
                            </div>
                            <input type="text" id="pledge_number" name="pledge_number" value="{{ old('pledge_number') }}"
                                   class="rx-input @error('pledge_number') border-red-500 @enderror"
                                   placeholder="AH001">
                        </div>
                        @error('pledge_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- System Access Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-lock" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Ufikiaji wa Mfumo</h3>
                        <p class="text-sm text-gray-500">Usanidi wa akaunti na majukumu</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Create User Account -->
                    <div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <label class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" name="create_user_account" id="create_user_account" value="1"
                                           {{ old('create_user_account') ? 'checked' : '' }} class="sr-only">
                                    <div class="block bg-gray-300 w-10 h-6 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">Tengeneza Akaunti ya Mtumiaji</span>
                                    <p class="text-xs text-gray-600 mt-1">
                                        Username = Namba ya Kadi, Password = Jina la Ukoo
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jukumu (Role)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-shield text-gray-400"></i>
                            </div>
                            <select id="role_id" name="role_id"
                                    class="pl-10 rx-select @error('role_id') border-red-500 @enderror">
                                <option value="">Chagua Jukumu</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle text-[#efc120] mr-1"></i>
                            Chagua ikiwa muumini atakuwa na majukumu maalum (Mhasibu, Mchungaji, n.k.)
                        </p>
                        @error('role_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Idara (Department)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-sitemap text-gray-400"></i>
                            </div>
                            <select id="department_id" name="department_id"
                                    class="pl-10 rx-select @error('department_id') border-red-500 @enderror">
                                <option value="">Chagua Idara</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle text-[#efc120] mr-1"></i>
                            Chagua ikiwa muumini ni sehemu ya idara maalum (Uhasibu, Muziki, Ujenzi, n.k.)
                        </p>
                        @error('department_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumuiya -->
                    <div>
                        <label for="jumuiya_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Jumuiya
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <select id="jumuiya_id" name="jumuiya_id"
                                    class="pl-10 rx-select @error('jumuiya_id') border-red-500 @enderror">
                                <option value="">Chagua Jumuiya</option>
                                @foreach($jumuiyas as $jumuiya)
                                    <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>
                                        {{ $jumuiya->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle text-[#efc120] mr-1"></i>
                            Chagua jumuiya ambayo muumini atakuwa mwanachama
                        </p>
                        @error('jumuiya_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sticky-note" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Maelezo Mengine</h3>
                        <p class="text-sm text-gray-500">Ongeza maelezo yoyote mengine muhimu</p>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                        Maelezo (Hiari)
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3">
                            <i class="fas fa-edit text-gray-400"></i>
                        </div>
                        <textarea id="notes" name="notes" rows="3"
                                  class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#efc120]/30 focus:border-[#efc120] text-gray-900 text-sm transition-all duration-200 @error('notes') border-red-500 @enderror"
                                  placeholder="Andika maelezo yoyote mengine muhimu...">{{ old('notes') }}</textarea>
                    </div>
                    @error('notes')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sticky Form Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('members.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Hifadhi
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Toggle Switch Style */
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: #efc120;
    }
    input:checked ~ .block {
        background-color: #efc120;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-select today's date for membership date if not set
        const membershipDateInput = document.getElementById('membership_date');
        if (membershipDateInput && !membershipDateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            membershipDateInput.value = today;
        }

        // Toggle switch functionality
        const createAccountCheckbox = document.getElementById('create_user_account');
        const toggleSwitch = createAccountCheckbox.parentElement.parentElement;

        createAccountCheckbox.addEventListener('change', function() {
            const dot = toggleSwitch.querySelector('.dot');
            const block = toggleSwitch.querySelector('.block');

            if (this.checked) {
                dot.style.backgroundColor = '#efc120';
                block.style.backgroundColor = '#efc120';
            } else {
                dot.style.backgroundColor = '#fff';
                block.style.backgroundColor = '#d1d5db';
            }
        });

        // Initialize toggle switch state
        if (createAccountCheckbox.checked) {
            const dot = toggleSwitch.querySelector('.dot');
            const block = toggleSwitch.querySelector('.block');
            dot.style.backgroundColor = '#efc120';
            block.style.backgroundColor = '#efc120';
        }
    });
</script>
@endsection
