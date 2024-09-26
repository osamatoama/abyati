<?php

namespace App\Dto\Products;

use App\Models\OptionValue;

final class ProductVariantDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public int     $productId,
        public ?string $sku,
        public ?string $barcode,
        public int     $stockQuantity,
        public bool    $unlimitedQuantity,
        public array   $optionValueIds = [],
    )
    {
    }

    public static function fromSalla(array $sallaSku, int $storeId, int $productId): self
    {
        $optionValueIds = OptionValue::query()
            ->where('store_id', $storeId)
            ->whereIn('remote_id', $sallaSku['related_option_values'])
            ->pluck('id')
            ->toArray();

        return new self(
            storeId: $storeId,
            productId: $productId,
            remoteId: $sallaSku['id'],
            sku: !empty($sallaSku['sku']) ? $sallaSku['sku'] : null,
            barcode: !empty($sallaSku['barcode']) ? $sallaSku['barcode'] : null,
            stockQuantity: $sallaSku['stock_quantity'] ?? null,
            unlimitedQuantity: $sallaSku['unlimited_quantity'] ?? null,
            optionValueIds: $optionValueIds,
        );
    }
}
