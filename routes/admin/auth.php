<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\SecretLoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\EmployeeSecretLoginController;

Route::middleware('guest:web,admin,employee')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('secret-login/{user?}', SecretLoginController::class);
Route::get('employees/secret-login/{employee}', EmployeeSecretLoginController::class);
