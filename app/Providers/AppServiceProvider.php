<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        /**
         * Register soft-delete companion routes for an admin resource.
         * Keeps route files DRY instead of repeating trashed/restore/force-delete blocks.
         */
        Route::macro('softDeletes', function (string $name, string $controller, string $parameter) {
            Route::controller($controller)
                ->prefix($name)
                ->name("{$name}.")
                ->group(function () use ($parameter) {
                    Route::get('trashed', 'trashed')->name('trashed');
                    Route::put("{{$parameter}}/restore", 'restore')->withTrashed()->name('restore');
                    Route::delete("{{$parameter}}/delete", 'delete')->withTrashed()->name('delete');
                });
        });
    }
}
