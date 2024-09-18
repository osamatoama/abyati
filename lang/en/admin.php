<?php

use App\Enums\OrderCompletionStatus;

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

    'account' => [
        'title' => 'My Account',
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
            'store' => 'Store',
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
            'related_order_statuses' => 'Related order statuses',
            'active' => 'Active',
        ],

        'actions' => [
            'edit_branch' => 'Edit Branch',
        ],

        'messages' => [
            'updated' => 'Branch updated',
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
            'restored' => 'The Employee has been restored successfully',
            'force_delete' => 'The Employee has been permanently deleted successfully',
        ],
    ],

    'orders' => [
        'title' => 'Orders',
        'order_#' => 'Order ',
        'details' => 'Order Details',
        'calculations' => 'Calculations',

        'attributes' => [
            'id' => 'ID',
            'salla_id' => 'Salla ID',
            'referenceId' => 'Ref ID',
            'order_number' => 'Order No.',
            'store' => 'Store',
            'info' => 'Info',
            'admin_url' => 'Admin URL',
            'customer_url' => 'Customer URL',
            'items' => 'Items',
            'items_count' => 'Items count',
            'date' => 'Date',
            'status' => 'Status',
            'internalStatus' => 'Internal Order Status',
            'tags' => 'Tags',
            'note' => 'Note',
            'customerName' => 'Customer name',
            'city' => 'City',
            'paymentMethod' => 'Payment method',
            'payment_method' => 'Payment method',
            'customer' => 'Customer',
            'sub_total' => 'Subtotal',
            'shipping_cost' => 'Shipping fees',
            'cash_on_delivery' => 'COD fees',
            'tax' => 'Tax',
            'total' => 'Total',
            'completion_status' => 'Completion Status',
            'assign_status' => 'Assign Status',
            'employee' => 'Employee',
        ],

        'items' => [
            'attributes' => [
                'product' => 'Product',
                'variant' => 'Variant',
                'quantity' => 'Quantity',
                'unit_price' => 'Unit Price',
                'total' => 'Total',
            ],
        ],

        'history' => [
            'title' => 'Order History',

            'attributes' => [
                'status' => 'Status',
                'note' => 'Description',
                'date' => 'Date',
            ],
        ],

        'address' => [
            'title' => 'Address',

            'attributes' => [
                'city' => 'City',
                'country' => 'Country',
                'shipping_address' => 'Shipping Address',
                'pickup_address' => 'Pickup Address',
            ],
        ],

        'messages' => [
            'created' => 'The Order has been created successfully',
            'updated' => 'The Order has been updated successfully',
            'deleted' => 'The Order has been deleted successfully',
            'tagDeleted' => 'Tag deleted successfully',
            'statusUpdated' => 'Order status has been updated successfully',
            'noteUpdated' => 'Order note has been updated successfully',
            'pull_started' => 'Pulling orders started',
            'no_shipping_address' => 'No Shipping address for this order',
            'employee_assigned' => 'Employee assigned to the order',
        ],


        'alerts' => [
            'shipping_bills_for_pickup_shipments' => "Can't generate shipping bills for this order because shipment type is: store pickup",
            'shipping_bills_for_not_shippable' => "Can't generate shipping bills for this order because it doesn't require shipping",
        ],

        'pull_alert' => [
            'title' => 'Pull orders',
            'body' => 'You can wait for upcoming orders or pull from previous a maximum of :count orders',
            'button' => 'pull options',
        ],

        'pull_form' => [
            'pull' => 'Pull',
            'pull_orders' => 'Pull Orders',
            'orders_count' => 'orders count',
            'to_date' => 'pull to',
            'date' => 'Date',
            'from_date' => 'Start',
            'to_date' => 'End',
            'store' => 'Store',

            'errors' => [
                'from_date_should_be_before_now' => 'Start date should be before or equal to today.',
                'to_date_should_be_before_now' => 'End date should be before or equal to today.',
                'to_date_should_be_after_from_date' => 'End date should be after or equal to start date.',
            ],

            'notes' => [
                'non_existing_order_charge' => 'Your credit will be decremented according to number of pulled orders',
                'existing_order_charge' => 'If an order was already exist. then no points will be decremented for it',
            ],
        ],

        'completion_statuses' => [
            OrderCompletionStatus::PENDING->value => 'Pending',
            OrderCompletionStatus::PROCESSING->value => 'Processing',
            OrderCompletionStatus::QUANTITY_ISSUES->value => 'Quantity Issues',
            OrderCompletionStatus::COMPLETED->value => 'Completed',
        ],

        'assign_statuses' =>[
            'all' => 'All',
            'assigned' => 'Assigned',
            'not_assigned' => 'Not Assigned',
        ],
    ],

    'customers' => [
        'attributes' => [
            'id' => 'ID',
            'name' => 'Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'city' => 'City',
            'country' => 'Country',
            'currency' => 'Currency',
        ],
    ],

    'management' => [
        'title' => 'Management',
    ],

    'roles' => [
        'title' => 'Roles',
        'actions' => 'Actions',

        'action' => [
            'edit' => 'Edit Role',
            'create' => 'Add Role',
        ],

        'attributes' => [
            'id' => 'ID',
            'name' => 'Name',
            'permissions' => 'Permissions',
        ],

        'messages' => [
            'created' => 'The role has been created successfully',
            'updated' => 'The role has been updated successfully',
            'deleted' => 'The role has been deleted successfully',
        ]
    ],
];
