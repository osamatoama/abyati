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
            'warehouse' => 'Warehouse',
            'categories' => 'Categories',
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
            'attached_at' => 'Attached at',
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

        'errors' => [
            'invalid_barcode' => 'Invalid barcode',
        ],
    ],

    'stores' => [
        'title' => 'Stores',

        'attributes' => [
            'name' => 'Name',
            'domain' => 'Domain',
            'id_color' => 'Identifier Color',
            'active' => 'Active',
        ],

        'messages' => [
            'updated' => 'Updated successfully',
        ],
    ],

    'branches' => [
        'title' => 'Branches',

        'attributes' => [
            'id' => 'ID',
            'remote_id' => 'Salla ID',
            'name' => 'Name',
            'warehouses_count' => 'Warehouses Count',
            'related_order_status' => 'Related order status',
            'related_order_statuses' => 'Related order statuses',
            'active' => 'Active',
        ],

        'actions' => [
            'create' => 'Create Branch',
            'edit_branch' => 'Edit Branch',
        ],

        'messages' => [
            'created' => 'Branch created',
            'updated' => 'Branch updated',
            'deleted' => 'Branch deleted',
            'activated' => 'Branch activated',
            'deactivated' => 'Branch deactivated',
        ],

        'errors' => [
            'should_have_no_relations' => 'You cannot perform this action, because this branch has related employees or orders. Deactivate the branch instead.',
        ],
    ],

    'shelves' => [
        'title' => 'Shelves',
        'model' => 'Shelf',
        'num_#' => 'Shelf :name',

        'attributes' => [
            'id' => 'ID',
            'warehouse' => 'Warehouse',
            'aisle' => 'Aisle',
            'name' => 'Name',
            'description' => 'Description',
            'order' => 'Order',
            'products_count' => 'Products Count',
        ],

        'actions' => [
            'create' => 'Create Shelf',
            'edit' => 'Edit Shelf',
            'attach_product' => 'Attach Product',
            'detach_product' => 'Detach Product',
            'import' => 'Import',
            'import_products' => 'Import Products',
            'download_warehouse_template' => 'Download Warehouse Template',
            'download_aisle_template' => 'Download Aisle Template',
            'download_shelf_template' => 'Download Shelf Template',
        ],

        'import_options' => [
            'warehouse' => 'Warehouse',
            'aisle' => 'Aisle',
            'shelf' => 'Shelf',
        ],

        'messages' => [
            'created' => 'Shelf created',
            'updated' => 'Shelf updated',
            'deleted' => 'Shelf deleted',
            'activated' => 'Shelf activated',
            'deactivated' => 'Shelf deactivated',
            'product_attached' => 'Products attached to the shelf',
            'product_detached' => 'Product detached from the shelf',
            'products_detached' => 'Products detached from the shelf',
            'product_transferred' => 'Product transferred from the shelf',
            'products_transferred' => 'Products transferred from the shelf',
            'import_started' => 'Started importing data from the file',
            'imported' => 'Data imported successfully',
        ],

        'errors' => [
            'should_have_no_relations' => 'You cannot perform this action, because this shelf has related products or stocktakings. Deactivate the shelf instead.',
            'invalid_barcode' => 'Invalid barcode',
            'product_already_attached' => 'Product already attached to the shelf',
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

    'supports' => [
        'title' => 'Support Staff',
        'actions' => 'Actions',
        'password_hint' => 'Use 8 or more characters with a mix of letters, numbers & symbols.',

        'action' => [
            'edit' => 'Edit',
            'create' => 'Create',
            'delete' => 'Delete',
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

    'users' => [
        'title' => 'Users',
        'actions' => 'Actions',

        'password_hint' => 'Use 8 or more characters with a mix of letters, numbers & symbols.',

        'action' => [
            'edit' => 'Edit User',
            'create' => 'Create User',
            'delete' => 'Delete User',
        ],

        'attributes' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'role' => 'Role',
            'active' => 'Active',
        ],

        'messages' => [
            'created' => 'The User has been created successfully',
            'updated' => 'The User has been updated successfully',
            'deleted' => 'The User has been deleted successfully',
            'activated' => 'The User has been activated successfully',
            'deactivated' => 'The User has been deactivated successfully',
            'should_have_no_relations' => "You can't perform this action, because this user has related data. Deactivate the user instead.",
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
            'branch' => 'Branch',
            'employee' => 'Employee',
        ],

        'items' => [
            'attributes' => [
                'product' => 'Product',
                'variant' => 'Variant',
                'barcode' => 'Barcode',
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

        'payment_methods' => [
            'credit_card' => 'Credit Card',
            'paypal' => 'Paypal',
            'mada' => 'Mada',
            'free' => 'Free',
            'bank' => 'Bank Transfer',
            'cod' => 'COD',
            'apple_pay' => 'Applepay',
            'stc_pay' => 'STC Pay',
            'waiting' => 'Waiting',
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
        ],

        'errors' => [
            'should_have_no_relations' => 'You cannot perform this action, because this role has related users',
        ],
    ],

    'reports' => [
        'title' => 'Reports',
        'results' => 'Results',

        'employee_performance' => [
            'title' => 'Employee Performance',

            'attributes' => [
                'order_number' => 'Order Number',
                'started_at' => 'Started At',
                'completed_at' => 'Completed At',
                'duration' => 'Duration',
                'duration_minutes' => 'Duration (Minutes)',
            ],

            'filters' => [
                'employee_id' => 'Employee',
            ],
        ],

        'quantity_issues' => [
            'title' => 'Quantity Issues',

            'attributes' => [
                'product_remote_id' => 'Product ID',
                'product_name' => 'Product Name',
                'product_image' => 'Image',
                'issues_count' => 'Issues Count',
            ],

            'filters' => [

            ],
        ],

        'products_without_shelves' => [
            'title' => 'Products Without Shelves',

            'attributes' => [
                'product_remote_id' => 'Salla ID',
                'product_name' => 'Name',
                'product_image' => 'Image',
                'product_sku' => 'SKU',
                'quantities' => 'Quantities',
            ],

            'filters' => [
                'warehouse_id' => 'Warehouse',
            ],
        ],
    ],
];
