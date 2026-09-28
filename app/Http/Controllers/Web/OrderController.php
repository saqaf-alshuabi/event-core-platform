<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Attendee;
use App\Models\Order;
use App\Models\PurchasedTicket;
use App\Models\Ticket;
use App\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $attendee = Attendee::firstOrCreate(['user_id' => $user->id]);

        $items = collect($request->validated('items'));
        $groupedByEvent = $items->groupBy('event_id');

        DB::transaction(function () use ($groupedByEvent, $attendee) {
            foreach ($groupedByEvent as $eventId => $eventItems) {
                $total = $eventItems->sum(fn (array $item) => $item['price'] * $item['quantity']);

                $order = Order::create([
                    'event_id' => $eventId,
                    'attendee_id' => $attendee->id,
                    'total_price' => $total,
                    'status' => OrderStatus::Pending,
                ]);

                foreach ($eventItems as $item) {
                    $ticket = Ticket::query()
                        ->whereKey($item['id'])
                        ->where('event_id', $eventId)
                        ->firstOrFail();

                    $order->orderItems()->create([
                        'ticket_id' => $ticket->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    for ($i = 0; $i < $item['quantity']; $i++) {
                        PurchasedTicket::create([
                            'order_id' => $order->id,
                            'ticket_id' => $ticket->id,
                            'attendee_id' => $attendee->id,
                            'ticket_code' => strtoupper(Str::random(10)),
                            'is_used' => false,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('web.events.index')
            ->with('success', 'Order placed successfully.');
    }
}
