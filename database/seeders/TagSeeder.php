<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Store;
use App\Enums\TagSlug;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplierStore = Store::supplier()->first();

        $tags = [
            [
                'name' => 'يحتوي على منتجات مجمدات',
                'slug' => TagSlug::HAS_FROZEN_PRODUCTS,
                'description' => 'إذا كان الطلب يحتوي على منتجات من تصنيف "المجمدات" وشركة الشحن (أرامكس - سمسا - اليمامة)',
            ],
            [
                'name' => 'تأكيد التحويل',
                'slug' => TagSlug::CONFIRM_BANK_TRANSFER,
                'description' => 'إذا كان الطلب مدفوع عن طريق حوالة بنكية',
            ],
            [
                'name' => 'طلب من فرع خاطئ',
                'slug' => TagSlug::WRONG_SHIPMENT_BRANCH,
                'description' => 'إذا كان العميل من تبوك واختار فرع الرياض واختار شحن لتبوك أو العكس',
            ],
            [
                'name' => 'طلب خارجي',
                'slug' => TagSlug::EXTERNAL_ORDER,
                'description' => 'إذا كانت مدينة العميل غير مدينة الفرع الذي طلب منه',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate([
                'store_id' => $supplierStore->id,
                'slug' => $tag['slug'] ?? null,
            ], [
                'name' => $tag['name'],
                'description' => $tag['description'],
            ]);
        }
    }
}
