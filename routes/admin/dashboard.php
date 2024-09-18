<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\EmployeeController;

// use App\Http\Controllers\Admin\SettingController;
// use App\Http\Controllers\Admin\Settings\DomainSettingController;
// use App\Http\Controllers\Admin\Settings\ReturnSettingController;
// use App\Http\Controllers\Admin\Settings\WebsiteSettingController;
// use App\Http\Controllers\Admin\Settings\ExchangeSettingController;
// use App\Http\Controllers\Admin\Settings\ShippingSettingController;

// Home
Route::get('/', HomeController::class)->name('home');

// Products
Route::resource('products', ProductController::class)->only('index', 'show');

// Branches
Route::prefix('branches')->as('branches.')->group(function () {
    Route::put('{branch}/toggle-active', [BranchController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('branches', BranchController::class)->only('index', 'show');

// Orders
Route::prefix('orders')->as('orders.')->group(function () {
    // Route::post('pull/setup', [OrderController::class, 'setupPull'])->name('pull.setup');

    // Route::get('{order}/histories', [OrderController::class, 'histories'])->name('histories.index');
    Route::get('export', [OrderController::class, 'export'])->name('export');
});
Route::resource('orders', OrderController::class)->only('index', 'show');

// Employees
Route::prefix('employees')->as('employees.')->group(function () {
    Route::put('{employee}/toggle-active', [EmployeeController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('employees', EmployeeController::class)->except(['create', 'show', 'edit']);

// Users
Route::prefix('users')->as('users.')->group(function () {
    Route::put('{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

// Role
Route::resource('roles', RoleController::class)->except('show');

Route::prefix('reports')->as('reports.')->group(function () {
});

Route::get('account', [AccountController::class, 'index'])->name('account.index');

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
