<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhooks\V1\SallaWebhookController;

Route::post('salla', SallaWebhookController::class)->name('salla');
