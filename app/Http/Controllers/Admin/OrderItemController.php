<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;

class OrderItemController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function show(OrderItem $orderItem): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function edit(OrderItem $orderItem): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function update(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function destroy(OrderItem $orderItem): RedirectResponse
    {
        $orderItem->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order item deleted successfully.');
    }

    public function trashed(): RedirectResponse
    {
        return redirect()->route('orders.trashed');
    }

    public function restore(OrderItem $orderItem): RedirectResponse
    {
        $orderItem->restore();

        return redirect()
            ->route('orders.trashed')
            ->with('success', 'Order item restored successfully.');
    }

    public function delete(OrderItem $orderItem): RedirectResponse
    {
        $orderItem->forceDelete();

        return redirect()
            ->route('orders.trashed')
            ->with('success', 'Order item deleted permanently.');
    }
}
