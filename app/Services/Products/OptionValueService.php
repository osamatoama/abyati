<?php

namespace App\Services\Products;

use App\Models\OptionValue;
use App\Dto\Products\OptionValueDto;
use App\Services\Concerns\HasInstance;

final class OptionValueService
{
    use HasInstance;

    public function updateOrCreate(OptionValueDto $optionValueDto): OptionValue
    {
        return OptionValue::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $optionValueDto->remoteId,
                    'store_id' => $optionValueDto->storeId,
                    'option_id' => $optionValueDto->optionId,
                ],
                values: [
                    'name' => $optionValueDto->name,
                ],
            );
    }
}
