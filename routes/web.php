<?php

use App\Models\Tag;
use App\Models\Order;
use App\Models\Shelf;
use App\Models\Store;
use App\Models\Webhook;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LocaleController;
use App\Services\Orders\Tags\OrderTagChecker;
use App\Imports\Admin\Shelf\ShelfProductsImport;
use App\Imports\Admin\Shelf\WarehouseProductsImport;
use App\Services\Salla\Merchant\SallaMerchantService;

Route::get('/', HomeController::class)->name('home');

Route::redirect('login', 'employee/login')->name('login');

Route::get('locale/{locale?}', [LocaleController::class, 'change'])->name('locale.change');

Route::get('salla-branches', function($page = 1) {
    $response = SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->branches()->get(
        page: $page,
    );

    return $response;
});

Route::get('salla-products', function($page = 1) {
    return SallaMerchantService::withToken(
        accessToken: Store::latest()->first()->user?->sallaToken?->access_token,
    )->products()->get(
        page: $page,
    );
});

Route::get('salla-products/restore', function($page = 1) {
    return SallaMerchantService::withToken(
        accessToken: Store::latest()->first()->user?->sallaToken?->access_token,
    )->products()->restore(
        page: $page,
    );
});

Route::get('salla-products/{id}', function($id) {
    return SallaMerchantService::withToken(
        accessToken: Store::latest()->first()->user?->sallaToken?->access_token,
    )->products()->details(
        id: $id,
    );
});

Route::get('salla-products-quantities', function(Request $request, $page = 1) {
    $filters = $request->query('filters', []);

    return SallaMerchantService::withToken(
        accessToken: Store::first()->user?->sallaToken?->access_token,
    )->products()->quantities(
        // page: $page,
        filters: $filters,
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

Route::get('test/import', function() {
    Excel::import(
        new WarehouseProductsImport(Warehouse::firstWhere('name', 'تبوك')),
        public_path('imports/tabuk-shelves.xlsx')
    );
});

Route::get('test/import-shelf', function() {
    Excel::import(
        new ShelfProductsImport(
            Warehouse::firstWhere('name', 'تبوك'),
            Shelf::firstWhere('name', 'A1'),
        ),
        public_path('imports/shelf-products.xlsx')
    );
});

Route::get('test/sort', function() {
    $shelves = [
        'F1',
        'A10',
        'B6',
        'C11',
        'B3',
        'F2',
    ];

    usort($shelves, function($a, $b) {
        return strnatcmp($a, $b);
    });

    return $shelves;
});

Route::get('test/order-sort', function() {
    $order = Order::find(8523);

    return $order->getItemsSortedByShelf();
});

Route::get('test/import-missing-barcodes', function() {
    return array_map(
        array: cache()->get('import_shelves_missing_barcodes', []),
        callback: fn($barcode) => [
            'barcode' => $barcode
        ],
    );
});

Route::get('test/tagger/{order}', function(Order $order) {
    $tags = Tag::query()
        ->forStore($order->store_id)
        ->active()
        ->get();

    foreach ($tags as $tag) {
        // if (OrderTagChecker::check(
        //     order: $order,
        //     tag: $tag,
        // )) {
        //     $order->tags()->attach($tag->id);
        // }

        $check = OrderTagChecker::check(
            order: $order,
            tag: $tag,
        );

        dump($tag->name . ': ' . ($check ? 'true' : 'false'));
    }
});
