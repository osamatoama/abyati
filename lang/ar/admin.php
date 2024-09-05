<?php

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
            'image' => 'الصورة',
            'name' => 'الاسم',
            'sku' => 'SKU',
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
];
