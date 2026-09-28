<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Event;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('event.eventImages')->latest('updated_at')->get();
        return Inertia::render('Admin/tickets/Index', ['tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::latest('updated_at')->get();
        return Inertia::render('Admin/tickets/Create', ['events' => $events]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        Ticket::create($request->validated());
        session()->flash('success', 'Ticket created successfully.');
        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return Inertia::render('Admin/tickets/Edit', ['ticket' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        session()->flash('success', 'Ticket updated successfully.');
        return redirect()->route('tickets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        session()->flash('success', 'Ticket deleted successfully.');
        return redirect()->route('tickets.index');
    }
    /**
     * Display a listing of the trashed resources.
     */
    public function trashed()
    {
        $tickets = Ticket::onlyTrashed()->with('event.eventImages')->latest('updated_at')->get();
        return Inertia::render('Admin/tickets/Trashed', ['tickets' => $tickets]);
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Ticket $ticket)
    {
        $ticket->restore();
        session()->flash('success', 'Ticket restored successfully.');
        return redirect()->route('tickets.trashed');
    }
    /**
     * Delete the specified resource.
     */
    public function delete(Ticket $ticket)
    {
        $ticket->forceDelete();
        session()->flash('success', 'Ticket deleted permanently.');
        return redirect()->route('tickets.trashed');
    }
}
