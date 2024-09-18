<?php

use App\Models\Branch;
use App\Models\Order;
use App\Models\SmsProvider;
use App\Models\ReturnRequest;
use App\Models\ExchangeRequest;
use App\Models\SystemShippingCompany;
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

Breadcrumbs::for('admin.branches.show', function ($trail, Branch $branch) {
    $trail->parent('admin.branches.index');
    $trail->push($branch->name, route('admin.branches.show', $branch->id));
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

Breadcrumbs::for('admin.employees.create', function ($trail) {
    $trail->parent('admin.employees.index');
    $trail->push(__('admin.employees.action.create'), route('admin.employees.create'));
});

Breadcrumbs::for('admin.employees.edit', function ($trail) {
    $trail->parent('admin.employees.index');
    $trail->push(__('admin.employees.action.edit'), route('admin.employees.edit', request('employee')));
});

Breadcrumbs::for('admin.employees.trash', function ($trail) {
    $trail->parent('admin.employees.index');
    $trail->push(__('admin.tags.trash'), route('admin.employees.trash', request('employee')));
});

//tags
Breadcrumbs::for('admin.tags.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.tags.title'), route('admin.tags.index'));
});

Breadcrumbs::for('admin.tags.trash', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.tags.title'), route('admin.tags.index'));
    $trail->push(__('admin.tags.trash'), route('admin.tags.trash'));
});

Breadcrumbs::for('admin.tags.create', function ($trail) {
    $trail->parent('admin.tags.index');
    $trail->push(__('admin.tags.action.create'), route('admin.tags.create'));
});

Breadcrumbs::for('admin.tags.edit', function ($trail) {
    $trail->parent('admin.tags.index');
    $trail->push(__('admin.tags.action.edit'), route('admin.tags.edit', request('tag')));
});

// System Shipping Companies
Breadcrumbs::for('admin.system-shipping-companies.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.system-shipping-companies.title'), route('admin.system-shipping-companies.index'));
});

Breadcrumbs::for('admin.system-shipping-companies.settings', function ($trail, SystemShippingCompany $systemShippingCompany) {
    $trail->parent('admin.system-shipping-companies.index');
    $trail->push($systemShippingCompany?->name, '#');
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

//Sms
Breadcrumbs::for('sms', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.sms.title'), '#');
});

Breadcrumbs::for('admin.sms.integration.index', function ($trail) {
    $trail->parent('sms');
    $trail->push(__('admin.sms.integration.title'), route('admin.sms.integration.index'));
});

Breadcrumbs::for('admin.sms.integration.settings', function ($trail, SmsProvider $smsProvider) {
    $trail->parent('admin.sms.integration.index');
    $trail->push($smsProvider?->name, '#');
});

Breadcrumbs::for('admin.sms.templates.index', function ($trail) {
    $trail->parent('sms');
    $trail->push(__('admin.sms.message_templates'), route('admin.sms.templates.index'));
});


//Return
Breadcrumbs::for('return', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.return.title'), '#');
});

Breadcrumbs::for('admin.return.reasons.index', function ($trail) {
    $trail->parent('return');
    $trail->push(__('admin.return.reasons.title'), route('admin.return.reasons.index'));
});

Breadcrumbs::for('admin.return.statuses.index', function ($trail) {
    $trail->parent('return');
    $trail->push(__('admin.return.statuses.title'), route('admin.return.statuses.index'));
});

Breadcrumbs::for('admin.return.requests.index', function ($trail) {
    $trail->parent('return');
    $trail->push(__('admin.return.requests.index.title'), route('admin.return.requests.index'));
});

Breadcrumbs::for('admin.return.requests.show', function ($trail, ReturnRequest $returnRequest) {
    $trail->parent('admin.return.requests.index');
    $trail->push(__('admin.return.requests.show.request_no', ['id' => $returnRequest->id]), route('admin.return.requests.index')); // TODO:fix return requests show breadcrumb
});

//Exchange
Breadcrumbs::for('exchange', function ($trail) {
    $trail->parent('admin.home');
    $trail->push(__('admin.exchange.title'), '#');
});

Breadcrumbs::for('admin.exchange.reasons.index', function ($trail) {
    $trail->parent('exchange');
    $trail->push(__('admin.exchange.reasons.title'), route('admin.exchange.reasons.index'));
});

Breadcrumbs::for('admin.exchange.statuses.index', function ($trail) {
    $trail->parent('exchange');
    $trail->push(__('admin.exchange.statuses.title'), route('admin.exchange.statuses.index'));
});

Breadcrumbs::for('admin.exchange.requests.index', function ($trail) {
    $trail->parent('exchange');
    $trail->push(__('admin.exchange.requests.index.title'), route('admin.exchange.requests.index'));
});

Breadcrumbs::for('admin.exchange.requests.show', function ($trail, ExchangeRequest $exchangeRequest) {
    $trail->parent('admin.exchange.requests.index');
    $trail->push(__('admin.exchange.requests.show.request_no', ['id' => $exchangeRequest->id]), route('admin.exchange.requests.index')); // TODO:fix exchange requests show breadcrumb
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

Breadcrumbs::for('admin.reports.reasons.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.reasons.name'), route('admin.reports.reasons.index'));
});

Breadcrumbs::for('admin.reports.return-products.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.return_products.name'), route('admin.reports.return-products.index'));
});

Breadcrumbs::for('admin.reports.exchange-products.index', function ($trail) {
    $trail->parent('admin.reports.index');
    $trail->push(__('admin.reports.exchange_products.name'), route('admin.reports.exchange-products.index'));
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

Breadcrumbs::for('admin.settings.exchange.index', function ($trail) {
    $trail->parent('admin.settings.index');
    $trail->push(__('admin.settings.exchange.title'), route('admin.settings.exchange.index'));
});

Breadcrumbs::for('admin.settings.website.index', function ($trail) {
    $trail->parent('admin.settings.index');
    $trail->push(__('admin.settings.website_button.title'), route('admin.settings.website.index'));
});

Breadcrumbs::for('admin.settings.domain.index', function ($trail) {
    $trail->parent('admin.settings.index');
    $trail->push(__('admin.settings.domain.title'), route('admin.settings.domain.index'));
});

Breadcrumbs::for('admin.settings.shipping.index', function ($trail) {
    $trail->parent('admin.settings.index');
    $trail->push(__('admin.settings.shipping.title'), route('admin.settings.shipping.index'));
});
