<?php

use App\Enums\StocktakingStatus;
use App\Enums\StocktakingIssueType;
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
            'shelf' => 'الرف',
            'image' => 'الصورة',
            'name' => 'الاسم',
            'sku' => 'SKU',
            'barcode' => 'الباركود',
            'variants' => 'الخيارات',
            'variant' => 'الخيارات',
            'quantity' => 'الكمية',
            'remote_quantity' => 'الكمية في سلة',
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
            'expiry_date' => 'انتهاء الصلاحية',
            'synced' => 'تمت المزامنة',
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
        'process_order_#' => 'طلب #:id',
        'details' => 'تفاصيل الطلب',
        'calculations' => 'الحسابات',
        'customer_info' => 'بيانات العميل',

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
                'barcode' => 'الباركود',
                'quantity' => 'الكمية',
                'executed_quantity' => 'الكمية المؤكدة',
                'unit_price' => 'سعر القطعة',
                'total' => 'الإجمالي',
                'employee_note' => 'الملاحظة',
            ],

            'alerts' => [
                'transfer_to_support' => 'سيتم إشعار فريق الدعم بوجود مشكلة كميات في هذا المنتج. تأكد من عدم توافر الكمية المطلوبة قبل التحويل.',
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
            'unassigned' => 'تم إلغاء إسناد الطلب',
            'item_executed' => 'تم تجهيز المنتج',
            'order_executed' => 'تم تجهيز الطلب',
            'item_transferred_to_support' => 'تم تحويل المنتج لفريق الدعم',
            'unassign_confirm' => 'سيتم إلغاء إسناد الطلب منك وإعادة الطلب إلى القائمة',
            'reset' => 'تم استعادة الحالة الافتراضية للطلب',
        ],

        'errors' => [
            'cannot_process' => 'لا يمكنك تجهيز هذا الطلب',
            'invalid_barcode' => 'الباركود غير صحيح',
            'no_barcode_for_this_product' => 'لا يوجد باركود لهذا المنتج',
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

        'process_statuses' => [
            'pending' => 'قيد التأكيد',
            'completed' => 'تم التأكيد',
            'quantity_issues' => 'مشاكل كميات',
        ],

        'assign_statuses' =>[
            'all' => 'الكل',
            'assigned' => 'مسند',
            'assigned_to_me' => 'مسند لي',
            'not_assigned' => 'غير مسند',
        ],

        'actions' => [
            'assign' => 'إسناد',
            'unassign' => 'إلغاء الإسناد',
            'process' => 'تجهيز',
            'scan_item' => 'مسح',
            'transfer' => 'تحويل',
            'transfer_to_support' => 'تحويل للدعم',
            'scan_barcode' => 'مسح الباركود',
            'show_details' => 'عرض التفاصيل',
        ],

        'notifications' => [
            'order_assigned_to_you' => 'تم إسناد طلب رقم :id لك',
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
            'sync_products' => 'مزامنة المنتجات',
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

    'stocktakings' => [
        'title' => 'عمليات الجرد',
        'model' => 'عملية جرد',
        'num_#' => 'جرد :name',
        'process_stocktaking_#' => 'جرد #:id',

        'attributes' => [
            'id' => 'المعرف',
            'employee' => 'الموظف',
            'shelf' => 'الرف',
            'warehouse' => 'المستودع',
            'status' => 'الحالة',
            'started_at' => 'وقت البدأ',
            'finished_at' => 'وقت الانتهاء',
            'products' => 'المنتجات',
            'products_count' => 'عدد المنتجات',
            'issues' => 'المشاكل',
            'issues_count' => 'عدد المشاكل',
        ],

        'actions' => [
            'create' => 'بدأ الجرد',
            'stocktake_shelf' => 'جرد الرف',
            'process' => 'استئناف الجرد',
            'confirm' => 'تأكيد',
            'edit' => 'تعديل',
            'save_updates' => 'حفظ التعديلات',
            'has_issue' => 'يوجد مشكلة',
            'print_barcode' => 'طباعة الباركود',
            'transfer_to_support' => 'تحويل للدعم',
            'attach_to_shelf' => 'إضافة للرف',
        ],

        'statuses' => [
            StocktakingStatus::PENDING->value => 'جاري المعالجة',
            StocktakingStatus::COMPLETED->value => 'مكتمل',
        ],

        'process_statuses' => [
            'pending' => 'قيد التأكيد',
            'confirmed' => 'تم التأكيد',
            'has_issues' => 'يوجد مشاكل',
            'missing_barcodes' => 'باركودات غير موجودة في المتجر',
        ],

        'issues' => [
            'select_issue' => 'اختر نوع المشكلة',

            'attributes' => [
                'product' => 'المنتج',
                'type' => 'نوع المشكلة',
                'employee_note' => 'ملاحظة الموظف',
                'resolved' => 'تم الحل',
            ],

            'types' => [
                StocktakingIssueType::WRONG_SHELF->value => 'رف خطأ',
                // StocktakingIssueType::NO_SHELF->value => '',
                StocktakingIssueType::WRONG_PRICE->value => 'سعر غير صحيح',
                StocktakingIssueType::WRONG_QUANTITY->value => 'كمية غير صحيحة',
                StocktakingIssueType::WRONG_BARCODE->value => 'باركود غير صحيح',
                StocktakingIssueType::MISSING_FROM_SALLA->value => 'غير موجود في سلة',
                StocktakingIssueType::OTHER->value => 'أخرى',
            ],
        ],

        'messages' => [
            'product_updated' => 'تم تحديث بيانات المنتج بنجاح',
        ],

        'alerts' => [
            'update_product' => 'سيتم تعديل بيانات المنتج في سلة والمنصة',
        ],

        'errors' => [
            'barcode_not_exists' => 'الباركود غير موجود في المتجر',
            'barcode_not_exists_in_shelf' => 'الباركود غير موجود في هذا الرف',
            'invalid_barcode' => 'الباركود غير صحيح',
            'product_already_stocktaken' => 'المنتج تم جرده بالفعل',
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
                'quantities' => 'الكميات',
            ],

            'filters' => [
                'warehouse_id' => 'المستودع',
            ],
        ],

        'products_with_multiple_shelves' => [
            'title' => 'منتجات متعددة الرفوف',

            'attributes' => [
                'product_remote_id' => 'معرف سلة',
                'product_name' => 'الاسم',
                'product_image' => 'الصورة',
                'product_sku' => 'SKU',
                'shelves' => 'الرفوف',
                'quantities' => 'الكميات',
            ],

            'filters' => [
                'warehouse_id' => 'المستودع',
            ],
        ],

        'nearly_expired_products' => [
            'title' => 'منتجات قاربت انتهاء الصلاحية',

            'attributes' => [
                'product_remote_id' => 'معرف سلة',
                'product_name' => 'الاسم',
                'product_image' => 'الصورة',
                'product_sku' => 'SKU',
                'shelves' => 'الرفوف',
                'quantities' => 'الكميات',
                'expiry_date' => 'انتهاء الصلاحية',
            ],

            'filters' => [
                'warehouse_id' => 'المستودع',
            ],
        ],

        'out_of_stock_products' => [
            'title' => 'منتجات منتهية الكمية',

            'attributes' => [
                'product_remote_id' => 'معرف سلة',
                'product_name' => 'الاسم',
                'product_image' => 'الصورة',
                'product_sku' => 'SKU',
                'shelves' => 'الرفوف',
                'quantities' => 'الكميات',
            ],

            'filters' => [
                'warehouse_id' => 'المستودع',
                'employee_id' => 'الموظف',
                'aisle' => 'الممر',
                'shelf' => 'الرف',
            ],
        ],
    ],
];
