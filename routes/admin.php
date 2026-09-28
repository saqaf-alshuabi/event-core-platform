<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::softDeletes('users', UserController::class, 'user');
    Route::resource('users', UserController::class)->only(['index', 'destroy']);

    Route::softDeletes('organizers', OrganizerController::class, 'organizer');
    Route::resource('organizers', OrganizerController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::softDeletes('events', EventController::class, 'event');
    Route::resource('events', EventController::class);

    Route::resource('event.eventImages', EventImageController::class)
        ->parameters(['eventImages' => 'image'])
        ->only(['create', 'store']);
    Route::resource('event_images', EventImageController::class)
        ->only(['edit', 'update', 'destroy']);

    Route::softDeletes('tickets', TicketController::class, 'ticket');
    Route::resource('tickets', TicketController::class)->except(['show']);

    Route::softDeletes('orders', OrderController::class, 'order');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});
