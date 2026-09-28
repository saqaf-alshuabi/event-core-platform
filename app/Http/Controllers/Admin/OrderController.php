<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SoftDeletesResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    use SoftDeletesResource;

    public function index(): Response
    {
        return Inertia::render('Admin/orders/Index', [
            'orders' => Order::query()
                ->with(['attendee.user', 'event', 'orderItems.ticket'])
                ->latest('updated_at')
                ->get(),
        ]);
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
        return $this->show($order);
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
        return $this->renderTrashed();
    }

    public function restore(Order $order): RedirectResponse
    {
        return $this->restoreModel($order);
    }

    public function delete(Order $order): RedirectResponse
    {
        return $this->forceDeleteModel($order);
    }

    protected function softDeleteQuery(): Builder
    {
        return Order::query()->with(['attendee.user', 'event']);
    }

    protected function trashedInertiaPage(): string
    {
        return 'Admin/orders/Trashed';
    }

    protected function trashedPropName(): string
    {
        return 'orders';
    }

    protected function trashedRouteName(): string
    {
        return 'orders.trashed';
    }
}
