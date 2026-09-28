<?php

use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('about', 'about')->name('about');
    Route::get('contact', 'contact')->name('contact');
});

Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::prefix('web')
    ->name('web.')
    ->group(function () {
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

        Route::get('shopping', [PageController::class, 'shopping'])->name('shopping');

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('checkout', [PageController::class, 'checkout'])->name('checkout');
            Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        });
    });

Route::get('dashboard', [PageController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
