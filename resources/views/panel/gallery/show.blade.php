@extends('layouts.app')

@section('title', 'Galeri - Mfumo wa ROC')
@section('page-title', 'Galeri')
@section('page-subtitle', 'Angalia picha na video za galeri')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('gallery.index') }}" class="p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-images" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $gallery->title }}</h1>
            <p class="text-sm text-gray-500">Angalia picha na video za galeri hii</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('gallery.edit', $gallery->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i> Hariri
            </a>
        </div>
    </div>

    <!-- Gallery Profile Header -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    <i class="fas fa-images text-3xl md:text-4xl"></i>
                </div>
                <!-- Info -->
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold truncate">{{ $gallery->title }}</h2>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                @if($gallery->event_type)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(255,255,255,0.15); color: white;">
                                    <i class="fas fa-tag text-[10px]"></i>{{ $gallery->event_type }}
                                </span>
                                @endif
                                @if($gallery->status === 'published')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(34,197,94,0.2); color: #4ade80;">
                                        <i class="fas fa-check-circle"></i>Imechapishwa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(234,179,8,0.2); color: #facc15;">
                                        <i class="fas fa-clock"></i>Rasimu
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Bar -->
        <div class="px-6 md:px-8 py-4 border-b border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-calendar text-sm" style="color: #3b82f6"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Iliundwa</p>
                    <p class="text-sm font-medium text-gray-900">{{ $gallery->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            @if($gallery->media_date)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(16,185,129,0.1)">
                    <i class="fas fa-clock text-sm" style="color: #10b981"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Tarehe ya Tukio</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($gallery->media_date)->format('d/m/Y') }}</p>
                </div>
            </div>
            @endif
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(124,58,237,0.1)">
                    <i class="fas fa-photo-video text-sm" style="color: #7c3aed"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Jumla ya Vifaa</p>
                    <p class="text-sm font-medium text-gray-900">{{ $gallery->items_count ?? $gallery->items->count() }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.1)">
                    <i class="fas fa-hdd text-sm" style="color: #f59e0b"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Ukubwa Jumla</p>
                    <p class="text-sm font-medium text-gray-900">{{ $gallery->total_size ?? '0 MB' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Gallery Details & Media -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Gallery Details Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Galeri</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1">
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar w-4 text-center text-gray-400"></i> Iliundwa</span>
                            <span class="text-sm font-medium text-gray-900">{{ $gallery->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if($gallery->media_date)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center" style="color: #16a34a"></i> Tarehe ya Tukio</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($gallery->media_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if($gallery->event)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar-check w-4 text-center" style="color: #7c3aed"></i> Tukio</span>
                            <span class="text-sm font-medium text-gray-900">{{ $gallery->event->title }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user w-4 text-center text-gray-400"></i> Iliyoandikwa na</span>
                            <span class="text-sm font-medium text-gray-900">{{ $gallery->creator->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-photo-video w-4 text-center" style="color: #3b82f6"></i> Jumla ya Vifaa</span>
                            <span class="text-sm font-medium text-gray-900">{{ $gallery->items_count ?? $gallery->items->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-hdd w-4 text-center" style="color: #16a34a"></i> Ukubwa Jumla</span>
                            <span class="text-sm font-medium text-gray-900">{{ $gallery->total_size ?? '0 MB' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($gallery->description)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Maelezo ya Galeri</h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-quote-left text-sm mt-1" style="color: #efc120"></i>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $gallery->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Media Items Grid -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-th-large text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Picha na Video</h3>
                    <span class="rx-badge rx-badge-default text-[11px]">{{ $gallery->items_count ?? $gallery->items->count() }} vifaa</span>
                </div>

                <div class="p-6">
                    @if($gallery->items->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($gallery->items as $item)
                            <div class="group relative rounded-xl overflow-hidden border border-gray-200 aspect-square bg-gray-100">
                                @if($item->file_type === 'image')
                                    <img src="{{ asset('storage/' . $item->file_path) }}"
                                         alt="{{ $item->caption ?? $gallery->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @elseif($item->file_type === 'video')
                                    <video src="{{ asset('storage/' . $item->file_path) }}"
                                           class="w-full h-full object-cover"
                                           preload="metadata"
                                           muted></video>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 group-hover:bg-opacity-40 transition-all duration-200">
                                        <div class="h-12 w-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center">
                                            <i class="fas fa-play text-lg ml-0.5" style="color: #360958"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-file text-4xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Overlay Info -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <p class="text-white text-xs font-medium truncate">{{ $item->original_name ?? $item->caption ?? 'Bila jina' }}</p>
                                    <p class="text-gray-300 text-xs">{{ $item->formatted_size ?? $item->file_size }}</p>
                                </div>

                                <!-- Delete Button -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <form action="{{ route('gallery.delete-item', [$gallery->id, $item->id]) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Je, una uhakika unataka kufuta faili hili?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="h-8 w-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-200 shadow-lg"
                                                title="Futa">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Caption Below -->
                                @if($item->caption)
                                <div class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-60">
                                    <p class="text-white text-xs truncate">{{ $item->caption }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rx-empty py-8">
                            <div class="rx-empty-icon">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">Hakuna Vifaa Vilivyohifadhiwa</h3>
                            <p class="text-sm text-gray-500">Galeri hii bado haina picha au video.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Add More Files & Quick Actions -->
        <div class="space-y-6">
            <!-- Add More Files -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('gallery.add-items', $gallery->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                                <i class="fas fa-plus-circle" style="color: #efc120"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Ongeza Faili</h3>
                                <p class="text-xs text-gray-500">Pakia picha/video zaidi</p>
                            </div>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-yellow-400 transition duration-200 bg-gray-50">
                            <input type="file" name="files[]" id="addFiles" multiple
                                   accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/mpeg,video/quicktime"
                                   class="hidden" onchange="updateAddFileNames(this)">
                            <label for="addFiles" class="cursor-pointer">
                                <div class="mb-3">
                                    <i class="fas fa-cloud-upload-alt text-4xl" style="color: #360958;"></i>
                                </div>
                                <p class="text-gray-700 font-medium mb-1 text-sm">
                                    Bofya kupakia faili zaidi
                                </p>
                                <p class="text-xs text-gray-500">
                                    Picha na Video
                                </p>
                            </label>
                            <div id="add-file-names" class="mt-3 text-xs font-medium text-green-600 hidden">
                            </div>
                        </div>
                        @error('files')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror

                        <button type="submit" class="rx-btn rx-btn-primary w-full mt-4">
                            <i class="fas fa-upload"></i>
                            <span>Pakia Faili</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-bolt text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Vitendo vya Haraka</h3>
                </div>

                <div class="p-4 space-y-2">
                    <a href="{{ route('gallery.edit', $gallery->id) }}"
                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 border border-gray-100">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-edit" style="color: #efc120"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Hariri Galeri</p>
                            <p class="text-xs text-gray-500">Badilisha taarifa za galeri</p>
                        </div>
                    </a>

                    <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST"
                          onsubmit="return confirm('Je, una uhakika unataka kufuta galeri hii na picha zote?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-red-50 transition-all duration-200 border border-red-100">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-red-50">
                                <i class="fas fa-trash text-red-500"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-red-700">Futa Galeri</p>
                                <p class="text-xs text-red-500">Futa galeri na picha zote</p>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateAddFileNames(input) {
    const fileNamesDiv = document.getElementById('add-file-names');
    if (input.files.length > 0) {
        fileNamesDiv.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i> ' + input.files.length + ' faili limechaguliwa';
        fileNamesDiv.classList.remove('hidden');
    } else {
        fileNamesDiv.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
