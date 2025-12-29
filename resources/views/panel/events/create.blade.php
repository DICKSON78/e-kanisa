@extends('layouts.app')

@section('title', 'Ongeza Tukio - Mfumo wa Kanisa')
@section('page-title', 'Tukio Jipya')
@section('page-subtitle', 'Ongeza tukio jipya la kanisa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Rudi Orodhani
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Ongeza Tukio Jipya</h1>
            </div>
            <p class="text-gray-600">Jaza taarifa za tukio la kanisa</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('events.store') }}" class="divide-y divide-gray-200">
            @csrf

            <!-- Event Details Section -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Tukio</h3>
                        <p class="text-sm text-gray-600">Jaza taarifa za kimsingi za tukio</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                            Kichwa cha Tukio <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-gray-400"></i>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('title') border-red-500 @enderror"
                                   placeholder="Kichwa cha tukio">
                        </div>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Type -->
                    <div>
                        <label for="event_type" class="block text-sm font-semibold text-gray-900 mb-2">
                            Aina ya Tukio <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list-alt text-gray-400"></i>
                            </div>
                            <select id="event_type" name="event_type" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('event_type') border-red-500 @enderror">
                                <option value="">Chagua Aina ya Tukio</option>
                                <option value="Ibada" {{ old('event_type') === 'Ibada' ? 'selected' : '' }}>Ibada</option>
                                <option value="Semina" {{ old('event_type') === 'Semina' ? 'selected' : '' }}>Semina</option>
                                <option value="Mkutano" {{ old('event_type') === 'Mkutano' ? 'selected' : '' }}>Mkutano</option>
                                <option value="Sherehe" {{ old('event_type') === 'Sherehe' ? 'selected' : '' }}>Sherehe</option>
                                <option value="Kambi" {{ old('event_type') === 'Kambi' ? 'selected' : '' }}>Kambi</option>
                                <option value="Mkesha" {{ old('event_type') === 'Mkesha' ? 'selected' : '' }}>Mkesha</option>
                                <option value="Safari" {{ old('event_type') === 'Safari' ? 'selected' : '' }}>Safari</option>
                                <option value="Tamasha" {{ old('event_type') === 'Tamasha' ? 'selected' : '' }}>Tamasha</option>
                                <option value="Matambuzi" {{ old('event_type') === 'Matambuzi' ? 'selected' : '' }}>Matambuzi</option>
                                <option value="Furaha" {{ old('event_type') === 'Furaha' ? 'selected' : '' }}>Furaha</option>
                            </select>
                        </div>
                        @error('event_type')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-day text-gray-400"></i>
                            </div>
                            <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" required
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('event_date') border-red-500 @enderror">
                        </div>
                        @error('event_date')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-semibold text-gray-900 mb-2">
                            Muda wa Kuanza
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-400"></i>
                            </div>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('start_time') border-red-500 @enderror">
                        </div>
                        @error('start_time')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-semibold text-gray-900 mb-2">
                            Muda wa Mwisho
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-400"></i>
                            </div>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('end_time') border-red-500 @enderror">
                        </div>
                        @error('end_time')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Venue -->
                    <div class="md:col-span-2">
                        <label for="venue" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mahali
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input type="text" id="venue" name="venue" value="{{ old('venue') }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('venue') border-red-500 @enderror"
                                   placeholder="Mahali patakofanyika tukio">
                        </div>
                        @error('venue')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                            Maelezo
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-align-left text-gray-400"></i>
                            </div>
                            <textarea id="description" name="description" rows="4"
                                      class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('description') border-red-500 @enderror"
                                      placeholder="Maelezo ya tukio">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Planning Section -->
            <div class="p-6 bg-gray-50">
                <div class="flex items-center mb-6">
                    <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tasks text-primary-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mipango na Bajeti</h3>
                        <p class="text-sm text-gray-600">Taarifa za mpango na bajeti</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Expected Attendance -->
                    <div>
                        <label for="expected_attendance" class="block text-sm font-semibold text-gray-900 mb-2">
                            Watarajiwa
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input type="number" id="expected_attendance" name="expected_attendance" value="{{ old('expected_attendance') }}" min="0"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('expected_attendance') border-red-500 @enderror"
                                   placeholder="Idadi ya watarajiwa">
                        </div>
                        @error('expected_attendance')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Budget -->
                    <div>
                        <label for="budget" class="block text-sm font-semibold text-gray-900 mb-2">
                            Bajeti (TZS)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                            </div>
                            <input type="number" id="budget" name="budget" step="0.01" min="0" value="{{ old('budget') }}"
                                   class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900 @error('budget') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('budget')
                            <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                            Maelezo Mengine (Hiari)
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3">
                                <i class="fas fa-sticky-note text-gray-400"></i>
                            </div>
                            <textarea id="notes" name="notes" rows="3"
                                      class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-900"
                                      placeholder="Maelezo mengine yoyote muhimu...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('events.index') }}"
                   class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-primary-600 text-white font-bold rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi Tukio</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
