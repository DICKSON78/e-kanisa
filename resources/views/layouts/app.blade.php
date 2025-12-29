<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mfumo wa Kanisa')</title>
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
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            500: '#360958',
                            600: '#2a0745',
                            700: '#1f0533',
                            800: '#150324',
                        },
                        secondary: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            500: '#efc120',
                            600: '#d4a81c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #360958;
            --secondary: #efc120;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* ============================================
           SIDEBAR STYLES - IMPROVED
           ============================================ */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            background: #2a0745;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Desktop - Expanded sidebar by default */
        @media (min-width: 1025px) {
            .sidebar {
                width: 280px;
                padding: 1.5rem;
            }
            .sidebar.collapsed {
                width: 70px;
                padding: 1rem 0.5rem;
            }
            .main-content {
                margin-left: 280px;
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                width: calc(100% - 280px);
            }
            .main-content.sidebar-collapsed {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            /* Hide text elements when collapsed */
            .sidebar.collapsed .sidebar-text,
            .sidebar.collapsed .logo-text,
            .sidebar.collapsed .user-details {
                display: none;
            }

            .sidebar.collapsed .request-badge {
                display: none;
            }

            /* Center items when collapsed */
            .sidebar.collapsed .sidebar-logo {
                justify-content: center;
                padding: 1rem 0;
            }

            .sidebar.collapsed .sidebar-link {
                justify-content: center;
                padding: 0.875rem;
                width: 48px;
                margin: 0.5rem auto;
            }

            .sidebar.collapsed .sidebar-user {
                padding: 1rem 0;
                justify-content: center;
            }

            .sidebar.collapsed .user-container {
                justify-content: center;
            }
        }

        /* Tablet/Mobile - Collapsed by default */
        @media (max-width: 1024px) {
            .sidebar {
                width: 70px;
                padding: 1rem 0.5rem;
            }
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            /* When expanded on mobile */
            .sidebar.mobile-expanded {
                width: 280px;
                padding: 1.5rem;
                box-shadow: 2px 0 25px rgba(0, 0, 0, 0.3);
            }

            /* Hide text elements when collapsed */
            .sidebar:not(.mobile-expanded) .sidebar-text,
            .sidebar:not(.mobile-expanded) .logo-text,
            .sidebar:not(.mobile-expanded) .user-details {
                display: none;
            }

            .sidebar:not(.mobile-expanded) .request-badge {
                display: none;
            }

            /* Center items when collapsed */
            .sidebar:not(.mobile-expanded) .sidebar-logo {
                justify-content: center;
                padding: 1rem 0;
            }

            .sidebar:not(.mobile-expanded) .sidebar-link {
                justify-content: center;
                padding: 0.875rem;
                width: 48px;
                margin: 0.5rem auto;
            }

            .sidebar:not(.mobile-expanded) .sidebar-user {
                padding: 1rem 0;
                justify-content: center;
            }

            .sidebar:not(.mobile-expanded) .user-container {
                justify-content: center;
            }
        }

        /* Very small mobile devices */
        @media (max-width: 480px) {
            .sidebar {
                width: 60px;
            }
            .main-content {
                margin-left: 60px;
                width: calc(100% - 60px);
            }
            .sidebar:not(.mobile-expanded) .sidebar-link {
                width: 44px;
                padding: 0.75rem;
            }
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Logo Section */
        .sidebar-logo {
            display: flex;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .logo-text {
            margin-left: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            white-space: nowrap;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .sidebar-link:hover {
            background-color: rgba(239, 193, 32, 0.15);
            color: #efc120;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #efc120 0%, #d4a81c 100%);
            color: #360958;
            font-weight: 600;
        }

        .sidebar-link i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-text {
            margin-left: 1rem;
            font-size: 0.9375rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .request-badge {
            margin-left: auto;
            background: linear-gradient(135deg, #efc120, #d4a81c);
            color: #360958;
            padding: 0.25rem 0.625rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip for collapsed sidebar */
        .sidebar-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1f0533;
            color: white;
            padding: 0.5rem 0.875rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            margin-left: 0.875rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            pointer-events: none;
            z-index: 1001;
        }

        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1f0533;
        }

        @media (min-width: 1025px) {
            .sidebar.collapsed .sidebar-link:hover .sidebar-tooltip {
                opacity: 1;
                visibility: visible;
            }
        }

        @media (max-width: 1024px) {
            .sidebar:not(.mobile-expanded) .sidebar-link:hover .sidebar-tooltip {
                opacity: 1;
                visibility: visible;
            }
        }

        /* User Profile Section */
        .sidebar-user {
            padding: 1.25rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: auto;
        }

        .user-container {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .user-details {
            margin-left: 1rem;
            flex: 1;
        }

        .user-details p:first-child {
            font-size: 0.9375rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.125rem;
        }

        .user-details p:last-child {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* ============================================
           HEADER STYLES - FIXED WIDTH ISSUE
           ============================================ */
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
            width: 100%;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0; /* Allows text truncation */
        }

        .toggle-btn {
            width: 42px;
            height: 42px;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .toggle-btn:hover {
            background: #f3f4f6;
            color: #360958;
            transform: scale(1.05);
        }

        .toggle-btn:active {
            transform: scale(0.95);
        }

        .toggle-btn i {
            font-size: 1.375rem;
        }

        .header-title {
            min-width: 0;
            flex: 1;
        }

        .header-title h2 {
            font-size: 1.625rem;
            font-weight: 600;
            color: #360958;
            margin-bottom: 0.25rem;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-title p {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }

        .notification-btn {
            position: relative;
            width: 42px;
            height: 42px;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .notification-btn:hover {
            background: #f3f4f6;
            color: #360958;
            transform: scale(1.05);
        }

        .notification-btn i {
            font-size: 1.25rem;
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 9px;
            height: 9px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .header-date {
            font-size: 0.875rem;
            color: #6b7280;
            white-space: nowrap;
            font-weight: 500;
            flex-shrink: 0;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .header-user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #f3e8ff, #faf5ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #360958;
            box-shadow: 0 2px 6px rgba(54, 9, 88, 0.15);
            flex-shrink: 0;
        }

        .header-user-info {
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .header-user-info p {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.2;
            white-space: nowrap;
        }

        .header-user-info span {
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1.2;
            white-space: nowrap;
        }

        .logout-btn {
            width: 38px;
            height: 38px;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            transform: scale(1.05);
        }

        .logout-btn i {
            font-size: 1.125rem;
        }

        /* Responsive Header */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .header-title h2 {
                font-size: 1.25rem;
            }

            .header-title p {
                font-size: 0.8125rem;
            }

            .header-date.date-desktop {
                display: none;
            }

            .header-user-info {
                display: none;
            }

            .header-right {
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0.875rem;
            }

            .header-title h2 {
                font-size: 1.125rem;
            }

            .header-title p {
                font-size: 0.75rem;
            }

            .toggle-btn,
            .notification-btn,
            .header-user-avatar,
            .logout-btn {
                width: 36px;
                height: 36px;
            }

            .toggle-btn i {
                font-size: 1.25rem;
            }

            .header-date {
                font-size: 0.75rem;
            }
        }

        /* ============================================
           MAIN CONTENT - FIXED WIDTH
           ============================================ */
        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
            width: 100%;
        }

        .content-area {
            flex: 1;
            padding: 2rem;
            width: 100%;
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .content-area {
                padding: 1rem;
            }
        }

        /* ============================================
           NOTIFICATION STYLES
           ============================================ */
        .notification-container {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 1100;
            width: 380px;
            max-width: calc(100vw - 40px);
        }

        @media (max-width: 768px) {
            .notification-container {
                width: calc(100vw - 40px);
                right: 20px;
                top: 80px;
            }
        }

        .notification {
            background: white;
            border-radius: 14px;
            margin-bottom: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 5px solid;
        }

        .notification.success { border-left-color: #10b981; }
        .notification.error { border-left-color: #ef4444; }
        .notification.warning { border-left-color: #f59e0b; }
        .notification.info { border-left-color: #3b82f6; }

        .notification-header {
            padding: 14px 16px;
            background: linear-gradient(135deg, #360958 0%, #2a0745 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-sender {
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .notification-sender i {
            margin-right: 8px;
        }

        .notification-time {
            font-size: 0.6875rem;
            opacity: 0.85;
        }

        .notification-body {
            padding: 14px 16px;
            color: #374151;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .notification-actions {
            padding: 10px 16px;
            background: #f9fafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e7eb;
        }

        .notification-category {
            font-size: 0.6875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .notification-close {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .notification-close:hover {
            background: #e5e7eb;
            color: #374151;
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(120%);
                opacity: 0;
            }
        }

        /* ============================================
           CARD STYLES
           ============================================ */
        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
        }

        /* ============================================
           GLOBAL MODAL STYLES WITH BLUR
           ============================================ */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
            transform: scale(0.95) translateY(-10px);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-backdrop.active .modal-content {
            transform: scale(1) translateY(0);
        }

        /* Modal positioning - exclude sidebar and header from blur */
        .modal-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 50;
            transition: all 0.3s ease;
        }

        /* Modal inner content should be above the overlay */
        .modal-overlay > div {
            z-index: 51;
        }

        /* ============================================
           INSTANT SIDEBAR COLLAPSE STATE
           Applied via JS before DOM loads to prevent flash
           ============================================ */
        @media (min-width: 1025px) {
            body.sidebar-collapsed-state .sidebar {
                width: 70px;
                padding: 1rem 0.5rem;
            }
            body.sidebar-collapsed-state .sidebar .sidebar-text,
            body.sidebar-collapsed-state .sidebar .logo-text,
            body.sidebar-collapsed-state .sidebar .user-details,
            body.sidebar-collapsed-state .sidebar .request-badge {
                display: none;
            }
            body.sidebar-collapsed-state .sidebar .sidebar-logo {
                justify-content: center;
                padding: 1rem 0;
            }
            body.sidebar-collapsed-state .sidebar .sidebar-link {
                justify-content: center;
                padding: 0.875rem;
                width: 48px;
                margin: 0.5rem auto;
            }
            body.sidebar-collapsed-state .sidebar .sidebar-user {
                padding: 1rem 0;
                justify-content: center;
            }
            body.sidebar-collapsed-state .sidebar .user-container {
                justify-content: center;
            }
            body.sidebar-collapsed-state .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <script>
        // Apply sidebar state immediately to prevent flash
        (function() {
            if (window.innerWidth > 1024 && localStorage.getItem('sidebarCollapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed-state');
            }
        })();
    </script>
    <div class="flex h-screen">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar text-white flex flex-col fixed h-full" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <div class="logo-icon" style="padding: 4px;">
                    <img src="{{ asset('images/kkkt_logo.png') }}" alt="KKKT Logo" class="w-full h-full object-contain">
                </div>
                <span class="logo-text">KKKT Agape</span>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <!-- Dashboard - Visible to All -->
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span class="sidebar-text">Dashboard</span>
                    <div class="sidebar-tooltip">Dashboard</div>
                </a>

                <!-- Member Portal - Visible to All -->
                <a href="{{ route('member.portal') }}" class="sidebar-link {{ request()->routeIs('member.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span class="sidebar-text">Portal Yangu</span>
                    <div class="sidebar-tooltip">Portal Yangu</div>
                </a>

                <!-- Members - Visible to Admin & Pastor -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <a href="{{ route('members.index') }}" class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span class="sidebar-text">Waumini</span>
                    <div class="sidebar-tooltip">Waumini</div>
                </a>
                @endif

                <!-- Financial Sections - Visible to Admin & Accountant -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <a href="{{ route('income.index') }}" class="sidebar-link {{ request()->routeIs('income.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span class="sidebar-text">Mapato</span>
                    <div class="sidebar-tooltip">Mapato</div>
                </a>
                <a href="{{ route('expenses.index') }}" class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span class="sidebar-text">Matumizi</span>
                    <div class="sidebar-tooltip">Matumizi</div>
                </a>
                <a href="{{ route('offerings.index') }}" class="sidebar-link {{ request()->routeIs('offerings.*') ? 'active' : '' }}">
                    <i class="fas fa-gift"></i>
                    <span class="sidebar-text">Sadaka</span>
                    <div class="sidebar-tooltip">Sadaka</div>
                </a>
                <a href="{{ route('requests.index') }}" class="sidebar-link {{ request()->routeIs('requests.*') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i>
                    <span class="sidebar-text">Maombi ya Fedha</span>
                    <span class="request-badge" id="sidebarRequestsBadge">
                        @php
                            $sidebarPendingRequests = \App\Models\Request::where('status', 'Inasubiri')->count();
                        @endphp
                        {{ $sidebarPendingRequests }}
                    </span>
                    <div class="sidebar-tooltip">Maombi ya Fedha</div>
                </a>
                @endif

                <!-- Pastoral Services - Visible to All (Members see only their own) -->
                <a href="{{ route('pastoral-services.index') }}" class="sidebar-link {{ request()->routeIs('pastoral-services.*') ? 'active' : '' }}">
                    <i class="fas fa-praying-hands"></i>
                    <span class="sidebar-text">Huduma za Kichungaji</span>
                    <div class="sidebar-tooltip">Huduma za Kichungaji</div>
                </a>

                <!-- Events - Visible to All (Members see only public events) -->
                <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="sidebar-text">Matukio</span>
                    <div class="sidebar-tooltip">Matukio</div>
                </a>

                <!-- Reports - Visible to Admin & Accountant Only -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <a href="{{ route('export.excel') }}" class="sidebar-link {{ request()->routeIs('export.excel*') || request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span class="sidebar-text">Ripoti</span>
                    <div class="sidebar-tooltip">Ripoti</div>
                </a>
                @endif

                <!-- Settings - Visible to All (Members see only their settings) -->
                <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span class="sidebar-text">Mipangilio</span>
                    <div class="sidebar-tooltip">Mipangilio</div>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="sidebar-user">
                <div class="user-container">
                    <div class="user-avatar">
                        <i class="fas fa-user text-primary-500"></i>
                    </div>
                    <div class="user-details">
                        <p>{{ Auth::user()->name ?? 'Admin Kanisa' }}</p>
                        <p>{{ Auth::user()->email ?? 'admin@kanisa.org' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content" id="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="toggle-btn" id="toggleSidebar" aria-label="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-title">
                        <h2>@yield('page-title', 'Dashboard')</h2>
                        <p>@yield('page-subtitle', 'Karibu kwenye mfumo wa usimamizi wa kanisa')</p>
                    </div>
                </div>
                <div class="header-right">
                    <button class="notification-btn" id="notificationToggle" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-dot" id="notificationDot" style="display: none;"></span>
                    </button>

                    <div class="header-date date-desktop">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, F d, Y') }}
                    </div>
                    <div class="header-date date-mobile" style="display: none;">
                        {{ \Carbon\Carbon::now()->translatedFormat('M d, Y') }}
                    </div>

                    <div class="header-user">
                        <div class="header-user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="header-user-info">
                            <p>{{ Auth::user()->name ?? 'Admin Kanisa' }}</p>
                            <span>Admin</span>
                        </div>
                    </div>
                    @auth
                    <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-label="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                </div>
            </header>

            <!-- Notifications Container -->
            <div class="notification-container" id="notificationContainer"></div>

            <!-- Page Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('toggleSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Check if sidebar state is saved in localStorage
            const savedSidebarState = localStorage.getItem('sidebarCollapsed');
            const isDesktop = window.innerWidth > 1024;

            // Sync classes on page load (body class was already applied by inline script)
            if (isDesktop && savedSidebarState === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
                document.body.classList.add('sidebar-collapsed-state');
            }

            // Toggle sidebar function for both desktop and mobile
            function toggleSidebar() {
                if (window.innerWidth <= 1024) {
                    // Mobile behavior
                    sidebar.classList.toggle('mobile-expanded');
                    sidebarOverlay.classList.toggle('active');

                    if (sidebar.classList.contains('mobile-expanded')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                } else {
                    // Desktop behavior
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                    document.body.classList.toggle('sidebar-collapsed-state');

                    // Save state to localStorage
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                }
            }

            // Toggle button click
            toggleButton.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking on overlay (mobile only)
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth <= 1024 && sidebar.classList.contains('mobile-expanded')) {
                    toggleSidebar();
                }
            });

            // Close sidebar when clicking on a link (mobile only)
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 1024 && sidebar.classList.contains('mobile-expanded')) {
                        toggleSidebar();
                    }
                });
            });

            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 1024) {
                    // Desktop - remove mobile expanded state
                    sidebar.classList.remove('mobile-expanded');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';

                    // Apply saved collapsed state
                    const savedState = localStorage.getItem('sidebarCollapsed');
                    if (savedState === 'true') {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('sidebar-collapsed');
                        document.body.classList.add('sidebar-collapsed-state');
                    } else {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('sidebar-collapsed');
                        document.body.classList.remove('sidebar-collapsed-state');
                    }
                } else {
                    // Mobile - remove desktop collapsed state and body class
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('sidebar-collapsed');
                    document.body.classList.remove('sidebar-collapsed-state');

                    // Ensure sidebar is collapsed by default on mobile
                    if (!sidebar.classList.contains('mobile-expanded')) {
                        sidebar.classList.remove('mobile-expanded');
                        sidebarOverlay.classList.remove('active');
                    }
                }

                updateDateDisplay();
            }

            // Initialize
            handleResize();
            window.addEventListener('resize', handleResize);

            // Notification system
            let notifications = [];
            const notificationContainer = document.getElementById('notificationContainer');
            const notificationToggle = document.getElementById('notificationToggle');
            const notificationDot = document.getElementById('notificationDot');

            function showNotification(message, type = 'success', category = 'Mfumo') {
                const now = new Date();
                const timeString = now.toLocaleTimeString('sw-TZ', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });

                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.innerHTML = `
                    <div class="notification-header">
                        <div class="notification-sender">
                            <i class="fas ${getNotificationIcon(type)}"></i>
                            Mfumo wa Kanisa
                        </div>
                        <div class="notification-time">${timeString}</div>
                    </div>
                    <div class="notification-body">
                        ${message}
                    </div>
                    <div class="notification-actions">
                        <span class="notification-category">${category}</span>
                        <button class="notification-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                notificationContainer.appendChild(notification);
                notifications.push(notification);

                // Auto-remove after 6 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.style.animation = 'slideOut 0.3s ease-in-out';
                        setTimeout(() => {
                            notification.remove();
                            notifications = notifications.filter(n => n !== notification);
                            updateNotificationDot();
                        }, 300);
                    }
                }, 6000);

                // Manual close
                const closeBtn = notification.querySelector('.notification-close');
                closeBtn.addEventListener('click', () => {
                    notification.style.animation = 'slideOut 0.3s ease-in-out';
                    setTimeout(() => {
                        notification.remove();
                        notifications = notifications.filter(n => n !== notification);
                        updateNotificationDot();
                    }, 300);
                });

                updateNotificationDot();
            }

            function getNotificationIcon(type) {
                const icons = {
                    'success': 'fa-check-circle',
                    'error': 'fa-exclamation-circle',
                    'warning': 'fa-exclamation-triangle',
                    'info': 'fa-info-circle'
                };
                return icons[type] || 'fa-bell';
            }

            function updateNotificationDot() {
                if (notifications.length > 0) {
                    notificationDot.style.display = 'block';
                } else {
                    notificationDot.style.display = 'none';
                }
            }

            notificationToggle.addEventListener('click', () => {
                if (notifications.length === 0) {
                    showNotification('Hakuna arifa mpya zilizopo', 'info', 'Mfumo');
                }
            });

            // Handle Laravel flash messages
            @if(session('success'))
                showNotification("{{ session('success') }}", 'success', 'Mafanikio');
            @endif
            @if(session('error'))
                showNotification("{{ session('error') }}", 'error', 'Hitilafu');
            @endif
            @if(session('warning'))
                showNotification("{{ session('warning') }}", 'warning', 'Onyo');
            @endif
            @if(session('info'))
                showNotification("{{ session('info') }}", 'info', 'Taarifa');
            @endif

            // Show date on mobile
            function updateDateDisplay() {
                const dateDesktop = document.querySelector('.date-desktop');
                const dateMobile = document.querySelector('.date-mobile');

                if (window.innerWidth <= 768) {
                    dateDesktop.style.display = 'none';
                    dateMobile.style.display = 'block';
                } else {
                    dateDesktop.style.display = 'block';
                    dateMobile.style.display = 'none';
                }
            }

            updateDateDisplay();
        });

        // Auto-refresh sidebar badge for pending requests
        function refreshSidebarBadge() {
            fetch('/api/dashboard-stats')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('sidebarRequestsBadge');
                    if (badge && data.pending_requests !== undefined) {
                        badge.textContent = data.pending_requests;
                    }
                })
                .catch(error => {
                    console.error('Error refreshing sidebar badge:', error);
                });
        }

        // Refresh badge every 30 seconds
        setInterval(refreshSidebarBadge, 30000);

        // Also refresh when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                refreshSidebarBadge();
            }
        });

        // Global Styled Alert/Confirm Modal System
        const alertModalHTML = `
            <div id="globalAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="alertModalContent">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div id="alertIconContainer" class="flex-shrink-0 h-12 w-12 rounded-full flex items-center justify-center">
                                <i id="alertIcon" class="text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 id="alertTitle" class="text-lg font-bold text-gray-900 mb-2"></h3>
                                <p id="alertMessage" class="text-gray-600"></p>
                            </div>
                        </div>
                    </div>
                    <div id="alertActions" class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                        <button id="alertCancelBtn" class="hidden px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-all duration-200">
                            Ghairi
                        </button>
                        <button id="alertOkBtn" class="px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200 flex items-center gap-2">
                            <span>Sawa</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', alertModalHTML);

        // Modal configuration by type
        const alertTypes = {
            success: {
                bgColor: 'bg-green-100',
                iconColor: 'text-green-600',
                icon: 'fas fa-check-circle',
                btnColor: 'bg-green-600 hover:bg-green-700',
                title: 'Imefanikiwa!'
            },
            error: {
                bgColor: 'bg-red-100',
                iconColor: 'text-red-600',
                icon: 'fas fa-exclamation-circle',
                btnColor: 'bg-red-600 hover:bg-red-700',
                title: 'Hitilafu!'
            },
            warning: {
                bgColor: 'bg-yellow-100',
                iconColor: 'text-yellow-600',
                icon: 'fas fa-exclamation-triangle',
                btnColor: 'bg-yellow-600 hover:bg-yellow-700',
                title: 'Onyo!'
            },
            info: {
                bgColor: 'bg-blue-100',
                iconColor: 'text-blue-600',
                icon: 'fas fa-info-circle',
                btnColor: 'bg-blue-600 hover:bg-blue-700',
                title: 'Taarifa'
            },
            confirm: {
                bgColor: 'bg-purple-100',
                iconColor: 'text-purple-600',
                icon: 'fas fa-question-circle',
                btnColor: 'bg-primary-600 hover:bg-primary-700',
                title: 'Thibitisha'
            }
        };

        // Show styled alert modal
        function showAlertModal(message, type = 'info', title = null, callback = null) {
            const modal = document.getElementById('globalAlertModal');
            const content = document.getElementById('alertModalContent');
            const iconContainer = document.getElementById('alertIconContainer');
            const icon = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            const okBtn = document.getElementById('alertOkBtn');
            const cancelBtn = document.getElementById('alertCancelBtn');

            const config = alertTypes[type] || alertTypes.info;

            // Reset classes
            iconContainer.className = 'flex-shrink-0 h-12 w-12 rounded-full flex items-center justify-center ' + config.bgColor;
            icon.className = config.icon + ' text-xl ' + config.iconColor;
            okBtn.className = 'px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200 flex items-center gap-2 ' + config.btnColor;

            titleEl.textContent = title || config.title;
            messageEl.textContent = message;

            // Show/hide cancel button for confirm type
            if (type === 'confirm') {
                cancelBtn.classList.remove('hidden');
            } else {
                cancelBtn.classList.add('hidden');
            }

            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);

            // Handle OK button
            const handleOk = () => {
                closeAlertModal();
                if (callback) callback(true);
                okBtn.removeEventListener('click', handleOk);
                cancelBtn.removeEventListener('click', handleCancel);
            };

            // Handle Cancel button
            const handleCancel = () => {
                closeAlertModal();
                if (callback) callback(false);
                okBtn.removeEventListener('click', handleOk);
                cancelBtn.removeEventListener('click', handleCancel);
            };

            okBtn.addEventListener('click', handleOk);
            cancelBtn.addEventListener('click', handleCancel);

            // Close on backdrop click (for non-confirm modals)
            modal.onclick = (e) => {
                if (e.target === modal && type !== 'confirm') {
                    handleOk();
                }
            };
        }

        // Close alert modal
        function closeAlertModal() {
            const modal = document.getElementById('globalAlertModal');
            const content = document.getElementById('alertModalContent');

            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Show confirm modal (returns promise)
        function showConfirmModal(message, title = 'Thibitisha') {
            return new Promise((resolve) => {
                showAlertModal(message, 'confirm', title, (result) => {
                    resolve(result);
                });
            });
        }

        // Convenience functions
        window.showSuccess = (message, title = null) => showAlertModal(message, 'success', title);
        window.showError = (message, title = null) => showAlertModal(message, 'error', title);
        window.showWarning = (message, title = null) => showAlertModal(message, 'warning', title);
        window.showInfo = (message, title = null) => showAlertModal(message, 'info', title);
        window.showConfirm = showConfirmModal;

        // Override native alert (optional - uncomment to auto-replace all alerts)
        // window.alert = (message) => showAlertModal(message, 'info');
    </script>

    @yield('modals')
    @yield('scripts')
</body>
</html>
