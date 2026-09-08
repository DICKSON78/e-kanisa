@extends('layouts.app')

@section('title', 'Hariri Ratiba - Mfumo wa ROC')
@section('page-title', 'Hariri Ratiba')
@section('page-subtitle', 'Badilisha taarifa za ratiba ya kuhudumu')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('serving.show', $schedule->id) }}" class="rx-btn rx-btn-secondary rx-btn-sm">
            <i class="fas fa-arrow-left text-xs"></i> Rudi
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #360958"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Hariri Ratiba</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za {{ $schedule->title }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card">
        <form method="POST" action="{{ route('serving.update', $schedule->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Ratiba -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar-check" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ratiba</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za kimsingi za ratiba</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Kichwa cha Ratiba <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $schedule->title) }}" required class="rx-input rx-input-no-icon @error('title') border-red-500 @enderror" placeholder="Kichwa cha ratiba">
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Maelezo</label>
                        <textarea id="description" name="description" rows="3" class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror" placeholder="Maelezo ya ratiba">{{ old('description', $schedule->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tarehe ya Ratiba <span class="text-red-500">*</span></label>
                        <input type="date" id="schedule_date" name="schedule_date" value="{{ old('schedule_date', \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d')) }}" required class="rx-input rx-input-no-icon @error('schedule_date') border-red-500 @enderror">
                        @error('schedule_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Aina ya Huduma <span class="text-red-500">*</span></label>
                        <select id="service_type" name="service_type" required class="rx-select">
                            <option value="Ibada Kuu" {{ old('service_type', $schedule->service_type) === 'Ibada Kuu' ? 'selected' : '' }}>Ibada Kuu</option>
                            <option value="Ibada ya Jumapili" {{ old('service_type', $schedule->service_type) === 'Ibada ya Jumapili' ? 'selected' : '' }}>Ibada ya Jumapili</option>
                            <option value="Ibada ya Alhamisi" {{ old('service_type', $schedule->service_type) === 'Ibada ya Alhamisi' ? 'selected' : '' }}>Ibada ya Alhamisi</option>
                            <option value="Kikao" {{ old('service_type', $schedule->service_type) === 'Kikao' ? 'selected' : '' }}>Kikao</option>
                            <option value="Nyingine" {{ old('service_type', $schedule->service_type) === 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Hali ya Ratiba <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required class="rx-select">
                            <option value="Inayokuja" {{ old('status', $schedule->status) === 'Inayokuja' ? 'selected' : '' }}>Inayokuja</option>
                            <option value="Inaendelea" {{ old('status', $schedule->status) === 'Inaendelea' ? 'selected' : '' }}>Inaendelea</option>
                            <option value="Imekamilika" {{ old('status', $schedule->status) === 'Imekamilika' ? 'selected' : '' }}>Imekamilika</option>
                            <option value="Imesitishwa" {{ old('status', $schedule->status) === 'Imesitishwa' ? 'selected' : '' }}>Imesitishwa</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                <a href="{{ route('serving.show', $schedule->id) }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times text-xs"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save text-xs"></i> Sasisha Ratiba
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
