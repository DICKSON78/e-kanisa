@extends('layouts.app')

@section('title', 'Hariri Tukio - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hariri Tukio</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za {{ $event->title }}</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('events.update', $event->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Tukio -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Tukio</h3>
                        <p class="text-sm text-gray-500">Sasisha taarifa za kimsingi za tukio</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">Kichwa cha Tukio <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                               class="rx-input @error('title') border-red-500 @enderror" placeholder="Kichwa cha tukio">
                        @error('title')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="event_type" class="block text-sm font-semibold text-gray-900 mb-2">Aina ya Tukio <span class="text-red-500">*</span></label>
                        <select id="event_type" name="event_type" required class="rx-select">
                            <option value="Ibada" {{ old('event_type', $event->event_type) === 'Ibada' ? 'selected' : '' }}>Ibada</option>
                            <option value="Semina" {{ old('event_type', $event->event_type) === 'Semina' ? 'selected' : '' }}>Semina</option>
                            <option value="Mkutano" {{ old('event_type', $event->event_type) === 'Mkutano' ? 'selected' : '' }}>Mkutano</option>
                            <option value="Sherehe" {{ old('event_type', $event->event_type) === 'Sherehe' ? 'selected' : '' }}>Sherehe</option>
                            <option value="Kambi" {{ old('event_type', $event->event_type) === 'Kambi' ? 'selected' : '' }}>Kambi</option>
                            <option value="Mkesha" {{ old('event_type', $event->event_type) === 'Mkesha' ? 'selected' : '' }}>Mkesha</option>
                            <option value="Safari" {{ old('event_type', $event->event_type) === 'Safari' ? 'selected' : '' }}>Safari</option>
                            <option value="Tamasha" {{ old('event_type', $event->event_type) === 'Tamasha' ? 'selected' : '' }}>Tamasha</option>
                        </select>
                    </div>

                    <div>
                        <label for="event_date" class="block text-sm font-semibold text-gray-900 mb-2">Tarehe <span class="text-red-500">*</span></label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required
                               class="rx-input">
                    </div>

                    <div>
                        <label for="start_time" class="block text-sm font-semibold text-gray-900 mb-2">Muda wa Kuanza</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time) }}" class="rx-input">
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-semibold text-gray-900 mb-2">Muda wa Mwisho</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="rx-input">
                    </div>

                    <div class="md:col-span-2">
                        <label for="venue" class="block text-sm font-semibold text-gray-900 mb-2">Mahali</label>
                        <input type="text" id="venue" name="venue" value="{{ old('venue', $event->venue) }}" class="rx-input" placeholder="Mahali patakofanyika tukio">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">Maelezo</label>
                        <textarea id="description" name="description" rows="4" class="rx-input" placeholder="Maelezo ya tukio">{{ old('description', $event->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Mipango, Bajeti na Mahudhurio -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-tasks" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mipango, Bajeti na Mahudhurio</h3>
                        <p class="text-sm text-gray-500">Taarifa za mpango, bajeti na mahudhurio</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="expected_attendance" class="block text-sm font-semibold text-gray-900 mb-2">Watarajiwa</label>
                        <input type="number" id="expected_attendance" name="expected_attendance" value="{{ old('expected_attendance', $event->expected_attendance) }}" min="0"
                               class="rx-input" placeholder="Idadi ya watarajiwa">
                    </div>

                    <div>
                        <label for="actual_attendance" class="block text-sm font-semibold text-gray-900 mb-2">Waliohudhuria</label>
                        <input type="number" id="actual_attendance" name="actual_attendance" value="{{ old('actual_attendance', $event->actual_attendance) }}" min="0"
                               class="rx-input" placeholder="Idadi halisi waliohudhuria">
                        <p class="text-xs text-gray-600 mt-1"><i class="fas fa-info-circle" style="color: #efc120" class="mr-1"></i> Kwa tukio zilizopita tu</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="budget" class="block text-sm font-semibold text-gray-900 mb-2">Bajeti (TZS)</label>
                        <input type="number" id="budget" name="budget" step="0.01" min="0" value="{{ old('budget', $event->budget) }}" class="rx-input" placeholder="0.00">
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">Maelezo Mengine (Hiari)</label>
                        <textarea id="notes" name="notes" rows="3" class="rx-input" placeholder="Maelezo mengine yoyote muhimu...">{{ old('notes', $event->notes) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}
                                       class="h-5 w-5 rounded border-gray-300 focus:ring-primary-500" style="color: #360958">
                                <div class="ml-3 flex items-center">
                                    <i class="fas fa-check-circle mr-2" style="color: #16a34a"></i>
                                    <span class="text-gray-700 font-medium">Tukio ni hai</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('events.show', $event->id) }}" class="rx-btn rx-btn-secondary"><i class="fas fa-times"></i> Ghairi</a>
                <button type="submit" class="rx-btn rx-btn-primary"><i class="fas fa-save"></i> Sasisha Tukio</button>
            </div>
        </form>
    </div>
</div>
@endsection
