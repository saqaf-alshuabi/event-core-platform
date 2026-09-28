<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $orders = Order::with(['attendee.user', 'event', 'orderItems.ticket'])
            ->latest('updated_at')
            ->get();

        return Inertia::render('Admin/orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('orders.index');
    }

    public function show(Order $order): Response
    {
        $order->load(['attendee.user', 'event', 'orderItems.ticket', 'purchasedTickets']);

        return Inertia::render('Admin/orders/Edit', [
            'order' => $order,
        ]);
    }

    public function edit(Order $order): Response
    {
        $order->load(['attendee.user', 'event', 'orderItems.ticket']);

        return Inertia::render('Admin/orders/Edit', [
            'order' => $order,
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function trashed(): Response
    {
        $orders = Order::onlyTrashed()
            ->with(['attendee.user', 'event'])
            ->latest('updated_at')
            ->get();

        return Inertia::render('Admin/orders/Trashed', [
            'orders' => $orders,
        ]);
    }

    public function restore(Order $order): RedirectResponse
    {
        $order->restore();

        return redirect()
            ->route('orders.trashed')
            ->with('success', 'Order restored successfully.');
    }

    public function delete(Order $order): RedirectResponse
    {
        $order->forceDelete();

        return redirect()
            ->route('orders.trashed')
            ->with('success', 'Order deleted permanently.');
    }
}
