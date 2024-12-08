<?php

use App\Enums\EmployeeRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Employee\HasRole;
use App\Http\Controllers\Employee\HomeController;
use App\Http\Controllers\Employee\TestController;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\Employee\ShelfController;
use App\Http\Controllers\Employee\AccountController;
use App\Http\Controllers\Employee\ProductController;

// Home
Route::get('/', HomeController::class)->name('home');

// Products
Route::prefix('products')->as('products.')->group(function () {
    Route::get('select', [ProductController::class, 'select'])->name('select');
});

// Orders
Route::prefix('orders')
    ->as('orders.')
    ->middleware(HasRole::class . ':' . EmployeeRole::ORDERS_FULFILLMENT->value)
    ->group(function () {
        Route::post('{order}/assign', [OrderController::class, 'assign'])->name('assign');
        Route::post('{order}/unassign', [OrderController::class, 'unassign'])->name('unassign');
        Route::get('{order}/process', [OrderController::class, 'process'])->name('process');
        Route::get('export', [OrderController::class, 'export'])->name('export');
        Route::post('{order}/reset', [OrderController::class, 'reset'])->name('reset');

        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('{order}', [OrderController::class, 'show'])->name('show');
});

// Shelves
Route::prefix('shelves')
    ->as('shelves.')
    ->middleware(HasRole::class . ':' . EmployeeRole::STOCKTAKING->value)
    ->group(function () {
        Route::get('select', [ShelfController::class, 'select'])->name('select');
        Route::get('select-ailses', [ShelfController::class, 'selectAisles'])->name('select.aisles');
        Route::get('{shelf}/products', [ShelfController::class, 'products'])->name('products');
        Route::post('{shelf}/products/attach', [ShelfController::class, 'attachProduct'])->name('products.attach');
        Route::put('{shelf}/products/bulk-detach', [ShelfController::class, 'bulkDetachProducts'])->name('products.bulk_detach');
        Route::put('{shelf}/products/bulk-transfer', [ShelfController::class, 'bulkTransferProducts'])->name('products.bulk_transfer');
        Route::put('{shelf}/products/{product}/detach', [ShelfController::class, 'detachProduct'])->name('products.detach');

        Route::get('/', [ShelfController::class, 'index'])->name('index');
        Route::get('{shelf}', [ShelfController::class, 'show'])->name('show');
});

// Reports
Route::prefix('reports')->as('reports.')->group(function () {
    //
});

Route::get('account', [AccountController::class, 'index'])->name('account.index');

// Test
Route::get('test', TestController::class)->name('test');
