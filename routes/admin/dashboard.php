<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ProductController;
// use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\EmployeeController;
// use App\Http\Controllers\Admin\Settings\DomainSettingController;
// use App\Http\Controllers\Admin\Settings\ReturnSettingController;
// use App\Http\Controllers\Admin\Settings\WebsiteSettingController;
// use App\Http\Controllers\Admin\Settings\ExchangeSettingController;
// use App\Http\Controllers\Admin\Settings\ShippingSettingController;

Route::as('client.')->group(function () {
    // Home
    // Route::get('/', HomeController::class)->name('home');

    // Products
    // Route::resource('products', ProductController::class)->only('index', 'show');

    // Orders
    // Route::prefix('orders')->as('orders.')->group(function () {
    //     Route::post('pull/setup', [OrderController::class, 'setupPull'])->name('pull.setup');

    //     Route::get('{order}/histories', [OrderController::class, 'histories'])->name('histories.index');
    // });
    // Route::resource('orders', OrderController::class)->only('index', 'show');

    // Route::prefix('employees')->as('employees.')->group(function () {
    //     Route::put('{employee}/toggle-active', [EmployeeController::class, 'toggleActive'])->name('toggle_active');
    //     Route::get('trash', [EmployeeController::class, 'trash'])->name('trash');
    //     Route::put('{employee}/restore', [EmployeeController::class, 'restore'])->name('restore');
    //     Route::delete('{employee}/force-delete', [EmployeeController::class, 'forceDestroy'])->name('force-destroy');
    // });
    // Route::resource('employees', EmployeeController::class)->except(['create', 'show', 'edit']);

    // Route::prefix('roles')->as('roles.')->group(function () {
    //     Route::get('trash', [RoleController::class, 'trash'])->name('trash');
    //     Route::put('{role}/restore', [RoleController::class, 'restore'])->name('restore');
    //     Route::delete('{role}/force-delete', [RoleController::class, 'forceDestroy'])->name('force-destroy');
    // });
    // Route::resource('roles', RoleController::class)->except('show');

    Route::prefix('reports')->as('reports.')->group(function () {
    });

    // Route::prefix('account')->as('account.')->group(function () {
    //     Route::get('/', [AccountController::class, 'index'])->name('index');
    // });

    Route::prefix('settings')->as('settings.')->group(function () {
        // Route::get('/', [SettingController::class, 'index'])->name('index');

        // Route::prefix('return')->as('return.')->controller(ReturnSettingController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::put('update', 'update')->name('update');
        // });

        // Route::prefix('exchange')->as('exchange.')->controller(ExchangeSettingController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::put('update', 'update')->name('update');
        // });

        // Route::prefix('website')->as('website.')->controller(WebsiteSettingController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::put('update', 'update')->name('update');
        // });

        // Route::prefix('domain')->as('domain.')->controller(DomainSettingController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::put('update', 'update')->name('update');
        // });

        // Route::prefix('shipping')->as('shipping.')->controller(ShippingSettingController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::put('update', 'update')->name('update');
        // });
    });
});
