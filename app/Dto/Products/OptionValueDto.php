<?php

namespace App\Dto\Products;

final class OptionValueDto
{
    public function __construct(
        public int     $storeId,
        public int     $remoteId,
        public int     $optionId,
        public ?string $name,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOptionValue, int $storeId, int $optionId): self
    {
        return new self(
            storeId: $storeId,
            optionId: $optionId,
            remoteId: $sallaOptionValue['id'],
            name: $sallaOptionValue['name'],
        );
    }
}
