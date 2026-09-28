<?php

use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\PurchasedTicketController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/trashed', 'trashed')->name('users.trashed');
        Route::put('/users/{user}/restore', 'restore')->name('users.restore')->withTrashed();
        Route::delete('/users/{user}/delete', 'delete')->name('users.delete')->withTrashed();
    });
    Route::resource('users', UserController::class);

    Route::controller(OrganizerController::class)->group(function () {
        Route::get('/organizers/trashed', 'trashed')->name('organizers.trashed');
        Route::put('/organizers/{organizer}/restore', 'restore')->name('organizers.restore')->withTrashed();
        Route::delete('/organizers/{organizer}/delete', 'delete')->name('organizers.delete')->withTrashed();
    });
    Route::resource('organizers', OrganizerController::class);

    Route::controller(AttendeeController::class)->group(function () {
        Route::get('/attendees/trashed', 'trashed')->name('attendees.trashed');
        Route::put('/attendees/{attendee}/restore', 'restore')->name('attendees.restore')->withTrashed();
        Route::delete('/attendees/{attendee}/delete', 'delete')->name('attendees.delete')->withTrashed();
    });
    Route::resource('attendees', AttendeeController::class);

    Route::controller(EventController::class)->group(function () {
        Route::get('/events/trashed', 'trashed')->name('events.trashed');
        Route::put('/events/{event}/restore', 'restore')->name('events.restore')->withTrashed();
        Route::delete('/events/{event}/delete', 'delete')->name('events.delete')->withTrashed();
    });

    Route::resource('events', EventController::class);
    Route::resource('event.eventImages', EventImageController::class)
        ->parameters(['eventImages' => 'image'])
        ->only(['store', 'create']);
    Route::resource('event_images', EventImageController::class)->except(['store', 'create', 'show', 'index']);

    Route::controller(TicketController::class)->group(function () {
        Route::get('/tickets/trashed', 'trashed')->name('tickets.trashed');
        Route::put('/tickets/{ticket}/restore', 'restore')->name('tickets.restore')->withTrashed();
        Route::delete('/tickets/{ticket}/delete', 'delete')->name('tickets.delete')->withTrashed();
    });
    Route::resource('tickets', TicketController::class);

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders/trashed', 'trashed')->name('orders.trashed');
        Route::put('/orders/{order}/restore', 'restore')->name('orders.restore')->withTrashed();
        Route::delete('/orders/{order}/delete', 'delete')->name('orders.delete')->withTrashed();
    });
    Route::resource('orders', OrderController::class);

    Route::controller(OrderItemController::class)->group(function () {
        Route::get('/order_items/trashed', 'trashed')->name('order_items.trashed');
        Route::put('/order_items/{order_item}/restore', 'restore')->name('order_items.restore')->withTrashed();
        Route::delete('/order_items/{order_item}/delete', 'delete')->name('order_items.delete')->withTrashed();
    });
    Route::resource('order_items', OrderItemController::class);

    Route::controller(PurchasedTicketController::class)->group(function () {
        Route::get('/purchased_tickets/trashed', 'trashed')->name('purchased_tickets.trashed');
        Route::put('/purchased_tickets/{purchased_ticket}/restore', 'restore')->name('purchased_tickets.restore')->withTrashed();
        Route::delete('/purchased_tickets/{purchased_ticket}/delete', 'delete')->name('purchased_tickets.delete')->withTrashed();
    });
    Route::resource('purchased_tickets', PurchasedTicketController::class);
});
