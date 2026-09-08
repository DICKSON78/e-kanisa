@extends('layouts.app')

@section('title', 'Ongeza Uhamisho - Mfumo wa ROC')
@section('page-title', 'Ongeza Uhamisho wa Uanachama')
@section('page-subtitle', 'Jaza taarifa za uhamisho wa muumini')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-plus text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ongeza Uhamisho Mpya</h1>
                <p class="text-sm text-gray-500">Jaza taarifa za uhamisho wa muumini kati ya makanisa</p>
            </div>
        </div>
        <a href="{{ route('transfers.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span class="hidden sm:inline">Rudi Orodhani</span>
        </a>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('transfers.store') }}">
            @csrf

            <!-- Member & Transfer Type Section -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Muumini na Aina ya Uhamisho</h3>
                        <p class="text-sm text-gray-500">Chagua muumini na aina ya uhamisho</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Member -->
                    <div class="md:col-span-2">
                        <label for="member_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Muumini <span class="text-red-500">*</span>
                        </label>
                        <select id="member_id" name="member_id" required class="rx-select @error('member_id') border-red-500 @enderror">
                            <option value="">Chagua Muumini</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->first_name }} {{ $member->last_name ?? '' }} ({{ $member->member_number ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transfer Type -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Aina ya Uhamisho <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200 {{ old('transfer_type') == 'Kuingia' ? 'bg-green-50 border-green-400 ring-2 ring-green-200' : '' }}">
                                <input type="radio" name="transfer_type" value="Kuingia" {{ old('transfer_type') == 'Kuingia' ? 'checked' : '' }} required
                                       class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300" onchange="toggleChurchFields()">
                                <div class="ml-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-in-alt text-green-600 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Kuingia</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Muumini anajiunga na kanisa hili</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200 {{ old('transfer_type') == 'Kutoka' ? 'bg-orange-50 border-orange-400 ring-2 ring-orange-200' : '' }}">
                                <input type="radio" name="transfer_type" value="Kutoka" {{ old('transfer_type') == 'Kutoka' ? 'checked' : '' }} required
                                       class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300" onchange="toggleChurchFields()">
                                <div class="ml-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-out-alt text-orange-600 mr-2"></i>
                                        <span class="text-gray-700 font-medium">Kutoka</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Muumini anaondoka kanisa hili</p>
                                </div>
                            </label>
                        </div>
                        @error('transfer_type')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Church Information Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-church text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kanisa</h3>
                        <p class="text-sm text-gray-500">Jaza kanisa la asili na kanisa la kufikia</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- From Church -->
                    <div id="fromChurchGroup">
                        <label for="from_church" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Kanisa la Kutoka <span class="text-red-500" id="fromChurchRequired">*</span>
                        </label>
                        <input type="text" id="from_church" name="from_church" value="{{ old('from_church') }}"
                               class="rx-input rx-input-no-icon @error('from_church') border-red-500 @enderror"
                               placeholder="Jina la kanisa la asili">
                        @error('from_church')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- To Church -->
                    <div id="toChurchGroup">
                        <label for="to_church" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Kanisa la Kwenda <span class="text-red-500" id="toChurchRequired">*</span>
                        </label>
                        <input type="text" id="to_church" name="to_church" value="{{ old('to_church') }}"
                               class="rx-input rx-input-no-icon @error('to_church') border-red-500 @enderror"
                               placeholder="Jina la kanisa la kufikia">
                        @error('to_church')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- From Pastor -->
                    <div>
                        <label for="from_pastor" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Mchungaji wa Kuondoka
                        </label>
                        <input type="text" id="from_pastor" name="from_pastor" value="{{ old('from_pastor') }}"
                               class="rx-input rx-input-no-icon @error('from_pastor') border-red-500 @enderror"
                               placeholder="Jina la mchungaji">
                        @error('from_pastor')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- To Pastor -->
                    <div>
                        <label for="to_pastor" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Mchungaji wa Kupokea
                        </label>
                        <input type="text" id="to_pastor" name="to_pastor" value="{{ old('to_pastor') }}"
                               class="rx-input rx-input-no-icon @error('to_pastor') border-red-500 @enderror"
                               placeholder="Jina la mchungaji">
                        @error('to_pastor')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transfer Date -->
                    <div>
                        <label for="transfer_date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Tarehe ya Uhamisho <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" required
                               class="rx-input rx-input-no-icon @error('transfer_date') border-red-500 @enderror">
                        @error('transfer_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Sababu ya Uhamisho
                        </label>
                        <input type="text" id="reason" name="reason" value="{{ old('reason') }}"
                               class="rx-input rx-input-no-icon @error('reason') border-red-500 @enderror"
                               placeholder="Sababu ya uhamisho">
                        @error('reason')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sticky-note text-sm" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Maelezo Mengine</h3>
                        <p class="text-sm text-gray-500">Ongeza maelezo yoyote mengine muhimu</p>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        Maelezo (Hiari)
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="rx-input rx-input-no-icon @error('notes') border-red-500 @enderror"
                              placeholder="Andika maelezo yoyote mengine muhimu...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('transfers.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi Uhamisho</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleChurchFields() {
        const transferType = document.querySelector('input[name="transfer_type"]:checked')?.value;
        const fromChurchInput = document.getElementById('from_church');
        const toChurchInput = document.getElementById('to_church');
        const fromChurchRequired = document.getElementById('fromChurchRequired');
        const toChurchRequired = document.getElementById('toChurchRequired');

        if (transferType === 'Kuingia') {
            fromChurchInput.setAttribute('required', 'required');
            toChurchInput.removeAttribute('required');
            fromChurchRequired.style.display = '';
            toChurchRequired.style.display = 'none';
        } else if (transferType === 'Kutoka') {
            toChurchInput.setAttribute('required', 'required');
            fromChurchInput.removeAttribute('required');
            toChurchRequired.style.display = '';
            fromChurchRequired.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleChurchFields();
    });
</script>
@endsection
