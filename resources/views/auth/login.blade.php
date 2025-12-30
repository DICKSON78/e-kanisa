<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Prevent caching - prevents access after logout via browser back button -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
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
            border-radius: 16px;
            max-width: 420px;
            width: 90%;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        /* Login Progress Bar */
        .login-progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: rgba(54, 9, 88, 0.1);
            z-index: 9999;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease;
        }

        .login-progress-container.active {
            opacity: 1;
            visibility: visible;
        }

        .login-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #360958, #efc120, #360958);
            background-size: 200% 100%;
            animation: progressGradient 1.5s ease infinite;
            transition: width 0.3s ease;
        }

        @keyframes progressGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-progress-bar.indeterminate {
            width: 100%;
            animation: progressIndeterminate 1.5s ease-in-out infinite, progressGradient 1.5s ease infinite;
        }

        @keyframes progressIndeterminate {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Login Progress Bar -->
    <div class="login-progress-container" id="loginProgressContainer">
        <div class="login-progress-bar" id="loginProgressBar"></div>
    </div>

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
        <div class="modal-content relative p-6">
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

            <!-- Error/Success Messages -->
            <div id="forgot-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span id="forgot-error-text"></span>
                </div>
            </div>
            <div id="forgot-success" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span id="forgot-success-text"></span>
                </div>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4" id="reset-password-form">
                @csrf
                <div>
                    <label for="reset-email" class="block text-sm font-medium text-gray-700 mb-1">Barua Pepe ya Usajili</label>
                    <input type="email" id="reset-email" name="email"
                           class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition bg-white text-gray-800"
                           placeholder="barua@pepe.com" required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle"></i> Ingiza barua pepe uliyoitumia wakati wa kusajili
                    </p>
                </div>
                <button type="submit" id="forgot-submit-btn" class="btn-primary w-full text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane" id="forgot-btn-icon"></i>
                    <span id="forgot-btn-text">Tuma Kiungo cha Kubadilisha</span>
                </button>
            </form>

            <!-- Church Contact Info -->
            @php
                $churchPhone = \App\Models\Setting::get('church_phone', '+255 XXX XXX XXX');
                $churchEmail = \App\Models\Setting::get('church_email', 'info@kkkt-agape.org');
            @endphp
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-xs font-semibold text-gray-800 mb-1">Msaada wa Ziada</p>
                <p class="text-xs text-gray-600 mb-2">Ukishindwa, wasiliana na ofisi:</p>
                <div class="text-xs space-y-1">
                    @if($churchPhone)
                    <p><i class="fas fa-phone text-blue-500 mr-1"></i><a href="tel:{{ $churchPhone }}" class="text-blue-600 hover:underline">{{ $churchPhone }}</a></p>
                    @endif
                    @if($churchEmail)
                    <p><i class="fas fa-envelope text-blue-500 mr-1"></i><a href="mailto:{{ $churchEmail }}" class="text-blue-600 hover:underline">{{ $churchEmail }}</a></p>
                    @endif
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-500">
                Unakumbuka nenosiri lako?
                <a href="#" onclick="closeModal('forgot-password-modal')" class="text-purple-600 hover:text-purple-700 focus:outline-none">
                    Ingia
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div id="loginAlertModal" class="modal">
        <div class="modal-content p-6 text-center">
            <div id="loginAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100">
                <i id="loginAlertIconClass" class="fas fa-check-circle text-3xl text-green-600"></i>
            </div>
            <h3 id="loginAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Imefanikiwa!</h3>
            <p id="loginAlertMessage" class="text-gray-600 mb-6">Ujumbe hapa</p>
            <button onclick="closeModal('loginAlertModal')" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-all">
                <i class="fas fa-check mr-2"></i>Sawa, Nimeelewa
            </button>
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

        // Forgot Password Form Submit
        document.getElementById('reset-password-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const btn = document.getElementById('forgot-submit-btn');
            const btnIcon = document.getElementById('forgot-btn-icon');
            const btnText = document.getElementById('forgot-btn-text');
            const errorDiv = document.getElementById('forgot-error');
            const errorText = document.getElementById('forgot-error-text');
            const successDiv = document.getElementById('forgot-success');
            const successText = document.getElementById('forgot-success-text');

            // Hide previous messages
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');

            // Show loading state
            btn.disabled = true;
            btnIcon.className = 'fas fa-spinner fa-spin';
            btnText.textContent = 'Inatuma...';

            // Submit via AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, data })))
            .then(({ status, data }) => {
                // Reset button state
                btn.disabled = false;
                btnIcon.className = 'fas fa-paper-plane';
                btnText.textContent = 'Tuma Kiungo';

                if (status === 200 || data.success) {
                    // Show success
                    successText.textContent = data.message || 'Kiungo cha kubadilisha nenosiri kimetumwa kwa barua pepe yako!';
                    successDiv.classList.remove('hidden');
                    form.reset();

                    // Close modal after 3 seconds
                    setTimeout(() => {
                        closeModal('forgot-password-modal');
                        showLoginAlert('success', 'Imefanikiwa!', successText.textContent);
                    }, 2000);
                } else {
                    // Show error
                    errorText.textContent = data.message || data.errors?.email?.[0] || 'Kuna hitilafu. Tafadhali jaribu tena.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                // Reset button state
                btn.disabled = false;
                btnIcon.className = 'fas fa-paper-plane';
                btnText.textContent = 'Tuma Kiungo';

                errorText.textContent = 'Kuna hitilafu. Tafadhali jaribu tena.';
                errorDiv.classList.remove('hidden');
            });
        });

        // Show Alert Modal
        function showLoginAlert(type, title, message) {
            const iconContainer = document.getElementById('loginAlertIcon');
            const iconClass = document.getElementById('loginAlertIconClass');
            const titleEl = document.getElementById('loginAlertTitle');
            const messageEl = document.getElementById('loginAlertMessage');

            const configs = {
                'success': { bgColor: 'bg-green-100', iconColor: 'text-green-600', icon: 'fas fa-check-circle' },
                'error': { bgColor: 'bg-red-100', iconColor: 'text-red-600', icon: 'fas fa-times-circle' },
                'warning': { bgColor: 'bg-yellow-100', iconColor: 'text-yellow-600', icon: 'fas fa-exclamation-triangle' },
                'info': { bgColor: 'bg-blue-100', iconColor: 'text-blue-600', icon: 'fas fa-info-circle' }
            };

            const config = configs[type] || configs['info'];

            iconContainer.className = `h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 ${config.bgColor}`;
            iconClass.className = `${config.icon} text-3xl ${config.iconColor}`;
            titleEl.textContent = title;
            messageEl.textContent = message;

            openModal('loginAlertModal');
        }

        // Auto-focus on email input
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.focus();
            }
        });

        // ============================================
        // LOGIN PROGRESS BAR
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            const progressContainer = document.getElementById('loginProgressContainer');
            const progressBar = document.getElementById('loginProgressBar');
            const submitBtn = loginForm.querySelector('button[type="submit"]');

            loginForm.addEventListener('submit', function(e) {
                // Show progress bar
                progressContainer.classList.add('active');
                progressBar.classList.add('indeterminate');

                // Disable submit button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Inaendelea...';

                // Let the form submit normally
            });
        });

        // ============================================
        // HANDLE BFCACHE - Prevent cached login page issues
        // ============================================
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was restored from bfcache - reset form state
                const progressContainer = document.getElementById('loginProgressContainer');
                const progressBar = document.getElementById('loginProgressBar');
                const loginForm = document.getElementById('login-form');
                const submitBtn = loginForm?.querySelector('button[type="submit"]');

                // Hide progress bar
                if (progressContainer) {
                    progressContainer.classList.remove('active');
                }
                if (progressBar) {
                    progressBar.classList.remove('indeterminate');
                }
                // Reset submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i> Ingia';
                }
            }
        });
    </script>
</body>
</html>
