@extends('layouts.app')

@section('title', 'Ongeza Darasa - Mfumo wa ROC')
@section('page-title', 'Ongeza Darasa')
@section('page-subtitle', 'Sajili darasa jipya la Sunday School')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('children.index') }}" class="p-2 text-gray-400 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                <i class="fas fa-plus" style="color: #efc120;"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ongeza Darasa Jipya</h1>
                <p class="text-sm text-gray-500">Jaza fomu hii kusajili darasa jipya la Sunday School</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                    <i class="fas fa-chalkboard" style="color: #efc120;"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Taarifa za Darasa</h3>
            </div>
        </div>

        <form action="{{ route('children.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jina la Darasa -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Jina la Darasa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="rx-input rx-input-no-icon @error('name') border-red-500 @enderror"
                           placeholder="Mfano: Darasa la Watoto Wadogo">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Umri Mdogo -->
                <div>
                    <label for="age_min" class="block text-sm font-medium text-gray-700 mb-2">
                        Umri Mdogo (miaka) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="age_min" id="age_min" value="{{ old('age_min', 3) }}" required min="0" max="18"
                           class="rx-input rx-input-no-icon @error('age_min') border-red-500 @enderror"
                           placeholder="Mfano: 3">
                    @error('age_min')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Umri Mkuu -->
                <div>
                    <label for="age_max" class="block text-sm font-medium text-gray-700 mb-2">
                        Umri Mkuu (miaka) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="age_max" id="age_max" value="{{ old('age_max', 12) }}" required min="0" max="18"
                           class="rx-input rx-input-no-icon @error('age_max') border-red-500 @enderror"
                           placeholder="Mfano: 12">
                    @error('age_max')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hali
                    </label>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-3 text-sm text-gray-700">
                            Darasa linafanya kazi
                        </label>
                    </div>
                </div>

                <!-- Maelezo -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Maelezo
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror"
                              placeholder="Maelezo mafupi kuhusu darasa hili...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </form>

        <!-- Sticky Footer -->
        <div class="sticky bottom-0 bg-white border-t border-gray-200 p-4">
            <div class="flex justify-end gap-3">
                <a href="{{ route('children.index') }}" class="rx-btn rx-btn-secondary">
                    Ghairi
                </a>
                <button type="submit" form="children-create-form" class="rx-btn rx-btn-primary" onclick="this.closest('form').submit();">
                    <i class="fas fa-save"></i>
                    Hifadhi Darasa
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
