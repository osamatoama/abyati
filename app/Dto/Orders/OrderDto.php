<?php

namespace App\Dto\Orders;

use App\Models\Store;
use App\Models\Branch;
use Illuminate\Support\Carbon;
use App\Models\ShippingCompany;
use App\Services\Salla\Merchant\SallaMerchantService;

final class OrderDto
{
    public function __construct(
        public int     $remoteId,
        public int     $referenceId,
        public int     $storeId,
        public ?int    $branchId = null,
        // public ?int    $employeeId,
        public ?Carbon $date,
        public ?int    $statusId,
        public ?string $statusName,
        // public ?string $completionStatus,
        public ?string $shipmentType = null,
        public ?int    $shippingCompanyId = null,
        public ?int    $shipmentBranchId = null,
        public ?string $paymentMethod = null,
        public ?array  $amounts,
        public ?array  $customer,
        public ?array  $address = null,
    )
    {
        //
    }

    public static function fromSalla(array $sallaOrder, int $storeId, int $statusId): self
    {
        $store = Store::findOrFail($storeId);

        $branch = $store->branches()->wherePivot('order_status_id', $statusId)->first();

        return new self(
            remoteId: $sallaOrder['id'],
            referenceId: $sallaOrder['reference_id'],
            storeId: $storeId,
            branchId: $branch?->id,
            date: !empty($sallaOrder['date']['date']) ? SallaMerchantService::parseDate(
                date: $sallaOrder['date'],
            ) : null,
            statusId: $statusId,
            statusName: $sallaOrder['status']['name'] ?? null,
            shipmentType: null,
            shippingCompanyId: null,
            shipmentBranchId: null,
            paymentMethod: $sallaOrder['payment_method'] ?? null,
            amounts: $sallaOrder['amounts'] ?? null,
            customer: $sallaOrder['customer'] ?? null,
            address: null,
        );
    }

    public static function fromSallaWebhook(array $sallaOrder, int $storeId, int $statusId): self
    {
        $store = Store::findOrFail($storeId);

        $branch = $store->branches()->wherePivot('order_status_id', $statusId)->first();

        $shipmentType = $sallaOrder['shipments'][0]['type'] ?? null;

        $address = $sallaOrder['shipments'][0]['ship_to'] ?? null;

        $shippingCompanyRemoteId = $sallaOrder['shipments'][0]['courier_id'] ?? null;
        $shippingCompany = null;
        if ($shippingCompanyRemoteId) {
            $shippingCompany = ShippingCompany::where('remote_id', $shippingCompanyRemoteId)->first();
        }

        $shipmentBranchRemoteId = $sallaOrder['shipment_branch'][0]['id'] ?? null;
        $shipmentBranch = null;
        if ($shipmentBranchRemoteId) {
            $shipmentBranch = Branch::where('remote_id', $shipmentBranchRemoteId)->first();
        }

        return new self(
            remoteId: $sallaOrder['id'],
            referenceId: $sallaOrder['reference_id'],
            storeId: $storeId,
            branchId: $branch?->id,
            date: !empty($sallaOrder['date']['date']) ? SallaMerchantService::parseDate(
                date: $sallaOrder['date'],
            ) : null,
            statusId: $statusId,
            statusName: $sallaOrder['status']['name'] ?? null,
            shipmentType: $shipmentType,
            shippingCompanyId: $shippingCompany?->id,
            shipmentBranchId: $shipmentBranch?->id,
            paymentMethod: $sallaOrder['payment_method'] ?? null,
            amounts: $sallaOrder['amounts'] ?? null,
            customer: $sallaOrder['customer'] ?? null,
            address: $address,
        );
    }
}
