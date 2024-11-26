<?php

namespace App\Dto\Orders;

use App\Models\Branch;
use App\Models\ShippingCompany;

final class OrderShipmentDto
{
    public function __construct(
        public ?string $shipmentType,
        public ?int    $shippingCompanyId = null,
        // public ?int    $shipmentBranchId = null,
        public ?array  $address,
    )
    {
        //
    }

    public static function fromSalla(array $sallaShipment): self
    {
        $shippingCompanyRemoteId = $sallaShipment['courier_id'] ?? null;
        $shippingCompany = null;
        if ($shippingCompanyRemoteId) {
            $shippingCompany = ShippingCompany::where('remote_id', $shippingCompanyRemoteId)->first();
        }

        // $shipmentBranchRemoteId = $sallaShipment['branch_id'] ?? null;
        // $shipmentBranch = null;
        // if ($shipmentBranchRemoteId) {
        //     $shipmentBranch = Branch::where('remote_id', $shipmentBranchRemoteId)->first();
        // }

        return new self(
            shipmentType: $sallaShipment['type'] ?? null,
            shippingCompanyId: $shippingCompany?->id,
            // shipmentBranchId: $shipmentBranch?->id,
            address: $sallaShipment['ship_to'] ?? null,
        );
    }
}
