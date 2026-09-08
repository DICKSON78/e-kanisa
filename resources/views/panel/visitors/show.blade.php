@extends('layouts.app')

@section('title', 'Taarifa za Mgeni - Mfumo wa ROC')
@section('page-title', 'Taarifa za Mgeni')
@section('page-subtitle', 'Angalia taarifa kamili za mgeni')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('visitors.index') }}" class="rx-btn rx-btn-secondary !px-3">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                <i class="fas fa-user text-secondary-500"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Taarifa za Mgeni</h1>
                <p class="text-sm text-gray-500">Angalia taarifa kamili za mgeni wa kanisa</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('visitors.edit', $visitor->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i>
                <span>Hariri</span>
            </a>
            <a href="{{ route('visitors.index') }}" class="rx-btn rx-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Rudi Orodhani</span>
            </a>
        </div>
    </div>

    <!-- Visitor Profile Header -->
    <div class="rx-card overflow-hidden">
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Icon -->
                <div class="h-20 w-20 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.2);">
                    <i class="fas fa-user text-white text-4xl"></i>
                </div>

                <!-- Visitor Info -->
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $visitor->first_name }} {{ $visitor->last_name }}</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-white opacity-80"></i>
                                    <span class="text-sm opacity-90">{{ $visitor->phone }}</span>
                                </div>
                                @if($visitor->email)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-white opacity-80"></i>
                                    <span class="text-sm opacity-90">{{ $visitor->email }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-3 flex-wrap">
                                @php
                                    $followUpBadgeColors = [
                                        'Inasubiri' => 'bg-yellow-500',
                                        'Imeanzishwa' => 'bg-blue-500',
                                        'Imekamilika' => 'bg-green-500',
                                    ];
                                    $followUpBadgeColor = $followUpBadgeColors[$visitor->follow_up_status] ?? 'bg-gray-500';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 {{ $followUpBadgeColor }} text-white rounded-full text-xs font-semibold">
                                    <i class="fas fa-headset mr-1.5"></i>{{ $visitor->follow_up_status ?? 'Haijafikiwa' }}
                                </span>
                                @if($visitor->status)
                                <span class="inline-flex items-center px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">
                                    {{ $visitor->status }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 flex-wrap">
                            @if($visitor->follow_up_status !== 'Imekamilika')
                            <form method="POST" action="{{ route('visitors.follow-up', $visitor->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="rx-btn rx-btn-sm text-white !bg-white/20 hover:!bg-white/30 !border-0">
                                    <i class="fas fa-headset"></i>
                                    <span>Fuatilia</span>
                                </button>
                            </form>
                            @endif
                            @if($visitor->follow_up_status === 'Imekamilika' && $visitor->status !== 'Mwanachama')
                            <form method="POST" action="{{ route('visitors.convert', $visitor->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="rx-btn rx-btn-sm text-white !bg-green-500 hover:!bg-green-600 !border-0">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Badilisha kuwa Mwanachama</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Visitor Details (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information Card -->
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-user text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Kibinafsi</h3>
                        <p class="text-xs text-gray-500">Taarifa za msingi za mgeni</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gender -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Jinsia</p>
                        <div class="flex items-center">
                            @if($visitor->gender == 'Mme')
                                <i class="fas fa-male text-blue-500 mr-2"></i>
                            @else
                                <i class="fas fa-female text-pink-500 mr-2"></i>
                            @endif
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->gender == 'Mme' ? 'Mwanaume' : 'Mwanamke' }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    @if($visitor->address)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Anwani</p>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2 mt-0.5"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->address }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- City -->
                    @if($visitor->city)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Jiji</p>
                        <div class="flex items-center">
                            <i class="fas fa-city text-secondary-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->city }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-phone-alt text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Mawasiliano</h3>
                        <p class="text-xs text-gray-500">Mawasiliano ya mgeni</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Phone -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Namba ya Simu</p>
                        <div class="flex items-center">
                            <i class="fas fa-mobile-alt text-green-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->phone }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    @if($visitor->email)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Barua pepe</p>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->email }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Visit Information Card -->
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-church text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ziara</h3>
                        <p class="text-xs text-gray-500">Taarifa za ziara na ibada</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Visit Date -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Tarehe ya Ziara</p>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-secondary-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($visitor->visit_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Service Type -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Aina ya Ibada</p>
                        <div class="flex items-center">
                            <i class="fas fa-praying-hands text-purple-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->service_type }}</p>
                        </div>
                    </div>

                    <!-- Church From -->
                    @if($visitor->church_from)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Kanisa Alilokitoka</p>
                        <div class="flex items-center">
                            <i class="fas fa-church text-secondary-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->church_from }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Referred By -->
                    @if($visitor->referred_by)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Aliyemkaribisha</p>
                        <div class="flex items-center">
                            <i class="fas fa-user-tag text-yellow-500 mr-2"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $visitor->referred_by }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($visitor->notes)
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-sticky-note text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Maelezo</h3>
                        <p class="text-xs text-gray-500">Maelezo ya ziara</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <div class="flex items-start">
                        <i class="fas fa-edit text-secondary-500 mr-2 mt-0.5"></i>
                        <p class="text-sm text-gray-700">{{ $visitor->notes }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Quick Stats (1/3) -->
        <div class="space-y-6">
            <!-- Follow Up Status Card -->
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-headset text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Hali ya Ufuatiliaji</h3>
                        <p class="text-xs text-gray-500">Muhtasari wa ufuatiliaji</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-headset text-blue-500 mr-2 text-sm"></i>
                            <span class="text-xs text-gray-500">Hali</span>
                        </div>
                        @php
                            $statusColorMap = [
                                'Inasubiri' => 'text-yellow-600',
                                'Imeanzishwa' => 'text-blue-600',
                                'Imekamilika' => 'text-green-600',
                            ];
                        @endphp
                        <span class="text-sm font-medium {{ $statusColorMap[$visitor->follow_up_status] ?? 'text-gray-900' }}">{{ $visitor->follow_up_status ?? 'Haijafikiwa' }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-secondary-500 mr-2 text-sm"></i>
                            <span class="text-xs text-gray-500">Siku Tangu Ziara</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($visitor->visit_date)->diffForHumans() }}
                        </span>
                    </div>

                    @if($visitor->assignedUser)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-user-tie text-green-500 mr-2 text-sm"></i>
                            <span class="text-xs text-gray-500">Aliyeteuliwa</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $visitor->assignedUser->name }}</span>
                    </div>
                    @endif

                    @if($visitor->status)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-users text-purple-500 mr-2 text-sm"></i>
                            <span class="text-xs text-gray-500">Hali ya Mgeni</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $visitor->status }}</span>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-5 space-y-3">
                    @if($visitor->follow_up_status !== 'Imekamilika')
                    <form method="POST" action="{{ route('visitors.follow-up', $visitor->id) }}">
                        @csrf
                        <button type="submit" class="w-full rx-btn rx-btn-sm text-white justify-center !bg-blue-500 hover:!bg-blue-600 !border-0 !py-2.5">
                            <i class="fas fa-headset"></i>
                            <span class="font-medium">Anza Kufuatilia</span>
                        </button>
                    </form>
                    @endif

                    @if($visitor->follow_up_status === 'Imekamilika' && $visitor->status !== 'Mwanachama')
                    <form method="POST" action="{{ route('visitors.convert', $visitor->id) }}">
                        @csrf
                        <button type="submit" class="w-full rx-btn rx-btn-sm text-white justify-center !bg-green-500 hover:!bg-green-600 !border-0 !py-2.5">
                            <i class="fas fa-user-plus"></i>
                            <span class="font-medium">Badilisha kuwa Mwanachama</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="rx-card p-6">
                <div class="flex items-center mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,193,32,0.1);">
                        <i class="fas fa-cogs text-secondary-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Vitendo vya Haraka</h3>
                        <p class="text-xs text-gray-500">Chagua kitendo</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('visitors.edit', $visitor->id) }}"
                       class="rx-btn rx-btn-primary w-full justify-center">
                        <i class="fas fa-edit"></i>
                        <span class="font-medium">Hariri Taarifa</span>
                    </a>

                    <a href="{{ route('visitors.index') }}"
                       class="rx-btn rx-btn-secondary w-full justify-center">
                        <i class="fas fa-arrow-left"></i>
                        <span>Rudi Orodhani</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
