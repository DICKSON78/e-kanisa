@extends('layouts.app')

@section('title', 'Taarifa za Ufuatiliaji - Mfumo wa E-Kanisa')
@section('page-title', 'Taarifa za Ufuatiliaji')
@section('page-subtitle', 'Angalia maelezo kamili ya ufuatiliaji')

@section('content')
<div class="space-y-6">
    <!-- Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('followups.index') }}" class="rx-btn rx-btn-secondary rx-btn-sm">
            <i class="fas fa-arrow-left text-xs"></i> Rudi
        </a>
        <a href="{{ route('followups.edit', $followup->id) }}" class="rx-btn rx-btn-primary rx-btn-sm">
            <i class="fas fa-edit text-xs"></i> Hariri
        </a>
    </div>

    <!-- Profile Banner -->
    <div class="rx-card overflow-hidden">
        <div class="bg-gradient-to-r from-[#360958] to-[#1f0533] p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                    <i class="fas fa-headset text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <h2 class="text-2xl font-bold">{{ $followup->subject }}</h2>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="flex items-center gap-1.5 text-sm opacity-90">
                            <i class="fas fa-user"></i> {{ $followup->member->full_name ?? 'N/A' }}
                        </span>
                        @if($followup->status === 'Inasubiri')
                            <span class="rx-badge" style="background: rgba(234,179,8,0.9); color: white"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                        @elseif($followup->status === 'Imeanzishwa')
                            <span class="rx-badge" style="background: rgba(59,130,246,0.9); color: white"><i class="fas fa-play-circle mr-1"></i>Imeanzishwa</span>
                        @else
                            <span class="rx-badge" style="background: rgba(34,197,94,0.9); color: white"><i class="fas fa-check-circle mr-1"></i>Imekamilika</span>
                        @endif
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
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ufuatiliaji</h3>
                        <p class="text-xs text-gray-500">Maelezo ya ufuatiliaji</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Aina</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-tag text-xs" style="color: #360958"></i> {{ $followup->follow_up_type }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Kipaumbele</p>
                        @if($followup->priority === 'Ya Dharura')
                            <span class="rx-badge rx-badge-red"><i class="fas fa-exclamation-circle mr-1"></i>Ya Dharura</span>
                        @elseif($followup->priority === 'Ya Juu')
                            <span class="rx-badge rx-badge-gold"><i class="fas fa-arrow-up mr-1"></i>Ya Juu</span>
                        @else
                            <span class="rx-badge rx-badge-blue"><i class="fas fa-minus mr-1"></i>Ya Kawaida</span>
                        @endif
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Hali</p>
                        @if($followup->status === 'Inasubiri')
                            <span class="rx-badge rx-badge-yellow"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                        @elseif($followup->status === 'Imeanzishwa')
                            <span class="rx-badge rx-badge-blue"><i class="fas fa-play-circle mr-1"></i>Imeanzishwa</span>
                        @else
                            <span class="rx-badge rx-badge-green"><i class="fas fa-check-circle mr-1"></i>Imekamilika</span>
                        @endif
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Mtendaji</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-user-tie text-xs" style="color: #360958"></i> {{ $followup->assignedUser->name ?? 'N/A' }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Tarehe ya Kuanza</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-calendar-plus text-xs" style="color: #360958"></i> {{ \Carbon\Carbon::parse($followup->start_date)->format('d/m/Y') }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Tarehe ya Kufuatilia</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-calendar-check text-xs" style="color: #360958"></i> {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d/m/Y') }}</p>
                    </div>
                    @if($followup->last_contact_date)
                    <div class="p-3 rounded-lg bg-gray-50 sm:col-span-2">
                        <p class="text-[11px] text-gray-500 mb-1 uppercase font-medium">Mawasiliano ya Mwisho</p>
                        <p class="text-sm font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-phone text-xs" style="color: #360958"></i> {{ \Carbon\Carbon::parse($followup->last_contact_date)->format('d/m/Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maelezo -->
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Maelezo</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili kuhusu ufuatiliaji</p>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-gray-50 text-sm text-gray-700 whitespace-pre-wrap">{{ $followup->description ?: 'Hakuna maelezo.' }}</div>
            </div>

            <!-- Hatua Zilizochukuliwa -->
            @if($followup->action_taken)
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Hatua Zilizochukuliwa</h3>
                        <p class="text-xs text-gray-500">Vitendo vilivyofanywa</p>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-blue-50 text-sm text-gray-700 whitespace-pre-wrap">{{ $followup->action_taken }}</div>
            </div>
            @endif

            <!-- Matokeo -->
            @if($followup->outcome)
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(34,197,94,0.1)">
                        <i class="fas fa-flag-checkered text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Matokeo</h3>
                        <p class="text-xs text-gray-500">Matokeo ya ufuatiliaji</p>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-green-50 text-sm text-gray-700 whitespace-pre-wrap">{{ $followup->outcome }}</div>
            </div>
            @endif
        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-6">
            <!-- Sasisha Hali -->
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sync-alt" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Sasisha Hali</h3>
                        <p class="text-xs text-gray-500">Badilisha hali ya ufuatiliaji</p>
                    </div>
                </div>
                <form action="{{ route('followups.update-status', $followup->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Hali</label>
                        <select name="status" required class="rx-select">
                            <option value="Inasubiri" {{ $followup->status === 'Inasubiri' ? 'selected' : '' }}>Inasubiri</option>
                            <option value="Imeanzishwa" {{ $followup->status === 'Imeanzishwa' ? 'selected' : '' }}>Imeanzishwa</option>
                            <option value="Imekamilika" {{ $followup->status === 'Imekamilika' ? 'selected' : '' }}>Imekamilika</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Hatua Zilizochukuliwa</label>
                        <textarea name="action_taken" rows="3" class="rx-input rx-input-no-icon" placeholder="Eleza hatua zilizochukuliwa...">{{ old('action_taken', $followup->action_taken) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Matokeo</label>
                        <textarea name="outcome" rows="3" class="rx-input rx-input-no-icon" placeholder="Eleza matokeo...">{{ old('outcome', $followup->outcome) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Mawasiliano ya Mwisho</label>
                        <input type="date" name="last_contact_date" value="{{ old('last_contact_date', $followup->last_contact_date ? \Carbon\Carbon::parse($followup->last_contact_date)->format('Y-m-d') : date('Y-m-d')) }}" class="rx-input rx-input-no-icon">
                    </div>
                    <button type="submit" class="rx-btn rx-btn-primary w-full">
                        <i class="fas fa-save text-xs"></i> Sasisha Hali
                    </button>
                </form>
            </div>

            <!-- Taarifa za Mwanachama -->
            <div class="rx-card p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #360958"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900">Mwanachama</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Jina</span>
                        <span class="text-sm font-medium text-gray-900">{{ $followup->member->full_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Namba</span>
                        <span class="text-sm font-medium text-gray-900">{{ $followup->member->member_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-gray-500">Simu</span>
                        <span class="text-sm font-medium text-gray-900">{{ $followup->member->phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
