<?php

namespace App\Enums\Queues;

enum BatchName: string
{
    case SALLA_PULL_ORDERS = 'salla.pull.orders';
    case SALLA_PULL_ORDER_STATUSES = 'salla.pull.order_statuses';
    case SALLA_PULL_PRODUCTS = 'salla.pull.products';
    case SALLA_PULL_BRANCHES = 'salla.pull.branches';
    case SALLA_PULL_SHIPPING_COMPANIES = 'salla.pull.shipping_companies';
}
