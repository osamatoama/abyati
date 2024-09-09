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
            'barcode' => 'Barcode',
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

    'employees' => [
        'management' => 'Employees Management',
        'title' => 'Employees',
        'actions' => 'Actions',
        'password_hint' => 'Use 8 or more characters with a mix of letters, numbers & symbols.',

        'action' => [
            'edit' => 'Edit Employee',
            'create' => 'Create Employee',
            'restore' => 'Restore Employee',
            'delete' => 'Delete Employee',
        ],

        'attributes' => [
            'name' => 'Name',
            'branch' => 'Branch',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'role' => 'Role',
            'totalOrders' => 'Total Orders',
            'totalProducts' => 'Total Products',
            'active' => 'Active',
        ],

        'messages' => [
            'created' => 'The Employee has been created successfully',
            'updated' => 'The Employee has been updated successfully',
            'deleted' => 'The Employee has been deleted successfully',
            'activated' => 'The Employee has been activated successfully',
            'deactivated' => 'The Employee has been deactivated successfully',
            'should_have_no_relations' => "You can't perform this action, because this employee has related order status updates. Deactivate the employee instead.",
            'restored' => 'The Employee has been restored successfully!',
            'force_delete' => 'The Employee has been permanently deleted successfully!',
        ],
    ],
];
