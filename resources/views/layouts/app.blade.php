<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Prevent caching - prevents access after logout via browser back button -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Mfumo wa Kanisa')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/kkkt_logo.png') }}">

    <!-- CRITICAL: Prevent FOUC - Hide page until CSS loads -->
    <style id="critical-css">
        /* Hide everything until CSS is ready */
        html { visibility: hidden; opacity: 0; }
        html.css-ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease; }

        /* Critical layout - ensure sidebar and content don't overlap */
        .sidebar {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            width: 280px !important;
            height: 100vh !important;
            z-index: 1000 !important;
            background: linear-gradient(180deg, #360958 0%, #2a0745 50%, #1f0533 100%) !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .main-content {
            margin-left: 280px !important;
            width: calc(100% - 280px) !important;
            min-height: 100vh !important;
            background: #f8fafc !important;
        }
        /* Collapsed sidebar state */
        body.sidebar-collapsed-state .sidebar { width: 70px !important; }
        body.sidebar-collapsed-state .main-content { margin-left: 70px !important; width: calc(100% - 70px) !important; }

        @media (max-width: 1024px) {
            .sidebar { width: 70px !important; }
            .main-content { margin-left: 70px !important; width: calc(100% - 70px) !important; }
        }
        @media (max-width: 480px) {
            .sidebar { width: 60px !important; }
            .main-content { margin-left: 60px !important; width: calc(100% - 60px) !important; }
        }
    </style>

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
            background: linear-gradient(180deg, #360958 0%, #2a0745 50%, #1f0533 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            height: 80px;
            flex-shrink: 0;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #ffffff 0%, #f3e8ff 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .logo-text {
            margin-left: 1rem;
            font-size: 1.375rem;
            font-weight: 700;
            color: white;
            white-space: nowrap;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0;
            min-height: 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
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
            height: 48px;
            flex-shrink: 0;
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
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            margin-top: auto;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
            height: 80px;
            flex-shrink: 0;
        }

        .user-container {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ffffff 0%, #f3e8ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .user-details {
            margin-left: 1rem;
            flex: 1;
            min-width: 0;
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

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Notification Dropdown */
        .notification-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 360px;
            max-width: calc(100vw - 2rem);
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow: hidden;
            animation: dropdownSlide 0.2s ease-out;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-dropdown-header {
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, #360958, #2a0745);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-dropdown-header h3 {
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .notification-count {
            font-size: 0.75rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .notification-dropdown-body {
            max-height: 320px;
            overflow-y: auto;
        }

        .notification-empty {
            padding: 2rem;
            text-align: center;
            color: #6b7280;
        }

        .notification-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            background: #f9fafb;
        }

        .notification-item-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-item-icon i {
            font-size: 1.125rem;
        }

        .notification-item-content {
            flex: 1;
            min-width: 0;
        }

        .notification-item-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.125rem;
        }

        .notification-item-desc {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .notification-item-badge {
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            padding: 0.25rem 0.625rem;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .notification-dropdown-footer {
            padding: 0.875rem 1.25rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .notification-dropdown-footer a {
            font-size: 0.875rem;
            color: #360958;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .notification-dropdown-footer a:hover {
            color: #efc120;
        }

        @media (max-width: 480px) {
            .notification-dropdown {
                width: calc(100vw - 1rem);
                right: -0.5rem;
            }
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

        /* Modal positioning - no blur per user request */
        .modal-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 9999;
            transition: all 0.3s ease;
        }

        /* Modal inner content should be above the overlay */
        .modal-overlay > div {
            z-index: 10000;
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
        // Mark CSS as ready to show page
        document.documentElement.classList.add('css-ready');

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
                <!-- Dashboard - Visible to Mchungaji & Muhasibu ONLY -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span class="sidebar-text">Dashboard</span>
                    <div class="sidebar-tooltip">Dashboard</div>
                </a>
                @endif

                <!-- Member Portal - Visible to All -->
                <a href="{{ route('member.portal') }}" class="sidebar-link {{ request()->routeIs('member.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span class="sidebar-text">Portal Yangu</span>
                    <div class="sidebar-tooltip">Portal Yangu</div>
                </a>

                <!-- SECTION FOR MCHUNGAJI AND MUHASIBU ONLY -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                    <!-- Members - Only for Admin & Pastor -->
                    <a href="{{ route('members.index') }}" class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">Waumini</span>
                        <div class="sidebar-tooltip">Waumini</div>
                    </a>

                    <!-- Financial Sections - Only for Admin & Accountant -->
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
                        <div class="sidebar-tooltip">Maombi ya Fedha</div>
                    </a>
                @endif

                <!-- SECTION FOR ALL USERS (MWANACHAMA, MCHUNGAJI, MUHASIBU) -->
                <!-- Pastoral Services - Visible to All -->
                <a href="{{ route('pastoral-services.index') }}" class="sidebar-link {{ request()->routeIs('pastoral-services.*') ? 'active' : '' }}">
                    <i class="fas fa-praying-hands"></i>
                    <span class="sidebar-text">Huduma za Kichungaji</span>
                    <div class="sidebar-tooltip">Huduma za Kichungaji</div>
                </a>

                <!-- Events - Visible to All -->
                <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="sidebar-text">Matukio</span>
                    <div class="sidebar-tooltip">Matukio</div>
                </a>

                <!-- Messages - Leaders Only (Mchungaji, Mhasibu) -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                @if(\Illuminate\Support\Facades\Route::has('messages.index'))
                @php
                    try {
                        $sidebarUnreadMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                    } catch (\Exception $e) {
                        $sidebarUnreadMessages = 0;
                    }
                @endphp
                <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span class="sidebar-text">Ujumbe</span>
                    @if($sidebarUnreadMessages > 0)
                        <span class="request-badge">{{ $sidebarUnreadMessages }}</span>
                    @endif
                    <div class="sidebar-tooltip">Ujumbe</div>
                </a>
                @endif
                @endif

                <!-- SECTION FOR MCHUNGAJI AND MUHASIBU ONLY -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                    <!-- Reports - Only for Admin & Accountant -->
                    <a href="{{ route('export.excel') }}" class="sidebar-link {{ request()->routeIs('export.excel*') || request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span class="sidebar-text">Ripoti</span>
                        <div class="sidebar-tooltip">Ripoti</div>
                    </a>
                @endif

                <!-- Settings - Visible to All -->
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
                        <p style="font-size: 0.9375rem; font-weight: 600; color: white; margin-bottom: 0.125rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">{{ Auth::user()->name }}</p>
                        <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.7);">{{ Auth::user()->role->name ?? 'Muumini' }}</p>
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
                    <!-- Messages Button - Leaders Only (Mchungaji, Mhasibu) -->
                    @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                    @if(\Illuminate\Support\Facades\Route::has('messages.index'))
                    <a href="{{ route('messages.index') }}" class="notification-btn" aria-label="Ujumbe" title="Ujumbe">
                        <i class="fas fa-comment-dots"></i>
                        @php
                            try {
                                $headerUnreadMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                            } catch (\Exception $e) {
                                $headerUnreadMessages = 0;
                            }
                        @endphp
                        @if($headerUnreadMessages > 0)
                        <span class="notification-badge" style="background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 2px 6px rgba(34, 197, 94, 0.4);">{{ $headerUnreadMessages }}</span>
                        @endif
                    </a>
                    @endif
                    @endif

                    <!-- Notification Dropdown -->
                    <div class="relative" id="notificationWrapper">
                        <button class="notification-btn" id="notificationToggle" aria-label="Notifications">
                            <i class="fas fa-bell"></i>
                            @php
                                // Check if user needs to change password
                                $needsPasswordChange = Auth::user()->needsPasswordChange();

                                $pendingRequests = 0;
                                $pendingPastoral = 0;
                                $pendingMembers = 0;
                                $newEvents = 0;
                                $memberPastoral = 0;
                                $totalNotifications = ($needsPasswordChange ? 1 : 0);

                                // Different notifications for members vs admin
                                try {
                                    if (Auth::user()->isMwanachama()) {
                                        // Member sees only their pastoral service updates and new events
                                        if (Auth::user()->member) {
                                            $memberPastoral = \App\Models\PastoralService::where('member_id', Auth::user()->member->id)
                                                ->whereIn('status', ['Imeidhinishwa', 'Imekataliwa', 'Imekamilika'])
                                                ->where('updated_at', '>=', now()->subDays(7))
                                                ->count();
                                        }
                                        $newEvents = \App\Models\Event::where('is_active', true)
                                            ->where('created_at', '>=', now()->subDays(7))
                                            ->where('event_date', '>=', now())
                                            ->count();
                                        $pendingPastoral = $memberPastoral;
                                        $totalNotifications = $memberPastoral + $newEvents + ($needsPasswordChange ? 1 : 0);
                                    } else {
                                        // Admin/Pastor sees all pending items
                                        $pendingRequests = \App\Models\Request::where('status', 'Inasubiri')->count();
                                        $pendingPastoral = \App\Models\PastoralService::where('status', 'Inasubiri')->count();
                                        if (Auth::user()->isMchungaji() || Auth::user()->isMhasibu()) {
                                            $pendingMembers = \App\Models\User::where('is_active', false)->count();
                                        }
                                        $totalNotifications = $pendingRequests + $pendingPastoral + $pendingMembers + ($needsPasswordChange ? 1 : 0);
                                    }
                                } catch (\Exception $e) {
                                    // Ignore DB errors; fallbacks already set
                                }
                            @endphp
                            @if($totalNotifications > 0)
                            <span class="notification-badge" id="notificationBadge">{{ $totalNotifications }}</span>
                            @endif
                        </button>

                        <!-- Notification Dropdown Panel -->
                        <div class="notification-dropdown hidden" id="notificationDropdown">
                            <div class="notification-dropdown-header">
                                <h3><i class="fas fa-bell mr-2"></i>Arifa</h3>
                                <span class="notification-count">{{ $totalNotifications }} mpya</span>
                            </div>
                            <div class="notification-dropdown-body">
                                @if($totalNotifications == 0)
                                <div class="notification-empty">
                                    <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                                    <p>Hakuna arifa mpya</p>
                                </div>
                                @else
                                    {{-- Password change notification (shown first, for all users with default password) --}}
                                    @if($needsPasswordChange)
                                    <a href="{{ route('settings.index') }}?tab=password" class="notification-item">
                                        <div class="notification-item-icon bg-orange-100">
                                            <i class="fas fa-key text-orange-600"></i>
                                        </div>
                                        <div class="notification-item-content">
                                            <p class="notification-item-title">Badilisha Nywila</p>
                                            <p class="notification-item-desc">Unatumia nywila ya msingi. Badilisha kwa usalama wako.</p>
                                        </div>
                                        <span class="notification-item-badge bg-orange-500">!</span>
                                    </a>
                                    @endif

                                    @if(Auth::user()->isMwanachama())
                                        {{-- Member notifications --}}
                                        @if($pendingPastoral > 0)
                                        <a href="{{ route('pastoral-services.index') }}" class="notification-item">
                                            <div class="notification-item-icon bg-purple-100">
                                                <i class="fas fa-praying-hands text-purple-600"></i>
                                            </div>
                                            <div class="notification-item-content">
                                                <p class="notification-item-title">Huduma za Kichungaji</p>
                                                <p class="notification-item-desc">{{ $pendingPastoral }} maombi yako yamepata majibu</p>
                                            </div>
                                            <span class="notification-item-badge bg-purple-500">{{ $pendingPastoral }}</span>
                                        </a>
                                        @endif

                                        @if($newEvents > 0)
                                        <a href="{{ route('events.index') }}" class="notification-item">
                                            <div class="notification-item-icon bg-blue-100">
                                                <i class="fas fa-calendar-alt text-blue-600"></i>
                                            </div>
                                            <div class="notification-item-content">
                                                <p class="notification-item-title">Matukio Mapya</p>
                                                <p class="notification-item-desc">{{ $newEvents }} matukio mapya yameongezwa</p>
                                            </div>
                                            <span class="notification-item-badge bg-blue-500">{{ $newEvents }}</span>
                                        </a>
                                        @endif
                                    @else
                                        {{-- Admin/Pastor notifications --}}
                                        @if($pendingRequests > 0)
                                        <a href="{{ route('requests.index') }}" class="notification-item">
                                            <div class="notification-item-icon bg-yellow-100">
                                                <i class="fas fa-paper-plane text-yellow-600"></i>
                                            </div>
                                            <div class="notification-item-content">
                                                <p class="notification-item-title">Maombi ya Fedha</p>
                                                <p class="notification-item-desc">{{ $pendingRequests }} maombi yanasubiri kuidhinishwa</p>
                                            </div>
                                            <span class="notification-item-badge bg-yellow-500">{{ $pendingRequests }}</span>
                                        </a>
                                        @endif

                                        @if($pendingPastoral > 0)
                                        <a href="{{ route('pastoral-services.index') }}" class="notification-item">
                                            <div class="notification-item-icon bg-purple-100">
                                                <i class="fas fa-praying-hands text-purple-600"></i>
                                            </div>
                                            <div class="notification-item-content">
                                                <p class="notification-item-title">Huduma za Kichungaji</p>
                                                <p class="notification-item-desc">{{ $pendingPastoral }} maombi yanasubiri kuidhinishwa</p>
                                            </div>
                                            <span class="notification-item-badge bg-purple-500">{{ $pendingPastoral }}</span>
                                        </a>
                                        @endif

                                        @if($pendingMembers > 0)
                                        <a href="{{ route('members.index') }}?status=pending" class="notification-item">
                                            <div class="notification-item-icon bg-green-100">
                                                <i class="fas fa-user-plus text-green-600"></i>
                                            </div>
                                            <div class="notification-item-content">
                                                <p class="notification-item-title">Usajili Mpya</p>
                                                <p class="notification-item-desc">{{ $pendingMembers }} wanachama wanasubiri kuidhinishwa</p>
                                            </div>
                                            <span class="notification-item-badge bg-green-500">{{ $pendingMembers }}</span>
                                        </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="notification-dropdown-footer">
                                @if(Auth::user()->isMwanachama())
                                <a href="{{ route('pastoral-services.index') }}">Ona huduma zangu <i class="fas fa-arrow-right ml-1"></i></a>
                                @else
                                <a href="{{ route('requests.index') }}">Ona maombi yote <i class="fas fa-arrow-right ml-1"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>

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
                            <span> {{Auth::user()->role->name}}</span>
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

            // Toast Notification system (for flash messages)
            let notifications = [];
            const notificationContainer = document.getElementById('notificationContainer');
            const notificationToggle = document.getElementById('notificationToggle');

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
                // Notification dot is now replaced with badge in header
                // Toast notifications are separate from dropdown notifications
            }

            // Notification Dropdown Toggle
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationWrapper = document.getElementById('notificationWrapper');

            notificationToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!notificationWrapper.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });

            // Close dropdown on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    notificationDropdown.classList.add('hidden');
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

        // ============================================
        // REAL-TIME NOTIFICATION UPDATES
        // ============================================
        let lastNotificationCount = {{ $totalNotifications }};

        function refreshNotifications() {
            fetch('/panel/notifications', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                const dropdownBody = document.querySelector('.notification-dropdown-body');
                const countSpan = document.querySelector('.notification-count');

                // Update badge
                if (data.total > 0) {
                    if (badge) {
                        badge.textContent = data.total;
                        badge.classList.remove('hidden');
                    } else {
                        // Create badge if it doesn't exist
                        const btn = document.getElementById('notificationToggle');
                        const newBadge = document.createElement('span');
                        newBadge.className = 'notification-badge';
                        newBadge.id = 'notificationBadge';
                        newBadge.textContent = data.total;
                        btn.appendChild(newBadge);
                    }

                    // Show toast notification if count increased
                    if (data.total > lastNotificationCount) {
                        const diff = data.total - lastNotificationCount;
                        showNotificationToast(diff);
                    }
                } else {
                    if (badge) {
                        badge.classList.add('hidden');
                    }
                }

                // Update count in dropdown header
                if (countSpan) {
                    countSpan.textContent = data.total + ' mpya';
                }

                // Update dropdown body content
                if (dropdownBody) {
                    updateNotificationDropdown(data);
                }

                lastNotificationCount = data.total;
            })
            .catch(error => {
                console.error('Error refreshing notifications:', error);
            });
        }

        function updateNotificationDropdown(data) {
            const dropdownBody = document.querySelector('.notification-dropdown-body');
            if (!dropdownBody) return;

            let html = '';
            let hasNotifications = data.total > 0 || data.needs_password_change;

            if (!hasNotifications) {
                html = `
                    <div class="notification-empty">
                        <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                        <p>Hakuna arifa mpya</p>
                    </div>
                `;
            } else {
                // Password change notification (always show first if needed)
                if (data.needs_password_change) {
                    html += `
                        <a href="{{ route('settings.index') }}?tab=password" class="notification-item">
                            <div class="notification-item-icon bg-orange-100">
                                <i class="fas fa-key text-orange-600"></i>
                            </div>
                            <div class="notification-item-content">
                                <p class="notification-item-title">Badilisha Nywila</p>
                                <p class="notification-item-desc">Unatumia nywila ya msingi. Badilisha kwa usalama wako.</p>
                            </div>
                            <span class="notification-item-badge bg-orange-500">!</span>
                        </a>
                    `;
                }

                if (data.pending_requests > 0) {
                    html += `
                        <a href="{{ route('requests.index') }}" class="notification-item">
                            <div class="notification-item-icon bg-yellow-100">
                                <i class="fas fa-paper-plane text-yellow-600"></i>
                            </div>
                            <div class="notification-item-content">
                                <p class="notification-item-title">Maombi ya Fedha</p>
                                <p class="notification-item-desc">${data.pending_requests} maombi yanasubiri kuidhinishwa</p>
                            </div>
                            <span class="notification-item-badge bg-yellow-500">${data.pending_requests}</span>
                        </a>
                    `;
                }

                if (data.pending_pastoral > 0) {
                    html += `
                        <a href="{{ route('pastoral-services.index') }}" class="notification-item">
                            <div class="notification-item-icon bg-purple-100">
                                <i class="fas fa-praying-hands text-purple-600"></i>
                            </div>
                            <div class="notification-item-content">
                                <p class="notification-item-title">Huduma za Kichungaji</p>
                                <p class="notification-item-desc">${data.pending_pastoral} maombi yanasubiri kuidhinishwa</p>
                            </div>
                            <span class="notification-item-badge bg-purple-500">${data.pending_pastoral}</span>
                        </a>
                    `;
                }

                if (data.pending_members > 0) {
                    html += `
                        <a href="{{ route('members.index') }}?status=pending" class="notification-item">
                            <div class="notification-item-icon bg-green-100">
                                <i class="fas fa-user-plus text-green-600"></i>
                            </div>
                            <div class="notification-item-content">
                                <p class="notification-item-title">Usajili Mpya</p>
                                <p class="notification-item-desc">${data.pending_members} wanachama wanasubiri kuidhinishwa</p>
                            </div>
                            <span class="notification-item-badge bg-green-500">${data.pending_members}</span>
                        </a>
                    `;
                }

                // New events notification (for members)
                if (data.new_events > 0) {
                    html += `
                        <a href="{{ route('events.index') }}" class="notification-item">
                            <div class="notification-item-icon bg-blue-100">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="notification-item-content">
                                <p class="notification-item-title">Matukio Mapya</p>
                                <p class="notification-item-desc">${data.new_events} matukio mapya yameongezwa</p>
                            </div>
                            <span class="notification-item-badge bg-blue-500">${data.new_events}</span>
                        </a>
                    `;
                }
            }

            dropdownBody.innerHTML = html;
        }

        function showNotificationToast(count) {
            const message = count === 1
                ? 'Una arifa mpya 1'
                : `Una arifa mpya ${count}`;

            // Use existing notification system
            if (typeof showNotification === 'function') {
                showNotification(message, 'info', 'Arifa');
            }

            // Add visual pulse to bell icon
            const bellIcon = document.querySelector('#notificationToggle i');
            if (bellIcon) {
                bellIcon.classList.add('fa-shake');
                setTimeout(() => {
                    bellIcon.classList.remove('fa-shake');
                }, 1000);
            }
        }

        // Refresh notifications every 15 seconds
        setInterval(refreshNotifications, 15000);

        // Also refresh when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                refreshNotifications();
            }
        });

        // Session Timeout - Logout after 10 minutes of inactivity
        const SESSION_TIMEOUT = 10 * 60 * 1000; // 10 minutes in milliseconds
        const WARNING_TIME = 60 * 1000; // Show warning 1 minute before timeout
        let inactivityTimer;
        let warningTimer;
        let warningShown = false;

        function resetInactivityTimer() {
            // Clear existing timers
            clearTimeout(inactivityTimer);
            clearTimeout(warningTimer);
            warningShown = false;

            // Hide warning if shown
            const warningBanner = document.getElementById('sessionWarningBanner');
            if (warningBanner) {
                warningBanner.remove();
            }

            // Set warning timer (1 minute before logout)
            warningTimer = setTimeout(showSessionWarning, SESSION_TIMEOUT - WARNING_TIME);

            // Set logout timer
            inactivityTimer = setTimeout(logoutDueToInactivity, SESSION_TIMEOUT);
        }

        function showSessionWarning() {
            if (warningShown) return;
            warningShown = true;

            const warningHTML = `
                <div id="sessionWarningBanner" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" style="animation: modalSlideIn 0.3s ease-out;">
                        <div class="p-6 text-center">
                            <div class="h-20 w-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4" style="animation: pulse 2s infinite;">
                                <i class="fas fa-clock text-orange-600 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Muda wa Kikao Unakaribia Kuisha!</h3>
                            <p class="text-gray-600 mb-2">Utaondolewa kwenye mfumo baada ya <span id="countdownSeconds" class="font-bold text-red-600">60</span> sekunde kwa kukosa shughuli.</p>
                            <p class="text-sm text-gray-500 mb-6">Bofya kitufe hapa chini kuendelea kutumia mfumo.</p>
                            <button onclick="resetInactivityTimer()" class="w-full px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #360958 0%, #2a0745 100%);">
                                <i class="fas fa-sync-alt"></i>
                                <span>Endelea Kutumia Mfumo</span>
                            </button>
                        </div>
                    </div>
                </div>
                <style>
                    @keyframes modalSlideIn {
                        from { opacity: 0; transform: scale(0.9) translateY(-20px); }
                        to { opacity: 1; transform: scale(1) translateY(0); }
                    }
                    @keyframes pulse {
                        0%, 100% { transform: scale(1); }
                        50% { transform: scale(1.05); }
                    }
                </style>
            `;
            document.body.insertAdjacentHTML('afterbegin', warningHTML);

            // Start countdown
            let seconds = 60;
            const countdownEl = document.getElementById('countdownSeconds');
            const countdownInterval = setInterval(() => {
                seconds--;
                if (countdownEl) countdownEl.textContent = seconds;
                if (seconds <= 0) clearInterval(countdownInterval);
            }, 1000);
        }

        function logoutDueToInactivity() {
            // Remove warning modal if exists
            const warningBanner = document.getElementById('sessionWarningBanner');
            if (warningBanner) warningBanner.remove();

            // Show styled logout modal
            const logoutModalHTML = `
                <div id="sessionLogoutModal" class="fixed inset-0 z-[10000] flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(6px);">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" style="animation: modalSlideIn 0.3s ease-out;">
                        <div class="p-6 text-center">
                            <div class="h-20 w-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-sign-out-alt text-red-600 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Kikao Kimeisha</h3>
                            <p class="text-gray-600 mb-6">Umekuwa bila shughuli kwa muda mrefu. Unaondolewa kwenye mfumo kwa usalama wako.</p>
                            <div class="flex items-center justify-center gap-2 text-gray-500">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Inaondoka...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('afterbegin', logoutModalHTML);

            // Submit logout form after a brief delay to show the modal
            setTimeout(() => {
                document.getElementById('logout-form').submit();
            }, 1500);
        }

        // Reset timer on user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(function(event) {
            document.addEventListener(event, resetInactivityTimer, true);
        });

        // Initialize the timer
        resetInactivityTimer();

        // Global Styled Alert/Confirm Modal System
        const alertModalHTML = `
            <div id="globalAlertModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
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

        // ============================================
        // PREVENT BROWSER BACK/FORWARD NAVIGATION
        // ============================================
        (function() {
            // Push current state to prevent going back
            history.pushState(null, null, location.href);

            // Listen for popstate (when user tries to go back/forward)
            window.addEventListener('popstate', function(event) {
                // Push state again to keep user on current page
                history.pushState(null, null, location.href);
            });

            // Handle page show event (when page is restored from bfcache)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Page was restored from browser cache - force full reload from server
                    window.location.replace(window.location.href);
                }
            });

            // Check session validity
            function checkSessionValidity() {
                fetch('/panel/check-session', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }).then(function(response) {
                    if (!response.ok || response.status === 401) {
                        // Session invalid - redirect to login
                        window.location.replace('{{ route("login") }}');
                    }
                }).catch(function() {
                    // On error, reload page to let server handle it
                    window.location.reload();
                });
            }

            // Check session when page becomes visible after being hidden
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    checkSessionValidity();
                }
            });
        })();
    </script>

    @yield('modals')
    @yield('scripts')
</body>
</html>
