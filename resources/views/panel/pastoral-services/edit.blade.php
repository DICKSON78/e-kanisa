@extends('layouts.app')

@section('title', 'Hariri Ombi la Huduma - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('pastoral-services.show', $service->id) }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-edit" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hariri Ombi la Huduma</h1>
                <p class="text-sm text-gray-500">{{ $service->service_number }} - Sasisha taarifa za ombi</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('pastoral-services.update', $service->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Huduma -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-hands-praying" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Huduma</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za kimsingi za ombi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Muumini <span class="text-red-500">*</span></label>
                        <select name="member_id" required class="rx-select @error('member_id') !border-red-500 @enderror">
                            <option value="">Chagua Muumini</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ (old('member_id', $service->member_id) == $member->id) ? 'selected' : '' }}>
                                    {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }} ({{ $member->member_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Huduma <span class="text-red-500">*</span></label>
                        <select name="service_type" required class="rx-select @error('service_type') !border-red-500 @enderror">
                            <option value="">Chagua Aina ya Huduma</option>
                            @foreach($serviceTypes as $key => $value)
                                <option value="{{ $key }}" {{ (old('service_type', $service->service_type) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('service_type')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Inayopendelewa</label>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date', $service->preferred_date ? $service->preferred_date->format('Y-m-d') : '') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="rx-input rx-input-no-icon @error('preferred_date') !border-red-500 @enderror">
                        <p class="mt-1.5 text-xs text-gray-500"><i class="fas fa-info-circle mr-1" style="color: #efc120"></i>Chagua tarehe unayopendelea kupata huduma hii</p>
                        @error('preferred_date')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo za Ziada</h3>
                        <p class="text-xs text-gray-500">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo (Hiari)</label>
                    <textarea name="description" rows="5" class="rx-input rx-input-no-icon @error('description') !border-red-500 @enderror" placeholder="Andika maelezo zaidi kuhusu ombi lako...">{{ old('description', $service->description) }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('pastoral-services.show', $service->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi Mabadiliko</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
