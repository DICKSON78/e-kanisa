@extends('layouts.app')

@section('title', 'Ujumbe - Mfumo wa E-Kanisa')
@section('page-title', 'Ujumbe')
@section('page-subtitle', 'Mazungumzo na viongozi')

@section('styles')
<style>
    :root {
        --whatsapp-primary: #360958;
        --whatsapp-primary-dark: #2a0745;
        --whatsapp-bg: #f0f2f5;
        --whatsapp-header-bg: #f0f2f5;
        --whatsapp-chat-bg: #ffffff;
        --whatsapp-input-bg: #f0f2f5;
        --whatsapp-green: #25d366;
        --whatsapp-gray: #667781;
        --whatsapp-dark: #111b21;
        --whatsapp-light-gray: #8696a0;
        --whatsapp-border: #e9edef;
        --whatsapp-message-sent: #d9fdd3;
        --whatsapp-message-received: #ffffff;
    }

    .whatsapp-container {
        display: flex;
        height: calc(100vh - 140px);
        min-height: 600px;
        background: var(--whatsapp-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--whatsapp-border);
    }

    .whatsapp-sidebar {
        width: 35%;
        min-width: 380px;
        max-width: 450px;
        background: var(--whatsapp-chat-bg);
        border-right: 1px solid var(--whatsapp-border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-header {
        padding: 12px 16px;
        background: var(--whatsapp-header-bg);
        border-bottom: 1px solid var(--whatsapp-border);
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #360958 0%, #2a0745 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(54, 9, 88, 0.2);
    }

    .user-avatar i { color: white; font-size: 16px; }

    .header-actions { display: flex; gap: 28px; margin-left: auto; }

    .header-action-btn {
        width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
        border-radius: 0.75rem; color: #6b7280; cursor: pointer; font-size: 16px;
        transition: all 0.2s; position: relative;
        background: rgba(239,193,32,0.1); border: 1px solid rgba(239,193,32,0.2);
    }
    .header-action-btn:hover { color: #360958; background: rgba(239,193,32,0.15); border-color: #efc120; }

    .search-filter-bar {
        padding: 16px; background: var(--whatsapp-header-bg);
        border-bottom: 1px solid var(--whatsapp-border);
        flex-shrink: 0; display: flex; flex-direction: column; gap: 12px;
    }

    .search-container { position: relative; }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--whatsapp-light-gray); font-size: 16px; }
    .search-input {
        width: 100%; padding: 12px 16px 12px 48px; border: 1px solid #e5e7eb;
        border-radius: 0.75rem; background: white; color: var(--whatsapp-dark);
        font-size: 15px; outline: none; transition: all 0.3s;
    }
    .search-input:focus { border-color: #efc120; box-shadow: 0 0 0 3px rgba(239,193,32,0.15); }
    .search-input::placeholder { color: var(--whatsapp-light-gray); font-weight: 400; }

    .filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
    .filter-tab {
        padding: 8px 16px; border: 1px solid #e5e7eb; background: white;
        color: var(--whatsapp-gray); font-size: 13px; font-weight: 500;
        cursor: pointer; border-radius: 0.75rem; transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .filter-tab:hover { background: rgba(239,193,32,0.05); border-color: #efc120; }
    .filter-tab.active { background: rgba(239,193,32,0.1); border-color: #efc120; color: #360958; box-shadow: 0 1px 3px rgba(239,193,32,0.15); }

    .chats-list {
        flex: 1; overflow-y: auto; overflow-x: hidden;
        background: var(--whatsapp-chat-bg);
        scrollbar-width: thin; scrollbar-color: rgba(54, 9, 88, 0.3) transparent;
    }
    .chats-list::-webkit-scrollbar { width: 5px; }
    .chats-list::-webkit-scrollbar-track { background: rgba(54, 9, 88, 0.05); border-radius: 4px; }
    .chats-list::-webkit-scrollbar-thumb { background: linear-gradient(180deg, var(--whatsapp-primary) 0%, var(--whatsapp-primary-dark) 100%); border-radius: 4px; }

    .chat-item {
        display: flex; align-items: center; padding: 14px 16px;
        border-bottom: 1px solid var(--whatsapp-border); cursor: pointer;
        transition: all 0.3s; position: relative; text-decoration: none; color: inherit;
    }
    .chat-item:hover { background-color: rgba(54, 9, 88, 0.03); }
    .chat-item.active { background-color: rgba(54, 9, 88, 0.07); border-left: 4px solid var(--whatsapp-primary); }

    .chat-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(135deg, var(--whatsapp-primary) 0%, var(--whatsapp-primary-dark) 100%);
        display: flex; align-items: center; justify-content: center;
        margin-right: 16px; flex-shrink: 0; position: relative;
        box-shadow: 0 3px 6px rgba(54, 9, 88, 0.15);
    }
    .chat-avatar i { color: white; font-size: 22px; }

    .chat-info { flex: 1; min-width: 0; }
    .chat-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
    .chat-name { font-size: 17px; font-weight: 500; color: var(--whatsapp-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .chat-time { font-size: 12px; color: var(--whatsapp-light-gray); flex-shrink: 0; font-weight: 400; }
    .chat-preview { display: flex; align-items: center; gap: 6px; }
    .chat-message { font-size: 15px; color: var(--whatsapp-gray); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; font-weight: 400; line-height: 1.4; }

    .chat-unread {
        background: linear-gradient(135deg, #ef4444, #dc2626); color: white;
        border-radius: 50%; min-width: 22px; height: 22px; font-size: 12px;
        font-weight: 700; display: flex; align-items: center; justify-content: center;
        padding: 0 6px; margin-left: 8px; flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
    }

    .online-indicator {
        position: absolute; bottom: 2px; right: 2px; width: 14px; height: 14px;
        background: #22c55e; border: 2px solid white; border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .online-indicator.offline { background: #9ca3af; }

    .unread-header-badge {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
        background: linear-gradient(135deg, #ef4444, #dc2626); color: white;
        border-radius: 20px; font-size: 13px; font-weight: 600;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    .unread-header-badge.hidden { display: none; }

    .chat-role {
        font-size: 11px; color: var(--whatsapp-primary);
        background: rgba(54, 9, 88, 0.1); padding: 2px 8px; border-radius: 10px; margin-left: 8px;
    }

    .chat-area {
        flex: 1; display: flex; flex-direction: column;
        background-color: var(--whatsapp-bg); position: relative; overflow: hidden;
    }
    .chat-area::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25'%3E%3Cdefs%3E%3Cpattern id='p' width='120' height='120' patternUnits='userSpaceOnUse'%3E%3Cpath fill='%23f0f2f5' d='M0 0h120v120H0z'/%3E%3Cpath fill='%23e9edef' d='M60 0h60v60H60zM0 60h60v60H0z'/%3E%3C/pattern%3E%3C/defs%3E%3Crect fill='url(%23p)' width='100%25' height='100%25' opacity='0.15'/%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .welcome-screen {
        flex: 1; display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 40px 20px; text-align: center;
        position: relative; z-index: 1;
    }
    .welcome-icon {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, rgba(239,193,32,0.12), rgba(239,193,32,0.04));
        border-radius: 1.25rem; display: flex; align-items: center;
        justify-content: center; margin-bottom: 24px; position: relative;
    }
    .welcome-icon i { color: #360958; font-size: 32px; position: relative; z-index: 1; }

    .welcome-title { font-size: 20px; font-weight: 700; color: var(--whatsapp-dark); margin-bottom: 8px; line-height: 1.3; letter-spacing: -0.3px; }
    .welcome-subtitle { font-size: 14px; color: var(--whatsapp-gray); max-width: 400px; line-height: 1.6; margin-bottom: 24px; font-weight: 400; }

    .security-info {
        display: flex; align-items: center; gap: 10px; color: var(--whatsapp-light-gray);
        font-size: 13px; margin-top: 24px; padding: 12px 20px; background: white;
        border-radius: 0.75rem; border: 1px solid var(--whatsapp-border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    .security-info i { color: #16a34a; font-size: 14px; }

    .new-chat-btn {
        background: linear-gradient(135deg, #360958 0%, #2a0745 100%);
        color: white; border: none; border-radius: 12px; padding: 12px 24px;
        font-size: 14px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 10px;
        transition: all 0.2s; box-shadow: 0 2px 8px rgba(54, 9, 88, 0.25);
        position: relative; overflow: hidden;
    }
    .new-chat-btn::before {
        content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.5s;
    }
    .new-chat-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 24px rgba(54, 9, 88, 0.45); }
    .new-chat-btn:hover::before { left: 100%; }
    .new-chat-btn:active { transform: translateY(-1px); }
    .new-chat-btn i { font-size: 18px; transition: transform 0.3s; }
    .new-chat-btn:hover i { transform: translateX(4px); }

    .no-chats-message { padding: 60px 20px; text-align: center; color: var(--whatsapp-gray); }
    .no-chats-message i { font-size: 64px; margin-bottom: 20px; opacity: 0.5; }
    .no-chats-message h3 { font-size: 18px; color: var(--whatsapp-dark); margin-bottom: 8px; font-weight: 400; }

    .chat-area-header {
        background: var(--whatsapp-header-bg); padding: 10px 16px;
        border-bottom: 1px solid var(--whatsapp-border);
        display: flex; align-items: center; gap: 16px; flex-shrink: 0;
        position: relative; z-index: 2;
    }
    .chat-contact-info { flex: 1; min-width: 0; }
    .contact-name { font-size: 16px; font-weight: 500; color: var(--whatsapp-dark); margin-bottom: 2px; }
    .contact-status { font-size: 13px; color: var(--whatsapp-gray); }

    .messages-container {
        flex: 1; padding: 16px 12%; overflow-y: auto; overflow-x: hidden;
        display: flex; flex-direction: column; position: relative; z-index: 1;
        background: transparent;
        scrollbar-width: thin; scrollbar-color: rgba(54, 9, 88, 0.4) transparent;
    }
    .messages-container::-webkit-scrollbar { width: 6px; }
    .messages-container::-webkit-scrollbar-track { background: rgba(54, 9, 88, 0.08); border-radius: 6px; margin: 8px 0; }
    .messages-container::-webkit-scrollbar-thumb { background: linear-gradient(180deg, var(--whatsapp-primary) 0%, var(--whatsapp-primary-dark) 100%); border-radius: 6px; }

    .message-wrapper { margin-bottom: 4px; max-width: 80%; display: flex; }
    .message-wrapper.sent { justify-content: flex-end; margin-left: auto; }
    .message-wrapper.received { justify-content: flex-start; margin-right: auto; }

    .message-bubble {
        padding: 6px 10px; border-radius: 16px; word-wrap: break-word;
        line-height: 1.35; display: inline-flex; align-items: flex-end;
        gap: 6px; flex-wrap: wrap;
    }
    .sent .message-bubble {
        background: linear-gradient(135deg, var(--whatsapp-primary) 0%, var(--whatsapp-primary-dark) 100%);
        color: white; border-radius: 16px 16px 4px 16px;
    }
    .received .message-bubble {
        background: white; color: var(--whatsapp-dark);
        border-radius: 16px 16px 16px 4px; border: 1px solid var(--whatsapp-border);
    }

    .message-content { font-size: 14px; line-height: 1.35; word-break: break-word; }
    .sent .message-content { color: white; }
    .received .message-content { color: var(--whatsapp-dark); }

    .message-meta { display: inline-flex; align-items: center; gap: 3px; flex-shrink: 0; }
    .message-time { font-size: 10px; opacity: 0.7; }
    .sent .message-time { color: rgba(255, 255, 255, 0.8); }
    .sent .message-meta i { color: rgba(255, 255, 255, 0.8); font-size: 10px; }
    .received .message-time { color: var(--whatsapp-light-gray); }
    .received .message-meta i { color: var(--whatsapp-light-gray); font-size: 10px; }

    .date-separator { text-align: center; margin: 24px 0; clear: both; }
    .date-separator span {
        background: rgba(0, 0, 0, 0.08); color: var(--whatsapp-gray);
        font-size: 12.5px; padding: 8px 16px; border-radius: 20px;
        display: inline-block; font-weight: 500; backdrop-filter: blur(10px);
    }

    .input-area {
        background: var(--whatsapp-input-bg); padding: 10px 16px;
        border-top: 1px solid var(--whatsapp-border); flex-shrink: 0;
        position: relative; z-index: 2;
    }
    .input-wrapper {
        display: flex; align-items: flex-end; gap: 12px; background: white;
        border-radius: 8px; padding: 9px 12px; border: 1px solid var(--whatsapp-border);
        transition: all 0.2s;
    }
    .input-wrapper:focus-within { border-color: var(--whatsapp-primary); box-shadow: 0 0 0 1px var(--whatsapp-primary); outline: none; }

    .input-btn {
        color: var(--whatsapp-light-gray); cursor: pointer; font-size: 24px;
        padding: 8px; transition: color 0.2s; flex-shrink: 0; outline: none;
    }
    .input-btn:hover { color: var(--whatsapp-gray); }

    .message-input {
        flex: 1; border: none; outline: none; background: transparent;
        color: var(--whatsapp-dark); font-size: 15px; line-height: 20px;
        resize: none; max-height: 100px; min-height: 20px; padding: 5px 0;
    }
    .message-input:focus { outline: none; }
    .message-input::placeholder { color: var(--whatsapp-light-gray); }

    .send-btn {
        width: 40px; height: 40px; background: var(--whatsapp-primary);
        border: none; border-radius: 50%; color: white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background 0.2s; flex-shrink: 0; outline: none;
    }
    .send-btn:hover { background: var(--whatsapp-primary-dark); }
    .send-btn:disabled { background: var(--whatsapp-light-gray); cursor: not-allowed; }

    .loading-spinner { display: flex; align-items: center; justify-content: center; padding: 40px; }
    .loading-spinner i { font-size: 32px; color: var(--whatsapp-primary); animation: spin 1s linear infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    @media (max-width: 1024px) {
        .whatsapp-sidebar { width: 40%; min-width: 350px; }
        .messages-container { padding: 20px 10% 16px; }
    }
    @media (max-width: 768px) {
        .whatsapp-container { height: calc(100vh - 100px); min-height: 400px; border-radius: 0; box-shadow: none; }
        .whatsapp-sidebar { width: 100%; min-width: 100%; }
        .whatsapp-sidebar.hidden-mobile { display: none; }
        .chat-area { display: none; }
        .chat-area.active { display: flex; }
        .welcome-icon { width: 200px; height: 200px; }
        .welcome-icon i { font-size: 70px; }
        .welcome-title { font-size: 26px; }
        .filter-tabs { overflow-x: auto; white-space: nowrap; padding-bottom: 4px; }
        .filter-tab { min-width: 100px; }
        .messages-container { padding: 16px 16px 12px; }
        .message-wrapper { max-width: 85%; }
    }
    @media (max-width: 480px) {
        .whatsapp-container { height: calc(100vh - 80px); }
        .sidebar-header { padding: 10px 12px; gap: 16px; }
        .header-actions { gap: 20px; }
        .search-filter-bar { padding: 12px; }
        .chat-item { padding: 12px; }
        .chat-avatar { width: 48px; height: 48px; margin-right: 12px; }
        .chat-avatar i { font-size: 20px; }
        .welcome-icon { width: 160px; height: 160px; }
        .welcome-icon i { font-size: 60px; }
        .welcome-title { font-size: 22px; }
        .welcome-subtitle { font-size: 14px; padding: 0 10px; }
        .new-chat-btn { padding: 14px 24px; font-size: 15px; }
    }
</style>
@endsection

@section('content')
<div class="whatsapp-container">
    <!-- Left Sidebar - Chats List -->
    <div class="whatsapp-sidebar" id="chatsSidebar">
        <div class="sidebar-header">
            <div class="user-avatar" title="{{ Auth::user()->name }}" style="width: 36px; height: 36px; border-radius: 0.75rem; background: linear-gradient(135deg, #360958, #2a0745);">
                <i class="fas fa-user" style="font-size: 14px;"></i>
            </div>
            <div class="header-actions">
                <div class="header-action-btn" title="Anza Mazungumzo Mapya" id="openNewChatBtn" style="border-radius: 0.75rem;">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>

        <div class="search-filter-bar">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Tafuta mazungumzo...">
            </div>

            @php
                $totalUnread = $conversations->sum('unread_count');
            @endphp
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($onlineCount > 0)
                <div class="unread-header-badge" style="background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-circle" style="font-size: 10px;"></i>
                    <span>{{ $onlineCount }} Online</span>
                </div>
                @endif
                <div class="unread-header-badge {{ $totalUnread == 0 ? 'hidden' : '' }}" id="unreadHeaderBadge">
                    <i class="fas fa-envelope"></i>
                    <span id="unreadHeaderCount">{{ $totalUnread }} Isiyosomwa</span>
                </div>
            </div>

            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="contacts">
                    <i class="fas fa-users"></i>
                    <span>Contacts</span>
                </button>
                <button class="filter-tab" data-filter="all">
                    <i class="fas fa-comments"></i>
                    <span>Yote</span>
                </button>
                <button class="filter-tab" data-filter="unread">
                    <i class="fas fa-envelope"></i>
                    <span>Isiyosomwa</span>
                    @if($totalUnread > 0)
                    <span class="chat-unread" style="margin-left: 4px; min-width: 18px; height: 18px; font-size: 10px;">{{ $totalUnread }}</span>
                    @endif
                </button>
            </div>
        </div>

        <div class="chats-list" id="chatsList">
            @foreach($allUsers as $user)
                @php
                    $isOnline = $user->last_seen_at && $user->last_seen_at->diffInMinutes(now()) < 5;
                    $contactUnread = $unreadPerContact[$user->id] ?? 0;
                @endphp
                <div class="chat-item contact-item"
                     data-user-id="{{ $user->id }}"
                     data-user-name="{{ $user->name }}"
                     data-user-role="{{ $user->role->name ?? 'Mwanachama' }}"
                     data-online="{{ $isOnline ? 'true' : 'false' }}"
                     data-unread-count="{{ $contactUnread }}">
                    <div class="chat-avatar">
                        <i class="fas fa-user"></i>
                        <div class="online-indicator {{ $isOnline ? '' : 'offline' }}"></div>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h3 class="chat-name">{{ $user->name }}</h3>
                            <span class="chat-role">{{ $user->role->name ?? 'Mwanachama' }}</span>
                        </div>
                        <div class="chat-preview">
                            <span class="chat-message" style="color: var(--whatsapp-light-gray);">
                                @if($isOnline)
                                    <i class="fas fa-circle" style="color: #22c55e; font-size: 8px; margin-right: 6px;"></i>
                                    Online sasa
                                @else
                                    <i class="fas fa-paper-plane" style="margin-right: 6px;"></i>
                                    Bonyeza kuanza mazungumzo
                                @endif
                            </span>
                        </div>
                    </div>
                    @if($contactUnread > 0)
                        <div class="chat-unread">{{ $contactUnread }}</div>
                    @endif
                </div>
            @endforeach

            @foreach($conversations as $conv)
                @php
                    $convUserOnline = $conv['user']->last_seen_at && $conv['user']->last_seen_at->diffInMinutes(now()) < 5;
                @endphp
                <div class="chat-item conversation-item"
                     data-user-id="{{ $conv['user']->id }}"
                     data-user-name="{{ $conv['user']->name }}"
                     data-user-role="{{ $conv['user']->role->name ?? 'Mwanachama' }}"
                     data-unread="{{ $conv['unread_count'] > 0 ? 'true' : 'false' }}"
                     data-online="{{ $convUserOnline ? 'true' : 'false' }}"
                     style="display: none;">
                    <div class="chat-avatar">
                        <i class="fas fa-user"></i>
                        <div class="online-indicator {{ $convUserOnline ? '' : 'offline' }}"></div>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h3 class="chat-name">{{ $conv['user']->name }}</h3>
                            <span class="chat-time">
                                @php
                                    $created = $conv['last_message']->created_at;
                                    $today = \Carbon\Carbon::today();
                                    $yesterday = \Carbon\Carbon::yesterday();
                                    if ($created->isSameDay($today)) {
                                        echo $created->format('H:i');
                                    } elseif ($created->isSameDay($yesterday)) {
                                        echo 'Jana';
                                    } elseif ($created->isCurrentWeek()) {
                                        echo $created->translatedFormat('l');
                                    } else {
                                        echo $created->format('d/m/Y');
                                    }
                                @endphp
                            </span>
                        </div>
                        <div class="chat-preview">
                            <span class="chat-message">
                                @if($conv['last_message']->sender_id == Auth::id())
                                    <span style="color: var(--whatsapp-gray);">Wewe: </span>
                                @endif
                                {{ Str::limit($conv['last_message']->content, 35) }}
                            </span>
                        </div>
                    </div>
                    @if($conv['unread_count'] > 0)
                        <div class="chat-unread">{{ $conv['unread_count'] }}</div>
                    @endif
                </div>
            @endforeach

            <div class="no-chats-message" id="noResultsMessage" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>Hakuna Matokeo</h3>
                <p>Hakuna mazungumzo yanayolingana na utafutaji wako</p>
            </div>
            <div class="no-chats-message" id="noContactsMessage" style="display: none;">
                <i class="fas fa-users"></i>
                <h3>Hakuna Contacts</h3>
                <p>Hakuna watumiaji wengine wa kuwasiliana nao</p>
            </div>
            <div class="no-chats-message" id="noConversationsMessage" style="display: none;">
                <i class="fas fa-comment-slash" style="color: #22c55e;"></i>
                <h3>Hakuna Mazungumzo</h3>
                <p>Hakuna mazungumzo bado</p>
            </div>
        </div>
    </div>

    <!-- Right Side - Chat Area -->
    <div class="chat-area" id="chatArea">
        <div class="welcome-screen" id="welcomeScreen">
            <div class="welcome-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h1 class="welcome-title">Ujumbe wa Muumini</h1>
            <p class="welcome-subtitle">
                Tuma na kupokea ujumbe bila kuchapishwa. Mazungumzo yako yamehifadhiwa
                kwa usalama wa juu.
            </p>
            <button class="new-chat-btn" id="newChatBtn">
                <i class="fas fa-paper-plane"></i>
                <span>ANZA MAZUNGUMZO MAPYA</span>
            </button>
            <div class="security-info">
                <i class="fas fa-lock"></i>
                <span>Ujumbe wako uko salama</span>
            </div>
        </div>

        <div id="activeChatContainer" style="display: none; flex-direction: column; height: 100%; position: relative; z-index: 1;">
            <div class="chat-area-header">
                <div class="user-avatar" id="chatUserAvatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="chat-contact-info">
                    <div class="contact-name" id="chatUserName">-</div>
                    <div class="contact-status" id="chatUserRole">-</div>
                </div>
                <div class="header-actions">
                    <div class="header-action-btn" id="closeChatBtn" title="Funga">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>

            <div class="messages-container" id="messagesContainer">
                <div class="loading-spinner" id="messagesLoading">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>

            <div class="input-area">
                <form id="messageForm">
                    @csrf
                    <input type="hidden" name="receiver_id" id="receiverId" value="">
                    <div class="input-wrapper">
                        <div class="input-btn">
                            <i class="far fa-smile"></i>
                        </div>
                        <textarea
                            name="content"
                            id="messageContent"
                            rows="1"
                            required
                            class="message-input"
                            placeholder="Andika ujumbe..."
                            autocomplete="off"></textarea>
                        <button type="submit" id="sendBtn" class="send-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendMessageUrl = @json(\Illuminate\Support\Facades\Route::has('messages.send') ? route('messages.send') : url('/panel/messages/send'));
    const filterTabs = document.querySelectorAll('.filter-tab');
    const searchInput = document.getElementById('searchInput');
    const chatArea = document.getElementById('chatArea');
    const welcomeScreen = document.getElementById('welcomeScreen');
    const activeChatContainer = document.getElementById('activeChatContainer');
    const messagesContainer = document.getElementById('messagesContainer');
    const messagesLoading = document.getElementById('messagesLoading');
    const messageForm = document.getElementById('messageForm');
    const messageContent = document.getElementById('messageContent');
    const sendBtn = document.getElementById('sendBtn');
    const receiverId = document.getElementById('receiverId');
    const chatUserName = document.getElementById('chatUserName');
    const chatUserRole = document.getElementById('chatUserRole');
    const chatsSidebar = document.getElementById('chatsSidebar');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const noContactsMessage = document.getElementById('noContactsMessage');
    const noConversationsMessage = document.getElementById('noConversationsMessage');

    let activeFilter = 'contacts';
    let currentUserId = null;
    let lastMessageId = 0;
    let pollingInterval = null;

    filterChats();

    document.getElementById('newChatBtn')?.addEventListener('click', function() {
        const contactsTab = document.querySelector('[data-filter="contacts"]');
        if (contactsTab) contactsTab.click();
    });

    document.getElementById('openNewChatBtn')?.addEventListener('click', function() {
        const contactsTab = document.querySelector('[data-filter="contacts"]');
        if (contactsTab) contactsTab.click();
    });

    function setupChatItemListeners() {
        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', handleChatItemClick);
        });
    }

    function handleChatItemClick(e) {
        const item = e.currentTarget;
        const userId = item.dataset.userId;
        const userName = item.dataset.userName;
        const userRole = item.dataset.userRole;
        const isContact = item.classList.contains('contact-item');

        document.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');

        const unreadBadge = item.querySelector('.chat-unread');
        if (unreadBadge) {
            unreadBadge.remove();
            item.dataset.unread = 'false';
        }

        if (isContact) {
            const existingConv = document.querySelector(`.conversation-item[data-user-id="${userId}"]`);
            if (!existingConv) {
                const newConvItem = document.createElement('div');
                newConvItem.className = 'chat-item conversation-item active';
                newConvItem.dataset.userId = userId;
                newConvItem.dataset.userName = userName;
                newConvItem.dataset.userRole = userRole;
                newConvItem.dataset.unread = 'false';
                newConvItem.innerHTML = `
                    <div class="chat-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="chat-info">
                        <div class="chat-header">
                            <h3 class="chat-name">${escapeHtml(userName)}</h3>
                            <span class="chat-time">Sasa</span>
                        </div>
                        <div class="chat-preview">
                            <span class="chat-message" style="color: var(--whatsapp-light-gray);">
                                Mazungumzo mapya...
                            </span>
                        </div>
                    </div>
                `;
                const firstItem = document.querySelector('.chat-item');
                if (firstItem) {
                    firstItem.parentNode.insertBefore(newConvItem, firstItem);
                } else {
                    document.getElementById('chatsList').appendChild(newConvItem);
                }
                newConvItem.addEventListener('click', handleChatItemClick);
            }
        }

        openChat(userId, userName, userRole);
    }

    setupChatItemListeners();

    function openChat(userId, userName, userRole) {
        currentUserId = userId;
        receiverId.value = userId;
        chatUserName.textContent = userName;
        chatUserRole.textContent = userRole;

        welcomeScreen.style.display = 'none';
        activeChatContainer.style.display = 'flex';

        if (window.innerWidth <= 768) {
            chatsSidebar.classList.add('hidden-mobile');
            chatArea.classList.add('active');
        }

        loadMessages(userId);
        startPolling(userId);

        setTimeout(() => {
            messageContent.focus();
            messageContent.blur();
            setTimeout(() => messageContent.focus(), 100);
        }, 100);
    }

    document.getElementById('closeChatBtn')?.addEventListener('click', function() {
        closeChat();
    });

    function closeChat() {
        currentUserId = null;
        receiverId.value = '';

        welcomeScreen.style.display = 'flex';
        activeChatContainer.style.display = 'none';

        document.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));

        if (window.innerWidth <= 768) {
            chatsSidebar.classList.remove('hidden-mobile');
            chatArea.classList.remove('active');
        }

        stopPolling();
    }

    function loadMessages(userId) {
        messagesLoading.style.display = 'flex';
        messagesContainer.innerHTML = '';
        messagesContainer.appendChild(messagesLoading);

        fetch(`{{ url('panel/messages/conversation') }}/${userId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            messagesLoading.style.display = 'none';
            renderMessages(data.messages);
            lastMessageId = data.last_id || 0;
            scrollToBottom();
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            messagesLoading.innerHTML = '<p style="color: var(--whatsapp-gray);">Hitilafu kutokea. Jaribu tena.</p>';
        });
    }

    function renderMessages(messages) {
        messagesContainer.innerHTML = '';

        if (!messages || messages.length === 0) {
            messagesContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; color: var(--whatsapp-primary);">
                    <i class="fas fa-comment-dots" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Hakuna ujumbe. Anza mazungumzo!</p>
                </div>
            `;
            return;
        }

        let currentDate = null;
        const authId = {{ Auth::id() }};

        messages.forEach(message => {
            const messageDate = new Date(message.created_at).toDateString();

            if (messageDate !== currentDate) {
                currentDate = messageDate;
                const dateLabel = getDateLabel(message.created_at);
                messagesContainer.innerHTML += `
                    <div class="date-separator">
                        <span>${dateLabel}</span>
                    </div>
                `;
            }

            const isSent = message.sender_id === authId;
            const messageTime = formatTime(message.created_at);

            messagesContainer.innerHTML += `
                <div class="message-wrapper ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
                    <div class="message-bubble">
                        <span class="message-content">${escapeHtml(message.content)}</span>
                        <span class="message-meta">
                            <span class="message-time">${messageTime}</span>
                            ${isSent ? `<i class="fas ${message.is_read ? 'fa-check-double' : 'fa-check'}"></i>` : '<i class="fas fa-comment-alt"></i>'}
                        </span>
                    </div>
                </div>
            `;
        });
    }

    messageForm?.addEventListener('submit', function(e) {
        e.preventDefault();

        const content = messageContent.value.trim();
        if (!content || !currentUserId) return;

        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const tempId = 'temp-' + Date.now();
        const now = new Date();
        messagesContainer.innerHTML += `
            <div class="message-wrapper sent" id="${tempId}">
                <div class="message-bubble">
                    <span class="message-content">${escapeHtml(content)}</span>
                    <span class="message-meta">
                        <span class="message-time">${formatTime(now.toISOString())}</span>
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
            </div>
        `;
        scrollToBottom();
        messageContent.value = '';
        messageContent.style.height = 'auto';

        const formData = new FormData(messageForm);
        formData.set('content', content);

        fetch(sendMessageUrl, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tempEl = document.getElementById(tempId);
                if (tempEl && data.message) {
                    tempEl.dataset.messageId = data.message.id;
                    const clockIcon = tempEl.querySelector('.fa-clock');
                    if (clockIcon) clockIcon.className = 'fas fa-check';
                    lastMessageId = data.message.id;
                }
                updateChatListItem(currentUserId, content);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const tempEl = document.getElementById(tempId);
            if (tempEl) {
                const clockIcon = tempEl.querySelector('.fa-clock');
                if (clockIcon) {
                    clockIcon.className = 'fas fa-exclamation-circle';
                    clockIcon.style.color = '#ff6b6b';
                }
            }
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            messageContent.focus();
            setTimeout(() => messageContent.blur(), 10);
            setTimeout(() => messageContent.focus(), 20);
        });
    });

    function updateChatListItem(userId, content) {
        const chatItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
        if (chatItem) {
            const messageEl = chatItem.querySelector('.chat-message');
            if (messageEl) {
                messageEl.innerHTML = `<span style="color: var(--whatsapp-gray);">Wewe: </span>${escapeHtml(content.substring(0, 35))}${content.length > 35 ? '...' : ''}`;
            }
            const timeEl = chatItem.querySelector('.chat-time');
            if (timeEl) timeEl.textContent = formatTime(new Date().toISOString());
            if (chatItem.parentNode) chatItem.parentNode.prepend(chatItem);
        }
    }

    function startPolling(userId) {
        stopPolling();
        pollingInterval = setInterval(() => {
            if (lastMessageId > 0) {
                fetch(`{{ url('panel/messages/conversation') }}/${userId}/new?last_id=${lastMessageId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        const authId = {{ Auth::id() }};
                        data.messages.forEach(message => {
                            if (!document.querySelector(`[data-message-id="${message.id}"]`)) {
                                const isSent = message.sender_id === authId;
                                messagesContainer.innerHTML += `
                                    <div class="message-wrapper ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
                                        <div class="message-bubble">
                                            <span class="message-content">${escapeHtml(message.content)}</span>
                                            <span class="message-meta">
                                                <span class="message-time">${formatTime(message.created_at)}</span>
                                                ${isSent ? `<i class="fas ${message.is_read ? 'fa-check-double' : 'fa-check'}"></i>` : '<i class="fas fa-comment-alt"></i>'}
                                            </span>
                                        </div>
                                    </div>
                                `;
                            }
                        });
                        lastMessageId = data.last_id;
                        if (isNearBottom()) scrollToBottom();
                    }
                })
                .catch(error => console.error('Polling error:', error));
            }
        }, 5000);
    }

    function stopPolling() {
        if (pollingInterval) { clearInterval(pollingInterval); pollingInterval = null; }
    }

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            filterChats();
        });
    });

    searchInput?.addEventListener('input', function() { filterChats(); });

    function filterChats() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        let visibleItems = 0;
        let hasContacts = false;
        let hasConversations = false;

        if (activeFilter === 'contacts') {
            document.querySelectorAll('.conversation-item').forEach(item => { item.style.display = 'none'; });
            document.querySelectorAll('.contact-item').forEach(item => {
                const name = item.dataset.userName?.toLowerCase() || '';
                const role = item.dataset.userRole?.toLowerCase() || '';
                if (searchTerm === '' || name.includes(searchTerm) || role.includes(searchTerm)) {
                    item.style.display = 'flex'; visibleItems++; hasContacts = true;
                } else { item.style.display = 'none'; }
            });
        } else if (activeFilter === 'all') {
            document.querySelectorAll('.contact-item').forEach(item => { item.style.display = 'none'; });
            document.querySelectorAll('.conversation-item').forEach(item => {
                const name = item.dataset.userName?.toLowerCase() || '';
                const message = item.querySelector('.chat-message')?.textContent.toLowerCase() || '';
                if (searchTerm === '' || name.includes(searchTerm) || message.includes(searchTerm)) {
                    item.style.display = 'flex'; visibleItems++; hasConversations = true;
                } else { item.style.display = 'none'; }
            });
        } else if (activeFilter === 'unread') {
            document.querySelectorAll('.contact-item').forEach(item => { item.style.display = 'none'; });
            document.querySelectorAll('.conversation-item').forEach(item => {
                const name = item.dataset.userName?.toLowerCase() || '';
                const message = item.querySelector('.chat-message')?.textContent.toLowerCase() || '';
                const hasUnread = item.dataset.unread === 'true';
                if (hasUnread && (searchTerm === '' || name.includes(searchTerm) || message.includes(searchTerm))) {
                    item.style.display = 'flex'; visibleItems++; hasConversations = true;
                } else { item.style.display = 'none'; }
            });
        }

        noResultsMessage.style.display = (searchTerm !== '' && visibleItems === 0) ? 'block' : 'none';

        if (activeFilter === 'contacts') {
            noContactsMessage.style.display = (!hasContacts && searchTerm === '') ? 'block' : 'none';
            noConversationsMessage.style.display = 'none';
        } else if (activeFilter === 'all') {
            noContactsMessage.style.display = 'none';
            noConversationsMessage.style.display = (!hasConversations && searchTerm === '') ? 'block' : 'none';
            if (!hasConversations && searchTerm === '') {
                noConversationsMessage.innerHTML = `<i class="fas fa-comments" style="color: #22c55e;"></i><h3>Hakuna Mazungumzo</h3><p>Bado hujaanza mazungumzo na mtu yeyote</p>`;
            }
        } else if (activeFilter === 'unread') {
            noContactsMessage.style.display = 'none';
            const unreadCount = Array.from(document.querySelectorAll('.conversation-item')).filter(item => item.dataset.unread === 'true').length;
            noConversationsMessage.style.display = (unreadCount === 0 && searchTerm === '') ? 'block' : 'none';
            if (unreadCount === 0 && searchTerm === '') {
                noConversationsMessage.innerHTML = `<i class="fas fa-check-double" style="color: #22c55e;"></i><h3>Umesoma Yote!</h3><p>Hakuna ujumbe usiosomwa</p>`;
            }
        }
    }

    messageContent?.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    });

    messageContent?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (this.value.trim()) messageForm.dispatchEvent(new Event('submit'));
        }
    });

    function scrollToBottom() { if (messagesContainer) messagesContainer.scrollTop = messagesContainer.scrollHeight; }
    function isNearBottom() { if (!messagesContainer) return false; return messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < 100; }
    function escapeHtml(text) { const div = document.createElement('div'); div.textContent = text; return div.innerHTML; }
    function formatTime(dateString) { const date = new Date(dateString); return date.toLocaleTimeString('sw-TZ', {hour: '2-digit', minute: '2-digit'}); }
    function getDateLabel(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        if (date.toDateString() === today.toDateString()) return 'Leo';
        else if (date.toDateString() === yesterday.toDateString()) return 'Jana';
        else return date.toLocaleDateString('sw-TZ', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            chatsSidebar.classList.remove('hidden-mobile');
            chatArea.classList.remove('active');
        }
    });

    document.addEventListener('focusin', function(e) {
        if (e.target.matches('input, textarea, button, [tabindex]')) {
            e.target.style.outline = 'none';
            e.target.style.boxShadow = 'none';
        }
    });
});
</script>
@endsection
