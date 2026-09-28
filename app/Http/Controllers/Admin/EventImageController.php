<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Models\EventImage;
use App\Http\Requests\StoreEventImageRequest;
use App\Http\Requests\UpdateEventImageRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return Inertia::render('Admin/event_images/Create', ['event' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventImageRequest $request, Event $event)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
            EventImage::create([
                'event_id' => $event->id,
                'url' => $imagePath,
            ]);
        }
        session()->flash('success', 'EventImage created successfully.');
        return redirect()->route('events.show', $event->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventImage $eventImage)
    {
        //
    }

    public function edit(EventImage $eventImage)
    {
        return Inertia::render('Admin/event_images/Edit', ['eventImage' => $eventImage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventImageRequest $request, EventImage $eventImage)
    {
        if ($request->hasFile('image')) {
            if ($eventImage->url) {
                Storage::disk('public')->delete($eventImage->url);
            }

            $imagePath = $request->file('image')->store('event_images', 'public');
            $eventImage->update([
                'url' => $imagePath,
            ]);
        }

        session()->flash('success', 'EventImage updated successfully.');
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventImage $eventImage)
    {
        if ($eventImage->url) {
            Storage::disk('public')->delete($eventImage->url);
        }
        $eventImage->delete();
        session()->flash('success', 'EventImage deleted successfully.');
        return redirect()->route('events.show', $eventImage->event_id);
    }
}
