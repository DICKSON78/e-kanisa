@extends('layouts.app')

@section('title', 'Taarifa za Sadaka - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('offerings.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-hand-holding-heart" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Taarifa za Sadaka</h1>
            <p class="text-sm text-gray-500">Angalia maelezo kamili ya sadaka</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('offerings.edit', $income->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span class="hidden sm:inline">Hariri</span>
            </a>
        </div>
    </div>

    <!-- Offering Profile Header -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Profile Icon -->
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(239,193,32,0.15)">
                    <i class="fas fa-hand-holding-heart text-white text-4xl"></i>
                </div>

                <!-- Offering Info -->
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-3xl font-bold">{{ number_format($income->amount, 0) }} TZS</h2>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold" style="background: rgba(239,193,32,0.2); color: #efc120">
                                    <i class="fas fa-tag mr-1.5"></i>{{ $income->category->name }}
                                </span>
                                @if($income->receipt_number)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1.5"></i>Risiti: {{ $income->receipt_number }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Offering Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Offering Details Card -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Sadaka</h3>
                        <p class="text-sm text-gray-500">Maelezo ya msingi ya sadaka</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Collection Date -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Tarehe ya Kukusanya</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($income->collection_date)->format('d/m/Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ \Carbon\Carbon::parse($income->collection_date)->format('l') }}
                        </p>
                    </div>

                    <!-- Amount -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Kiasi</p>
                        <p class="text-lg font-semibold" style="color: #16a34a">
                            {{ number_format($income->amount, 0) }} TZS
                        </p>
                    </div>

                    <!-- Category -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Aina ya Sadaka</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $income->category->name }}
                        </p>
                        @if($income->category->code)
                            <p class="text-xs text-gray-500 mt-1">Code: {{ $income->category->code }}</p>
                        @endif
                    </div>

                    <!-- Receipt Number -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Namba ya Risiti</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $income->receipt_number ?? '-' }}
                        </p>
                    </div>
                </div>

                @if($income->notes)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Maelezo</p>
                    <p class="text-gray-900">{{ $income->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Member Information Card -->
            @if($income->member)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                        <i class="fas fa-user" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mwanachama</h3>
                        <p class="text-sm text-gray-500">Maelezo ya mwanachama aliyetoa sadaka</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Jina</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $income->member->full_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Namba ya Mwanachama</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $income->member->member_number }}</p>
                    </div>
                    @if($income->member->phone)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Simu</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $income->member->phone }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: System Information -->
        <div class="space-y-6">
            <!-- System Info Card -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                        <i class="fas fa-info-circle" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mfumo</h3>
                        <p class="text-sm text-gray-500">Maelezo ya mfumo</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Imeundwa</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $income->created_at->format('d/m/Y H:i') }}
                        </p>
                        @if($income->creator)
                            <p class="text-xs text-gray-500 mt-1">na {{ $income->creator->name }}</p>
                        @endif
                    </div>

                    @if($income->updated_at != $income->created_at)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Imesasishwa</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $income->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="rx-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Vitendo</h3>
                <div class="space-y-3">
                    <a href="{{ route('offerings.edit', $income->id) }}" class="rx-btn rx-btn-primary w-full flex items-center justify-center gap-2">
                        <i class="fas fa-edit"></i>
                        Hariri Sadaka
                    </a>
                    <form action="{{ route('offerings.destroy', $income->id) }}" method="POST" onsubmit="return confirm('Je, una uhakika unataka kufuta sadaka hii?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rx-btn rx-btn-danger w-full flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i>
                            Futa Sadaka
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
