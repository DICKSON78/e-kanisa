<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Prevent caching - prevents access after logout via browser back button -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Jisajili - KKKT Agape</title>
    <link rel="icon" type="image/png" href="{{ asset('images/kkkt_logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#360958',
                            700: '#2a0745',
                            800: '#1e0533',
                            900: '#140322',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .step-indicator.active { background-color: #360958; color: white; }
        .step-indicator.completed { background-color: #10b981; color: white; }
        .step-line.active { background-color: #360958; }
        .step-line.completed { background-color: #10b981; }
        .input-focus:focus { border-color: #360958; box-shadow: 0 0 0 3px rgba(54, 9, 88, 0.2); }
        .step-content { display: none; }
        .step-content.active { display: block; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-6">
            <div class="flex justify-center items-center mb-4">
                <img src="{{ asset('images/kkkt_logo.png') }}" alt="KKKT Agape Logo" class="w-20 h-20 object-contain">
            </div>
            <span class="text-2xl font-bold text-primary-600 block">KKKT AGAPE</span>
            <h1 class="text-xl font-bold text-gray-800 mt-2">Jisajili kama Muumini</h1>
            <p class="text-gray-600 text-sm mt-1">Jaza fomu hii ili kujisajili kwenye mfumo wa Kanisa</p>
        </div>

        <!-- Display Errors -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-semibold">Kuna makosa yafuatayo:</span>
            </div>
            <ul class="list-disc list-inside ml-4 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        <!-- Step Indicators -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <!-- Step 1 -->
                <div class="flex flex-col items-center flex-1">
                    <div id="step-indicator-1" class="step-indicator active w-10 h-10 rounded-full flex items-center justify-center border-2 border-primary-600 font-bold text-sm">
                        <span class="step-number">1</span>
                        <i class="fas fa-check hidden"></i>
                    </div>
                    <span class="text-xs mt-1 text-gray-600 text-center">Binafsi</span>
                </div>
                <div id="step-line-1" class="step-line h-1 flex-1 bg-gray-300 mx-1"></div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center flex-1">
                    <div id="step-indicator-2" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 font-bold text-sm text-gray-400">
                        <span class="step-number">2</span>
                        <i class="fas fa-check hidden"></i>
                    </div>
                    <span class="text-xs mt-1 text-gray-600 text-center">Mawasiliano</span>
                </div>
                <div id="step-line-2" class="step-line h-1 flex-1 bg-gray-300 mx-1"></div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center flex-1">
                    <div id="step-indicator-3" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 font-bold text-sm text-gray-400">
                        <span class="step-number">3</span>
                        <i class="fas fa-check hidden"></i>
                    </div>
                    <span class="text-xs mt-1 text-gray-600 text-center">Kikristo</span>
                </div>
                <div id="step-line-3" class="step-line h-1 flex-1 bg-gray-300 mx-1"></div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center flex-1">
                    <div id="step-indicator-4" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 font-bold text-sm text-gray-400">
                        <span class="step-number">4</span>
                        <i class="fas fa-check hidden"></i>
                    </div>
                    <span class="text-xs mt-1 text-gray-600 text-center">Familia</span>
                </div>
                <div id="step-line-4" class="step-line h-1 flex-1 bg-gray-300 mx-1"></div>

                <!-- Step 5 -->
                <div class="flex flex-col items-center flex-1">
                    <div id="step-indicator-5" class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 font-bold text-sm text-gray-400">
                        <span class="step-number">5</span>
                        <i class="fas fa-check hidden"></i>
                    </div>
                    <span class="text-xs mt-1 text-gray-600 text-center">Thibitisha</span>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <form id="registrationForm" action="{{ route('register.post') }}" method="POST" class="bg-white rounded-xl shadow-lg overflow-hidden">
            @csrf

            <!-- Step 1: Personal Information -->
            <div id="step-1" class="step-content active p-6">
                <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kibinafsi</h3>
                        <p class="text-sm text-gray-600">Jaza taarifa zako za msingi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Kwanza <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Jina la kwanza">
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Kati
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-circle text-gray-400"></i>
                            </div>
                            <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Jina la kati">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jina la Ukoo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Jina la ukoo">
                        </div>
                        <p class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-info-circle"></i> Jina hili litatumika kama nenosiri lako la mwanzo
                        </p>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kuzaliwa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-birthday-cake text-gray-400"></i>
                            </div>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   max="{{ date('Y-m-d') }}">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Umri: <span id="age-display" class="font-medium text-primary-600">-</span>
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jinsia <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="gender" value="Mme" {{ old('gender') == 'Mme' ? 'checked' : '' }} required
                                       class="h-4 w-4 text-primary-600">
                                <div class="ml-2 flex items-center">
                                    <i class="fas fa-male text-blue-600 mr-1"></i>
                                    <span class="text-gray-700 text-sm">Mwanaume</span>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="gender" value="Mke" {{ old('gender') == 'Mke' ? 'checked' : '' }} required
                                       class="h-4 w-4 text-primary-600">
                                <div class="ml-2 flex items-center">
                                    <i class="fas fa-female text-pink-600 mr-1"></i>
                                    <span class="text-gray-700 text-sm">Mwanamke</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- ID Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Kitambulisho (NIDA)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Namba ya NIDA (tarakimu 20)"
                                   maxlength="20"
                                   pattern="[0-9]{20}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Namba ya NIDA lazima iwe na tarakimu 20 haswa
                            <span id="nida-counter" class="ml-2 font-medium text-primary-600">(0/20)</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Step 2: Contact Information -->
            <div id="step-2" class="step-content p-6">
                <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-phone-alt text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mawasiliano</h3>
                        <p class="text-sm text-gray-600">Jaza mawasiliano na anwani yako</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Simu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-alt text-gray-400"></i>
                            </div>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="0712 345 678">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Barua Pepe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="barua@pepe.com">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Anwani
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea name="address" rows="2"
                                      class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                      placeholder="Mtaa, Kata, Wilaya">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <!-- House Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Nyumba
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-home text-gray-400"></i>
                            </div>
                            <input type="text" name="house_number" value="{{ old('house_number') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="A123">
                        </div>
                    </div>

                    <!-- Block Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Namba ya Block
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" name="block_number" value="{{ old('block_number') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Block 5">
                        </div>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jiji/Mji
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-city text-gray-400"></i>
                            </div>
                            <input type="text" name="city" value="{{ old('city') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Dar es Salaam">
                        </div>
                    </div>

                    <!-- Region -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Mkoa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map text-gray-400"></i>
                            </div>
                            <input type="text" name="region" value="{{ old('region') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Dar es Salaam">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Christian Information -->
            <div id="step-3" class="step-content p-6">
                <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                    <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-church text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kikristo</h3>
                        <p class="text-sm text-gray-600">Taarifa za uanachama na ibada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Jumuiya -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Jumuiya <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <select name="jumuiya_id" required
                                    class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                                <option value="">-- Chagua Jumuiya --</option>
                                @foreach($jumuiyas as $jumuiya)
                                    <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>
                                        {{ $jumuiya->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Chagua jumuiya unayoishi karibu nayo
                        </p>
                    </div>

                    <!-- Baptism Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Ubatizo
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-water text-gray-400"></i>
                            </div>
                            <input type="date" name="baptism_date" value="{{ old('baptism_date') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                    </div>

                    <!-- Confirmation Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kipaimara
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hands-praying text-gray-400"></i>
                            </div>
                            <input type="date" name="confirmation_date" value="{{ old('confirmation_date') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                    </div>

                    <!-- Marital Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Hali ya Ndoa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-heart text-gray-400"></i>
                            </div>
                            <select name="marital_status" required
                                    class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                                <option value="">-- Chagua --</option>
                                <option value="Hajaoa/Hajaolewa" {{ old('marital_status') == 'Hajaoa/Hajaolewa' ? 'selected' : '' }}>Hajaoa/Hajaolewa</option>
                                <option value="Ameoa/Ameolewa" {{ old('marital_status') == 'Ameoa/Ameolewa' ? 'selected' : '' }}>Ameoa/Ameolewa</option>
                                <option value="Mjane/Mgane" {{ old('marital_status') == 'Mjane/Mgane' ? 'selected' : '' }}>Mjane/Mgane</option>
                                <option value="Talaka" {{ old('marital_status') == 'Talaka' ? 'selected' : '' }}>Talaka</option>
                            </select>
                        </div>
                    </div>

                    <!-- Special Group -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Kundi Maalum
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-layer-group text-gray-400"></i>
                            </div>
                            <input type="text" name="special_group" value="{{ old('special_group') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Kwaya, Fellowship, etc.">
                        </div>
                    </div>

                    <!-- Occupation -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Kazi/Ajira
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <input type="text" name="occupation" value="{{ old('occupation') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Mfano: Mwalimu, Daktari, Mfanyabiashara">
                        </div>
                    </div>

                    <!-- Church Elder -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Mzee wa Kanisa (Referee)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            <input type="text" name="church_elder" value="{{ old('church_elder') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                   placeholder="Jina la mzee wa kanisa anayekujua">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Family Information -->
            <div id="step-4" class="step-content p-6">
                <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                    <div class="h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-heart text-pink-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Familia</h3>
                        <p class="text-sm text-gray-600">Taarifa za mwenzi na jirani kwa dharura</p>
                    </div>
                </div>

                <!-- Spouse Information -->
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-ring text-primary-600 mr-2"></i> Taarifa za Mwenzi/Mke
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <!-- Spouse Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Jina la Mwenzi/Mke
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-friends text-gray-400"></i>
                                </div>
                                <input type="text" name="spouse_name" value="{{ old('spouse_name') }}"
                                       class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none bg-white"
                                       placeholder="Jina kamili la mwenzi">
                            </div>
                        </div>

                        <!-- Spouse Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Simu ya Mwenzi/Mke
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="spouse_phone" value="{{ old('spouse_phone') }}"
                                       class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none bg-white"
                                       placeholder="0712 345 678">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Neighbor/Emergency Contact -->
                <div>
                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-people-arrows text-primary-600 mr-2"></i> Mawasiliano ya Dharura
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <!-- Neighbor Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Jina la Jirani/Ndugu
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tie text-gray-400"></i>
                                </div>
                                <input type="text" name="neighbor_name" value="{{ old('neighbor_name') }}"
                                       class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none bg-white"
                                       placeholder="Jina la jirani/ndugu">
                            </div>
                        </div>

                        <!-- Neighbor Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Simu ya Jirani/Ndugu
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="neighbor_phone" value="{{ old('neighbor_phone') }}"
                                       class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none bg-white"
                                       placeholder="0712 345 678">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Review & Submit -->
            <div id="step-5" class="step-content p-6">
                <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Thibitisha na Usajili</h3>
                        <p class="text-sm text-gray-600">Hakikisha taarifa zote ni sahihi</p>
                    </div>
                </div>

                <!-- Auto-generated Info Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Taarifa Zinazozalishwa Moja kwa Moja</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li><i class="fas fa-hashtag text-blue-500 mr-2"></i><strong>Namba ya Muumini:</strong> Itazalishwa moja kwa moja baada ya usajili</li>
                                <li><i class="fas fa-key text-blue-500 mr-2"></i><strong>Nenosiri:</strong> Jina lako la ukoo (last name) litatumika kama nenosiri</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Taarifa Muhimu</h4>
                            <p class="text-sm text-gray-600">
                                Baada ya kujisajili, akaunti yako itahitaji <strong>kuthibitishwa na msimamizi</strong> wa Kanisa kabla ya kuweza kuingia kwenye mfumo. Utapokea ujumbe wakati akaunti yako itakapoidhinishwa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div id="reviewSummary" class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Muhtasari wa Taarifa Zako</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Jina Kamili:</span>
                            <span id="summary-name" class="font-medium text-gray-900 ml-2">-</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Simu:</span>
                            <span id="summary-phone" class="font-medium text-gray-900 ml-2">-</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Jinsia:</span>
                            <span id="summary-gender" class="font-medium text-gray-900 ml-2">-</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Jumuiya:</span>
                            <span id="summary-jumuiya" class="font-medium text-gray-900 ml-2">-</span>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start mb-4">
                    <input type="checkbox" id="terms" required class="mt-1 h-4 w-4 text-primary-600 rounded">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Nathibitisha kuwa taarifa nilizojaza ni za kweli na sahihi. Naelewa kuwa kutoa taarifa za uongo kunaweza kusababisha kufutwa uanachama.
                    </label>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-200">
                <button type="button" id="prevBtn" onclick="changeStep(-1)" class="hidden px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Rudi</span>
                </button>
                <div class="flex-1"></div>
                <button type="button" id="nextBtn" onclick="changeStep(1)" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all flex items-center gap-2">
                    <span>Endelea</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
                <button type="submit" id="submitBtn" class="hidden px-8 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition-all flex items-center gap-2">
                    <i class="fas fa-check"></i>
                    <span>Jisajili</span>
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="flex items-center justify-center my-6">
            <p class="text-gray-500">Tayari una akaunti?
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Ingia hapa</a>
            </p>
        </div>
    </div>

    <!-- Custom Alert Modal -->
    <div id="registerAlertModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="registerAlertModalContent">
            <div class="p-6 text-center">
                <div id="registerAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-yellow-100">
                    <i id="registerAlertIconClass" class="fas fa-exclamation-triangle text-3xl text-yellow-600"></i>
                </div>
                <h3 id="registerAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Onyo</h3>
                <p id="registerAlertMessage" class="text-gray-600 mb-6">Ujumbe hapa</p>
                <button onclick="closeRegisterAlertModal()" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-all">
                    <i class="fas fa-check mr-2"></i>Sawa, Nimeelewa
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 5;

        // ========================================
        // Custom Alert Modal Functions
        // ========================================
        function showRegisterAlert(type, title, message) {
            const modal = document.getElementById('registerAlertModal');
            const content = document.getElementById('registerAlertModalContent');
            const iconContainer = document.getElementById('registerAlertIcon');
            const iconClass = document.getElementById('registerAlertIconClass');
            const titleEl = document.getElementById('registerAlertTitle');
            const messageEl = document.getElementById('registerAlertMessage');

            // Configure based on type
            const configs = {
                'success': {
                    bgColor: 'bg-green-100',
                    iconColor: 'text-green-600',
                    icon: 'fas fa-check-circle'
                },
                'error': {
                    bgColor: 'bg-red-100',
                    iconColor: 'text-red-600',
                    icon: 'fas fa-times-circle'
                },
                'warning': {
                    bgColor: 'bg-yellow-100',
                    iconColor: 'text-yellow-600',
                    icon: 'fas fa-exclamation-triangle'
                },
                'info': {
                    bgColor: 'bg-blue-100',
                    iconColor: 'text-blue-600',
                    icon: 'fas fa-info-circle'
                }
            };

            const config = configs[type] || configs['warning'];

            iconContainer.className = `h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 ${config.bgColor}`;
            iconClass.className = `${config.icon} text-3xl ${config.iconColor}`;
            titleEl.textContent = title;
            messageEl.textContent = message;

            // Show modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeRegisterAlertModal() {
            const modal = document.getElementById('registerAlertModal');
            const content = document.getElementById('registerAlertModalContent');

            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Close modal on backdrop click
        document.getElementById('registerAlertModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeRegisterAlertModal();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRegisterAlertModal();
            }
        });

        function showStep(step) {
            // Hide all steps
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step-${i}`).classList.remove('active');
            }
            // Show current step
            document.getElementById(`step-${step}`).classList.add('active');

            // Update step indicators
            for (let i = 1; i <= totalSteps; i++) {
                const indicator = document.getElementById(`step-indicator-${i}`);
                const line = document.getElementById(`step-line-${i}`);

                if (i < step) {
                    indicator.classList.add('completed');
                    indicator.classList.remove('active');
                    indicator.querySelector('.step-number').classList.add('hidden');
                    indicator.querySelector('.fa-check').classList.remove('hidden');
                    if (line) line.classList.add('completed');
                } else if (i === step) {
                    indicator.classList.add('active');
                    indicator.classList.remove('completed');
                    indicator.querySelector('.step-number').classList.remove('hidden');
                    indicator.querySelector('.fa-check').classList.add('hidden');
                } else {
                    indicator.classList.remove('active', 'completed');
                    indicator.querySelector('.step-number').classList.remove('hidden');
                    indicator.querySelector('.fa-check').classList.add('hidden');
                    if (line) line.classList.remove('completed', 'active');
                }
            }

            // Show/hide navigation buttons
            document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
            document.getElementById('nextBtn').classList.toggle('hidden', step === totalSteps);
            document.getElementById('submitBtn').classList.toggle('hidden', step !== totalSteps);

            // Update summary on last step
            if (step === totalSteps) {
                updateSummary();
            }
        }

        function validateStep(step) {
            const stepElement = document.getElementById(`step-${step}`);
            const requiredFields = stepElement.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }

                // Special handling for radio buttons
                if (field.type === 'radio') {
                    const radioGroup = stepElement.querySelectorAll(`input[name="${field.name}"]`);
                    const isChecked = Array.from(radioGroup).some(r => r.checked);
                    if (!isChecked) {
                        isValid = false;
                    }
                }
            });

            return isValid;
        }

        function changeStep(direction) {
            // Validate current step before moving forward
            if (direction === 1 && !validateStep(currentStep)) {
                showRegisterAlert('warning', 'Taarifa Hazijajazwa', 'Tafadhali jaza sehemu zote zenye alama ya * (nyekundu) kabla ya kuendelea.');
                return;
            }

            currentStep += direction;
            if (currentStep < 1) currentStep = 1;
            if (currentStep > totalSteps) currentStep = totalSteps;
            showStep(currentStep);

            // Scroll to top of form
            document.getElementById('registrationForm').scrollIntoView({ behavior: 'smooth' });
        }

        function updateSummary() {
            const firstName = document.querySelector('[name="first_name"]').value || '';
            const middleName = document.querySelector('[name="middle_name"]').value || '';
            const lastName = document.querySelector('[name="last_name"]').value || '';
            const phone = document.querySelector('[name="phone"]').value || '-';
            const gender = document.querySelector('[name="gender"]:checked');
            const jumuiyaSelect = document.querySelector('[name="jumuiya_id"]');
            const jumuiya = jumuiyaSelect.options[jumuiyaSelect.selectedIndex]?.text || '-';

            document.getElementById('summary-name').textContent = `${firstName} ${middleName} ${lastName}`.trim() || '-';
            document.getElementById('summary-phone').textContent = phone;
            document.getElementById('summary-gender').textContent = gender ? (gender.value === 'Mme' ? 'Mwanaume' : 'Mwanamke') : '-';
            document.getElementById('summary-jumuiya').textContent = jumuiya;
        }

        // Initialize
        showStep(1);

        // NIDA counter
        const nidaInput = document.getElementById('id_number');
        const nidaCounter = document.getElementById('nida-counter');

        if (nidaInput && nidaCounter) {
            nidaInput.addEventListener('input', function() {
                const length = this.value.length;
                nidaCounter.textContent = `(${length}/20)`;

                if (length === 20) {
                    nidaCounter.classList.remove('text-primary-600', 'text-red-500');
                    nidaCounter.classList.add('text-green-600');
                } else if (length > 0) {
                    nidaCounter.classList.remove('text-primary-600', 'text-green-600');
                    nidaCounter.classList.add('text-red-500');
                } else {
                    nidaCounter.classList.remove('text-red-500', 'text-green-600');
                    nidaCounter.classList.add('text-primary-600');
                }
            });

            // Initialize counter on page load
            if (nidaInput.value) {
                nidaInput.dispatchEvent(new Event('input'));
            }
        }

        // Age calculator
        const dobInput = document.getElementById('date_of_birth');
        const ageDisplay = document.getElementById('age-display');

        if (dobInput && ageDisplay) {
            dobInput.addEventListener('change', function() {
                if (this.value) {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageDisplay.textContent = `Miaka ${age}`;
                } else {
                    ageDisplay.textContent = '-';
                }
            });

            // Initialize age on page load
            if (dobInput.value) {
                dobInput.dispatchEvent(new Event('change'));
            }
        }

        // NIDA validation on step change
        const originalValidateStep = validateStep;
        validateStep = function(step) {
            const isValid = originalValidateStep(step);

            // Additional NIDA validation on step 1
            if (step === 1 && isValid) {
                const nidaField = document.getElementById('id_number');
                if (nidaField && nidaField.value.length > 0 && nidaField.value.length !== 20) {
                    nidaField.classList.add('border-red-500');
                    showRegisterAlert('warning', 'Namba ya NIDA', 'Namba ya NIDA lazima iwe na tarakimu 20 haswa. Sasa una tarakimu ' + nidaField.value.length + '.');
                    return false;
                }
            }

            return isValid;
        };
    </script>
</body>
</html>
