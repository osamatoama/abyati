<?php

use App\Models\Order;
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

// Test
Breadcrumbs::for('employee.test', function ($trail) {
    $trail->parent('employee.home');
    $trail->push('Test', route('employee.test'));
});
