<?php

use App\Enums\OrderCompletionStatus;

return [

    'auth' => [
        'failed' => 'البيانات المدخلة لا تتوافق مع البيانات لدينا',
        'throttle' => 'من فضلك قم بالمحاولة بعد :seconds ثانية',
        'sign_in' => 'تسجيل دخول',
        'login' => 'تسجيل الدخول',
        'sign_out' => 'تسجيل خروج',
        'orWithMail' => 'او عن طريق البريد الالكتروني',
        'email' => 'البريد الالكتروني',
        'password' => 'كلمة السر',
        'remember_me' => 'تذكرني',

        'attributes' => [
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة السر',
        ],

        'messages' => [
            'logged_in' => 'تم تسجيل الدخول بنجاح',
        ],
    ],

    'account' => [
        'title' => 'حسابي',
    ],

    'home' => [
        'title' => 'الرئيسية',
    ],

    'products' => [
        'title' => 'المنتجات',
        'undefined_variant' => 'غير محدد',
        'details' => 'تفاصيل المنتج',

        'attributes' => [
            'id' => 'المعرف',
            'salla_id' => 'معرف سلة',
            'store' => 'المتجر',
            'warehouse' => 'المستودع',
            'image' => 'الصورة',
            'name' => 'الاسم',
            'sku' => 'SKU',
            'barcode' => 'الباركود',
            'variants' => 'الخيارات',
            'variant' => 'الخيارات',
            'quantity' => 'الكمية',
            'show_only_bought_variants' => 'إظهار الخيارات التي تم شراؤها فقط',
            'included_order_statuses' => 'حالات الطلب',
            'price' => 'السعر',
            'regular_price' => 'السعر الاعتيادي',
            'sale_price' => 'السعر المخفض',
            'sale_end' => 'نهاية التخفيض',
            'admin_url' => 'رابط التحكم',
            'customer_url' => 'رابط العميل',
            'with_tax' => 'خاضع للضريبة',
            'attached_at' => 'تاريخ الربط',
        ],

        'statuses' => [
            'sale' => 'متاح',
            'out' => 'نفدت الكمية',
            'hidden' => 'مخفي',
            'deleted' => 'محذوف',
        ],

        'types' => [
            'product' => 'منتج جاهز',
            'service' => 'خدمة حسب الطلب',
            'digital' => 'منتج رقمي',
            'codes' => 'بطاقة رقمية',
            'group_products' => 'مجموعة منتجات',
            'booking' => 'حجوزات',
            'food' => 'مأكولات',
        ],

        'messages' => [
            'required_at_least_one_status' => 'قم بتحديد حالة طلب واحدة على الأقل من التصفية لإظهار نتائج الكميات',
            'no_variants' => 'لا توجد خيارات لهذا المنتج',
            'unlimited_quantity' => 'غير محدودة',
        ],

        'errors' => [
            'invalid_barcode' => 'الباركود غير صحيح',
        ],
    ],

    'stores' => [
        'title' => 'المتاجر',

        'attributes' => [
            'name' => 'الاسم',
            'domain' => 'النطاق',
            'id_color' => 'اللون المميز',
            'active' => 'مفعل',
        ],

        'messages' => [
            'updated' => 'تم التعديل',
        ],
    ],

    'branches' => [
        'title' => 'الفروع',

        'attributes' => [
            'id' => 'المعرف',
            'remote_id' => 'معرف سلة',
            'name' => 'الاسم',
            'warehouses_count' => 'عدد المستودعات',
            'related_order_status' => 'حالة الطلب المرتبطة بالفرع',
            'related_order_statuses' => 'حالات الطلب المرتبطة بالفرع',
            'active' => 'مفعل',
        ],

        'actions' => [
            'create' => 'إضافة فرع',
            'edit_branch' => 'تعديل الفرع',
        ],

        'messages' => [
            'created' => 'تم إضافة الفرع',
            'updated' => 'تم تعديل الفرع',
            'deleted' => 'تم حذف الفرع',
            'activated' => 'تم تفعيل الفرع',
            'deactivated' => 'تم إلغاء تفعيل الفرع',
        ],

        'errors' => [
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود موظفين أو طلبات تابعين لهذا الفرع. قم بإلغاء تفعيل الفرع بدلاً من الحذف.',
        ],
    ],

    'shelves' => [
        'title' => 'الرفوف',
        'model' => 'الرف',
        'num_#' => 'رف :name',

        'attributes' => [
            'id' => 'المعرف',
            'warehouse' => 'المستودع',
            'aisle' => 'الممر',
            'name' => 'الاسم',
            'description' => 'الوصف',
            'order' => 'الترتيب',
            'products_count' => 'عدد المنتجات',
        ],

        'actions' => [
            'create' => 'إضافة رف',
            'edit' => 'تعديل الرف',
            'attach_product' => 'إضافة منتج للرف',
            'detach_product' => 'إزالة المنتج',
            'import' => 'استيراد',
            'import_products' => 'استيراد المنتجات',
            'download_warehouse_template' => 'تحميل نموذج المستودع',
            'download_aisle_template' => 'تحميل نموذج الممر',
            'download_shelf_template' => 'تحميل نموذج الرف',
        ],

        'import_options' => [
            'warehouse' => 'مستودع',
            'aisle' => 'ممر',
            'shelf' => 'رف',
        ],

        'messages' => [
            'created' => 'تم إضافة الرف',
            'updated' => 'تم تعديل الرف',
            'deleted' => 'تم حذف الرف',
            'activated' => 'تم تفعيل الرف',
            'deactivated' => 'تم إلغاء تفعيل الرف',
            'product_attached' => 'تم إضافة المنتجات للرف',
            'product_detached' => 'تم إزالة المنتج من الرف',
            'products_detached' => 'تم إزالة المنتجات من الرف',
            'product_transferred' => 'تم نقل المنتج من الرف',
            'products_transferred' => 'تم نقل المنتجات من الرف',
            'import_started' => 'جاري استيراد البيانات من الملف',
            'imported' => 'تم استيراد البيانات بنجاح',
        ],

        'errors' => [
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود منتجات أو عمليات جرد تابعة لهذا الرف. قم بإلغاء تفعيل الرف بدلاً من الحذف.',
            'invalid_barcode' => 'الباركود غير صحيح',
            'product_already_attached' => 'المنتج موجود بالفعل في الرف',
        ],
    ],

    'employees' => [
        'management' => 'ادارة الموظفين',
        'title' => 'الموظفين',
        'actions' => 'العمليات',

        'password_hint' => 'أدخل على الأقل 8 أحرف تحتوي على حروف وأرقام ورموز',

        'action' => [
            'edit' => 'تعديل الموظف',
            'create' => 'إضافة موظف',
            'restore' => 'استعادة الموظف',
            'delete' => 'حذف الموظف',
        ],

        'attributes' => [
            'name' => 'الاسم',
            'branch' => 'الفرع',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة السر',
            'role' => 'الدور',
            'totalOrders' => 'عدد الطلبات',
            'totalProducts' => 'عدد المنتجات',
            'active' => 'مفعل',
        ],

        'messages' => [
            'created' => 'تم الإضافة بنجاح',
            'updated' => 'تم التعديل بنجاح',
            'deleted' => 'تم الحذف بنجاح',
            'activated' => 'تم تفعيل الموظف بنجاح',
            'deactivated' => 'تم إلغاء تفعيل الموظف بنجاح',
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود تحديثات لحالات الطلب تابعة لهذا الموظف. قم بإلغاء تفعيل الموظف بدلاً من الحذف.',
            'restored' => 'تمت الاستعادة بنجاح',
            'force_delete' => 'تم الحذف نهائياً بنجاح',
        ],
    ],

    'supports' => [
        'title' => 'فريق الدعم',
        'actions' => 'العمليات',

        'password_hint' => 'أدخل على الأقل 8 أحرف تحتوي على حروف وأرقام ورموز',

        'action' => [
            'edit' => 'تعديل',
            'create' => 'إضافة',
            'delete' => 'حذف',
        ],

        'attributes' => [
            'name' => 'الاسم',
            'branch' => 'الفرع',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة السر',
            'role' => 'الدور',
            'totalOrders' => 'عدد الطلبات',
            'totalProducts' => 'عدد المنتجات',
            'active' => 'مفعل',
        ],

        'messages' => [
            'created' => 'تم الإضافة بنجاح',
            'updated' => 'تم التعديل بنجاح',
            'deleted' => 'تم الحذف بنجاح',
            'activated' => 'تم تفعيل الموظف بنجاح',
            'deactivated' => 'تم إلغاء تفعيل الموظف بنجاح',
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود تحديثات لحالات الطلب تابعة لهذا الموظف. قم بإلغاء تفعيل الموظف بدلاً من الحذف.',
            'restored' => 'تمت الاستعادة بنجاح',
            'force_delete' => 'تم الحذف نهائياً بنجاح',
        ],
    ],

    'users' => [
        'title' => 'المستخدمين',
        'actions' => 'العمليات',

        'password_hint' => 'أدخل على الأقل 8 أحرف تحتوي على حروف وأرقام ورموز',

        'action' => [
            'edit' => 'تعديل المستخدم',
            'create' => 'إضافة المستخدم',
            'delete' => 'حذف المستخدم',
        ],

        'attributes' => [
            'name' => 'الاسم',
            'email' => 'البريد الالكتروني',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة السر',
            'role' => 'الدور',
            'active' => 'مفعل',
        ],

        'messages' => [
            'created' => 'تم الإضافة بنجاح',
            'updated' => 'تم التعديل بنجاح',
            'deleted' => 'تم الحذف بنجاح',
            'activated' => 'تم تفعيل المستخدم بنجاح',
            'deactivated' => 'تم إلغاء تفعيل المستخدم بنجاح',
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود بيانات تابعة لهذا المستخدم. قم بإلغاء تفعيل المستخدم بدلاً من الحذف.',
        ],
    ],

    'orders' => [
        'title' => 'الطلبات',
        'order_#' => 'طلب ',
        'details' => 'تفاصيل الطلب',
        'calculations' => 'الحسابات',

        'attributes' => [
            'id' => 'المعرف',
            'salla_id' => 'معرف سلة',
            'referenceId' => 'الرقم المرجعي',
            'store' => 'المتجر',
            'order_number' => 'رقم الطلب',
            'info' => 'معلومات الطلب',
            'admin_url' => 'رابط التحكم',
            'customer_url' => 'رابط العميل',
            'items' => 'المنتجات',
            'items_count' => 'عدد المنتجات',
            'date' => 'التاريخ',
            'status' => 'الحالة',
            'internalStatus' => 'الحالة الداخلية',
            'tags' => 'الوسوم',
            'note' => 'الملاحظة',
            'customerName' => 'اسم العميل',
            'city' => 'المدينة',
            'paymentMethod' => 'وسيلة الدفع',
            'payment_method' => 'وسيلة الدفع',
            'customer' => 'العميل',
            'sub_total' => 'مجموع المنتجات',
            'shipping_cost' => 'رسوم الشحن',
            'cash_on_delivery' => 'رسوم الدفع عند الاستلام',
            'tax' => 'الضريبة',
            'total' => 'إجمالي الطلب',
            'completion_status' => 'حالة التنفيذ',
            'assign_status' => 'حالة الإسناد',
            'branch' => 'الفرع',
            'employee' => 'الموظف',
        ],

        'items' => [
            'attributes' => [
                'product' => 'المنتج',
                'variant' => 'الخيارات',
                'barcode' => 'الباركود',
                'quantity' => 'الكمية',
                'unit_price' => 'سعر القطعة',
                'total' => 'الإجمالي',
            ],
        ],

        'history' => [
            'title' => 'سجل الطلب',

            'attributes' => [
                'status' => 'الحالة',
                'note' => 'الوصف',
                'date' => 'التاريخ',
            ],
        ],

        'address' => [
            'title' => 'العنوان',

            'attributes' => [
                'city' => 'المدينة',
                'country' => 'الدولة',
                'shipping_address' => 'عنوان الشحن',
                'pickup_address' => 'عنوان الاستلام',
            ],
        ],

        'messages' => [
            'created' => 'تم الإضافة بنجاح',
            'updated' => 'تم التعديل بنجاح',
            'tagDeleted' => 'تم حذف الوسم بنجاح',
            'statusUpdated' => 'تم تحديث حالة الطلب بنجاح',
            'noteUpdated' => 'تم تحديث الملاحظة بنجاح',
            'pull_started' => 'جاري سحب الطلبات',
            'no_shipping_address' => 'لا يوجد عنوان شحن لهذا الطلب',
            'employee_assigned' => 'تم تعيين الموظف للطلب',
        ],

        'alerts' => [
            'shipping_bills_for_pickup_shipments' => 'لا يمكن إصدار بوليصات شحن لهذا الطلب لأن نوع الشحن: استلام من الفرع',
            'shipping_bills_for_not_shippable' => 'لا يمكن إصدار بوليصات شحن لهذا الطلب لأنه لا يتطلب شحن',
        ],

        'pull_alert' => [
            'title' => 'سحب الطلبات',
            'body' => 'يمكنك انتظار الطلبات الجديدة أو سحب عدد من الطلبات السابقة',
            'button' => 'خيارات السحب',
        ],

        'pull_form' => [
            'pull' => 'سحب',
            'pull_orders' => 'سحب الطلبات',
            'orders_count' => 'عدد الطلبات',
            'to_date' => 'السحب إلى',
            'date' => 'التاريخ',
            'from_date' => 'البداية',
            'to_date' => 'النهاية',
            'store' => 'المتجر',

            'errors' => [
                'from_date_should_be_before_now' => 'تاريخ البداية يجب أن يكون تاريخا سابقا أو مطابقا لتاريخ اليوم.',
                'to_date_should_be_before_now' => 'تاريخ النهاية يجب أن يكون تاريخا سابقا أو مطابقا لتاريخ اليوم.',
                'to_date_should_be_after_from_date' => 'تاريخ النهاية يجب أن يكون تاريخا لاحقا أو مطابقا لتاريخ البداية.',
            ],

            'notes' => [
                'non_existing_order_charge' => 'سيتم خصم نقاط من الرصيد حسب عدد الطلبات التي يتم سحبها',
                'existing_order_charge' => 'في حال كان الطلب موجوداً بالفعل على المنصة لا يتم خصم نقاط من الرصيد',
            ],
        ],

        'completion_statuses' => [
            OrderCompletionStatus::PENDING->value => 'قيد الانتظار',
            OrderCompletionStatus::PROCESSING->value => 'قيد التنفيذ',
            OrderCompletionStatus::QUANTITY_ISSUES->value => 'مشاكل كميات',
            OrderCompletionStatus::COMPLETED->value => 'مكتمل',
        ],

        'assign_statuses' =>[
            'all' => 'الكل',
            'assigned' => 'مسند',
            'not_assigned' => 'غير مسند',
        ],
    ],

    'customers' => [
        'attributes' => [
            'id' => 'المعرف',
            'name' => 'الاسم',
            'first_name' => 'الاسم الاول',
            'last_name' => 'الاسم الاخير',
            'mobile' => 'رقم الهاتف',
            'email' => 'البريد الالكتروني',
            'city' => 'المدينة',
            'country' => 'الدولة',
            'currency' => 'العملة',
        ],
    ],

    'management' => [
        'title' => 'الإدارة',
    ],

    'roles' => [
        'title' => 'الأدوار',
        'actions' => 'العمليات',

        'action' => [
            'edit' => 'تعديل الدور',
            'create' => 'إضافة دور',
        ],

        'attributes' => [
            'id' => 'المعرف',
            'name' => 'الاسم',
            'permissions' => 'الصلاحيات',
        ],

        'messages' => [
            'created' => 'تم الإضافة بنجاح',
            'updated' => 'تم التعديل بنجاح',
            'deleted' => 'تم الالغاء بنجاح',
        ],

        'errors' => [
            'should_have_no_relations' => 'لا يمكن إجراء العملية لوجود مستخدمين تابعين لهذا الدور.',
        ],
    ],

    'reports' => [
        'title' => 'التقارير',
        'results' => 'النتائج',

        'employee_performance' => [
            'title' => 'أداء الموظفين',

            'attributes' => [
                'order_number' => 'رقم الطلب',
                'started_at' => 'بدأ في',
                'completed_at' => 'اكتمل في',
                'duration' => 'مدة التنفيذ',
                'duration_minutes' => 'مدة التنفيذ (دقائق)',
            ],

            'filters' => [
                'employee_id' => 'الموظف',
            ],
        ],

        'quantity_issues' => [
            'title' => 'مشاكل الكميات',

            'attributes' => [
                'product_remote_id' => 'معرف المنتج',
                'product_name' => 'اسم المنتج',
                'product_image' => 'الصورة',
                'issues_count' => 'عدد المشاكل',
            ],

            'filters' => [

            ],
        ],

        'products_without_shelves' => [
            'title' => 'منتجات بدون رفوف',

            'attributes' => [
                'product_remote_id' => 'معرف سلة',
                'product_name' => 'الاسم',
                'product_image' => 'الصورة',
                'product_sku' => 'SKU',
            ],

            'filters' => [
                'warehouse_id' => 'المستودع',
            ],
        ],
    ],
];
