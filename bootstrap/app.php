<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Localize;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::withoutMiddleware(['api', 'web'])
                ->prefix('webhooks')
                ->name('webhooks.')
                ->group(base_path('routes/webhooks/routes.php'));

            Route::prefix('admin')
                ->name('admin.')
                ->middleware(['web', Localize::class])
                ->group(function () {
                    Route::group([], base_path('routes/admin/routes.php'));
                });

            Route::prefix('employee')
                ->name('employee.')
                ->middleware(['web', Localize::class])
                ->group(function () {
                    Route::group([], base_path('routes/employee/routes.php'));
                });

            Route::prefix('support')
                ->name('support.')
                ->middleware(['web', Localize::class])
                ->group(function () {
                    Route::group([], base_path('routes/support/routes.php'));
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->routeIs('admin.*')) {
                return route('admin.login');
            }

            if ($request->routeIs('employee.*')) {
                return route('employee.login');
            }

            if ($request->routeIs('support.*')) {
                return route('support.login');
            }

            return url('/');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
