@extends('layouts.app')

@section('title', 'Taarifa za Malipo - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('online-giving.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-mobile-alt" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Taarifa za Malipo</h1>
                    <p class="text-sm text-gray-500">Angalia taarifa kamili za malipo ya mtandaoni</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($transaction->status === 'Inasubiri')
            <form method="POST" action="{{ route('online-giving.approve', $transaction->id) }}" class="inline">
                @csrf
                @method('POST')
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2" style="background: #16a34a; color: white;" onclick="return confirm('Je, unataka kuthibitisha malipo haya?')">
                    <i class="fas fa-check"></i>
                    <span class="hidden sm:inline">Thibitisha</span>
                </button>
            </form>
            <form method="POST" action="{{ route('online-giving.reject', $transaction->id) }}" class="inline">
                @csrf
                @method('POST')
                <button type="submit" class="rx-btn rx-btn-danger flex items-center gap-2" onclick="return confirm('Je, unataka kukataa malipo haya?')">
                    <i class="fas fa-times"></i>
                    <span class="hidden sm:inline">Kataa</span>
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Gradient Profile Banner -->
    @php
        $statusGradients = [
            'Inasubiri' => 'linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)',
            'Imekamilika' => 'linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%)',
            'Imeshindwa' => 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)',
            'Imerejeshwa' => 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%)',
        ];
    @endphp
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: {{ $statusGradients[$transaction->status] ?? 'linear-gradient(135deg, #360958, #2a0745)' }}" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15)">
                    <i class="fas fa-mobile-alt text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ number_format($transaction->amount, 0) }} TSh</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $transaction->purpose }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-credit-card"></i>
                                    <span>{{ $transaction->payment_method }}</span>
                                </div>
                                <span class="rx-badge text-xs" style="background: rgba(255,255,255,0.2); color: white;">
                                    {{ $transaction->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Taarifa za Malipo -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-receipt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Malipo</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili ya malipo</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Kiasi</label>
                        <p class="text-lg font-bold" style="color: #16a34a">{{ number_format($transaction->amount, 0) }} TSh</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Njia ya Malipo</label>
                        <p class="text-sm font-medium text-gray-900">{{ $transaction->payment_method }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Namba ya Rejea</label>
                        <p class="text-sm font-mono text-gray-900">{{ $transaction->reference_number ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nambari ya Simu</label>
                        <p class="text-sm text-gray-900">{{ $transaction->phone_number ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lengo</label>
                        <p class="text-sm text-gray-900">{{ $transaction->purpose }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Aina ya Mapato</label>
                        <p class="text-sm text-gray-900">{{ $transaction->incomeCategory->name ?? '-' }}</p>
                    </div>
                    @if($transaction->description)
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Maelezo</label>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-4">{{ $transaction->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Mwanachama -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Mwanachama</h3>
                        <p class="text-xs text-gray-500">Taarifa za mwanachama</p>
                    </div>
                </div>
                @if($transaction->member)
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jina Kamili</label>
                        <p class="text-sm font-medium text-gray-900">{{ $transaction->member->first_name }} {{ $transaction->member->middle_name ?? '' }} {{ $transaction->member->last_name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Namba ya Mwanachama</label>
                        <p class="text-sm text-gray-900">{{ $transaction->member->member_number }}</p>
                    </div>
                    @if($transaction->member->phone)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Simu</label>
                        <p class="text-sm text-gray-900">{{ $transaction->member->phone }}</p>
                    </div>
                    @endif
                </div>
                @else
                <p class="text-sm text-gray-400 italic">Hakuna taarifa za mwanachama</p>
                @endif
            </div>

            <!-- Nyakati -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-clock" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Nyakati</h3>
                        <p class="text-xs text-gray-500">Taarifa za wakati</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Imeundwa</label>
                        <p class="text-sm text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Imesasishwa</label>
                        <p class="text-sm text-gray-900">{{ $transaction->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($transaction->approved_at)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Imethibitishwa</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction->approved_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Mobile Actions -->
            @if($transaction->status === 'Inasubiri')
            <div class="rx-card rounded-2xl p-6 lg:hidden">
                <div class="space-y-3">
                    <form method="POST" action="{{ route('online-giving.approve', $transaction->id) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="rx-btn w-full justify-center py-3 flex items-center gap-2" style="background: #16a34a; color: white;" onclick="return confirm('Je, unataka kuthibitisha malipo haya?')">
                            <i class="fas fa-check"></i> Thibitisha Malipo
                        </button>
                    </form>
                    <form method="POST" action="{{ route('online-giving.reject', $transaction->id) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="rx-btn rx-btn-danger w-full justify-center py-3 flex items-center gap-2" onclick="return confirm('Je, unataka kukataa malipo haya?')">
                            <i class="fas fa-times"></i> Kataa Malipo
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
