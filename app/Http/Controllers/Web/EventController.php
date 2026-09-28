<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        $events = Event::query()
            ->with('eventImages')
            ->latest('updated_at')
            ->get();

        return Inertia::render('Web/events/Index', [
            'events' => $events,
        ]);
    }

    public function show(Event $event): Response
    {
        $event->load(['eventImages', 'tickets']);

        return Inertia::render('Web/events/Show', [
            'event' => $event,
        ]);
    }
}
