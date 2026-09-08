<?php

namespace App\Http\Controllers;

use App\Models\MediaGallery;
use App\Models\MediaItem;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaGallery::withCount('items');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('year')) {
            $query->whereYear('media_date', $request->year);
        }

        $galleries = $query->orderBy('media_date', 'desc')->paginate(12);

        $stats = [
            'total_galleries' => MediaGallery::count(),
            'total_items' => MediaItem::count(),
            'total_size' => MediaItem::sum('file_size'),
            'this_month' => MediaGallery::whereMonth('media_date', now()->month)
                ->whereYear('media_date', now()->year)->count(),
        ];

        if ($request->ajax()) {
            return view('panel.gallery._grid', compact('galleries'));
        }

        return view('panel.gallery.index', compact('galleries', 'stats'));
    }

    public function create()
    {
        $events = Event::orderBy('event_date', 'desc')->get(['id', 'title', 'event_date']);
        return view('panel.gallery.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'event_type' => 'nullable|string|max:255',
            'media_date' => 'required|date',
            'event_id' => 'nullable|exists:events,id',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:jpeg,jpg,png,gif,webp,mp4,mov,avi|max:20480',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Tafadhali ingiza jina la albamu',
            'media_date.required' => 'Tafadhali ingiza tarehe',
            'files.required' => 'Tafadhali upload picha au video',
            'files.*.mimes' => 'Aina ya faili hairuhusiwi',
            'files.*.max' => 'Ukubwa wa faili usizidi 20MB',
        ]);

        $validated['created_by'] = auth()->id();

        $gallery = MediaGallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_type' => $validated['event_type'] ?? null,
            'media_date' => $validated['media_date'],
            'status' => 'Published',
            'event_id' => $validated['event_id'] ?? null,
            'created_by' => $validated['created_by'],
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $path = $file->store('gallery/' . $gallery->id, 'public');

                $captions = $request->captions ?? [];

                MediaItem::create([
                    'gallery_id' => $gallery->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'caption' => $captions[$index] ?? null,
                    'alt_text' => $captions[$index] ?? $validated['title'],
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('gallery.show', $gallery->id)
            ->with('success', 'Albamu imeundwa na picha ' . $request->file('files')->count() . ' zimeongezwa');
    }

    public function show($id)
    {
        $gallery = MediaGallery::with(['items', 'event', 'creator'])->findOrFail($id);
        return view('panel.gallery.show', compact('gallery'));
    }

    public function edit($id)
    {
        $gallery = MediaGallery::findOrFail($id);
        $events = Event::orderBy('event_date', 'desc')->get(['id', 'title', 'event_date']);
        return view('panel.gallery.edit', compact('gallery', 'events'));
    }

    public function update(Request $request, $id)
    {
        $gallery = MediaGallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'event_type' => 'nullable|string|max:255',
            'media_date' => 'required|date',
            'status' => 'required|in:Draft,Published,Archived',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $gallery->update($validated);

        // Add new files if any
        if ($request->hasFile('files')) {
            $maxOrder = $gallery->items()->max('sort_order') ?? 0;
            foreach ($request->file('files') as $index => $file) {
                $path = $file->store('gallery/' . $gallery->id, 'public');
                $captions = $request->captions ?? [];

                MediaItem::create([
                    'gallery_id' => $gallery->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'caption' => $captions[$index] ?? null,
                    'alt_text' => $captions[$index] ?? $gallery->title,
                    'sort_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('gallery.show', $gallery->id)
            ->with('success', 'Albamu imesasishwa');
    }

    public function destroy($id)
    {
        $gallery = MediaGallery::findOrFail($id);

        // Delete files from storage
        foreach ($gallery->items as $item) {
            Storage::disk('public')->delete($item->file_path);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')
            ->with('success', 'Albamu imefutwa');
    }

    public function deleteItem($galleryId, $itemId)
    {
        $item = MediaItem::where('gallery_id', $galleryId)->findOrFail($itemId);
        Storage::disk('public')->delete($item->file_path);
        $item->delete();

        return redirect()->back()->with('success', 'Picha imefutwa');
    }
}
