<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\HomeController;
use App\Http\Controllers\Employee\TestController;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\Employee\AccountController;
// use App\Http\Controllers\Employee\SettingController;
// use App\Http\Controllers\Employee\Settings\DomainSettingController;
// use App\Http\Controllers\Employee\Settings\ReturnSettingController;
// use App\Http\Controllers\Employee\Settings\WebsiteSettingController;
// use App\Http\Controllers\Employee\Settings\ExchangeSettingController;
// use App\Http\Controllers\Employee\Settings\ShippingSettingController;

// Home
Route::get('/', HomeController::class)->name('home');

// Orders
Route::prefix('orders')->as('orders.')->group(function () {
    // Route::post('pull/setup', [OrderController::class, 'setupPull'])->name('pull.setup');

    // Route::get('{order}/histories', [OrderController::class, 'histories'])->name('histories.index');
    Route::post('{order}/assign', [OrderController::class, 'assign'])->name('assign');
    Route::post('{order}/unassign', [OrderController::class, 'unassign'])->name('unassign');
    Route::get('{order}/process', [OrderController::class, 'process'])->name('process');
    Route::get('export', [OrderController::class, 'export'])->name('export');
});
Route::resource('orders', OrderController::class)->only('index', 'show');

// Route::prefix('roles')->as('roles.')->group(function () {
//     Route::get('trash', [RoleController::class, 'trash'])->name('trash');
//     Route::put('{role}/restore', [RoleController::class, 'restore'])->name('restore');
//     Route::delete('{role}/force-delete', [RoleController::class, 'forceDestroy'])->name('force-destroy');
// });
// Route::resource('roles', RoleController::class)->except('show');

Route::prefix('reports')->as('reports.')->group(function () {
});

Route::get('account', [AccountController::class, 'index'])->name('account.index');

// Test
Route::get('test', TestController::class)->name('test');
