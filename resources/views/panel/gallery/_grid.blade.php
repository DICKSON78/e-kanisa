<!-- Grid Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Galeri
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $galleries->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $galleries->firstItem() }} - {{ $galleries->lastItem() }} ya {{ $galleries->total() }}
    </p>
</div>

<div class="p-6">
    @forelse($galleries as $gallery)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 group mb-4">
        <!-- Thumbnail -->
        <div class="h-48 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden relative">
            @if($gallery->items->isNotEmpty() && $gallery->items->first()->file_type === 'image')
                <img src="{{ asset('storage/' . $gallery->items->first()->file_path) }}"
                     alt="{{ $gallery->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @elseif($gallery->items->isNotEmpty() && $gallery->items->first()->file_type === 'video')
                <div class="text-center">
                    <div class="h-16 w-16 rounded-2xl flex items-center justify-center mx-auto mb-2" style="background: linear-gradient(135deg, #360958, #2a0745)">
                        <i class="fas fa-play text-white text-2xl ml-1"></i>
                    </div>
                    <p class="text-sm text-gray-500">Video</p>
                </div>
            @else
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-2" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-images text-2xl" style="color: #efc120"></i>
                    </div>
                    <p class="text-sm text-gray-400">Hakuna Picha</p>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-4">
            <div class="flex justify-between items-start mb-3">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                    <i class="fas fa-calendar text-[10px]"></i>
                    {{ $gallery->created_at->format('d/m/Y') }}
                </span>
                @if($gallery->status === 'published')
                    <span class="rx-badge rx-badge-success text-[11px]">
                        <i class="fas fa-check-circle mr-1"></i>Imechapishwa
                    </span>
                @else
                    <span class="rx-badge rx-badge-warning text-[11px]">
                        <i class="fas fa-clock mr-1"></i>Rasimu
                    </span>
                @endif
            </div>

            <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2">{{ $gallery->title }}</h3>

            <div class="space-y-1.5 mb-3">
                @if($gallery->event_type)
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-tag mr-2 w-4 text-center" style="color: #efc120"></i>
                    <span>{{ $gallery->event_type }}</span>
                </div>
                @endif

                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-photo-video mr-2 w-4 text-center" style="color: #3b82f6"></i>
                    <span>{{ $gallery->items_count ?? $gallery->items->count() }} vifaa</span>
                </div>

                @if($gallery->media_date)
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-clock mr-2 w-4 text-center" style="color: #16a34a"></i>
                    <span>{{ \Carbon\Carbon::parse($gallery->media_date)->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>

            @if($gallery->description)
            <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $gallery->description }}</p>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('gallery.show', $gallery->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia">
                    <i class="fas fa-eye text-xs"></i>
                </a>
                <a href="{{ route('gallery.edit', $gallery->id) }}" class="rx-icon-btn rx-icon-btn-purple" title="Hariri">
                    <i class="fas fa-edit text-xs"></i>
                </a>
                <button type="button"
                        onclick="confirmAction('delete', {{ $gallery->id }}, '{{ addslashes($gallery->title) }}')"
                        class="rx-icon-btn rx-icon-btn-red"
                        title="Futa">
                    <i class="fas fa-trash text-xs"></i>
                </button>
                <form id="delete-form-{{ $gallery->id }}" action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="rx-empty">
        <div class="rx-empty-icon">
            <i class="fas fa-images text-gray-300 text-2xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna galeri zilizopatikana</p>
        <p class="text-xs text-gray-400 mb-4">Hakuna galeri zinazolingana na vichujio vyako.</p>
        <a href="{{ route('gallery.create') }}" class="rx-btn rx-btn-primary">
            <i class="fas fa-plus"></i> Ongeza Galeri ya Kwanza
        </a>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($galleries->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $galleries->links() }}
</div>
@endif
