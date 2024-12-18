<?php

use App\Models\Order;
use App\Models\Branch;
use App\Models\Shelf;
use Diglactic\Breadcrumbs\Breadcrumbs;

/**
 * Admin Breadcrumbs
 */
Breadcrumbs::for('admin.home', function ($trail) {
    $trail->push(__('admin.home.title'), route('admin.home'));
});

// Stores
Breadcrumbs::for('admin.stores.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.stores.title'), route('admin.stores.index'));
});

// Branches
Breadcrumbs::for('admin.branches.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.branches.title'), route('admin.branches.index'));
});

Breadcrumbs::for('admin.branches.create', function ($trail) {
    $trail->parent('admin.branches.index');
    $trail->push(__('admin.branches.actions.create'), route('admin.branches.create'));
});

Breadcrumbs::for('admin.branches.edit', function ($trail, Branch $branch) {
    $trail->parent('admin.branches.index');
    $trail->push($branch->name, route('admin.branches.edit', $branch->id));
});

// Shelves
Breadcrumbs::for('admin.shelves.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.shelves.title'), route('admin.shelves.index'));
});

Breadcrumbs::for('admin.shelves.show', function ($trail, Shelf $shelf) {
    $trail->parent('admin.shelves.index');
    $trail->push($shelf->name, route('admin.shelves.show', $shelf->id));
});

Breadcrumbs::for('admin.shelves.create', function ($trail) {
    $trail->parent('admin.shelves.index');
    $trail->push(__('admin.shelves.actions.create'), route('admin.shelves.create'));
});

Breadcrumbs::for('admin.shelves.edit', function ($trail, Shelf $shelf) {
    $trail->parent('admin.shelves.index');
    $trail->push($shelf->name, route('admin.shelves.edit', $shelf->id));
});

//customers
Breadcrumbs::for('admin.customers.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.customers.title'), route('admin.customers.index'));
});

Breadcrumbs::for('admin.products.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.products.title'), route('admin.products.index'));
});

//roles
Breadcrumbs::for('admin.roles.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.roles.title'), route('admin.roles.index'));
});

Breadcrumbs::for('admin.roles.create', function ($trail) {
    $trail->parent('admin.roles.index');
    $trail->push(__('admin.roles.action.create'), route('admin.roles.create'));
});

Breadcrumbs::for('admin.roles.edit', function ($trail) {
    $trail->parent('admin.roles.index');
    $trail->push(__('admin.roles.action.edit'), route('admin.roles.edit', request('role')));
});

//Users
Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.users.title'), route('admin.users.index'));
});

Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push(__('admin.users.action.create'), route('admin.users.create'));
});

Breadcrumbs::for('admin.users.edit', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push(__('admin.users.action.edit'), route('admin.users.edit', request('role')));
});

//employees
Breadcrumbs::for('admin.employees.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.employees.title'), route('admin.employees.index'));
});

//supports
Breadcrumbs::for('admin.supports.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.supports.title'), route('admin.supports.index'));
});

//orders
Breadcrumbs::for('admin.orders.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.orders.title'), route('admin.orders.index'));
});

Breadcrumbs::for('admin.orders.show', function ($trail, Order $order) {
    $trail->parent('admin.orders.index');
    $trail->push(__('admin.orders.order_#') . $order->id, '#');
});

// Settings
Breadcrumbs::for('admin.subscription.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.subscription.title'), route('admin.subscription.index'));
});

//whatsapp
Breadcrumbs::for('whatsapp', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.whatsapp.title'), '#');
});

Breadcrumbs::for('admin.whatsapp.integration.index', function ($trail) {
    $trail->parent('whatsapp');
    $trail->push(__('admin.whatsapp.integration'), route('admin.whatsapp.integration.index'));
});

Breadcrumbs::for('admin.whatsapp.templates.index', function ($trail) {
    $trail->parent('whatsapp');
    $trail->push(__('admin.whatsapp.message_templates'), route('admin.whatsapp.templates.index'));
});

//Account
Breadcrumbs::for('admin.account.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.account.title'), route('admin.account.index'));
});

// Reports
Breadcrumbs::for('admin.reports.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.reports.title'), route('admin.reports.index'));
});

Breadcrumbs::for('admin.reports.employee-performance.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.employee_performance.title'), route('admin.reports.employee-performance.index'));
});

Breadcrumbs::for('admin.reports.quantity-issues.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.quantity_issues.title'), route('admin.reports.quantity-issues.index'));
});

Breadcrumbs::for('admin.reports.products-without-shelves.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.products_without_shelves.title'), route('admin.reports.products-without-shelves.index'));
});

Breadcrumbs::for('admin.reports.products-with-multiple-shelves.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.products_with_multiple_shelves.title'), route('admin.reports.products-with-multiple-shelves.index'));
});

Breadcrumbs::for('admin.reports.nearly-expired-products.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.nearly_expired_products.title'), route('admin.reports.nearly-expired-products.index'));
});

Breadcrumbs::for('admin.reports.out-of-stock-products.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.out_of_stock_products.title'), route('admin.reports.out-of-stock-products.index'));
});

// Settings
Breadcrumbs::for('admin.settings.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.settings.title'), route('admin.settings.index'));
});

Breadcrumbs::for('admin.settings.return.index', function ($trail) {
    $trail->parent('admin.settings.index');
    $trail->push(__('admin.settings.return.title'), route('admin.settings.return.index'));
});

// Test
Breadcrumbs::for('admin.test', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Test', route('admin.test'));
});
