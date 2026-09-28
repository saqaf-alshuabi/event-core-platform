<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SoftDeletesResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    use SoftDeletesResource;

    public function index(): Response
    {
        return Inertia::render('Admin/tickets/Index', [
            'tickets' => Ticket::query()->with('event.eventImages')->latest('updated_at')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/tickets/Create', [
            'events' => Event::query()->latest('updated_at')->get(['id', 'title']),
        ]);
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        Ticket::create($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function edit(Ticket $ticket): Response
    {
        return Inertia::render('Admin/tickets/Edit', [
            'ticket' => $ticket,
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function trashed(): Response
    {
        return $this->renderTrashed();
    }

    public function restore(Ticket $ticket): RedirectResponse
    {
        return $this->restoreModel($ticket);
    }

    public function delete(Ticket $ticket): RedirectResponse
    {
        return $this->forceDeleteModel($ticket);
    }

    protected function softDeleteQuery(): Builder
    {
        return Ticket::query()->with('event.eventImages');
    }

    protected function trashedInertiaPage(): string
    {
        return 'Admin/tickets/Trashed';
    }

    protected function trashedPropName(): string
    {
        return 'tickets';
    }

    protected function trashedRouteName(): string
    {
        return 'tickets.trashed';
    }
}
