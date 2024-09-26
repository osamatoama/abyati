<?php

namespace App\Dto\Orders;

use App\Services\Salla\Merchant\SallaMerchantService;
use Illuminate\Support\Carbon;

final class OrderHistoryDto
{
    public function __construct(
        public int     $remoteId,
        public int     $orderId,
        public int     $statusId,
        public ?string $note,
        public ?Carbon $date,
    )
    {
    }

    public static function fromSalla(array $sallaOrderHistory, int $orderId, int $statusId): self
    {
        return new self(
            remoteId: $sallaOrderHistory['id'],
            orderId: $orderId,
            statusId: $statusId,
            note: !empty($sallaOrderHistory['note']) ? $sallaOrderHistory['note'] : null,
            date: !empty($sallaOrderHistory['created_at']['date']) ? SallaMerchantService::parseDate(
                date: $sallaOrderHistory['created_at'],
            ) : null,
        );
    }
}
