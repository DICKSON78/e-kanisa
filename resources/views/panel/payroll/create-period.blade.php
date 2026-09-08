@extends('layouts.app')

@section('title', 'Kipindi Kipya - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('payroll.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-calendar-plus" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kipindi Kipya cha Mishahara</h1>
            <p class="text-sm text-gray-500">Unda kipindi kipya cha mishahara</p>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('payroll.store-period') }}">
            @csrf

            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Kipindi</h3>
                        <p class="text-sm text-gray-500">Weka mwezi na mwaka wa kipindi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="month" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwezi <span class="text-red-500">*</span>
                        </label>
                        <select id="month" name="month" required class="rx-select @error('month') border-red-500 @enderror">
                            <option value="">Chagua Mwezi</option>
                            <option value="1" {{ old('month') == '1' ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ old('month') == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ old('month') == '3' ? 'selected' : '' }}>Machi</option>
                            <option value="4" {{ old('month') == '4' ? 'selected' : '' }}>Aprili</option>
                            <option value="5" {{ old('month') == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ old('month') == '6' ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ old('month') == '7' ? 'selected' : '' }}>Julai</option>
                            <option value="8" {{ old('month') == '8' ? 'selected' : '' }}>Agosti</option>
                            <option value="9" {{ old('month') == '9' ? 'selected' : '' }}>Septemba</option>
                            <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>Oktoba</option>
                            <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>Novemba</option>
                            <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>Desemba</option>
                        </select>
                        @error('month')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwaka <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}" required
                               class="rx-input rx-input-no-icon @error('year') border-red-500 @enderror">
                        @error('year')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pay_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Malipo <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="pay_date" name="pay_date" value="{{ old('pay_date') }}" required
                               class="rx-input rx-input-no-icon @error('pay_date') border-red-500 @enderror">
                        @error('pay_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Warning Banner -->
            <div class="mx-6 mb-6">
                <div class="p-4 rounded-xl flex items-start gap-3" style="background: #fef9c3; border: 1px solid #fde68a;">
                    <i class="fas fa-exclamation-triangle mt-0.5" style="color: #a16207"></i>
                    <div>
                        <p class="text-sm font-medium" style="color: #a16207">Kumbuka</p>
                        <p class="text-sm mt-1" style="color: #854d0e">Baada ya kuhifadhi kipindi, utaweza kuchakata mishahara. Hakikisha mwezi na mwaka ni sahihi kabla ya kuendelea.</p>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('payroll.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save"></i> Hifadhi Kipindi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
