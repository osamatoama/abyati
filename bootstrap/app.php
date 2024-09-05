<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::withoutMiddleware(['api', 'web'])
                ->prefix('webhooks')
                ->name('webhooks.')
                ->group(base_path('routes/webhooks/routes.php'));

            Route::prefix('admin')
                ->middleware(['web', 'localize'])
                ->group(function () {
                    Route::group([], base_path('routes/admin/routes.php'));
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
