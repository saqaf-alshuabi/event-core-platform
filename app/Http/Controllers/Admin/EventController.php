<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SoftDeletesResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    use SoftDeletesResource;

    public function index(): Response
    {
        return Inertia::render('Admin/events/Index', [
            'events' => Event::query()->with('eventImages')->latest('updated_at')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/events/Create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $organizer = Auth::user()?->organizer;

        abort_unless($organizer, 403, 'Organizer profile required.');

        $event = Event::create([
            ...$request->safe()->only(['title', 'description', 'location', 'start_date', 'end_date']),
            'organizer_id' => $organizer->id,
        ]);

        $this->storeEventImage($request, $event);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event): Response
    {
        $event->load(['eventImages', 'organizer.user']);

        return Inertia::render('Admin/events/Show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event): Response
    {
        $event->load('eventImages');

        return Inertia::render('Admin/events/Edit', [
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->location,
                'start_date' => $event->start_date->format('Y-m-d'),
                'end_date' => $event->end_date->format('Y-m-d'),
            ],
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->safe()->only([
            'title',
            'description',
            'location',
            'start_date',
            'end_date',
        ]));

        if ($request->hasFile('image')) {
            $this->replaceEventImage($request, $event);
        }

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function trashed(): Response
    {
        return $this->renderTrashed();
    }

    public function restore(Event $event): RedirectResponse
    {
        return $this->restoreModel($event);
    }

    public function delete(Event $event): RedirectResponse
    {
        return $this->forceDeleteModel($event);
    }

    protected function softDeleteQuery(): Builder
    {
        return Event::query()->with('eventImages');
    }

    protected function trashedInertiaPage(): string
    {
        return 'Admin/events/Trashed';
    }

    protected function trashedPropName(): string
    {
        return 'events';
    }

    protected function trashedRouteName(): string
    {
        return 'events.trashed';
    }

    private function storeEventImage(StoreEventRequest|UpdateEventRequest $request, Event $event): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $path = $request->file('image')->store('event_images', 'public');

        EventImage::create([
            'event_id' => $event->id,
            'url' => $path,
        ]);
    }

    private function replaceEventImage(UpdateEventRequest $request, Event $event): void
    {
        $existing = $event->eventImages()->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->url);
            $existing->delete();
        }

        $this->storeEventImage($request, $event);
    }
}
