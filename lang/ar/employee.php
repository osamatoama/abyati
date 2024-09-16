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
            'image' => 'الصورة',
            'name' => 'الاسم',
            'sku' => 'SKU',
            'barcode' => 'الباركود',
            'variants' => 'الخيارات',
            'variant' => 'الخيار',
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
    ],

    'branches' => [
        'title' => 'الفروع',

        'attributes' => [
            'id' => 'المعرف',
            'name' => 'الاسم',
            'related_order_status' => 'حالة الطلب المرتبطة بالفرع',
            'related_order_statuses' => 'حالات الطلب المرتبطة بالفرع',
            'active' => 'مفعل',
        ],

        'actions' => [
            'edit_branch' => 'تعديل الفرع',
        ],

        'messages' => [
            'updated' => 'تم تعديل الفرع',
            'activated' => 'تم تفعيل الفرع',
            'deactivated' => 'تم إلغاء تفعيل الفرع',
        ],
    ],

    'orders' => [
        'title' => 'الطلبات',
        'order_#' => 'طلب ',
        'process_order_#' => 'تجهيز طلب #:id',
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
            'employee' => 'الموظف',
        ],

        'items' => [
            'attributes' => [
                'product' => 'المنتج',
                'variant' => 'الخيارات',
                'quantity' => 'الكمية',
                'executed_quantity' => 'الكمية المؤكدة',
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
            'assigned' => 'تم إسناد الطلب',
            'item_executed' => 'تم تجهيز المنتج',
        ],

        'errors' => [
            'cannot_process' => 'لا يمكنك تجهيز هذا الطلب',
            'invalid_barcode' => 'الباركود غير صحيح',
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
            'assigned_to_me' => 'مسند لي',
            'not_assigned' => 'غير مسند',
        ],

        'actions' => [
            'assign' => 'إسناد',
            'process' => 'تجهيز',
            'scan_item' => 'تأكيد',
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
];
