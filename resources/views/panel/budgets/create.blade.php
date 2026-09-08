@extends('layouts.app')
@section('title', 'Ongeza Bajeti - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('budgets.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-plus" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ongeza Bajeti Mpya</h1>
            <p class="text-sm text-gray-500">Weka bajeti ya matumizi</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf

            <!-- Taarifa za Bajeti -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Bajeti</h3>
                        <p class="text-sm text-gray-500">Jaza taarifa za kimsingi za bajeti</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kichwa cha Bajeti <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               class="rx-input rx-input-no-icon @error('title') border-red-500 @enderror"
                               placeholder="mfano: Bajeti ya Matumizi ya Ofisi">
                        @error('title')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo</label>
                        <textarea name="description" rows="3"
                                  class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror"
                                  placeholder="Andika maelezo ya bajeti...">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Mwaka <span class="text-red-500">*</span></label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2020"
                               class="rx-input rx-input-no-icon @error('year') border-red-500 @enderror">
                        @error('year')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Mwezi (bure = mwaka mzima)</label>
                        <select name="month" class="rx-select @error('month') border-red-500 @enderror">
                            <option value="">-- Mwaka Mzima --</option>
                            @php $months = [1=>'Januari',2=>'Februari',3=>'Machi',4=>'Aprili',5=>'Mei',6=>'Juni',7=>'Julai',8=>'Agosti',9=>'Septemba',10=>'Oktoba',11=>'Novemba',12=>'Desemba']; @endphp
                            @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ old('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kundi la Matumizi</label>
                        <select name="expense_category_id" class="rx-select @error('expense_category_id') border-red-500 @enderror">
                            <option value="">-- Jumla --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('expense_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kiasi Kilichopangwa (TZS) <span class="text-red-500">*</span></label>
                        <input type="number" name="budgeted_amount" value="{{ old('budgeted_amount') }}" required min="0" step="0.01"
                               class="rx-input rx-input-no-icon @error('budgeted_amount') border-red-500 @enderror" placeholder="0.00">
                        @error('budgeted_amount')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Maelezo ya Ziada -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Maelezo ya Ziada</h3>
                        <p class="text-sm text-gray-500">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo ya Ziada</label>
                        <textarea name="notes" rows="2"
                                  class="rx-input rx-input-no-icon @error('notes') border-red-500 @enderror"
                                  placeholder="Andika maelezo yoyote muhimu...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('budgets.index') }}" class="rx-btn rx-btn-secondary"><i class="fas fa-times"></i> Ghairi</a>
                <button type="submit" class="rx-btn rx-btn-primary"><i class="fas fa-save"></i> Hifadhi Bajeti</button>
            </div>
        </form>
    </div>
</div>
@endsection
