<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\Reports\EmployeePerformanceReportController;
use App\Http\Controllers\Admin\Reports\ReportController;

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

// Stores
Route::prefix('stores')->as('stores.')->group(function () {
    // Route::put('{branch}/toggle-active', [BranchController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('stores', StoreController::class)->only('index', 'update');

// Branches
Route::prefix('branches')->as('branches.')->group(function () {
    Route::put('{branch}/toggle-active', [BranchController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('branches', BranchController::class)->only('index', 'edit', 'create', 'destroy');

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

// Supports
Route::prefix('supports')->as('supports.')->group(function () {
    Route::put('{support}/toggle-active', [SupportController::class, 'toggleActive'])->name('toggle_active');
});
Route::resource('supports', SupportController::class)->except(['create', 'show', 'edit']);

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

Route::prefix('reports')->as('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');

    Route::get('employee-performance', [EmployeePerformanceReportController::class, 'index'])->name('employee-performance.index');
});

Route::prefix('settings')->as('settings.')->group(function () {
    // Route::get('/', [SettingController::class, 'index'])->name('index');

    // Route::prefix('return')->as('return.')->controller(ReturnSettingController::class)->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::put('update', 'update')->name('update');
    // });
});
