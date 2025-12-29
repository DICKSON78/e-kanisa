<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jisajili - KKKT Agape</title>
    <link rel="icon" type="image/png" href="{{ asset('images/kkkt_logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #360958;
            --secondary: #efc120;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #F8FAFC;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .btn-primary {
            background: #360958;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #2a0745;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(54, 9, 88, 0.3);
        }

        .input-focus:focus {
            border-color: #360958;
            box-shadow: 0 0 0 3px rgba(54, 9, 88, 0.2);
        }
    </style>
</head>
<body class="text-gray-800 py-8">
    <div class="register-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-6">
            <div class="flex justify-center items-center mb-4">
                <img src="{{ asset('images/kkkt_logo.png') }}" alt="KKKT Agape Logo" class="w-24 h-24 object-contain">
            </div>
            <span class="text-2xl font-bold text-purple-600 my-2 block">KKKT AGAPE</span>
            <h1 class="text-2xl font-bold text-gray-800">Jisajili kama Muumini</h1>
            <p class="text-gray-600 mt-2">Jaza fomu hii ili kujisajili kwenye mfumo wa Kanisa</p>
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

        <!-- Registration Form -->
        <form action="{{ route('register.post') }}" method="POST" class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            @csrf

            <!-- Personal Information Section -->
            <div>
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                    <div class="h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-user text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Taarifa za Kibinafsi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Jina la Kwanza <span class="text-red-500">*</span>
                        </label>
                        <input id="first_name" name="first_name" type="text" required value="{{ old('first_name') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mfano: John">
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Jina la Kati
                        </label>
                        <input id="middle_name" name="middle_name" type="text" value="{{ old('middle_name') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mfano: Peter">
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Jina la Mwisho <span class="text-red-500">*</span>
                        </label>
                        <input id="last_name" name="last_name" type="text" required value="{{ old('last_name') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mfano: Mwanga">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                            Tarehe ya Kuzaliwa <span class="text-red-500">*</span>
                        </label>
                        <input id="date_of_birth" name="date_of_birth" type="date" required value="{{ old('date_of_birth') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                            Jinsia <span class="text-red-500">*</span>
                        </label>
                        <select id="gender" name="gender" required
                                class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition">
                            <option value="">-- Chagua --</option>
                            <option value="Mme" {{ old('gender') == 'Mme' ? 'selected' : '' }}>Mwanaume</option>
                            <option value="Mke" {{ old('gender') == 'Mke' ? 'selected' : '' }}>Mwanamke</option>
                        </select>
                    </div>

                    <!-- Marital Status -->
                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">
                            Hali ya Ndoa <span class="text-red-500">*</span>
                        </label>
                        <select id="marital_status" name="marital_status" required
                                class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition">
                            <option value="">-- Chagua --</option>
                            <option value="Hajaoa/Hajaolewa" {{ old('marital_status') == 'Hajaoa/Hajaolewa' ? 'selected' : '' }}>Hajaoa/Hajaolewa</option>
                            <option value="Ameoa/Ameolewa" {{ old('marital_status') == 'Ameoa/Ameolewa' ? 'selected' : '' }}>Ameoa/Ameolewa</option>
                            <option value="Mjane" {{ old('marital_status') == 'Mjane' ? 'selected' : '' }}>Mjane</option>
                            <option value="Ametaliki" {{ old('marital_status') == 'Ametaliki' ? 'selected' : '' }}>Ametaliki</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div>
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                    <div class="h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-phone text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Mawasiliano</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Namba ya Simu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-alt text-gray-400"></i>
                            </div>
                            <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}"
                                   class="pl-10 input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                                   placeholder="+255 XXX XXX XXX">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Barua Pepe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                   class="pl-10 input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                                   placeholder="barua@pepe.com">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Barua pepe itatumika kuingia kwenye mfumo
                        </p>
                    </div>
                </div>
            </div>

            <!-- Jumuiya Section -->
            <div>
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                    <div class="h-8 w-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Jumuiya</h3>
                </div>

                <div>
                    <label for="jumuiya_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Chagua Jumuiya <span class="text-red-500">*</span>
                    </label>
                    <select id="jumuiya_id" name="jumuiya_id" required
                            class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition">
                        <option value="">-- Chagua Jumuiya --</option>
                        @foreach($jumuiyas as $jumuiya)
                            <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>
                                {{ $jumuiya->display_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle"></i> Chagua jumuiya unayoishi karibu nayo
                    </p>
                </div>
            </div>

            <!-- Address Section -->
            <div>
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                    <div class="h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Anwani</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Address -->
                    <div class="md:col-span-3">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Anwani Kamili
                        </label>
                        <input id="address" name="address" type="text" value="{{ old('address') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mtaa, Kata, Wilaya">
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            Jiji/Mji
                        </label>
                        <input id="city" name="city" type="text" value="{{ old('city') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mfano: Dar es Salaam">
                    </div>

                    <!-- Region -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 mb-1">
                            Mkoa
                        </label>
                        <input id="region" name="region" type="text" value="{{ old('region') }}"
                               class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Mfano: Dar es Salaam">
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div>
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                    <div class="h-8 w-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-lock text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Nenosiri</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Nenosiri <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                   class="pl-10 input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                                   placeholder="Herufi 8 au zaidi">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Thibitisha Nenosiri <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="pl-10 input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                                   placeholder="Rudia nenosiri">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="h-8 w-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Taarifa Muhimu</h4>
                        <p class="text-sm text-gray-600">
                            Baada ya kujisajili, akaunti yako itahitaji kuthibitishwa na msimamizi wa Kanisa kabla ya kuweza kuingia kwenye mfumo.
                            Utapokea ujumbe mfupi (SMS) au barua pepe wakati akaunti yako itakapoidhinishwa.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium">
                <i class="fas fa-user-plus mr-2"></i> Jisajili
            </button>
        </form>

        <!-- Login Link -->
        <div class="flex items-center justify-center my-6">
            <p class="text-gray-500">Tayari una akaunti?
                <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Ingia hapa</a>
            </p>
        </div>
    </div>
</body>
</html>
