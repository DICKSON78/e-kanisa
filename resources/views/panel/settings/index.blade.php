@extends('layouts.app')

@section('title', 'Mipangilio - Mfumo wa E-Kanisa')
@section('page-title', 'Mipangilio')
@section('page-subtitle', 'Simamia mipangilio ya mfumo')

@section('styles')
<style>
    .settings-container { opacity: 1; transition: opacity 0.2s ease; }
    .tab-btn {
        display: inline-flex; align-items: center; padding: 1rem 1.5rem;
        font-size: 0.875rem; font-weight: 500; border-bottom-width: 2px;
        white-space: nowrap; transition: all 0.2s ease;
    }
    .tab-content { padding: 1.5rem; }
</style>
@endsection

@section('content')
<div class="space-y-6 settings-container">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-cog" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Mipangilio</h1>
                <p class="text-sm text-gray-500">Simamia mipangilio ya akaunti yako na mfumo</p>
            </div>
        </div>
    </div>

    <!-- Tabs Card -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-100 bg-gray-50">
            <nav class="flex -mb-px overflow-x-auto p-1 gap-1">
                @if(!Auth::user()->isMwanachama())
                <button onclick="switchTab('church')" id="tab-church" class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent rounded-xl text-gray-500 hover:text-gray-700 hover:bg-white whitespace-nowrap transition-all duration-200">
                    <i class="fas fa-church mr-2"></i>Kanisa
                </button>
                <button onclick="switchTab('profile')" id="tab-profile" class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent rounded-xl text-gray-500 hover:text-gray-700 hover:bg-white whitespace-nowrap transition-all duration-200">
                    <i class="fas fa-user mr-2"></i>Wasifu
                </button>
                @else
                <button onclick="switchTab('profile')" id="tab-profile" class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent rounded-xl text-gray-500 hover:text-gray-700 hover:bg-white whitespace-nowrap transition-all duration-200">
                    <i class="fas fa-user mr-2"></i>Wasifu
                </button>
                @endif
                <button onclick="switchTab('password')" id="tab-password" class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent rounded-xl text-gray-500 hover:text-gray-700 hover:bg-white whitespace-nowrap transition-all duration-200">
                    <i class="fas fa-key mr-2"></i>Nywila
                </button>
                @if(Auth::user()->isMchungaji())
                <button onclick="switchTab('jumuiya')" id="tab-jumuiya" class="tab-btn px-5 py-3 text-sm font-semibold border-b-2 border-transparent rounded-xl text-gray-500 hover:text-gray-700 hover:bg-white whitespace-nowrap transition-all duration-200">
                    <i class="fas fa-users-cog mr-2"></i>Jumuiya
                </button>
                @endif
            </nav>
        </div>

        <!-- Church Settings Tab -->
        @if(!Auth::user()->isMwanachama())
        <div id="content-church" class="tab-content p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-church" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Taarifa za Kanisa</h3>
                    <p class="text-sm text-gray-500">Sasisha taarifa za kanisa lako</p>
                </div>
            </div>
            <form action="{{ route('settings.church.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Jina la Kanisa *</label>
                        <input type="text" name="church_name" value="{{ old('church_name', \App\Models\Setting::get('church_name', 'KANISA LA KIINJILI LA KILUTHERI TANZANIA')) }}" required
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Dayosisi</label>
                        <input type="text" name="diocese" value="{{ old('diocese', \App\Models\Setting::get('diocese', 'DAYOSISI YA MASHARIKI NA PWANI')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Jimbo</label>
                        <input type="text" name="district" value="{{ old('district', \App\Models\Setting::get('district', 'JIMBO LA MAGHARIBI')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Usharika</label>
                        <input type="text" name="parish" value="{{ old('parish', \App\Models\Setting::get('parish', 'USHARIKA WA MAKABE')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Mtaa</label>
                        <input type="text" name="mtaa" value="{{ old('mtaa', \App\Models\Setting::get('mtaa', 'MTAA WA AGAPE')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Simu</label>
                        <input type="text" name="church_phone" value="{{ old('church_phone', \App\Models\Setting::get('church_phone')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Barua Pepe</label>
                        <input type="email" name="church_email" value="{{ old('church_email', \App\Models\Setting::get('church_email')) }}"
                               class="rx-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Tovuti</label>
                        <input type="url" name="church_website" value="{{ old('church_website', \App\Models\Setting::get('church_website')) }}"
                               class="rx-input">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Anwani</label>
                    <textarea name="church_address" rows="3" class="rx-input">{{ old('church_address', \App\Models\Setting::get('church_address')) }}</textarea>
                </div>

                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Hifadhi Mabadiliko
                </button>
            </form>
        </div>
        @endif

        <!-- Profile Settings Tab -->
        <div id="content-profile" class="tab-content p-6 {{ Auth::user()->isMwanachama() ? '' : 'hidden' }}">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-user" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Wasifu Wako</h3>
                    <p class="text-sm text-gray-500">Sasisha taarifa zako za binafsi</p>
                </div>
            </div>
            <form action="{{ route('settings.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Jina Kamili *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="rx-input">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Barua Pepe *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="rx-input">
                </div>

                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Sasisha Wasifu
                </button>
            </form>
        </div>

        <!-- Password Settings Tab -->
        <div id="content-password" class="tab-content p-6 hidden">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-key" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Badilisha Nywila</h3>
                    <p class="text-sm text-gray-500">Sasisha nywila yako ya akaunti</p>
                </div>
            </div>

            @if(Auth::user()->needsPasswordChange())
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">Badilisha Nywila Yako</h4>
                        <p class="mt-1 text-sm text-yellow-700">Unatumia nywila ya msingi. Tafadhali badilisha nywila yako kwa usalama zaidi.</p>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('settings.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nywila ya Sasa *</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" required
                               class="rx-input pr-10 @error('current_password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nywila Mpya *</label>
                    <div class="relative">
                        <input type="password" name="password" id="new_password" required
                               class="rx-input pr-10 @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword('new_password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="new_password_icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-xs font-medium text-gray-700 mb-2">Nywila lazima iwe na:</p>
                        <ul class="text-xs text-gray-600 space-y-1">
                            <li id="req-length" class="flex items-center"><i class="fas fa-circle text-gray-300 mr-2 text-[6px]"></i>Angalau herufi 6</li>
                            <li id="req-upper" class="flex items-center"><i class="fas fa-circle text-gray-300 mr-2 text-[6px]"></i>Herufi kubwa (A-Z)</li>
                            <li id="req-lower" class="flex items-center"><i class="fas fa-circle text-gray-300 mr-2 text-[6px]"></i>Herufi ndogo (a-z)</li>
                            <li id="req-number" class="flex items-center"><i class="fas fa-circle text-gray-300 mr-2 text-[6px]"></i>Nambari (0-9)</li>
                            <li id="req-special" class="flex items-center"><i class="fas fa-circle text-gray-300 mr-2 text-[6px]"></i>Alama maalum (!@#$%^&*)</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Thibitisha Nywila Mpya *</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="rx-input pr-10">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="password_confirmation_icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-key"></i> Badilisha Nywila
                </button>
            </form>
        </div>

        <!-- Jumuiya Settings Tab -->
        @if(Auth::user()->isMchungaji())
        <div id="content-jumuiya" class="tab-content p-6 hidden">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-users-cog" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Usimamizi wa Jumuiya</h3>
                        <p class="text-sm text-gray-500">Ongeza, hariri au futa jumuiya za kanisa</p>
                    </div>
                </div>
                <button onclick="openCreateJumuiyaModal()" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ongeza Jumuiya</span>
                </button>
            </div>

            <!-- Stats Cards -->
            @php
                $totalJumuiyas = count($jumuiyas ?? []);
                $activeJumuiyas = collect($jumuiyas ?? [])->where('is_active', true)->count();
                $totalMembersInJumuiyas = collect($jumuiyas ?? [])->sum(function($j) { return $j->members()->count(); });
                $jumuiyasWithLeaders = collect($jumuiyas ?? [])->whereNotNull('leader_id')->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Jumuiya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalJumuiyas }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                            <i class="fas fa-layer-group" style="color: #3b82f6"></i>
                        </div>
                    </div>
                </div>

                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Jumuiya Hai</p>
                            <p class="text-2xl font-bold" style="color: #16a34a">{{ $activeJumuiyas }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                            <i class="fas fa-check-circle" style="color: #16a34a"></i>
                        </div>
                    </div>
                </div>

                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Wanachama Wote</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalMembersInJumuiyas }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                            <i class="fas fa-users" style="color: #360958"></i>
                        </div>
                    </div>
                </div>

                <div class="rx-stat-card rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Zina Viongozi</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $jumuiyasWithLeaders }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.1)">
                            <i class="fas fa-user-tie" style="color: #f59e0b"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumuiya Table -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <!-- Table Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-list text-xs" style="color: #efc120"></i>
                        </div>
                        <h4 class="text-sm font-semibold text-gray-900">Orodha ya Jumuiya</h4>
                        <span class="rx-badge rx-badge-default">{{ $totalJumuiyas }} jumuiya</span>
                    </div>
                    <div class="mt-2 sm:mt-0 flex items-center gap-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                        <span>Bofya vitendo kuangalia au kuhariri</span>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="rx-table w-full" id="jumuiyaTable">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">
                                    <div class="flex items-center"><i class="fas fa-users mr-2"></i> Jina la Jumuiya</div>
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">
                                    <div class="flex items-center"><i class="fas fa-user-tie mr-2"></i> Kiongozi</div>
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">
                                    <div class="flex items-center"><i class="fas fa-user-friends mr-2"></i> Wanachama</div>
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">
                                    <div class="flex items-center"><i class="fas fa-circle mr-2"></i> Hali</div>
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">
                                    <div class="flex items-center"><i class="fas fa-cogs mr-2"></i> Vitendo</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="jumuiyaTableBody">
                            @forelse($jumuiyas ?? [] as $jumuiya)
                            <tr class="bg-white hover:bg-gray-50 transition-all duration-200" id="jumuiya-row-{{ $jumuiya->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 flex-shrink-0" style="background: rgba(54,9,88,0.08)">
                                            <i class="fas fa-users" style="color: #360958"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $jumuiya->name }}</div>
                                            <div class="text-sm text-gray-500 flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                                {{ $jumuiya->location ?? 'Hakuna eneo' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($jumuiya->leader)
                                        <div class="text-sm text-gray-900 font-medium">{{ $jumuiya->leader->full_name }}</div>
                                        <div class="text-xs text-gray-500 flex items-center">
                                            <i class="fas fa-phone mr-1"></i>
                                            {{ $jumuiya->leader_phone ?? '-' }}
                                        </div>
                                    @else
                                        <span class="rx-badge rx-badge-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Hakuna Kiongozi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rx-badge rx-badge-info">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $jumuiya->members_count ?? $jumuiya->members()->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($jumuiya->is_active)
                                        <span class="rx-badge rx-badge-success">
                                            <i class="fas fa-check-circle mr-1"></i> Hai
                                        </span>
                                    @else
                                        <span class="rx-badge rx-badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i> Si Hai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="openShowJumuiyaModal({{ $jumuiya->id }})"
                                           class="rx-icon-btn rx-icon-btn-blue"
                                           title="Angalia Maelezo">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button onclick="openEditJumuiyaModal({{ $jumuiya->id }})"
                                           class="rx-icon-btn rx-icon-btn-purple"
                                           title="Hariri">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button onclick="confirmDeleteJumuiya({{ $jumuiya->id }}, '{{ $jumuiya->name }}', {{ $jumuiya->members()->count() }})"
                                                class="rx-icon-btn rx-icon-btn-red"
                                                title="Futa">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="empty-jumuiya-row">
                                <td colspan="5" class="py-12 px-6 text-center">
                                    <div class="rx-empty">
                                        <div class="rx-empty-icon">
                                            <i class="fas fa-users-slash text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="rx-empty-title">Hakuna jumuiya zilizosajiliwa</h3>
                                        <p class="rx-empty-description">Anza kwa kuongeza jumuiya ya kwanza</p>
                                        <button onclick="openCreateJumuiyaModal()" class="rx-btn rx-btn-primary">
                                            <i class="fas fa-plus"></i> Ongeza Jumuiya Mpya
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('modals')
@if(Auth::user()->isMchungaji())
<!-- Create Jumuiya Modal -->
<div id="createJumuiyaModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95" id="createJumuiyaModalContent">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-plus" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Ongeza Jumuiya Mpya</h3>
                </div>
                <button onclick="closeCreateJumuiyaModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form id="createJumuiyaForm" onsubmit="submitCreateJumuiya(event)">
            @csrf
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Jina la Jumuiya *</label>
                    <input type="text" name="name" id="create_jumuiya_name" required
                           class="rx-input" placeholder="Mfano: Jumuiya ya Upendo">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Eneo/Mtaa</label>
                    <input type="text" name="location" id="create_jumuiya_location"
                           class="rx-input" placeholder="Mfano: Mtaa wa Agape">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kiongozi wa Jumuiya</label>
                    <select name="leader_id" id="create_jumuiya_leader" class="rx-select">
                        <option value="">-- Chagua Kiongozi --</option>
                        @foreach(\App\Models\Member::where('is_active', true)->orderBy('first_name')->get() as $member)
                            <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo</label>
                    <textarea name="description" id="create_jumuiya_description" rows="3"
                              class="rx-input" placeholder="Maelezo mafupi kuhusu jumuiya..."></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="create_jumuiya_active" value="1" checked
                           class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="create_jumuiya_active" class="ml-2 text-sm text-gray-700">Jumuiya hai (inafanya kazi)</label>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeCreateJumuiyaModal()" class="rx-btn rx-btn-secondary">
                        Ghairi
                    </button>
                    <button type="submit" id="createJumuiyaBtn" class="rx-btn rx-btn-primary">
                        <i class="fas fa-save"></i>
                        <span>Hifadhi</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Jumuiya Modal -->
<div id="editJumuiyaModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95" id="editJumuiyaModalContent">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-edit" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Hariri Jumuiya</h3>
                </div>
                <button onclick="closeEditJumuiyaModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form id="editJumuiyaForm" onsubmit="submitEditJumuiya(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_jumuiya_id" name="id">
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Jina la Jumuiya *</label>
                    <input type="text" name="name" id="edit_jumuiya_name" required class="rx-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Eneo/Mtaa</label>
                    <input type="text" name="location" id="edit_jumuiya_location" class="rx-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kiongozi wa Jumuiya</label>
                    <select name="leader_id" id="edit_jumuiya_leader" class="rx-select">
                        <option value="">-- Chagua Kiongozi --</option>
                        @foreach(\App\Models\Member::where('is_active', true)->orderBy('first_name')->get() as $member)
                            <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo</label>
                    <textarea name="description" id="edit_jumuiya_description" rows="3" class="rx-input"></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="edit_jumuiya_active" value="1"
                           class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="edit_jumuiya_active" class="ml-2 text-sm text-gray-700">Jumuiya hai (inafanya kazi)</label>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditJumuiyaModal()" class="rx-btn rx-btn-secondary">
                        Ghairi
                    </button>
                    <button type="submit" id="editJumuiyaBtn" class="rx-btn rx-btn-primary">
                        <i class="fas fa-save"></i>
                        <span>Sasisha</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Show Jumuiya Modal -->
<div id="showJumuiyaModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95" id="showJumuiyaModalContent">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-users" style="color: #3b82f6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" id="show_jumuiya_name">Jumuiya</h3>
                        <p class="text-sm text-gray-500" id="show_jumuiya_location"></p>
                    </div>
                </div>
                <button onclick="closeShowJumuiyaModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-medium text-gray-500 mb-1">Kiongozi</div>
                    <div class="font-medium text-gray-900" id="show_jumuiya_leader">-</div>
                    <div class="text-sm text-gray-500" id="show_jumuiya_leader_phone"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-medium text-gray-500 mb-1">Wanachama</div>
                    <div class="font-medium text-gray-900" id="show_jumuiya_members_count">0</div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-medium text-gray-500 mb-1">Hali</div>
                    <div id="show_jumuiya_status"></div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs font-medium text-gray-500 mb-1">Tarehe ya Kuundwa</div>
                    <div class="font-medium text-gray-900" id="show_jumuiya_created">-</div>
                </div>
            </div>
            <div class="mb-6" id="show_jumuiya_description_section">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Maelezo</h4>
                <p class="text-gray-600 bg-gray-50 rounded-xl p-4" id="show_jumuiya_description">-</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Orodha ya Wanachama</h4>
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Jina</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Namba</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Simu</th>
                            </tr>
                        </thead>
                        <tbody id="show_jumuiya_members_list" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">Inapakia...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
            <div class="flex justify-end">
                <button type="button" onclick="closeShowJumuiyaModal()" class="rx-btn rx-btn-secondary">
                    Funga
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Modal -->
<div id="jumuiyaAlertModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="jumuiyaAlertModalContent">
        <div class="p-6 text-center">
            <div id="jumuiyaAlertIcon" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-yellow-100">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
            </div>
            <h3 id="jumuiyaAlertTitle" class="text-lg font-bold text-gray-900 mb-2">Onyo</h3>
            <p id="jumuiyaAlertMessage" class="text-gray-600 mb-6">Ujumbe wa onyo</p>
            <button onclick="closeJumuiyaAlertModal()" class="rx-btn rx-btn-primary w-full">
                Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="jumuiyaConfirmModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="jumuiyaConfirmModalContent">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-red-600 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Thibitisha Kufuta</h3>
            <p class="text-gray-600 mb-2">Je, una uhakika unataka kufuta jumuiya:</p>
            <p class="text-lg font-semibold text-red-600 mb-6" id="confirmJumuiyaName">Jina la Jumuiya</p>
            <div class="flex gap-3">
                <button onclick="closeJumuiyaConfirmModal()" class="flex-1 rx-btn rx-btn-secondary">
                    <i class="fas fa-times mr-2"></i>Ghairi
                </button>
                <button id="confirmDeleteBtn" class="flex-1 rx-btn rx-btn-danger">
                    <i class="fas fa-trash mr-2"></i>Futa Jumuiya
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '_icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('border-primary-500', 'text-primary-600', 'bg-white');
        el.classList.add('border-transparent', 'text-gray-500');
    });

    const content = document.getElementById('content-' + tabName);
    const tab = document.getElementById('tab-' + tabName);

    if (content && tab) {
        content.classList.remove('hidden');
        tab.classList.remove('border-transparent', 'text-gray-500');
        tab.classList.add('border-primary-500', 'text-primary-600', 'bg-white');
    }

    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.replaceState({}, '', url);
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab && document.getElementById('tab-' + tab)) {
        switchTab(tab);
    }
});

@if(Auth::user()->isMchungaji())
function openCreateJumuiyaModal() {
    const modal = document.getElementById('createJumuiyaModal');
    const content = document.getElementById('createJumuiyaModalContent');
    document.getElementById('createJumuiyaForm').reset();
    document.getElementById('create_jumuiya_active').checked = true;
    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeCreateJumuiyaModal() {
    const modal = document.getElementById('createJumuiyaModal');
    const content = document.getElementById('createJumuiyaModalContent');
    content.classList.remove('scale-100'); content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

function submitCreateJumuiya(event) {
    event.preventDefault();
    const form = document.getElementById('createJumuiyaForm');
    const btn = document.getElementById('createJumuiyaBtn');
    const formData = new FormData(form);
    formData.set('is_active', document.getElementById('create_jumuiya_active').checked ? '1' : '0');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inahifadhi...';

    fetch('{{ route("jumuiyas.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCreateJumuiyaModal();
            showJumuiyaWarningModal('Imefanikiwa!', data.message || 'Jumuiya imeongezwa kikamilifu.', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showJumuiyaWarningModal('Hitilafu!', data.message || 'Hitilafu imetokea wakati wa kuongeza jumuiya.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showJumuiyaWarningModal('Hitilafu ya Mtandao!', 'Hitilafu ya mtandao imetokea. Tafadhali jaribu tena.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> <span>Hifadhi</span>';
    });
}

function openEditJumuiyaModal(id) {
    const modal = document.getElementById('editJumuiyaModal');
    const content = document.getElementById('editJumuiyaModalContent');

    fetch(`/panel/jumuiyas/${id}/edit`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        const jumuiya = data.jumuiya;
        document.getElementById('edit_jumuiya_id').value = jumuiya.id;
        document.getElementById('edit_jumuiya_name').value = jumuiya.name || '';
        document.getElementById('edit_jumuiya_location').value = jumuiya.location || '';
        document.getElementById('edit_jumuiya_leader').value = jumuiya.leader_id || '';
        document.getElementById('edit_jumuiya_description').value = jumuiya.description || '';
        document.getElementById('edit_jumuiya_active').checked = jumuiya.is_active;
        modal.classList.remove('hidden');
        setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
    })
    .catch(error => { console.error('Error:', error); showError('Hitilafu ya kupakia data'); });
}

function closeEditJumuiyaModal() {
    const modal = document.getElementById('editJumuiyaModal');
    const content = document.getElementById('editJumuiyaModalContent');
    content.classList.remove('scale-100'); content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

function submitEditJumuiya(event) {
    event.preventDefault();
    const form = document.getElementById('editJumuiyaForm');
    const btn = document.getElementById('editJumuiyaBtn');
    const id = document.getElementById('edit_jumuiya_id').value;
    const formData = new FormData(form);
    formData.set('is_active', document.getElementById('edit_jumuiya_active').checked ? '1' : '0');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inasasisha...';

    fetch(`/panel/jumuiyas/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEditJumuiyaModal();
            showJumuiyaWarningModal('Imefanikiwa!', data.message || 'Jumuiya imesasishwa kikamilifu.', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showJumuiyaWarningModal('Hitilafu!', data.message || 'Hitilafu imetokea wakati wa kusasisha jumuiya.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showJumuiyaWarningModal('Hitilafu ya Mtandao!', 'Hitilafu ya mtandao imetokea. Tafadhali jaribu tena.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> <span>Sasisha</span>';
    });
}

function openShowJumuiyaModal(id) {
    const modal = document.getElementById('showJumuiyaModal');
    const content = document.getElementById('showJumuiyaModalContent');

    fetch(`/panel/jumuiyas/${id}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        const jumuiya = data.jumuiya;
        const members = data.members;

        document.getElementById('show_jumuiya_name').textContent = jumuiya.name;
        document.getElementById('show_jumuiya_location').textContent = jumuiya.location || 'Hakuna eneo';
        document.getElementById('show_jumuiya_leader').textContent = jumuiya.leader ? jumuiya.leader.name : 'Hakuna kiongozi';
        document.getElementById('show_jumuiya_leader_phone').textContent = jumuiya.leader ? jumuiya.leader.phone : '';
        document.getElementById('show_jumuiya_members_count').textContent = jumuiya.members_count + ' wanachama';
        document.getElementById('show_jumuiya_created').textContent = jumuiya.created_at;

        const statusHtml = jumuiya.is_active
            ? '<span class="rx-badge rx-badge-success"><i class="fas fa-check-circle mr-1"></i> Hai</span>'
            : '<span class="rx-badge rx-badge-danger"><i class="fas fa-times-circle mr-1"></i> Si Hai</span>';
        document.getElementById('show_jumuiya_status').innerHTML = statusHtml;

        const descSection = document.getElementById('show_jumuiya_description_section');
        if (jumuiya.description) {
            descSection.classList.remove('hidden');
            document.getElementById('show_jumuiya_description').textContent = jumuiya.description;
        } else { descSection.classList.add('hidden'); }

        const membersList = document.getElementById('show_jumuiya_members_list');
        if (members.length > 0) {
            membersList.innerHTML = members.map(member => `
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 text-sm text-gray-900">${member.name}</td>
                    <td class="px-4 py-2 text-sm text-gray-500">${member.member_number}</td>
                    <td class="px-4 py-2 text-sm text-gray-500">${member.phone || '-'}</td>
                </tr>
            `).join('');
        } else {
            membersList.innerHTML = '<tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Hakuna wanachama waliosajiliwa</td></tr>';
        }

        modal.classList.remove('hidden');
        setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
    })
    .catch(error => { console.error('Error:', error); showError('Hitilafu ya kupakia data'); });
}

function closeShowJumuiyaModal() {
    const modal = document.getElementById('showJumuiyaModal');
    const content = document.getElementById('showJumuiyaModalContent');
    content.classList.remove('scale-100'); content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

function confirmDeleteJumuiya(id, name, membersCount) {
    if (membersCount > 0) {
        showJumuiyaWarningModal('Onyo: Jumuiya Ina Wanachama!', `Jumuiya "${name}" ina wanachama ${membersCount}. Huwezi kufuta jumuiya hii mpaka wanachama wote waondolewe.`, 'warning');
        return;
    }
    showJumuiyaConfirmModal(id, name);
}

function showJumuiyaWarningModal(title, message, type = 'warning') {
    const modal = document.getElementById('jumuiyaAlertModal');
    const iconContainer = document.getElementById('jumuiyaAlertIcon');
    const titleEl = document.getElementById('jumuiyaAlertTitle');
    const messageEl = document.getElementById('jumuiyaAlertMessage');
    const content = document.getElementById('jumuiyaAlertModalContent');

    const icons = {
        'warning': '<i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>',
        'error': '<i class="fas fa-times-circle text-red-600 text-2xl"></i>',
        'success': '<i class="fas fa-check-circle text-green-600 text-2xl"></i>',
        'info': '<i class="fas fa-info-circle text-blue-600 text-2xl"></i>'
    };
    const bgColors = {
        'warning': 'bg-yellow-100', 'error': 'bg-red-100', 'success': 'bg-green-100', 'info': 'bg-blue-100'
    };

    iconContainer.className = `w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 ${bgColors[type]}`;
    iconContainer.innerHTML = icons[type];
    titleEl.textContent = title;
    messageEl.textContent = message;

    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeJumuiyaAlertModal() {
    const modal = document.getElementById('jumuiyaAlertModal');
    const content = document.getElementById('jumuiyaAlertModalContent');
    content.classList.remove('scale-100'); content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

function showJumuiyaConfirmModal(id, name) {
    const modal = document.getElementById('jumuiyaConfirmModal');
    const content = document.getElementById('jumuiyaConfirmModalContent');
    const nameEl = document.getElementById('confirmJumuiyaName');
    const deleteBtn = document.getElementById('confirmDeleteBtn');

    nameEl.textContent = name;
    deleteBtn.onclick = function() { executeDeleteJumuiya(id, name); };

    modal.classList.remove('hidden');
    setTimeout(() => { content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
}

function closeJumuiyaConfirmModal() {
    const modal = document.getElementById('jumuiyaConfirmModal');
    const content = document.getElementById('jumuiyaConfirmModalContent');
    content.classList.remove('scale-100'); content.classList.add('scale-95');
    setTimeout(() => { modal.classList.add('hidden'); }, 200);
}

function executeDeleteJumuiya(id, name) {
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Inafuta...';

    fetch(`/panel/jumuiyas/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        closeJumuiyaConfirmModal();
        if (data.success) {
            showJumuiyaWarningModal('Imefanikiwa!', `Jumuiya "${name}" imefutwa kikamilifu.`, 'success');
            const row = document.getElementById(`jumuiya-row-${id}`);
            if (row) row.remove();
            const tbody = document.getElementById('jumuiyaTableBody');
            if (tbody.children.length === 0) {
                tbody.innerHTML = `
                    <tr id="empty-jumuiya-row">
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="rx-empty">
                                <div class="rx-empty-icon"><i class="fas fa-users-slash text-gray-400 text-2xl"></i></div>
                                <h3 class="rx-empty-title">Hakuna jumuiya zilizosajiliwa</h3>
                                <p class="rx-empty-description">Anza kwa kuongeza jumuiya ya kwanza</p>
                                <button onclick="openCreateJumuiyaModal()" class="rx-btn rx-btn-primary"><i class="fas fa-plus"></i> Ongeza Jumuiya Mpya</button>
                            </div>
                        </td>
                    </tr>`;
            }
            setTimeout(() => location.reload(), 1500);
        } else {
            showJumuiyaWarningModal('Hitilafu!', data.message || 'Hitilafu imetokea wakati wa kufuta jumuiya.', 'error');
        }
    })
    .catch(error => {
        closeJumuiyaConfirmModal();
        console.error('Error:', error);
        showJumuiyaWarningModal('Hitilafu ya Mtandao!', 'Hitilafu ya mtandao imetokea. Tafadhali jaribu tena.', 'error');
    })
    .finally(() => {
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = '<i class="fas fa-trash mr-2"></i>Futa Jumuiya';
    });
}

document.getElementById('createJumuiyaModal')?.addEventListener('click', function(e) { if (e.target === this) closeCreateJumuiyaModal(); });
document.getElementById('editJumuiyaModal')?.addEventListener('click', function(e) { if (e.target === this) closeEditJumuiyaModal(); });
document.getElementById('showJumuiyaModal')?.addEventListener('click', function(e) { if (e.target === this) closeShowJumuiyaModal(); });
document.getElementById('jumuiyaAlertModal')?.addEventListener('click', function(e) { if (e.target === this) closeJumuiyaAlertModal(); });
document.getElementById('jumuiyaConfirmModal')?.addEventListener('click', function(e) { if (e.target === this) closeJumuiyaConfirmModal(); });

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateJumuiyaModal(); closeEditJumuiyaModal(); closeShowJumuiyaModal();
        closeJumuiyaAlertModal(); closeJumuiyaConfirmModal();
    }
});
@endif

const passwordInput = document.getElementById('new_password');
if (passwordInput) {
    const requirements = {
        length: { el: document.getElementById('req-length'), regex: /.{6,}/ },
        upper: { el: document.getElementById('req-upper'), regex: /[A-Z]/ },
        lower: { el: document.getElementById('req-lower'), regex: /[a-z]/ },
        number: { el: document.getElementById('req-number'), regex: /[0-9]/ },
        special: { el: document.getElementById('req-special'), regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/ }
    };

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        Object.keys(requirements).forEach(key => {
            const req = requirements[key];
            const icon = req.el.querySelector('i');
            if (req.regex.test(password)) {
                icon.className = 'fas fa-check-circle text-green-500 mr-2 text-xs';
                req.el.classList.remove('text-gray-600');
                req.el.classList.add('text-green-600');
            } else {
                icon.className = 'fas fa-circle text-gray-300 mr-2 text-[6px]';
                req.el.classList.remove('text-green-600');
                req.el.classList.add('text-gray-600');
            }
        });
    });
}
</script>
@endsection
