<?php

use App\Models\Store;
use App\Models\Webhook;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LocaleController;
use App\Services\Salla\Merchant\SallaMerchantService;

Route::get('/', HomeController::class)->name('home');

Route::redirect('login', 'employee/login')->name('login');

Route::get('locale/{locale?}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('salla-products/{id}', function($id) {
    return SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->products()->details(
        id: $id,
    );
});

Route::get('salla-orders/{id}', function($id) {
    return SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->orders()->details(
        id: $id,
        filters: [
            'format' => 'light',
        ],
    );
});

Route::get('salla-order-items/{id}', function($id) {
    return SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->orderItems()->get(
        orderId: $id,
    );
});

Route::get('test', [TestController::class, 'index']);

Route::get('test/webhooks', function() {
    $ordersWebhooks = Webhook::select('id', 'event', 'provider_created_at', 'created_at', 'payload')
        ->where('provider_type', 'salla')
        ->where('provider_store_id', 625897342)
        ->whereIn('event', ['order.updated', 'order.status.updated'])
        ->orderBy('provider_created_at')
        ->get()
        ->map(function($webhook) {
            $webhook->order_id = $webhook->payload['order']['id'] ?? $webhook->payload['id'];
            unset($webhook->payload);
            $webhook->provider_created_at = (string) $webhook->provider_created_at->format('Y-m-d H:i');
            $webhook->created_at = (string) $webhook->created_at->format('Y-m-d H:i');
            return $webhook;
        })
        ->groupBy('order_id');

    $mistakeOrders = [];

    foreach ($ordersWebhooks as $orderId => $orderWebhooks) {
        if ($orderWebhooks->contains('event', 'order.status.updated') && ! $orderWebhooks->contains('event', 'order.updated')) {
            $mistakeOrders[$orderId] = $orderWebhooks;
        }
    }

    return [
        'all_count' => $ordersWebhooks->count(),
        'mistake_count' => count($mistakeOrders),
        'mistakes' => $mistakeOrders,
        'all' => $ordersWebhooks,
    ];
});

