<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Support\Auth\LoginController;
use App\Http\Controllers\Support\Auth\SecretLoginController;
use App\Http\Controllers\Support\Auth\ResetPasswordController;
use App\Http\Controllers\Support\Auth\SupportSecretLoginController;

Route::middleware('guest:support')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth:support')->group(function () {
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('secret-login/{user?}', SecretLoginController::class);
Route::get('supports/secret-login/{support}', SupportSecretLoginController::class);
