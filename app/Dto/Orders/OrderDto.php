<?php

namespace App\Dto\Orders;

use Illuminate\Support\Carbon;
use App\Enums\Salla\OrderAddressType;
use App\Services\Salla\Merchant\SallaMerchantService;

final class OrderDto
{
    public function __construct(
        public int     $remoteId,
        public int     $referenceId,
        public int     $storeId,
        // public int     $branchId,
        // public ?int    $employeeId,
        public ?Carbon $date,
        public ?int    $statusId,
        public ?string $statusName,
        // public ?string $completionStatus,
        public ?string $shipmentType,
        public ?array  $amounts,
        public ?array  $customer,
        public ?array  $address,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOrder, int $storeId, int $statusId): self
    {
        $shipmentType = $sallaOrder['shipments'][0]['type'] ?? null;

        $address = ($shipmentType == OrderAddressType::PICKUP->value)
            ? ($sallaOrder['shipping']['pickup_address'] ?? null)
            : ($sallaOrder['shipping']['address'] ?? null);

        return new self(
            remoteId: $sallaOrder['id'],
            referenceId: $sallaOrder['reference_id'],
            storeId: $storeId,
            date: !empty($sallaOrder['date']['date']) ? SallaMerchantService::parseDate(
                date: $sallaOrder['date'],
            ) : null,
            statusId: $statusId,
            statusName: $sallaOrder['status']['name'] ?? null,
            shipmentType: $shipmentType,
            amounts: $sallaOrder['amounts'] ?? null,
            customer: $sallaOrder['customer'] ?? null,
            address: $address,
        );
    }
}
