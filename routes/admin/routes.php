<?php

use Illuminate\Support\Facades\Route;

Route::group([], base_path('routes/admin/auth.php'));

Route::middleware(['auth:admin', 'active'])->group(
    base_path('routes/admin/dashboard.php')
);
