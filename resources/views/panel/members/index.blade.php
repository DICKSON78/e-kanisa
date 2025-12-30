@extends('layouts.app')

@section('title', 'Waumini - Mfumo wa Kanisa')
@section('page-title', 'Waumini')
@section('page-subtitle', 'Usimamizi wa taarifa za waumini wa kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Waumini wa Kanisa</h1>
            <p class="text-gray-600 mt-2">Usimamizi kamili wa orodha ya waumini wote</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('quick-entry.login') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700" target="_blank">
                <i class="fas fa-qrcode"></i>
                <span class="font-medium">Quick Entry</span>
            </a>
            <a href="{{ route('members.import.form') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                <i class="fas fa-file-upload"></i>
                <span class="font-medium">Ingiza Kwa Wingi</span>
            </a>
            <a href="{{ route('members.create') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800">
                <i class="fas fa-user-plus"></i>
                <span class="font-medium">Sajili Muumini</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumla ya Waumini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Waumini Hai</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-check text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Wanaosubiri Idhini</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['inactive'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-clock text-xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Wanaume</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['male'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-male text-xl text-primary-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Wanawake</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['female'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-pink-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-female text-xl text-pink-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter text-primary-500 mr-2"></i> Chuja Waumini
            </h3>
        </div>
        <form method="GET" action="{{ route('members.index') }}" data-auto-filter="true" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Field -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tafuta</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Tafuta jina, namba, simu, email...">
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jinsia</label>
                    <select name="gender" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                {{ $gender == 'Mme' ? 'Me' : ($gender == 'Mke' ? 'Ke' : $gender) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali</label>
                    <select name="is_active" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Hai</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Si Hai</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Age Group -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kundi la Umri</label>
                    <select name="age_group" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        @foreach($ageGroups as $ageGroup)
                            @php
                                $ageLabel = match($ageGroup) {
                                    'Watoto' => 'Watoto (Chini ya 18)',
                                    'Vijana' => 'Vijana (18-34)',
                                    'Wazima' => 'Wazima (35-59)',
                                    'Wazee' => 'Wazee (60+)',
                                    default => $ageGroup
                                };
                            @endphp
                            <option value="{{ $ageGroup }}" {{ request('age_group') == $ageGroup ? 'selected' : '' }}>
                                {{ $ageLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Special Group -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kundi Maalum</label>
                    <select name="special_group" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        @foreach($specialGroups as $group)
                            <option value="{{ $group }}" {{ request('special_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Marital Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali ya Ndoa</label>
                    <select name="marital_status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Wote</option>
                        @foreach($maritalStatuses as $maritalStatus)
                            <option value="{{ $maritalStatus }}" {{ request('marital_status') == $maritalStatus ? 'selected' : '' }}>
                                {{ $maritalStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="clearFilters()" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Futa Chujio</span>
                </button>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Tumia Chujio</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-primary-500 mr-2"></i> Orodha ya Waumini
                    <span class="ml-3 text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $members->total() }} waumini
                    </span>
                </h3>
            </div>
            <div class="mt-3 sm:mt-0">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500"></i>
                    <span>Angalia au hariri taarifa kwa kubofya vitendo</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-primary-600 text-white text-sm">
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-hashtag mr-2"></i>
                                Namba
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Jina
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-venus-mars mr-2"></i>
                                Jinsia
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                Simu
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                Email
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Uanachama
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-circle mr-2"></i>
                                Hali
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider sticky right-0 bg-primary-600">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                Vitendo
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                    <tr class="bg-white hover:bg-gray-50 transition-all duration-200 member-row"
                        data-name="{{ strtolower($member->first_name . ' ' . $member->middle_name . ' ' . $member->last_name) }}"
                        data-phone="{{ strtolower($member->phone ?? '') }}"
                        data-email="{{ strtolower($member->email ?? '') }}"
                        data-member-number="{{ strtolower($member->member_number ?? '') }}"
                        data-gender="{{ $member->gender }}"
                        data-age-group="{{ $member->age_group ?? '' }}"
                        data-special-group="{{ $member->special_group ?? '' }}"
                        data-marital-status="{{ $member->marital_status ?? '' }}"
                        data-is-active="{{ $member->is_active ? '1' : '0' }}">
                        <!-- Member Number -->
                        <td class="py-4 px-6 text-sm font-medium text-gray-900">
                            <div class="flex items-center gap-2">
                                <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $member->member_number }}</span>
                                <button onclick="viewQrCode('{{ $member->id }}', '{{ $member->member_number }}')"
                                        class="text-primary-600 hover:text-primary-800 transition-colors"
                                        title="Angalia QR Code">
                                    <i class="fas fa-qrcode"></i>
                                </button>
                            </div>
                        </td>

                        <!-- Name -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">
                                {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}
                            </div>
                        </td>

                        <!-- Gender -->
                        <td class="py-4 px-6 text-sm text-gray-600">
                            @if($member->gender == 'Mme')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-male mr-1"></i> Me
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                    <i class="fas fa-female mr-1"></i> Ke
                                </span>
                            @endif
                        </td>

                        <!-- Phone -->
                        <td class="py-4 px-6 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-gray-400"></i>
                                {{ $member->phone }}
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="py-4 px-6 text-sm text-gray-600">
                            <div class="flex items-center gap-2 max-w-[180px]">
                                <i class="fas fa-envelope text-gray-400 flex-shrink-0"></i>
                                @if($member->email)
                                    <span class="truncate" title="{{ $member->email }}">{{ $member->email }}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </div>
                        </td>

                        <!-- Membership Date -->
                        <td class="py-4 px-6 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($member->membership_date)->format('d/m/Y') }}
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-6 text-sm">
                            @if($member->is_active)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">
                                    <i class="fas fa-check-circle mr-1"></i>Hai
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 whitespace-nowrap">
                                    <i class="fas fa-clock mr-1"></i>Inasubiri Idhini
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-6 text-sm sticky right-0 bg-white">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('members.show', $member->id) }}"
                                   class="h-8 w-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all duration-200"
                                   title="Angalia Maelezo">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('members.edit', $member->id) }}"
                                   class="h-8 w-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center hover:bg-primary-200 transition-all duration-200"
                                   title="Hariri">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                @if($member->is_active)
                                <button type="button"
                                        onclick="confirmAction('deactivate', {{ $member->id }}, '{{ $member->full_name }}')"
                                        class="h-8 w-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center hover:bg-yellow-200 transition-all duration-200"
                                        title="Simamisha">
                                    <i class="fas fa-user-slash text-sm"></i>
                                </button>
                                @else
                                <button type="button"
                                        onclick="confirmAction('activate', {{ $member->id }}, '{{ $member->full_name }}')"
                                        class="h-8 w-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-all duration-200"
                                        title="Anzisha">
                                    <i class="fas fa-user-check text-sm"></i>
                                </button>
                                @endif
                                <button type="button"
                                        onclick="confirmAction('delete', {{ $member->id }}, '{{ $member->full_name }}')"
                                        class="h-8 w-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-all duration-200"
                                        title="Futa">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>

                                <!-- Hidden Forms -->
                                <form id="deactivate-form-{{ $member->id }}" action="{{ route('members.deactivate', $member->id) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <form id="activate-form-{{ $member->id }}" action="{{ route('members.activate', $member->id) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <form id="delete-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 px-6 text-center">
                            <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna waumini waliopatikana</h3>
                            <p class="text-gray-500 mb-6">Hakuna waumini wanaolingana na vichujio vyako.</p>
                            <a href="{{ route('members.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-200">
                                <i class="fas fa-user-plus mr-2"></i> Sajili Muumini Mpya
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Confirm Action Modal -->
<div id="confirmActionModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="confirmActionModalContent">
        <div class="p-6 text-center">
            <div id="confirmActionIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="confirmActionIconClass" class="text-3xl"></i>
            </div>
            <h3 id="confirmActionTitle" class="text-xl font-bold text-gray-900 mb-2">Thibitisha</h3>
            <p id="confirmActionMessage" class="text-gray-600 mb-2">Je, una uhakika?</p>
            <p id="confirmActionName" class="text-lg font-semibold mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeConfirmActionModal()" class="flex-1 px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-all">
                    <i class="fas fa-times mr-2"></i>Ghairi
                </button>
                <button id="confirmActionBtn" class="flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2">
                    <i id="confirmActionBtnIcon" class="fas fa-check"></i>
                    <span id="confirmActionBtnText">Thibitisha</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Modal (Success/Warning/Error) -->
<div id="memberAlertModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="memberAlertModalContent">
        <div class="p-6 text-center">
            <div id="memberAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="memberAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="memberAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="memberAlertMessage" class="text-gray-600 mb-6">Ujumbe hapa</p>
            <button onclick="closeMemberAlertModal()" class="w-full px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-all">
                <i class="fas fa-check mr-2"></i>Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-qrcode text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">QR Code ya Muumini</h3>
                        <p class="text-sm text-gray-600">Scan kupata taarifa za muumini</p>
                    </div>
                </div>
                <button type="button" onclick="closeQrModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6 text-center">
            <div class="mb-4">
                <p class="text-gray-700 mb-1">Namba ya Muumini:</p>
                <p class="text-2xl font-bold text-primary-600" id="qrMemberNumber"></p>
            </div>

            <div id="qrCodeContainer" class="flex justify-center items-center bg-white p-6 rounded-xl border-2 border-gray-200 mb-4">
                <!-- QR Code will be loaded here -->
            </div>

            <p class="text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i> Tumia QR code hii kwa ajili ya usajili wa haraka
            </p>
        </div>

        <!-- Modal Footer -->
        <div class="sticky bottom-0 bg-gray-50 px-6 py-5 rounded-b-xl border-t border-gray-200 flex justify-end space-x-3">
            <button onclick="printQrCode()" class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-print"></i>
                <span>Print</span>
            </button>
            <button onclick="closeQrModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-all duration-200">
                Funga
            </button>
        </div>
    </div>
</div>

<script>
// ========================================
// Confirm Action Modal Functions
// ========================================
let currentAction = null;
let currentMemberId = null;

function confirmAction(action, memberId, memberName) {
    currentAction = action;
    currentMemberId = memberId;

    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    const iconContainer = document.getElementById('confirmActionIcon');
    const iconClass = document.getElementById('confirmActionIconClass');
    const title = document.getElementById('confirmActionTitle');
    const message = document.getElementById('confirmActionMessage');
    const nameEl = document.getElementById('confirmActionName');
    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    // Configure based on action type
    if (action === 'delete') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100';
        iconClass.className = 'fas fa-trash-alt text-3xl text-red-600';
        title.textContent = 'Thibitisha Kufuta';
        message.textContent = 'Je, una uhakika unataka kufuta muumini huyu? Hatua hii haiwezi kutenduliwa.';
        nameEl.textContent = memberName;
        nameEl.className = 'text-lg font-semibold mb-6 text-red-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700';
        btnIcon.className = 'fas fa-trash';
        btnText.textContent = 'Futa';
    } else if (action === 'deactivate') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-yellow-100';
        iconClass.className = 'fas fa-user-slash text-3xl text-yellow-600';
        title.textContent = 'Thibitisha Kusimamisha';
        message.textContent = 'Je, una uhakika unataka kumsimamisha muumini huyu?';
        nameEl.textContent = memberName;
        nameEl.className = 'text-lg font-semibold mb-6 text-yellow-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-yellow-600 hover:bg-yellow-700';
        btnIcon.className = 'fas fa-user-slash';
        btnText.textContent = 'Simamisha';
    } else if (action === 'activate') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100';
        iconClass.className = 'fas fa-user-check text-3xl text-green-600';
        title.textContent = 'Thibitisha Kuanzisha';
        message.textContent = 'Je, una uhakika unataka kumwanzisha muumini huyu?';
        nameEl.textContent = memberName;
        nameEl.className = 'text-lg font-semibold mb-6 text-green-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700';
        btnIcon.className = 'fas fa-user-check';
        btnText.textContent = 'Anzisha';
    }

    // Set button click handler
    btn.onclick = function() {
        executeAction();
    };

    // Show modal
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeConfirmActionModal() {
    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');

    content.classList.remove('scale-100');
    content.classList.add('scale-95');

    setTimeout(() => {
        modal.classList.add('hidden');
        currentAction = null;
        currentMemberId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentMemberId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    // Show loading state
    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    // Submit the appropriate form
    const formId = `${currentAction}-form-${currentMemberId}`;
    const form = document.getElementById(formId);

    if (form) {
        form.submit();
    } else {
        showMemberAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

// ========================================
// Alert Modal Functions
// ========================================
function showMemberAlert(type, title, message) {
    const modal = document.getElementById('memberAlertModal');
    const content = document.getElementById('memberAlertModalContent');
    const iconContainer = document.getElementById('memberAlertIcon');
    const iconClass = document.getElementById('memberAlertIconClass');
    const titleEl = document.getElementById('memberAlertTitle');
    const messageEl = document.getElementById('memberAlertMessage');

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

    const config = configs[type] || configs['info'];

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

function closeMemberAlertModal() {
    const modal = document.getElementById('memberAlertModal');
    const content = document.getElementById('memberAlertModalContent');

    content.classList.remove('scale-100');
    content.classList.add('scale-95');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close modals on backdrop click
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('memberAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMemberAlertModal();
});

// ========================================
// Live Search Functionality
// ========================================
let searchTimeout;

function filterMembers() {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        const searchValue = document.querySelector('input[name="search"]').value.toLowerCase();
        const genderValue = document.querySelector('select[name="gender"]').value;
        const ageGroupValue = document.querySelector('select[name="age_group"]').value;
        const specialGroupValue = document.querySelector('select[name="special_group"]').value;
        const maritalStatusValue = document.querySelector('select[name="marital_status"]').value;
        const isActiveValue = document.querySelector('select[name="is_active"]').value;

        const rows = document.querySelectorAll('.member-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const phone = row.getAttribute('data-phone') || '';
            const email = row.getAttribute('data-email') || '';
            const memberNumber = row.getAttribute('data-member-number') || '';
            const gender = row.getAttribute('data-gender') || '';
            const ageGroup = row.getAttribute('data-age-group') || '';
            const specialGroup = row.getAttribute('data-special-group') || '';
            const maritalStatus = row.getAttribute('data-marital-status') || '';
            const isActive = row.getAttribute('data-is-active') || '';

            // Check if row matches search criteria
            const matchesSearch = searchValue === '' ||
                name.includes(searchValue) ||
                phone.includes(searchValue) ||
                email.includes(searchValue) ||
                memberNumber.includes(searchValue);

            const matchesGender = genderValue === '' || gender === genderValue;
            const matchesAgeGroup = ageGroupValue === '' || ageGroup === ageGroupValue;
            const matchesSpecialGroup = specialGroupValue === '' || specialGroup === specialGroupValue;
            const matchesMaritalStatus = maritalStatusValue === '' || maritalStatus === maritalStatusValue;
            const matchesIsActive = isActiveValue === '' || isActive === isActiveValue;

            // Show or hide row based on all criteria
            if (matchesSearch && matchesGender && matchesAgeGroup && matchesSpecialGroup && matchesMaritalStatus && matchesIsActive) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update count or show "no results" message if needed
        console.log(`Waumini ${visibleCount} wanaoonekana`);
    }, 300); // 300ms debounce
}

// Clear all filters
function clearFilters() {
    document.querySelector('input[name="search"]').value = '';
    document.querySelector('select[name="gender"]').value = '';
    document.querySelector('select[name="age_group"]').value = '';
    document.querySelector('select[name="special_group"]').value = '';
    document.querySelector('select[name="marital_status"]').value = '';
    document.querySelector('select[name="is_active"]').value = '';
    filterMembers();
}

// Add event listeners to all filter inputs
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const filterSelects = document.querySelectorAll('select[name="gender"], select[name="age_group"], select[name="special_group"], select[name="marital_status"], select[name="is_active"]');

    // Live search on input
    if (searchInput) {
        searchInput.addEventListener('input', filterMembers);
    }

    // Live filter on select change
    filterSelects.forEach(select => {
        select.addEventListener('change', filterMembers);
    });

    // Prevent form submission on Enter key in search field
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });
    }

    // Remove data-auto-filter attribute to prevent auto-submission
    const filterForm = document.querySelector('form[data-auto-filter]');
    if (filterForm) {
        filterForm.removeAttribute('data-auto-filter');
        // Prevent form submission
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            return false;
        });
    }
});

// QR Code Functions
function viewQrCode(memberId, memberNumber) {
    document.getElementById('qrMemberNumber').textContent = memberNumber;
    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '<div class="text-gray-500 py-8"><i class="fas fa-spinner fa-spin text-4xl"></i><p class="mt-2 text-sm">Inapakia QR code...</p></div>';

    // Load QR code
    const qrUrl = `/panel/members/${memberId}/qrcode`;
    fetch(qrUrl)
        .then(response => response.text())
        .then(svg => {
            qrContainer.innerHTML = svg;
            document.getElementById('qrCodeModal').classList.remove('hidden');
            setTimeout(() => {
                document.querySelector('#qrCodeModal > div').classList.remove('scale-95');
            }, 10);
        })
        .catch(error => {
            console.error('Error loading QR code:', error);
            qrContainer.innerHTML = '<p class="text-red-500 py-4"><i class="fas fa-exclamation-triangle mr-2"></i>Kuna hitilafu katika kupakua QR code</p>';
        });
}

function closeQrModal() {
    const modal = document.getElementById('qrCodeModal');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function printQrCode() {
    const memberNumber = document.getElementById('qrMemberNumber').textContent;
    const qrCode = document.getElementById('qrCodeContainer').innerHTML;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>QR Code - ${memberNumber}</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        text-align: center;
                        padding: 40px 20px;
                        background: white;
                    }
                    h1 {
                        color: #360958;
                        font-size: 24px;
                        margin-bottom: 10px;
                    }
                    h2 {
                        color: #666;
                        font-size: 16px;
                        margin-bottom: 30px;
                    }
                    .qr-container {
                        display: inline-block;
                        border: 3px solid #360958;
                        padding: 30px;
                        margin: 30px 0;
                        border-radius: 10px;
                        background: white;
                    }
                    .footer {
                        color: #666;
                        font-size: 14px;
                        margin-top: 20px;
                    }
                    @media print {
                        @page { margin: 20mm; }
                    }
                </style>
            </head>
            <body>
                <h1>KKKT Makabe Agape</h1>
                <h2>QR Code ya Muumini</h2>
                <h1 style="font-size: 28px; color: #360958; font-weight: bold; margin: 10px 0;">${memberNumber}</h1>
                <div class="qr-container">${qrCode}</div>
                <p class="footer">Scan QR code hii kupata taarifa za muumini</p>
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    }
                <\/script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

// Close QR modal when clicking outside
document.getElementById('qrCodeModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeQrModal();
});

// Close all modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeMemberAlertModal();
        closeQrModal();
    }
});

// Show flash messages as modals
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showMemberAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
    });
@endif

@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        showMemberAlert('error', 'Hitilafu!', '{{ session('error') }}');
    });
@endif

@if(session('warning'))
    document.addEventListener('DOMContentLoaded', function() {
        showMemberAlert('warning', 'Onyo!', '{{ session('warning') }}');
    });
@endif
</script>
@endsection
