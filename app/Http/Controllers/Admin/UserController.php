<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::query()
            ->latest('updated_at')
            ->get(['id', 'name', 'email', 'is_admin', 'created_at', 'updated_at']);

        return Inertia::render('Admin/users/Index', [
            'users' => $users,
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function edit(User $user): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function update(): RedirectResponse
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
        $users = User::onlyTrashed()->latest('updated_at')->get();

        return Inertia::render('Admin/users/Trashed', [
            'users' => $users,
        ]);
    }

    public function restore(User $user): RedirectResponse
    {
        $user->restore();

        return redirect()
            ->route('users.trashed')
            ->with('success', 'User restored successfully.');
    }

    public function delete(User $user): RedirectResponse
    {
        $user->forceDelete();

        return redirect()
            ->route('users.trashed')
            ->with('success', 'User deleted permanently.');
    }
}
