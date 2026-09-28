<?php

use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('about', function () {
    return Inertia::render('Web/About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Web/Contact');
})->name('contact');

Route::prefix('web')
    ->name('web.')
    ->group(function () {
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

        Route::get('shopping', function () {
            return Inertia::render('Web/carts/Shopping');
        })->name('shopping');

        Route::get('checkout', function () {
            return Inertia::render('Web/carts/Checkout');
        })->middleware(['auth', 'verified'])->name('checkout');

        Route::post('orders', [OrderController::class, 'store'])
            ->middleware(['auth', 'verified'])
            ->name('orders.store');
    });

Route::resource('contacts', ContactController::class)->only(['store']);

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
