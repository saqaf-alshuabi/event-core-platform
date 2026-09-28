<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;

class OrderItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, OrderItem $orderItem): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, OrderItem $orderItem): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, OrderItem $orderItem): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, OrderItem $orderItem): bool
    {
        return $user->isAdmin();
    }
}
