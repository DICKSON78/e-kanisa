<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KKKT Agape</title>
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

        .login-container {
            width: 100%;
            max-width: 400px;
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

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            padding: 24px;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal.active .modal-content {
            transform: translateY(0);
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Login Form Only - No Card Design -->
    <div class="login-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <img src="{{ asset('images/kkkt_logo.png') }}" alt="KKKT Agape Logo" class="w-40 h-40 object-contain">
            </div>
            <span class="text-2xl font-bold text-purple-600 my-2 block">KKKT AGAPE</span>
            <h1 class="text-2xl font-bold text-gray-800">Karibu Tena</h1>
            <p class="text-gray-600 mt-2">Ingia kwenye akaunti yako ya Kanisa</p>
        </div>

        <!-- Display Errors -->
        @if($errors->any())
        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('authenticate') }}" method="POST" class="space-y-4" id="login-form">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Namba ya Kadi au Barua Pepe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input id="email" name="email" type="text" required value="{{ old('email') }}"
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition bg-white text-gray-800"
                           placeholder="KKKT-AGAPE-2025-0001 au barua@pepe.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle"></i> Wanachama wanatumia namba yao ya kadi kuingia mfumoni
                </p>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Nenosiri</label>
                    <a href="#" onclick="openModal('forgot-password-modal')" class="text-sm text-purple-600 hover:text-purple-700 focus:outline-none">
                        Umesahau nenosiri?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition bg-white text-gray-800"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-purple-600 focus:ring-purple-600 border-gray-300 rounded bg-white">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Nikumbuke</label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium mt-4">
                <i class="fas fa-sign-in-alt mr-2"></i> Ingia
            </button>
        </form>

        <!-- Sign Up Link -->
        <div class="flex items-center justify-center my-6">
            <h2 class="text-gray-500">Huna akaunti?
                <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-medium">Jiandikishe hapa</a>
            </h2>
        </div>

    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal" class="modal">
        <div class="modal-content relative">
            <button onclick="closeModal('forgot-password-modal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="text-center mb-6">
                <div class="flex justify-center items-center mb-4">
                    <img src="{{ asset('images/kkkt_logo.png') }}" alt="KKKT Agape Logo" class="w-16 h-16 object-contain">
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Weka Upya Nenosiri</h2>
                <p class="text-gray-600 mt-2">Weka barua pepe yako kupokea kiungo cha kuweka upya nenosiri</p>
            </div>
            <form class="space-y-4" id="reset-password-form">
                <div>
                    <label for="reset-email" class="block text-sm font-medium text-gray-700 mb-1">Anwani ya Barua Pepe</label>
                    <input type="email" id="reset-email" name="email"
                           class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition bg-white text-gray-800"
                           placeholder="barua@pepe.com" required>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium">
                    <i class="fas fa-paper-plane mr-2"></i> Tuma Kiungo cha Kubadilisha
                </button>
            </form>
            <div class="mt-4 text-center text-sm text-gray-500">
                Unakumbuka nenosiri lako?
                <a href="#" onclick="closeModal('forgot-password-modal')" class="text-purple-600 hover:text-purple-700 focus:outline-none">
                    Ingia
                </a>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.active');
                modals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });

        // Display success/error messages from Laravel
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const successMsg = document.getElementById('success-message');
                successMsg.textContent = '{{ session('success') }}';
                successMsg.classList.remove('hidden');
            });
        @endif

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('error-message').classList.remove('hidden');
            });
        @endif

        document.getElementById('reset-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Kiungo cha kuweka upya nenosiri kimetumwa kwa barua pepe yako!');
            closeModal('forgot-password-modal');
        });

        // Auto-focus on email input
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.focus();
            }
        });
    </script>
</body>
</html>
