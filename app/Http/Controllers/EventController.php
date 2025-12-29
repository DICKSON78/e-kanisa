<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of events with filters
     */
    public function index(Request $request)
    {
        $query = Event::with('creator');

        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by upcoming/past
        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->upcoming();
            } elseif ($request->filter === 'past') {
                $query->past();
            }
        } else {
            // Default to upcoming events
            $query->upcoming();
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(20);

        // Get event types for filter
        $eventTypes = Event::select('event_type')
            ->distinct()
            ->whereNotNull('event_type')
            ->orderBy('event_type')
            ->pluck('event_type');

        return view('panel.events.index', compact('events', 'eventTypes'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        // Common event types in Swahili
        $eventTypes = [
            'Ibada',
            'Semina',
            'Mkutano',
            'Sherehe',
            'Kambi',
            'Msaada',
            'Harusi',
            'Mazishi',
            'Hafla Maalum',
            'Mkutano wa Vijana',
            'Mkutano wa Wanawake',
            'Maombi Maalum',
            'Evangelism'
        ];

        return view('panel.events.create', compact('eventTypes'));
    }

    /**
     * Store a newly created event in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',
            'expected_attendance' => 'nullable|integer|min:0|max:999999',
            'actual_attendance' => 'nullable|integer|min:0|max:999999',
            'budget' => 'nullable|numeric|min:0|max:999999999999.99',
            'notes' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'Tafadhali ingiza jina la tukio',
            'title.max' => 'Jina la tukio ni refu mno',
            'description.max' => 'Maelezo ni marefu mno',
            'event_type.required' => 'Tafadhali chagua aina ya tukio',
            'event_type.max' => 'Aina ya tukio ni ndefu mno',
            'event_date.required' => 'Tafadhali chagua tarehe ya tukio',
            'event_date.date' => 'Tarehe si sahihi',
            'start_time.date_format' => 'Muda wa kuanza si sahihi',
            'end_time.date_format' => 'Muda wa kumaliza si sahihi',
            'end_time.after' => 'Muda wa kumaliza lazima uwe baada ya muda wa kuanza',
            'venue.max' => 'Mahali ni refu mno',
            'expected_attendance' => 'Idadi inayotarajiwa si sahihi',
            'actual_attendance' => 'Idadi halisi si sahihi',
            'budget.numeric' => 'Bajeti lazima iwe nambari',
            'budget.min' => 'Bajeti lazima iwe chanya',
            'budget.max' => 'Bajeti ni kubwa mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = true;

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Tukio limerekodiwa kikamilifu');
    }

    /**
     * Display the specified event
     */
    public function show($id)
    {
        $event = Event::with('creator')->findOrFail($id);

        return view('panel.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        $eventTypes = [
            'Ibada',
            'Semina',
            'Mkutano',
            'Sherehe',
            'Kambi',
            'Msaada',
            'Harusi',
            'Mazishi',
            'Hafla Maalum',
            'Mkutano wa Vijana',
            'Mkutano wa Wanawake',
            'Maombi Maalum',
            'Evangelism'
        ];

        return view('panel.events.edit', compact('event', 'eventTypes'));
    }

    /**
     * Update the specified event in storage
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',
            'expected_attendance' => 'nullable|integer|min:0|max:999999',
            'actual_attendance' => 'nullable|integer|min:0|max:999999',
            'budget' => 'nullable|numeric|min:0|max:999999999999.99',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'Tafadhali ingiza jina la tukio',
            'title.max' => 'Jina la tukio ni refu mno',
            'description.max' => 'Maelezo ni marefu mno',
            'event_type.required' => 'Tafadhali chagua aina ya tukio',
            'event_type.max' => 'Aina ya tukio ni ndefu mno',
            'event_date.required' => 'Tafadhali chagua tarehe ya tukio',
            'event_date.date' => 'Tarehe si sahihi',
            'start_time.date_format' => 'Muda wa kuanza si sahihi',
            'end_time.date_format' => 'Muda wa kumaliza si sahihi',
            'end_time.after' => 'Muda wa kumaliza lazima uwe baada ya muda wa kuanza',
            'venue.max' => 'Mahali ni refu mno',
            'expected_attendance' => 'Idadi inayotarajiwa si sahihi',
            'actual_attendance' => 'Idadi halisi si sahihi',
            'budget.numeric' => 'Bajeti lazima iwe nambari',
            'budget.min' => 'Bajeti lazima iwe chanya',
            'budget.max' => 'Bajeti ni kubwa mno',
            'notes.max' => 'Maelezo ni marefu mno',
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Tukio limebadilishwa kikamilifu');
    }

    /**
     * Remove the specified event from storage (soft delete)
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Tukio limefutwa kikamilifu');
    }
}
