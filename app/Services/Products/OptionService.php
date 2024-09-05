<?php

namespace App\Services\Products;

use App\Models\Option;
use App\Dto\Products\OptionDto;
use App\Dto\Products\OptionValueDto;
use App\Services\Concerns\HasInstance;

final class OptionService
{
    use HasInstance;

    public function updateOrCreate(OptionDto $optionDto): Option
    {
        return Option::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $optionDto->remoteId,
                    'store_id' => $optionDto->storeId,
                    'product_id' => $optionDto->productId,
                ],
                values: [
                    'name' => $optionDto->name,
                ],
            );
    }

    public function saveSallaOption(array $sallaOption, int $storeId, int $productId): Option
    {
        $option = $this->updateOrCreate(
            optionDto: OptionDto::fromSalla(
                sallaOption: $sallaOption,
                storeId: $storeId,
                productId: $productId,
            ),
        );

        foreach ($sallaOption['values'] as $value) {
            OptionValueService::instance()
                ->updateOrCreate(
                    optionValueDto: OptionValueDto::fromSalla(
                        sallaOptionValue: $value,
                        storeId: $storeId,
                        optionId: $option->id,
                    ),
                );
        }

        return $option;
    }
}
