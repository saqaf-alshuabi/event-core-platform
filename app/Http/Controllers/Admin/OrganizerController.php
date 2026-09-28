<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SoftDeletesResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use App\Models\Organizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrganizerController extends Controller
{
    use SoftDeletesResource;

    public function index(): Response
    {
        return Inertia::render('Admin/organizers/Index', [
            'organizers' => Organizer::query()->with('user')->latest('updated_at')->get(),
        ]);
    }

    public function store(StoreOrganizerRequest $request): RedirectResponse
    {
        Organizer::create($request->validated());

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer created successfully.');
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
        return $this->renderTrashed();
    }

    public function restore(Organizer $organizer): RedirectResponse
    {
        return $this->restoreModel($organizer);
    }

    public function delete(Organizer $organizer): RedirectResponse
    {
        return $this->forceDeleteModel($organizer);
    }

    protected function softDeleteQuery(): Builder
    {
        return Organizer::query()->with('user');
    }

    protected function trashedInertiaPage(): string
    {
        return 'Admin/organizers/Trashed';
    }

    protected function trashedPropName(): string
    {
        return 'organizers';
    }

    protected function trashedRouteName(): string
    {
        return 'organizers.trashed';
    }
}
