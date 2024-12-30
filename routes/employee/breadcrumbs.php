<?php

use App\Models\Order;
use App\Models\Shelf;
use App\Models\Stocktaking;
use Diglactic\Breadcrumbs\Breadcrumbs;

/**
 * Employee Breadcrumbs
 */
Breadcrumbs::for('employee.home', function ($trail) {
    $trail->push(__('employee.home.title'), route('employee.home'));
});

//roles
Breadcrumbs::for('employee.roles.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.roles.title'), route('employee.roles.index'));
});

Breadcrumbs::for('employee.roles.create', function ($trail) {
    $trail->parent('employee.roles.index');
    $trail->push(__('employee.roles.action.create'), route('employee.roles.create'));
});

Breadcrumbs::for('employee.roles.trash', function ($trail) {
    $trail->parent('employee.roles.index');
    $trail->push(__('employee.roles.trash'), route('employee.roles.trash', request('role')));
});

Breadcrumbs::for('employee.roles.edit', function ($trail) {
    $trail->parent('employee.roles.index');
    $trail->push(__('employee.roles.action.edit'), route('employee.roles.edit', request('role')));
});

//orders
Breadcrumbs::for('employee.orders.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.orders.title'), route('employee.orders.index'));
});

Breadcrumbs::for('employee.orders.show', function ($trail, Order $order) {
    $trail->parent('employee.orders.index');
    $trail->push(__('employee.orders.order_#') . $order->id, '#');
});

Breadcrumbs::for('employee.orders.process', function ($trail, Order $order) {
    $trail->parent('employee.orders.index');
    $trail->push($order->reference_id . '#');
});

// Shelves
Breadcrumbs::for('employee.shelves.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.shelves.title'), route('employee.shelves.index'));
});

Breadcrumbs::for('employee.shelves.show', function ($trail, Shelf $shelf) {
    $trail->parent('employee.shelves.index');
    $trail->push($shelf->name, route('employee.shelves.show', $shelf->id));
});

Breadcrumbs::for('employee.shelves.products.sync', function ($trail, Shelf $shelf) {
    $trail->parent('employee.shelves.show', $shelf);
    $trail->push(__('employee.shelves.actions.sync_products'), route('employee.shelves.products.sync', $shelf->id));
});

// Stocktakings
Breadcrumbs::for('employee.stocktakings.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.stocktakings.title'), route('employee.stocktakings.index'));
});

Breadcrumbs::for('employee.stocktakings.show', function ($trail, Stocktaking $stocktaking) {
    $trail->parent('employee.stocktakings.index');
    $trail->push($stocktaking->id, route('employee.stocktakings.show', $stocktaking->id));
});

Breadcrumbs::for('employee.stocktakings.process', function ($trail, Stocktaking $stocktaking) {
    $trail->parent('employee.stocktakings.index');
    $trail->push($stocktaking->id . '#');
});

//Account
Breadcrumbs::for('employee.account.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.account.title'), route('employee.account.index'));
});

// Reports
Breadcrumbs::for('employee.reports.index', function ($trail) {
    $trail->parent('employee.home');
    $trail->push(__('employee.reports.title'), route('employee.reports.index'));
});

Breadcrumbs::for('employee.reports.out-of-stock-products.index', function ($trail) {
    $trail->parent('employee.reports.index');
    $trail->push(__('employee.reports.out_of_stock_products.title'), route('employee.reports.out-of-stock-products.index'));
});

// Test
Breadcrumbs::for('employee.test', function ($trail) {
    $trail->parent('employee.home');
    $trail->push('Test', route('employee.test'));
});
