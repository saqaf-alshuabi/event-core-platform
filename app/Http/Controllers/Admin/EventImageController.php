<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventImageRequest;
use App\Http\Requests\UpdateEventImageRequest;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class EventImageController extends Controller
{
    public function create(Event $event): Response
    {
        return Inertia::render('Admin/event_images/Create', [
            'event' => $event,
        ]);
    }

    public function store(StoreEventImageRequest $request, Event $event): RedirectResponse
    {
        $path = $request->file('image')->store('event_images', 'public');

        EventImage::create([
            'event_id' => $event->id,
            'url' => $path,
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event image uploaded successfully.');
    }

    public function edit(EventImage $eventImage): Response
    {
        return Inertia::render('Admin/event_images/Edit', [
            'eventImage' => $eventImage,
        ]);
    }

    public function update(UpdateEventImageRequest $request, EventImage $eventImage): RedirectResponse
    {
        if ($request->hasFile('image')) {
            if ($eventImage->url) {
                Storage::disk('public')->delete($eventImage->url);
            }

            $eventImage->update([
                'url' => $request->file('image')->store('event_images', 'public'),
            ]);
        }

        return redirect()
            ->route('events.show', $eventImage->event_id)
            ->with('success', 'Event image updated successfully.');
    }

    public function destroy(EventImage $eventImage): RedirectResponse
    {
        $eventId = $eventImage->event_id;

        if ($eventImage->url) {
            Storage::disk('public')->delete($eventImage->url);
        }

        $eventImage->delete();

        return redirect()
            ->route('events.show', $eventId)
            ->with('success', 'Event image deleted successfully.');
    }
}
