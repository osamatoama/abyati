<?php

use Illuminate\Support\Facades\Route;

Route::group([], base_path('routes/employee/auth.php'));

// Route::middleware(['auth:employee', 'active'])->group(
Route::middleware(['auth:employee'])->group(
    base_path('routes/employee/dashboard.php')
);
