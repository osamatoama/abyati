<?php

namespace App\Dto\Orders;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use App\Services\Currencies\CurrencyConverter;
use App\Services\Salla\Merchant\SallaMerchantService;

final class OrderDto
{
    public function __construct(
        public int     $remoteId,
        public int     $referenceId,
        public int     $storeId,
        public int     $couponId,
        public ?int    $marketerId,
        public ?Carbon $date,
        public ?string $dateTimezone,
        public ?int    $statusId,
        public ?string $statusName,
        public ?float  $subTotal,
        public ?float  $shippingCost,
        public ?float  $cashOnDelivery,
        public ?float  $tax,
        public float   $discount,
        public ?float  $discountedShipping,
        public ?float  $total,
        public ?string $currency,
        public ?float  $commission,
        // public bool    $isPaymentDue,
        // public bool    $isCommissionPaid,
    )
    {
    }

    public static function fromSalla(array $sallaOrder, int $storeId, int $statusId): self
    {
        $sallaOrderDiscounts = $sallaOrder['amounts']['discounts'];

        $sallaCouponDiscount = collect($sallaOrderDiscounts)
            ->whereNotNull('code')
            ->first();

        $coupon = null;

        if ($sallaCouponDiscount['code'] ?? false) {
            $coupon = Coupon::findByCode($sallaCouponDiscount['code']);
        }

        $subTotal = $sallaOrder['amounts']['sub_total']['amount'] ?? null;
        $shippingCost = $sallaOrder['amounts']['shipping_cost']['amount'] ?? null;
        $cashOnDelivery = $sallaOrder['amounts']['cash_on_delivery']['amount'] ?? null;
        $tax = $sallaOrder['amounts']['tax']['amount']['amount'] ?? null;
        $discount = $sallaCouponDiscount['discount'] ?? 0;
        $discountedShipping = $sallaCouponDiscount['discounted_shipping'] ?? null;
        $total = $sallaOrder['amounts']['total']['amount'] ?? null;
        $fromCurrency = $sallaOrder['currency'] ?? $sallaOrder['amounts']['total']['currency'] ?? null;

        return new self(
            remoteId: $sallaOrder['id'],
            referenceId: $sallaOrder['reference_id'],
            storeId: $storeId,
            couponId: $coupon?->id,
            marketerId: $coupon?->marketer_id,
            date: !empty($sallaOrder['date']['date']) ? SallaMerchantService::parseDate(
                date: $sallaOrder['date'],
            ) : null,
            dateTimezone: $sallaOrder['date']['timezone'] ?? null,
            statusId: $statusId,
            statusName: $sallaOrder['status']['name'] ?? null,
            subTotal: CurrencyConverter::convertToSar($subTotal, $fromCurrency),
            shippingCost: CurrencyConverter::convertToSar($shippingCost, $fromCurrency),
            cashOnDelivery: CurrencyConverter::convertToSar($cashOnDelivery, $fromCurrency),
            tax: CurrencyConverter::convertToSar($tax, $fromCurrency),
            discount: CurrencyConverter::convertToSar($discount, $fromCurrency),
            discountedShipping: CurrencyConverter::convertToSar($discountedShipping, $fromCurrency),
            total: CurrencyConverter::convertToSar($total, $fromCurrency),
            currency: CurrencyConverter::SAR_CODE,
            commission: null,
            // isPaymentDue: false,
            // isCommissionPaid: false,
        );
    }
}
