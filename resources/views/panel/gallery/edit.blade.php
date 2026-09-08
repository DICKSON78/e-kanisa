@extends('layouts.app')

@section('title', 'Hariri Galeri - Mfumo wa ROC')
@section('page-title', 'Hariri Galeri')
@section('page-subtitle', 'Badilisha taarifa za galeri')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('gallery.show', $gallery->id) }}" class="p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Hariri Galeri</h1>
            <p class="text-sm text-gray-500">Sasisha taarifa za {{ $gallery->title }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Edit Details Form -->
        <div class="rx-card rounded-2xl overflow-hidden">
            <form method="POST" action="{{ route('gallery.update', $gallery->id) }}">
                @csrf
                @method('PUT')

                <!-- Gallery Details Section -->
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-images" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Taarifa za Galeri</h3>
                            <p class="text-sm text-gray-500">Sasisha taarifa za kimsingi</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                                Kichwa cha Galeri <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-heading text-gray-400"></i>
                                </div>
                                <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" required
                                       class="rx-input @error('title') border-red-500 @enderror"
                                       placeholder="Kichwa cha galeri">
                            </div>
                            @error('title')
                                <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                                Maelezo
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </div>
                                <textarea id="description" name="description" rows="4"
                                          class="rx-input pl-10 @error('description') border-red-500 @enderror"
                                          placeholder="Maelezo ya galeri">{{ old('description', $gallery->description) }}</textarea>
                            </div>
                            @error('description')
                                <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Type -->
                        <div>
                            <label for="event_type" class="block text-sm font-semibold text-gray-900 mb-2">
                                Aina ya Tukio
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-list-alt text-gray-400"></i>
                                </div>
                                <select id="event_type" name="event_type"
                                        class="rx-select">
                                    <option value="">Chagua Aina ya Tukio</option>
                                    <option value="Ibada" {{ old('event_type', $gallery->event_type) === 'Ibada' ? 'selected' : '' }}>Ibada</option>
                                    <option value="Semina" {{ old('event_type', $gallery->event_type) === 'Semina' ? 'selected' : '' }}>Semina</option>
                                    <option value="Mkutano" {{ old('event_type', $gallery->event_type) === 'Mkutano' ? 'selected' : '' }}>Mkutano</option>
                                    <option value="Sherehe" {{ old('event_type', $gallery->event_type) === 'Sherehe' ? 'selected' : '' }}>Sherehe</option>
                                    <option value="Kambi" {{ old('event_type', $gallery->event_type) === 'Kambi' ? 'selected' : '' }}>Kambi</option>
                                    <option value="Mkesha" {{ old('event_type', $gallery->event_type) === 'Mkesha' ? 'selected' : '' }}>Mkesha</option>
                                    <option value="Safari" {{ old('event_type', $gallery->event_type) === 'Safari' ? 'selected' : '' }}>Safari</option>
                                    <option value="Tamasha" {{ old('event_type', $gallery->event_type) === 'Tamasha' ? 'selected' : '' }}>Tamasha</option>
                                    <option value="Nyingine" {{ old('event_type', $gallery->event_type) === 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                                </select>
                            </div>
                        </div>

                        <!-- Media Date -->
                        <div>
                            <label for="media_date" class="block text-sm font-semibold text-gray-900 mb-2">
                                Tarehe ya Tukio
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-day text-gray-400"></i>
                                </div>
                                <input type="date" id="media_date" name="media_date" value="{{ old('media_date', $gallery->media_date ? \Carbon\Carbon::parse($gallery->media_date)->format('Y-m-d') : '') }}"
                                       class="rx-input @error('media_date') border-red-500 @enderror">
                            </div>
                            @error('media_date')
                                <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Select -->
                        <div>
                            <label for="event_id" class="block text-sm font-semibold text-gray-900 mb-2">
                                Tukio (Hiari)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-check text-gray-400"></i>
                                </div>
                                <select id="event_id" name="event_id"
                                        class="rx-select">
                                    <option value="">Chagua Tukio (Hiari)</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('event_id', $gallery->event_id) == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }} - {{ $event->event_date->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" value="published" {{ old('status', $gallery->status) === 'published' ? 'checked' : '' }}
                                           class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                    <div class="ml-3 flex items-center">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <span class="text-gray-700 font-medium text-sm">Chapisha Galeri</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('gallery.show', $gallery->id) }}" class="rx-btn rx-btn-secondary">
                            <i class="fas fa-times"></i>
                            <span>Ghairi</span>
                        </a>
                        <button type="submit" class="rx-btn rx-btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Sasisha Galeri</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add More Files -->
        <div class="space-y-6">
            <div class="rx-card rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('gallery.add-items', $gallery->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                <i class="fas fa-cloud-upload-alt" style="color: #efc120"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Ongeza Faili Zaidi</h3>
                                <p class="text-sm text-gray-500">Pakia picha na/au video mpya</p>
                            </div>
                        </div>

                        <div>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-yellow-400 transition duration-200 bg-gray-50">
                                <input type="file" name="files[]" id="addFiles" multiple
                                       accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/mpeg,video/quicktime"
                                       class="hidden" onchange="updateAddFileNames(this)">
                                <label for="addFiles" class="cursor-pointer">
                                    <div class="mb-3">
                                        <i class="fas fa-cloud-upload-alt text-5xl" style="color: #360958;"></i>
                                    </div>
                                    <p class="text-gray-700 font-medium mb-1">
                                        Bofya hapa kuchagua faili
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Picha (JPEG, PNG, GIF, WebP) na Video (MP4, MPEG, MOV)
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        Unaweza kuchagua faili nyingi kwa wakati mmoja
                                    </p>
                                </label>
                                <div id="add-file-names" class="mt-4 text-sm font-medium text-green-600 hidden">
                                </div>
                                <div id="add-file-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3 hidden">
                                </div>
                            </div>
                            @error('files')
                                <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                            @error('files.*')
                                <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
                        <div class="flex justify-end">
                            <button type="submit" class="rx-btn rx-btn-primary">
                                <i class="fas fa-upload"></i>
                                <span>Pakia Faili</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Current Files -->
            @if($gallery->items->count() > 0)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-th" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Faili za Sasa</h3>
                        <p class="text-sm text-gray-500">{{ $gallery->items->count() }} faili</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @foreach($gallery->items->take(9) as $item)
                    <div class="relative aspect-square rounded-xl overflow-hidden border border-gray-200">
                        @if($item->file_type === 'image')
                            <img src="{{ asset('storage/' . $item->file_path) }}"
                                 alt="{{ $item->caption ?? '' }}"
                                 class="w-full h-full object-cover">
                        @elseif($item->file_type === 'video')
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-video text-2xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    @endforeach
                    @if($gallery->items->count() > 9)
                    <div class="aspect-square rounded-xl border border-gray-200 flex items-center justify-center bg-gray-50">
                        <span class="text-sm text-gray-500 font-medium">+{{ $gallery->items->count() - 9 }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateAddFileNames(input) {
    const fileNamesDiv = document.getElementById('add-file-names');
    const filePreviewDiv = document.getElementById('add-file-preview');

    if (input.files.length > 0) {
        let names = Array.from(input.files).map(f => f.name).join(', ');
        fileNamesDiv.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i> ' + input.files.length + ' faili limechaguliwa';
        fileNamesDiv.classList.remove('hidden');

        filePreviewDiv.innerHTML = '';
        filePreviewDiv.classList.remove('hidden');
        Array.from(input.files).forEach(file => {
            const preview = document.createElement('div');
            preview.className = 'relative rounded-lg overflow-hidden border border-gray-200 aspect-square';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<div class="w-full h-full bg-gray-100 flex items-center justify-center"><i class="fas fa-video text-3xl text-gray-400"></i></div>';
            }
            filePreviewDiv.appendChild(preview);
        });
    } else {
        fileNamesDiv.classList.add('hidden');
        filePreviewDiv.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
