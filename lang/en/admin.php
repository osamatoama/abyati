<?php

return [

    'auth' => [
        'failed' => 'The entered data does not match our records',
        'throttle' => 'Please try again after :seconds seconds',
        'sign_in' => 'Sign In',
        'login' => 'Login',
        'sign_out' => 'Sign Out',
        'orWithMail' => 'Or with email',
        'email' => 'Email',
        'password' => 'Password',
        'remember_me' => 'Remember Me',

        'attributes' => [
            'email' => 'Email',
            'password' => 'Password',
        ],

        'messages' => [
            'logged_in' => 'Logged in successfully',
        ],
    ],


    'home' => [
        'title' => 'Home',
    ],

    'products' => [
        'title' => 'Products',
        'undefined_variant' => 'Undefined',
        'details' => 'Product Details',

        'attributes' => [
            'id' => 'ID',
            'salla_id' => 'Salla ID',
            'image' => 'Image',
            'name' => 'Name',
            'sku' => 'SKU',
            'variants' => 'Variants',
            'variant' => 'Variant',
            'quantity' => 'Quantity',
            'show_only_bought_variants' => 'Show only bought variants',
            'included_order_statuses' => 'Included order statuses',
            'price' => 'price',
            'regular_price' => 'Regular price',
            'sale_price' => 'Sale price',
            'sale_end' => 'Sale end',
            'admin_url' => 'Admin URL',
            'customer_url' => 'Customer URL',
            'with_tax' => 'Tax applied',
        ],

        'statuses' => [
            'sale' => 'Sale',
            'out' => 'Out',
            'hidden' => 'Hidden',
            'deleted' => 'Deleted',
        ],

        'types' => [
            'product' => 'Product',
            'service' => 'Service',
            'digital' => 'Digital',
            'codes' => 'Codes',
            'group_products' => 'Products group',
            'booking' => 'Bookings',
            'food' => 'Food',
        ],

        'messages' => [
            'required_at_least_one_status' => 'You should select at least one order status from filters to show quantity results',
            'no_variants' => 'No variants for this product',
            'unlimited_quantity' => 'Unlimited',
        ],
    ],

    'branches' => [
        'title' => 'Branches',

        'attributes' => [
            'id' => 'ID',
            'name' => 'Name',
            'related_order_status' => 'Related order status',
            'active' => 'Active',
        ],

        'messages' => [
            'activated' => 'Branch activated',
            'deactivated' => 'Branch deactivated',
        ],
    ],
];
