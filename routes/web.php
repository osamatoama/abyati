<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('login', 'admin/login')->name('login');


Route::get('locale/{locale?}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('test', [TestController::class, 'index']);
