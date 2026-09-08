@extends('layouts.app')

@section('title', 'Taarifa za Ratiba - Mfumo wa E-Kanisa')
@section('page-title', 'Taarifa za Ratiba')
@section('page-subtitle', 'Angalia maelezo kamili ya ratiba ya kuhudumu')

@section('content')
<div class="space-y-6">
    <!-- Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('serving.index') }}" class="rx-btn rx-btn-secondary rx-btn-sm">
            <i class="fas fa-arrow-left text-xs"></i> Rudi
        </a>
        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
        <a href="{{ route('serving.edit', $schedule->id) }}" class="rx-btn rx-btn-primary rx-btn-sm">
            <i class="fas fa-edit text-xs"></i> Hariri
        </a>
        @endif
    </div>

    <!-- Profile Banner -->
    <div class="rx-card overflow-hidden">
        <div class="bg-gradient-to-r from-[#360958] to-[#1f0533] p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                    <i class="fas fa-calendar-check text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <h2 class="text-2xl font-bold">{{ $schedule->title }}</h2>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="rx-badge" style="background: rgba(255,255,255,0.15); color: white"><i class="fas fa-tag mr-1"></i>{{ $schedule->service_type }}</span>
                        <span class="rx-badge" style="background: rgba(255,255,255,0.15); color: white"><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}</span>
                        @php
                            $statusBg = match($schedule->status) {
                                'Inayokuja' => 'rgba(59,130,246,0.8)',
                                'Inaendelea' => 'rgba(34,197,94,0.8)',
                                'Imekamilika' => 'rgba(107,114,128,0.8)',
                                'Imesitishwa' => 'rgba(239,68,68,0.8)',
                                default => 'rgba(234,179,8,0.8)',
                            };
                        @endphp
                        <span class="rx-badge" style="background: {{ $statusBg }}; color: white"><i class="fas fa-circle mr-1 text-[8px]"></i>{{ $schedule->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Taarifa -->
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ratiba</h3>
                        <p class="text-xs text-gray-500">Maelezo ya msingi ya ratiba</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Tarehe</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2">
                            <i class="fas fa-calendar text-xs" style="color: #360958"></i>
                            <span>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5 ml-5">{{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('l') }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Aina ya Huduma</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-list-alt text-xs text-purple-500"></i> {{ $schedule->service_type }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Hali</p>
                        @php
                            $statusIcon = match($schedule->status) {
                                'Inayokuja' => ['icon' => 'fa-clock', 'badge' => 'rx-badge-blue'],
                                'Inaendelea' => ['icon' => 'fa-spinner', 'badge' => 'rx-badge-green'],
                                'Imekamilika' => ['icon' => 'fa-check-circle', 'badge' => 'rx-badge-gray'],
                                'Imesitishwa' => ['icon' => 'fa-times-circle', 'badge' => 'rx-badge-red'],
                                default => ['icon' => 'fa-question-circle', 'badge' => 'rx-badge-yellow'],
                            };
                        @endphp
                        <span class="rx-badge {{ $statusIcon['badge'] }}"><i class="fas {{ $statusIcon['icon'] }} mr-1 text-[10px]"></i>{{ $schedule->status }}</span>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Iliyotengenezwa na</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-user text-xs" style="color: #360958"></i> {{ $schedule->creator->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            @if($schedule->description)
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Maelezo ya Ratiba</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili kuhusu ratiba hii</p>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 text-sm text-gray-700 whitespace-pre-wrap">{{ $schedule->description }}</div>
            </div>
            @endif

            <!-- Waliopangwa Table -->
            <div class="rx-card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-users" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Waliopangwa Kuhudumu</h3>
                        <p class="text-xs text-gray-500">{{ $schedule->assignments->count() }} walioajiriwa</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="rx-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jina la Muumini</th>
                                <th>Jukumu</th>
                                <th>Nafasi</th>
                                <th>Hali</th>
                                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                                <th>Vitendo</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedule->assignments as $index => $assignment)
                            <tr>
                                <td class="text-sm text-gray-400">{{ $index + 1 }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                            <i class="fas fa-user text-xs" style="color: #360958"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $assignment->member->first_name ?? '-' }} {{ $assignment->member->last_name ?? '' }}</div>
                                            <div class="text-xs text-gray-400">{{ $assignment->member->member_number ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="rx-badge rx-badge-purple"><i class="fas fa-briefcase mr-1 text-[10px]"></i>{{ $assignment->role }}</span></td>
                                <td class="text-sm text-gray-600">{{ $assignment->position ?? '-' }}</td>
                                <td>
                                    @php
                                        $aStatus = match($assignment->status ?? 'Inasubiri') {
                                            'Imethibitishwa' => ['label' => 'Imethibitishwa', 'badge' => 'rx-badge-green', 'icon' => 'fa-check-circle'],
                                            'Imekataliwa' => ['label' => 'Imekataliwa', 'badge' => 'rx-badge-red', 'icon' => 'fa-times-circle'],
                                            default => ['label' => 'Inasubiri', 'badge' => 'rx-badge-yellow', 'icon' => 'fa-clock'],
                                        };
                                    @endphp
                                    <span class="rx-badge {{ $aStatus['badge'] }}"><i class="fas {{ $aStatus['icon'] }} mr-1 text-[10px]"></i>{{ $aStatus['label'] }}</span>
                                </td>
                                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                                <td>
                                    <form action="{{ route('serving.remove-assignment', [$schedule->id, $assignment->id]) }}" method="POST" class="inline" onsubmit="return confirm('Je, una uhakika unataka kumuondoa mtu huyu?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rx-icon-btn rx-icon-btn-red" title="Ondoa">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 6 : 5 }}">
                                    <div class="rx-empty">
                                        <div class="rx-empty-icon">
                                            <i class="fas fa-users text-gray-400 text-xl"></i>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Hakuna Waliopangwa Bado</h3>
                                        <p class="text-xs text-gray-500">Hakuna waumini walioajiriwa katika ratiba hii bado.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-6">
            <!-- Ongeza Mtu -->
            @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(34,197,94,0.1)">
                        <i class="fas fa-user-plus text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Ongeza Mtu Mpya</h3>
                        <p class="text-xs text-gray-500">Mpangie mtu kuhudumu</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('serving.add-assignment', $schedule->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Muumini *</label>
                        <select name="member_id" required class="rx-select">
                            <option value="">Chagua Muumini</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Jukumu *</label>
                        <select name="role" required class="rx-select">
                            <option value="">Chagua Jukumu</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Nafasi</label>
                        <input type="text" name="position" placeholder="mfano: Kwanza" class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Maelezo</label>
                        <textarea name="notes" rows="3" placeholder="Maelezo ya ziada..." class="rx-input rx-input-no-icon"></textarea>
                    </div>
                    <button type="submit" class="rx-btn rx-btn-primary w-full">
                        <i class="fas fa-plus text-xs"></i> Ongeza
                    </button>
                </form>
            </div>
            @endif

            <!-- Takwimu -->
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-line" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Takwimu</h3>
                        <p class="text-xs text-gray-500">Muhtasari wa ratiba</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-users text-xs text-blue-500"></i>
                            <span class="text-xs text-gray-600">Jumla Waliopangwa</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $schedule->assignments->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-xs text-green-500"></i>
                            <span class="text-xs text-gray-600">Waliokubali</span>
                        </div>
                        <span class="text-sm font-bold text-green-600">{{ $schedule->assignments->where('status', 'Imethibitishwa')->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-xs text-yellow-500"></i>
                            <span class="text-xs text-gray-600">Wanasubiri</span>
                        </div>
                        <span class="text-sm font-bold text-yellow-600">{{ $schedule->assignments->where('status', 'Inasubiri')->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-xs" style="color: #360958"></i>
                            <span class="text-xs text-gray-600">Tarehe</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
