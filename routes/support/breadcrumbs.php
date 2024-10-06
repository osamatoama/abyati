<?php

use App\Models\Order;
use Diglactic\Breadcrumbs\Breadcrumbs;

/**
 * Support Breadcrumbs
 */
Breadcrumbs::for('support.home', function ($trail) {
    $trail->push(__('support.home.title'), route('support.home'));
});

//orders
Breadcrumbs::for('support.orders.index', function ($trail) {
    $trail->parent('support.home');
    $trail->push(__('support.orders.title'), route('support.orders.index'));
});

Breadcrumbs::for('support.orders.show', function ($trail, Order $order) {
    $trail->parent('support.orders.index');
    $trail->push(__('support.orders.order_#') . $order->id, '#');
});

Breadcrumbs::for('support.orders.process', function ($trail, Order $order) {
    $trail->parent('support.orders.index');
    $trail->push(__('support.orders.process_order_#', ['id' => $order->reference_id]));
});

//Account
Breadcrumbs::for('support.account.index', function ($trail) {
    $trail->parent('support.home');
    $trail->push(__('support.account.title'), route('support.account.index'));
});

// Reports
Breadcrumbs::for('support.reports.index', function ($trail) {
    $trail->parent('support.home');
    $trail->push(__('support.reports.title'), route('support.reports.index'));
});

Breadcrumbs::for('support.reports.products-without-sku.index', function ($trail) {
    $trail->parent('support.reports.index');
    $trail->push(__('support.reports.products_without_sku.title'), route('support.reports.products-without-sku.index'));
});

