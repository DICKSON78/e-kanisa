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
    <title>@yield('title', 'Mfumo wa ROC')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/roc_logo.jpeg') }}">

    <!-- CRITICAL: Prevent FOUC - Hide page until CSS loads -->
    <style id="critical-css">
        html { visibility: hidden; opacity: 0; }
        html.css-ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease; }

        .sidebar {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            width: 272px !important;
            height: 100vh !important;
            z-index: 1000 !important;
            background: linear-gradient(180deg, #360958 0%, #2a0745 50%, #1f0533 100%) !important;
            display: flex !important;
            flex-direction: column !important;
            transform: translateX(0) !important;
        }
        .main-content {
            margin-left: 272px;
            width: calc(100% - 272px);
            min-height: 100vh;
            background: #F5F7F5;
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%) !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; }
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
            background-color: #F5F7F5;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 272px;
            height: 100vh;
            background: linear-gradient(180deg, #360958 0%, #2a0745 50%, #1f0533 100%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
            .sidebar.open { transform: translateX(0); }
        }

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

        .sidebar-logo {
            padding: 1.25rem 1.25rem 0.75rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            padding: 2px;
        }

        .logo-text {
            margin-left: 0;
            font-size: 0.9375rem;
            font-weight: 700;
            color: white;
            white-space: nowrap;
            line-height: 1;
        }

        .logo-subtitle {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 400;
            line-height: 1;
            margin-left: 0;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.5rem 0.75rem;
            min-height: 0;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(239, 193, 32, 0.25) transparent;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(239, 193, 32, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(239, 193, 32, 0.45); }

        .sidebar-group-label {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.75rem 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(239, 193, 32, 0.65);
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            border-radius: 0.5rem;
            margin-top: 0.25rem;
        }
        .sidebar-group-label:first-child { margin-top: 0; }
        .sidebar-group-label:hover { color: rgba(239, 193, 32, 0.9); }

        .sidebar-group-label .chevron {
            font-size: 0.5625rem;
            color: rgba(239, 193, 32, 0.4);
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }
        .sidebar-group-label.collapsed .chevron { transform: rotate(0deg); }
        .sidebar-group-label:not(.collapsed) .chevron { transform: rotate(90deg); }

        .sidebar-group-items {
            overflow: hidden;
            transition: max-height 0.25s ease, opacity 0.2s ease;
            max-height: 800px;
            opacity: 1;
        }
        .sidebar-group-items.collapsed { max-height: 0; opacity: 0; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .sidebar-link:hover { color: #ffffff; background: rgba(255, 255, 255, 0.1); }
        .sidebar-link.active { color: #ffffff; background: linear-gradient(135deg, #efc120 0%, #d4a81c 100%); }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; flex-shrink: 0; }

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

        .sidebar-bottom {
            padding: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .sidebar-bottom .sidebar-link {
            margin-bottom: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.75rem;
            margin-top: 0.5rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #efc120, #d4a81c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #360958;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-details p:first-child {
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-details p:last-child {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            height: auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }
        @media (min-width: 768px) {
            .header { padding: 1rem 2rem; }
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
            min-width: 0;
        }

        .toggle-btn {
            width: 2.25rem;
            height: 2.25rem;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .toggle-btn:hover { background: #f3f4f6; color: #360958; }
        .toggle-btn i { font-size: 1.125rem; }

        @media (min-width: 1025px) {
            .toggle-btn { display: none; }
        }

        .header-date {
            display: none;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            white-space: nowrap;
        }
        .header-date .separator {
            width: 1px;
            height: 14px;
            background: #d1d5db;
        }
        .header-date i { font-size: 0.75rem; color: #9ca3af; }
        @media (min-width: 640px) {
            .header-date { display: flex; }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .notification-btn {
            position: relative;
            width: 2.25rem;
            height: 2.25rem;
            background: #f3f4f6;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .notification-btn:hover { background: #e5e7eb; color: #360958; }
        .notification-btn i { font-size: 1rem; }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            min-width: 1rem;
            height: 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

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
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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

        .notification-dropdown-body { max-height: 320px; overflow-y: auto; }

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
        .notification-item:hover { background: #f9fafb; }

        .notification-item-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notification-item-icon i { font-size: 1.125rem; }

        .notification-item-content { flex: 1; min-width: 0; }
        .notification-item-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.125rem;
        }
        .notification-item-desc { font-size: 0.75rem; color: #6b7280; }

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
        }
        .notification-dropdown-footer a:hover { color: #efc120; }

        @media (max-width: 480px) {
            .notification-dropdown { width: calc(100vw - 1rem); right: -0.5rem; }
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
            cursor: pointer;
            padding: 0.25rem 0.5rem 0.25rem 0.25rem;
            border-radius: 9999px;
            transition: background 0.2s;
            position: relative;
        }
        .header-user:hover { background: #f3f4f6; }

        .header-user-avatar {
            width: 2.25rem;
            height: 2.25rem;
            background: linear-gradient(135deg, #efc120, #d4a81c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #360958;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .header-user-name {
            display: none;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
        }
        @media (min-width: 768px) {
            .header-user-name { display: block; }
        }

        .header-user-chevron {
            display: none;
            font-size: 0.75rem;
            color: #9ca3af;
            transition: transform 0.2s;
        }
        @media (min-width: 768px) {
            .header-user-chevron { display: block; }
        }
        .header-user.open .header-user-chevron { transform: rotate(180deg); }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 14rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            border: 1px solid #e5e7eb;
            z-index: 1000;
            overflow: hidden;
            animation: dropdownSlide 0.2s ease-out;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .user-dropdown-item:hover { background: #f3f4f6; }
        .user-dropdown-item i { width: 1rem; text-align: center; color: #6b7280; }
        .user-dropdown-item.logout { color: #dc2626; }
        .user-dropdown-item.logout i { color: #dc2626; }

        .header-time { display: none; }
        @media (min-width: 640px) {
            .header-time { display: inline; }
        }

        .main-content {
            margin-left: 272px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #F5F7F5;
            width: calc(100% - 272px);
        }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; width: 100%; }
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
           PHARMEX-STYLE DESIGN SYSTEM (ROC Adapted)
           ============================================ */

        /* --- Cards --- */
        .rx-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s, border-color 0.3s;
        }
        .rx-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

        /* --- Stat Cards --- */
        .rx-stat-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            padding: 1.5rem;
            transition: all 0.3s;
        }
        .rx-stat-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: #f5e6a3;
            transform: translateY(-2px);
        }

        /* --- Tables --- */
        .rx-table { width: 100%; border-collapse: collapse; }
        .rx-table thead tr { background: #f9fafb; }
        .rx-table thead th {
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }
        .rx-table tbody { border-top: 1px solid #f3f4f6; }
        .rx-table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .rx-table tbody tr { transition: background-color 0.15s; }
        .rx-table tbody tr:hover { background-color: rgba(239,193,32,0.04); }

        /* --- Buttons --- */
        .rx-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .rx-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .rx-btn-primary {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            background: #efc120;
            color: #360958;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            font-weight: 600;
        }
        .rx-btn-primary:hover {
            background: #d4a81c;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: translateY(-1px);
        }

        .rx-btn-secondary {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
        }
        .rx-btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .rx-btn-danger {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            background: #ef4444;
            color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .rx-btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .rx-btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
        }

        /* --- Icon Buttons (for table actions) --- */
        .rx-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }
        .rx-icon-btn-gold { color: #efc120; background: rgba(239,193,32,0.1); }
        .rx-icon-btn-gold:hover { background: rgba(239,193,32,0.2); }
        .rx-icon-btn-blue { color: #3b82f6; background: rgba(59,130,246,0.1); }
        .rx-icon-btn-blue:hover { background: rgba(59,130,246,0.15); }
        .rx-icon-btn-red { color: #ef4444; background: rgba(239,68,68,0.1); }
        .rx-icon-btn-red:hover { background: rgba(239,68,68,0.15); }
        .rx-icon-btn-purple { color: #360958; background: rgba(54,9,88,0.08); }
        .rx-icon-btn-purple:hover { background: rgba(54,9,88,0.15); }

        /* --- Badges --- */
        .rx-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .rx-badge-green { background: #dcfce7; color: #16a34a; }
        .rx-badge-red { background: #fee2e2; color: #dc2626; }
        .rx-badge-yellow { background: #fef9c3; color: #a16207; }
        .rx-badge-blue { background: #dbeafe; color: #2563eb; }
        .rx-badge-gray { background: #f3f4f6; color: #6b7280; }
        .rx-badge-purple { background: #ede9fe; color: #7c3aed; }
        .rx-badge-gold { background: #fef3c7; color: #92400e; }

        /* --- Form Inputs --- */
        .rx-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            background: white;
            transition: all 0.2s;
        }
        .rx-input:focus {
            outline: none;
            border-color: #efc120;
            box-shadow: 0 0 0 3px rgba(239,193,32,0.15);
        }
        .rx-input::placeholder { color: #9ca3af; }

        .rx-input-no-icon {
            padding-left: 1rem;
        }

        .rx-select {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            background: white url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") right 0.75rem center / 1.25em 1.25em no-repeat;
            appearance: none;
            transition: all 0.2s;
        }
        .rx-select:focus {
            outline: none;
            border-color: #efc120;
            box-shadow: 0 0 0 3px rgba(239,193,32,0.15);
        }

        /* --- Search Bar --- */
        .rx-search {
            position: relative;
        }
        .rx-search svg {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            color: #9ca3af;
        }
        .rx-search input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            transition: all 0.2s;
        }
        .rx-search input:focus {
            outline: none;
            border-color: #efc120;
            box-shadow: 0 0 0 3px rgba(239,193,32,0.15);
            background: white;
        }
        .rx-search input::placeholder { color: #9ca3af; }

        /* --- Empty State --- */
        .rx-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 1.5rem;
            text-align: center;
        }
        .rx-empty-icon {
            width: 4rem;
            height: 4rem;
            background: #f3f4f6;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        /* --- Animations --- */
        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .content-area > :first-child { animation: pageEnter 0.35s ease-out; }

    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <script>
        document.documentElement.classList.add('css-ready');
    </script>
    <div class="flex h-screen">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar text-white flex flex-col" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="logo-icon">
                        <img src="{{ asset('images/roc_logo.jpeg') }}" alt="ROC Logo" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="logo-text">ROC System</span>
                        <p class="logo-subtitle">Reality of Christ</p>
                    </div>
                </a>
                <button class="toggle-btn md:hidden text-white/60 hover:text-white" id="closeSidebar" aria-label="Close Sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav sidebar-scroll">
                <div class="space-y-1">
                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>MAIN</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                @endif
                <a href="{{ route('member.portal') }}" class="sidebar-link {{ request()->routeIs('member.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Portal Yangu</span>
                </a>
                </div>

                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>USIMAMIZI</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('members.index') }}" class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Waumini</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="sidebar-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Uhudhuriaji</span>
                    </a>
                    <a href="{{ route('visitors.index') }}" class="sidebar-link {{ request()->routeIs('visitors.*') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Wageni</span>
                    </a>
                    <a href="{{ route('followups.index') }}" class="sidebar-link {{ request()->routeIs('followups.*') ? 'active' : '' }}">
                        <i class="fas fa-headset"></i>
                        <span>Ufuatiliaji</span>
                    </a>
                    <a href="{{ route('children.index') }}" class="sidebar-link {{ request()->routeIs('children.*') ? 'active' : '' }}">
                        <i class="fas fa-child"></i>
                        <span>Sunday School</span>
                    </a>
                    <a href="{{ route('transfers.index') }}" class="sidebar-link {{ request()->routeIs('transfers.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Uhamisho</span>
                    </a>
                </div>

                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>FEDHA</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('income.index') }}" class="sidebar-link {{ request()->routeIs('income.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Mapato</span>
                    </a>
                    <a href="{{ route('expenses.index') }}" class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Matumizi</span>
                    </a>
                    <a href="{{ route('offerings.index') }}" class="sidebar-link {{ request()->routeIs('offerings.*') ? 'active' : '' }}">
                        <i class="fas fa-gift"></i>
                        <span>Sadaka</span>
                    </a>
                    <a href="{{ route('requests.index') }}" class="sidebar-link {{ request()->routeIs('requests.*') ? 'active' : '' }}">
                        <i class="fas fa-paper-plane"></i>
                        <span>Maombi ya Fedha</span>
                    </a>
                    <a href="{{ route('budgets.index') }}" class="sidebar-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Bajeti</span>
                    </a>
                    <a href="{{ route('statements.index') }}" class="sidebar-link {{ request()->routeIs('statements.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Taarifa za Mwaka</span>
                    </a>
                    <a href="{{ route('online-giving.index') }}" class="sidebar-link {{ request()->routeIs('online-giving.*') ? 'active' : '' }}">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Malipo ya Mtandaoni</span>
                    </a>
                    @if(Auth::user()->isMhasibu())
                    <a href="{{ route('accounting.chart-of-accounts') }}" class="sidebar-link {{ request()->routeIs('accounting.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Kitabu cha Hesabu</span>
                    </a>
                    <a href="{{ route('accounting.journal.index') }}" class="sidebar-link {{ request()->routeIs('accounting.journal.*') ? 'active' : '' }}">
                        <i class="fas fa-journal-whills"></i>
                        <span>Ingizo la Kitabu</span>
                    </a>
                    @if(Auth::user()->isMchungaji())
                    <a href="{{ route('payroll.index') }}" class="sidebar-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Ushuru</span>
                    </a>
                    @endif
                    @endif
                </div>

                @if(Auth::user()->isMchungaji())
                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>UTAWALA</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('approvals.index') }}" class="sidebar-link {{ request()->routeIs('approvals.*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature"></i>
                        <span>Idhini za Idara</span>
                    </a>
                    @if(Auth::user()->isMhasibu())
                    <a href="{{ route('approvals.thresholds') }}" class="sidebar-link {{ request()->routeIs('approvals.thresholds') ? 'active' : '' }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>Kiwango cha Idhini</span>
                    </a>
                    @endif
                </div>
                @endif

                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>HUDUMA</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('serving.index') }}" class="sidebar-link {{ request()->routeIs('serving.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Ratiba ya Kuhudumu</span>
                    </a>
                    <a href="{{ route('gallery.index') }}" class="sidebar-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>Picha na Video</span>
                    </a>
                </div>
                @endif

                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>JAMII</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('pastoral-services.index') }}" class="sidebar-link {{ request()->routeIs('pastoral-services.*') ? 'active' : '' }}">
                        <i class="fas fa-praying-hands"></i>
                        <span>Huduma za Kichungaji</span>
                    </a>
                    <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Matukio</span>
                    </a>
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
                        <span>Ujumbe</span>
                        @if($sidebarUnreadMessages > 0)
                            <span class="request-badge">{{ $sidebarUnreadMessages }}</span>
                        @endif
                    </a>
                    @endif
                    @endif
                </div>

                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>RIPOTI & MIPANGILIO</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('export.excel') }}" class="sidebar-link {{ request()->routeIs('export.excel*') || request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Ripoti</span>
                    </a>
                    @if(Auth::user()->isMhasibu())
                    <a href="{{ route('accounting.trial-balance') }}" class="sidebar-link {{ request()->routeIs('accounting.trial-balance') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale"></i>
                        <span>Mizani ya Majaribio</span>
                    </a>
                    <a href="{{ route('accounting.balance-sheet') }}" class="sidebar-link {{ request()->routeIs('accounting.balance-sheet') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Hali ya Fedha</span>
                    </a>
                    <a href="{{ route('accounting.income-statement') }}" class="sidebar-link {{ request()->routeIs('accounting.income-statement') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Mapato na Gharama</span>
                    </a>
                    @endif
                    <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Mipangilio</span>
                    </a>
                </div>
                @else
                <button class="sidebar-group-label" onclick="toggleGroup(this)">
                    <span>MIPANGILIO</span>
                    <i class="fas fa-chevron-right chevron"></i>
                </button>
                <div class="sidebar-group-items">
                    <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Mipangilio</span>
                    </a>
                </div>
                @endif

                </div>
            </nav>

            <!-- Bottom Section -->
            <div class="sidebar-bottom">
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                @else
                <a href="{{ route('settings.index') }}" class="sidebar-link">
                    <i class="fas fa-cog"></i>
                    <span>Mipangilio</span>
                </a>
                @endif
                <div class="sidebar-user">
                    @php
                        $userName = Auth::user()->name ?? 'Admin';
                        $userInitials = strtoupper(implode('', array_map(function($w) { return $w[0]; }, explode(' ', $userName))));
                        $userInitials = substr($userInitials, 0, 2);
                    @endphp
                    <div class="user-avatar">{{ $userInitials }}</div>
                    <div class="user-details">
                        <p>{{ $userName }}</p>
                        <p>{{ Auth::user()->role->name ?? 'Muumini' }}</p>
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
                    <div class="header-date">
                        <i class="fas fa-calendar"></i>
                        <span>{{ now()->format('l, F j, Y') }}</span>
                        <div class="separator"></div>
                        <i class="fas fa-clock"></i>
                        <span id="headerTime">{{ now()->format('H:i') }}</span>
                    </div>
                </div>
                <div class="header-right">
                    <!-- Messages Button -->
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
                        <span class="notification-badge" style="background: linear-gradient(135deg, #22c55e, #16a34a);">{{ $headerUnreadMessages }}</span>
                        @endif
                    </a>
                    @endif
                    @endif

                    <!-- Notification Dropdown -->
                    <div class="relative" id="notificationWrapper">
                        <button class="notification-btn" id="notificationToggle" aria-label="Notifications">
                            <i class="fas fa-bell"></i>
                            @php
                                $needsPasswordChange = Auth::user()->needsPasswordChange();
                                $pendingRequests = 0;
                                $pendingPastoral = 0;
                                $pendingMembers = 0;
                                $newEvents = 0;
                                $memberPastoral = 0;
                                $totalNotifications = ($needsPasswordChange ? 1 : 0);

                                try {
                                    if (Auth::user()->isMwanachama()) {
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
                                        $pendingRequests = \App\Models\Request::where('status', 'Inasubiri')->count();
                                        $pendingPastoral = \App\Models\PastoralService::where('status', 'Inasubiri')->count();
                                        if (Auth::user()->isMchungaji() || Auth::user()->isMhasibu()) {
                                            $pendingMembers = \App\Models\User::where('is_active', false)->count();
                                        }
                                        $totalNotifications = $pendingRequests + $pendingPastoral + $pendingMembers + ($needsPasswordChange ? 1 : 0);
                                    }
                                } catch (\Exception $e) {
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

                    <!-- User Dropdown -->
                    @php
                        $headerUserName = Auth::user()->name ?? 'Admin';
                        $headerInitials = strtoupper(implode('', array_map(function($w) { return $w[0]; }, explode(' ', $headerUserName))));
                        $headerInitials = substr($headerInitials, 0, 2);
                    @endphp
                    <div class="header-user" id="headerUserDropdown">
                        <div class="header-user-avatar">{{ $headerInitials }}</div>
                        <span class="header-user-name">{{ $headerUserName }}</span>
                        <i class="fas fa-chevron-down header-user-chevron"></i>

                        <div class="user-dropdown hidden" id="userDropdownMenu">
                            <div class="user-dropdown-item" style="cursor: default;">
                                <i class="fas fa-user"></i>
                                <div>
                                    <p style="font-weight: 600; font-size: 0.875rem;">{{ $headerUserName }}</p>
                                    <p style="font-size: 0.75rem; color: #6b7280;">{{ Auth::user()->role->name ?? 'Muumini' }}</p>
                                </div>
                            </div>
                            <div style="height: 1px; background: #e5e7eb; margin: 0.25rem 0;"></div>
                            <a href="{{ route('settings.index') }}" class="user-dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Mipangilio</span>
                            </a>
                            @auth
                            <button class="user-dropdown-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Ondoka</span>
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @endauth
                        </div>
                    </div>
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
        function toggleGroup(btn) {
            btn.classList.toggle('collapsed');
            const items = btn.nextElementSibling;
            if (items && items.classList.contains('sidebar-group-items')) {
                items.classList.toggle('collapsed');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar');
            var sidebarOverlay = document.getElementById('sidebarOverlay');
            var toggleBtn = document.getElementById('toggleSidebar');
            var closeBtn = document.getElementById('closeSidebar');
            var headerUser = document.getElementById('headerUserDropdown');
            var userDropdownMenu = document.getElementById('userDropdownMenu');

            // Auto-expand group with active link
            document.querySelectorAll('.sidebar-link.active').forEach(function(link) {
                var groupItems = link.closest('.sidebar-group-items');
                if (groupItems && groupItems.classList.contains('collapsed')) {
                    groupItems.classList.remove('collapsed');
                    var label = groupItems.previousElementSibling;
                    if (label && label.classList.contains('sidebar-group-label')) {
                        label.classList.remove('collapsed');
                    }
                }
            });

            // Mobile sidebar toggle
            function openSidebar() {
                sidebar.classList.add('open');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeSidebarFn() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (sidebar.classList.contains('open')) {
                        closeSidebarFn();
                    } else {
                        openSidebar();
                    }
                });
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebarFn);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebarFn);
            }

            // Close sidebar on link click (mobile)
            sidebar.querySelectorAll('.sidebar-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 1024) {
                        closeSidebarFn();
                    }
                });
            });

            // Header user dropdown
            if (headerUser) {
                headerUser.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdownMenu.classList.toggle('hidden');
                    headerUser.classList.toggle('open');
                });
            }
            document.addEventListener('click', function(e) {
                if (headerUser && !headerUser.contains(e.target)) {
                    userDropdownMenu.classList.add('hidden');
                    headerUser.classList.remove('open');
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (userDropdownMenu) userDropdownMenu.classList.add('hidden');
                    if (headerUser) headerUser.classList.remove('open');
                }
            });

            // Header time updater
            function updateHeaderTime() {
                var el = document.getElementById('headerTime');
                if (el) {
                    var now = new Date();
                    el.textContent = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
                }
            }
            setInterval(updateHeaderTime, 30000);

            // Toast notification system
            var notifications = [];
            var notificationContainer = document.getElementById('notificationContainer');
            var notificationToggle = document.getElementById('notificationToggle');
            var notificationDropdown = document.getElementById('notificationDropdown');
            var notificationWrapper = document.getElementById('notificationWrapper');

            function showNotification(message, type, category) {
                type = type || 'success';
                category = category || 'Mfumo';
                var now = new Date();
                var timeString = now.toLocaleTimeString('sw-TZ', { hour: '2-digit', minute: '2-digit', hour12: true });
                var icons = { 'success': 'fa-check-circle', 'error': 'fa-exclamation-circle', 'warning': 'fa-exclamation-triangle', 'info': 'fa-info-circle' };
                var iconClass = icons[type] || 'fa-bell';

                var notification = document.createElement('div');
                notification.className = 'notification ' + type;
                notification.innerHTML = '<div class="notification-header"><div class="notification-sender"><i class="fas ' + iconClass + '"></i> Mfumo wa ROC</div><div class="notification-time">' + timeString + '</div></div><div class="notification-body">' + message + '</div><div class="notification-actions"><span class="notification-category">' + category + '</span><button class="notification-close"><i class="fas fa-times"></i></button></div>';
                notificationContainer.appendChild(notification);
                notifications.push(notification);

                setTimeout(function() {
                    if (notification.parentNode) {
                        notification.style.animation = 'slideOut 0.3s ease-in-out';
                        setTimeout(function() {
                            notification.remove();
                            notifications = notifications.filter(function(n) { return n !== notification; });
                        }, 300);
                    }
                }, 6000);

                notification.querySelector('.notification-close').addEventListener('click', function() {
                    notification.style.animation = 'slideOut 0.3s ease-in-out';
                    setTimeout(function() {
                        notification.remove();
                        notifications = notifications.filter(function(n) { return n !== notification; });
                    }, 300);
                });
            }

            window.showNotification = showNotification;

            // Notification dropdown toggle
            if (notificationToggle && notificationDropdown) {
                notificationToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (notificationWrapper && !notificationWrapper.contains(e.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') notificationDropdown.classList.add('hidden');
                });
            }

            // Laravel flash messages
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

            // Responsive - ensure sidebar is closed on desktop resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    closeSidebarFn();
                }
            });
        });

        var lastNotificationCount = {{ $totalNotifications }};

        function refreshNotifications() {
            fetch('/panel/notifications', {
                method: 'GET',
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                var badge = document.getElementById('notificationBadge');
                var dropdownBody = document.querySelector('.notification-dropdown-body');
                var countSpan = document.querySelector('.notification-count');

                if (data.total > 0) {
                    if (badge) { badge.textContent = data.total; badge.classList.remove('hidden'); }
                    else {
                        var btn = document.getElementById('notificationToggle');
                        var newBadge = document.createElement('span');
                        newBadge.className = 'notification-badge';
                        newBadge.id = 'notificationBadge';
                        newBadge.textContent = data.total;
                        btn.appendChild(newBadge);
                    }
                    if (data.total > lastNotificationCount) {
                        var diff = data.total - lastNotificationCount;
                        var msg = diff === 1 ? 'Una arifa mpya 1' : 'Una arifa mpya ' + diff;
                        if (typeof showNotification === 'function') showNotification(msg, 'info', 'Arifa');
                        var bellIcon = document.querySelector('#notificationToggle i');
                        if (bellIcon) { bellIcon.classList.add('fa-shake'); setTimeout(function() { bellIcon.classList.remove('fa-shake'); }, 1000); }
                    }
                } else {
                    if (badge) badge.classList.add('hidden');
                }

                if (countSpan) countSpan.textContent = data.total + ' mpya';
                if (dropdownBody) updateNotificationDropdown(data);
                lastNotificationCount = data.total;
            })
            .catch(function() {});
        }

        function updateNotificationDropdown(data) {
            var dropdownBody = document.querySelector('.notification-dropdown-body');
            if (!dropdownBody) return;
            var html = '';
            var hasNotifications = data.total > 0 || data.needs_password_change;

            if (!hasNotifications) {
                html = '<div class="notification-empty"><i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i><p>Hakuna arifa mpya</p></div>';
            } else {
                if (data.needs_password_change) {
                    html += '<a href="{{ route("settings.index") }}?tab=password" class="notification-item"><div class="notification-item-icon bg-orange-100"><i class="fas fa-key text-orange-600"></i></div><div class="notification-item-content"><p class="notification-item-title">Badilisha Nywila</p><p class="notification-item-desc">Unatumia nywila ya msingi. Badilisha kwa usalama wako.</p></div><span class="notification-item-badge bg-orange-500">!</span></a>';
                }
                if (data.pending_requests > 0) {
                    html += '<a href="{{ route("requests.index") }}" class="notification-item"><div class="notification-item-icon bg-yellow-100"><i class="fas fa-paper-plane text-yellow-600"></i></div><div class="notification-item-content"><p class="notification-item-title">Maombi ya Fedha</p><p class="notification-item-desc">' + data.pending_requests + ' maombi yanasubiri kuidhinishwa</p></div><span class="notification-item-badge bg-yellow-500">' + data.pending_requests + '</span></a>';
                }
                if (data.pending_pastoral > 0) {
                    html += '<a href="{{ route("pastoral-services.index") }}" class="notification-item"><div class="notification-item-icon bg-purple-100"><i class="fas fa-praying-hands text-purple-600"></i></div><div class="notification-item-content"><p class="notification-item-title">Huduma za Kichungaji</p><p class="notification-item-desc">' + data.pending_pastoral + ' maombi yanasubiri kuidhinishwa</p></div><span class="notification-item-badge bg-purple-500">' + data.pending_pastoral + '</span></a>';
                }
                if (data.pending_members > 0) {
                    html += '<a href="{{ route("members.index") }}?status=pending" class="notification-item"><div class="notification-item-icon bg-green-100"><i class="fas fa-user-plus text-green-600"></i></div><div class="notification-item-content"><p class="notification-item-title">Usajili Mpya</p><p class="notification-item-desc">' + data.pending_members + ' wanachama wanasubiri kuidhinishwa</p></div><span class="notification-item-badge bg-green-500">' + data.pending_members + '</span></a>';
                }
                if (data.new_events > 0) {
                    html += '<a href="{{ route("events.index") }}" class="notification-item"><div class="notification-item-icon bg-blue-100"><i class="fas fa-calendar-alt text-blue-600"></i></div><div class="notification-item-content"><p class="notification-item-title">Matukio Mapya</p><p class="notification-item-desc">' + data.new_events + ' matukio mapya yameongezwa</p></div><span class="notification-item-badge bg-blue-500">' + data.new_events + '</span></a>';
                }
            }
            dropdownBody.innerHTML = html;
        }

        setInterval(refreshNotifications, 15000);
        document.addEventListener('visibilitychange', function() { if (!document.hidden) refreshNotifications(); });

        // Session timeout
        var SESSION_TIMEOUT = 10 * 60 * 1000;
        var WARNING_TIME = 60 * 1000;
        var inactivityTimer, warningTimer, warningShown = false;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            clearTimeout(warningTimer);
            warningShown = false;
            var warningBanner = document.getElementById('sessionWarningBanner');
            if (warningBanner) warningBanner.remove();
            warningTimer = setTimeout(showSessionWarning, SESSION_TIMEOUT - WARNING_TIME);
            inactivityTimer = setTimeout(logoutDueToInactivity, SESSION_TIMEOUT);
        }

        function showSessionWarning() {
            if (warningShown) return;
            warningShown = true;
            var warningHTML = '<div id="sessionWarningBanner" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"><div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"><div class="p-6 text-center"><div class="h-20 w-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-clock text-orange-600 text-4xl"></i></div><h3 class="text-xl font-bold text-gray-900 mb-2">Muda wa Kikao Unakaribia Kuisha!</h3><p class="text-gray-600 mb-2">Utaondolewa kwenye mfumo baada ya <span id="countdownSeconds" class="font-bold text-red-600">60</span> sekunde kwa kukosa shughuli.</p><p class="text-sm text-gray-500 mb-6">Bofya kitufe hapa chini kuendelea kutumia mfumo.</p><button onclick="resetInactivityTimer()" class="w-full px-6 py-3 text-white font-semibold rounded-xl" style="background:linear-gradient(135deg,#360958,#2a0745);"><i class="fas fa-sync-alt mr-2"></i>Endelea Kutumia Mfumo</button></div></div></div>';
            document.body.insertAdjacentHTML('afterbegin', warningHTML);
            var seconds = 60;
            var countdownEl = document.getElementById('countdownSeconds');
            var countdownInterval = setInterval(function() { seconds--; if (countdownEl) countdownEl.textContent = seconds; if (seconds <= 0) clearInterval(countdownInterval); }, 1000);
        }

        function logoutDueToInactivity() {
            var warningBanner = document.getElementById('sessionWarningBanner');
            if (warningBanner) warningBanner.remove();
            var logoutModalHTML = '<div id="sessionLogoutModal" class="fixed inset-0 z-[10000] flex items-center justify-center p-4" style="background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);"><div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"><div class="p-6 text-center"><div class="h-20 w-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-sign-out-alt text-red-600 text-4xl"></i></div><h3 class="text-xl font-bold text-gray-900 mb-2">Kikao Kimeisha</h3><p class="text-gray-600 mb-6">Umekuwa bila shughuli kwa muda mrefu. Unaondolewa kwenye mfumo kwa usalama wako.</p><div class="flex items-center justify-center gap-2 text-gray-500"><i class="fas fa-spinner fa-spin"></i><span>Inaondoka...</span></div></div></div></div>';
            document.body.insertAdjacentHTML('afterbegin', logoutModalHTML);
            setTimeout(function() { document.getElementById('logout-form').submit(); }, 1500);
        }

        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(function(event) {
            document.addEventListener(event, resetInactivityTimer, true);
        });
        resetInactivityTimer();

        // Global alert/confirm modal
        var alertModalHTML = '<div id="globalAlertModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]"><div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="alertModalContent"><div class="p-6"><div class="flex items-start gap-4"><div id="alertIconContainer" class="flex-shrink-0 h-12 w-12 rounded-full flex items-center justify-center"><i id="alertIcon" class="text-xl"></i></div><div class="flex-1"><h3 id="alertTitle" class="text-lg font-bold text-gray-900 mb-2"></h3><p id="alertMessage" class="text-gray-600"></p></div></div></div><div id="alertActions" class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200"><button id="alertCancelBtn" class="hidden px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Ghairi</button><button id="alertOkBtn" class="px-5 py-2.5 text-sm font-medium text-white rounded-lg flex items-center gap-2"><span>Sawa</span></button></div></div></div>';
        document.body.insertAdjacentHTML('beforeend', alertModalHTML);

        var alertTypes = {
            success: { bgColor: 'bg-green-100', iconColor: 'text-green-600', icon: 'fas fa-check-circle', btnColor: 'bg-green-600 hover:bg-green-700', title: 'Imefanikiwa!' },
            error: { bgColor: 'bg-red-100', iconColor: 'text-red-600', icon: 'fas fa-exclamation-circle', btnColor: 'bg-red-600 hover:bg-red-700', title: 'Hitilafu!' },
            warning: { bgColor: 'bg-yellow-100', iconColor: 'text-yellow-600', icon: 'fas fa-exclamation-triangle', btnColor: 'bg-yellow-600 hover:bg-yellow-700', title: 'Onyo!' },
            info: { bgColor: 'bg-blue-100', iconColor: 'text-blue-600', icon: 'fas fa-info-circle', btnColor: 'bg-blue-600 hover:bg-blue-700', title: 'Taarifa' },
            confirm: { bgColor: 'bg-purple-100', iconColor: 'text-purple-600', icon: 'fas fa-question-circle', btnColor: 'bg-primary-600 hover:bg-primary-700', title: 'Thibitisha' }
        };

        function showAlertModal(message, type, title, callback) {
            type = type || 'info';
            var modal = document.getElementById('globalAlertModal');
            var content = document.getElementById('alertModalContent');
            var iconContainer = document.getElementById('alertIconContainer');
            var icon = document.getElementById('alertIcon');
            var titleEl = document.getElementById('alertTitle');
            var messageEl = document.getElementById('alertMessage');
            var okBtn = document.getElementById('alertOkBtn');
            var cancelBtn = document.getElementById('alertCancelBtn');
            var config = alertTypes[type] || alertTypes.info;

            iconContainer.className = 'flex-shrink-0 h-12 w-12 rounded-full flex items-center justify-center ' + config.bgColor;
            icon.className = config.icon + ' text-xl ' + config.iconColor;
            okBtn.className = 'px-5 py-2.5 text-sm font-medium text-white rounded-lg flex items-center gap-2 ' + config.btnColor;
            titleEl.textContent = title || config.title;
            messageEl.textContent = message;
            if (type === 'confirm') cancelBtn.classList.remove('hidden'); else cancelBtn.classList.add('hidden');

            modal.classList.remove('hidden');
            setTimeout(function() { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);

            var handleOk = function() { closeAlertModal(); if (callback) callback(true); okBtn.removeEventListener('click', handleOk); cancelBtn.removeEventListener('click', handleCancel); };
            var handleCancel = function() { closeAlertModal(); if (callback) callback(false); okBtn.removeEventListener('click', handleOk); cancelBtn.removeEventListener('click', handleCancel); };
            okBtn.addEventListener('click', handleOk);
            cancelBtn.addEventListener('click', handleCancel);
            modal.onclick = function(e) { if (e.target === modal && type !== 'confirm') handleOk(); };
        }

        function closeAlertModal() {
            var modal = document.getElementById('globalAlertModal');
            var content = document.getElementById('alertModalContent');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(function() { modal.classList.add('hidden'); }, 200);
        }

        function showConfirmModal(message, title) {
            return new Promise(function(resolve) { showAlertModal(message, 'confirm', title || 'Thibitisha', function(result) { resolve(result); }); });
        }

        window.showSuccess = function(message, title) { showAlertModal(message, 'success', title); };
        window.showError = function(message, title) { showAlertModal(message, 'error', title); };
        window.showWarning = function(message, title) { showAlertModal(message, 'warning', title); };
        window.showInfo = function(message, title) { showAlertModal(message, 'info', title); };
        window.showConfirm = showConfirmModal;

        // Prevent browser back/forward
        (function() {
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function() { history.pushState(null, null, location.href); });
            window.addEventListener('pageshow', function(event) { if (event.persisted) window.location.replace(window.location.href); });
            function checkSessionValidity() {
                fetch('/panel/check-session', { method: 'GET', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                .then(function(response) { if (!response.ok || response.status === 401) window.location.replace('{{ route("login") }}'); })
                .catch(function() { window.location.reload(); });
            }
            document.addEventListener('visibilitychange', function() { if (!document.hidden) checkSessionValidity(); });
        })();
    </script>

    @yield('modals')
    @yield('scripts')
</body>
</html>
