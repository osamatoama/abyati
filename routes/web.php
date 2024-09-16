<?php

use App\Models\Store;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LocaleController;
use App\Services\Salla\Merchant\SallaMerchantService;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('login', 'admin/login')->name('login');


Route::get('locale/{locale?}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('salla-products/{id}', function($id) {
    return SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->products()->details(
        id: $id,
    );
});

Route::get('test', [TestController::class, 'index']);
