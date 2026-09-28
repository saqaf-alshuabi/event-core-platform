<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use App\Models\Organizer;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrganizerController extends Controller
{
    public function index(): Response
    {
        $organizers = Organizer::with('user')->latest('updated_at')->get();

        return Inertia::render('Admin/organizers/Index', [
            'organizers' => $organizers,
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('organizers.index');
    }

    public function store(StoreOrganizerRequest $request): RedirectResponse
    {
        Organizer::create($request->validated());

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer created successfully.');
    }

    public function show(Organizer $organizer): RedirectResponse
    {
        return redirect()->route('organizers.index');
    }

    public function edit(Organizer $organizer): RedirectResponse
    {
        return redirect()->route('organizers.index');
    }

    public function update(UpdateOrganizerRequest $request, Organizer $organizer): RedirectResponse
    {
        $organizer->update($request->validated());

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer updated successfully.');
    }

    public function destroy(Organizer $organizer): RedirectResponse
    {
        $organizer->delete();

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer deleted successfully.');
    }

    public function trashed(): Response
    {
        $organizers = Organizer::with('user')->onlyTrashed()->latest('updated_at')->get();

        return Inertia::render('Admin/organizers/Trashed', [
            'organizers' => $organizers,
        ]);
    }

    public function restore(Organizer $organizer): RedirectResponse
    {
        $organizer->restore();

        return redirect()
            ->route('organizers.trashed')
            ->with('success', 'Organizer restored successfully.');
    }

    public function delete(Organizer $organizer): RedirectResponse
    {
        $organizer->forceDelete();

        return redirect()
            ->route('organizers.trashed')
            ->with('success', 'Organizer deleted permanently.');
    }
}
