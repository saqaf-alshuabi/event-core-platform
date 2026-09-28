<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SoftDeletesResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    use SoftDeletesResource;

    public function index(): Response
    {
        return Inertia::render('Admin/users/Index', [
            'users' => User::query()
                ->latest('updated_at')
                ->get(['id', 'name', 'email', 'is_admin', 'created_at', 'updated_at']),
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function trashed(): Response
    {
        return $this->renderTrashed();
    }

    public function restore(User $user): RedirectResponse
    {
        return $this->restoreModel($user);
    }

    public function delete(User $user): RedirectResponse
    {
        return $this->forceDeleteModel($user);
    }

    protected function softDeleteQuery(): Builder
    {
        return User::query();
    }

    protected function trashedInertiaPage(): string
    {
        return 'Admin/users/Trashed';
    }

    protected function trashedPropName(): string
    {
        return 'users';
    }

    protected function trashedRouteName(): string
    {
        return 'users.trashed';
    }
}
