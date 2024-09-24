<?php

use Illuminate\Support\Facades\Route;

Route::group([], base_path('routes/support/auth.php'));

// Route::middleware(['auth:support', 'active'])->group(
Route::middleware(['auth:support'])->group(
    base_path('routes/support/dashboard.php')
);
