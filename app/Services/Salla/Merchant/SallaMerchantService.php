<?php

namespace App\Services\Salla\Merchant;

use Illuminate\Support\Carbon;
use App\Services\Salla\SallaService;
use App\Services\Salla\Merchant\Support\Orders;
use App\Services\Salla\Merchant\Support\Coupons;
use App\Services\Salla\Merchant\Support\Reviews;
use App\Services\Salla\Merchant\Support\Products;
use App\Services\Salla\Merchant\Contracts\Support;
use App\Services\Salla\Merchant\Support\Shipments;
use App\Services\Salla\Merchant\Support\Currencies;
use App\Services\Salla\Merchant\Support\OrderItems;
use App\Services\Salla\Merchant\Support\OrderStatuses;
use App\Services\Salla\Merchant\Support\AbandonedCarts;
use App\Services\Salla\Merchant\Support\OrderHistories;

final class SallaMerchantService extends SallaService
{
    public readonly string $baseUrl;

    public readonly Client $client;

    public function __construct(
        protected string $accessToken,
    ) {
        $this->baseUrl = 'https://api.salla.dev/admin/v2';
        $this->client = new Client(
            accessToken: $this->accessToken,
        );
    }

    public static function withToken(string $accessToken): self
    {
        return new self(
            accessToken: $accessToken,
        );
    }

    public function orders(): Orders
    {
        return $this->resolve(
            className: Orders::class,
        );
    }

    public function orderItems(): OrderItems
    {
        return $this->resolve(
            className: OrderItems::class,
        );
    }

    public function orderHistories(): OrderHistories
    {
        return $this->resolve(
            className: OrderHistories::class,
        );
    }

    public function orderStatuses(): OrderStatuses
    {
        return $this->resolve(
            className: OrderStatuses::class,
        );
    }

    public function shipments(): Shipments
    {
        return $this->resolve(
            className: Shipments::class,
        );
    }

    public function products(): Products
    {
        return $this->resolve(
            className: Products::class,
        );
    }

    public function abandonedCarts(): AbandonedCarts
    {
        return $this->resolve(
            className: AbandonedCarts::class,
        );
    }

    public function coupons(): Coupons
    {
        return $this->resolve(
            className: Coupons::class,
        );
    }

    public function reviews(): Reviews
    {
        return $this->resolve(
            className: Reviews::class,
        );
    }

    public function currencies(): Currencies
    {
        return $this->resolve(
            className: Currencies::class,
        );
    }

    public static function parseDate(array|string $date): Carbon
    {
        if (is_string(
            value: $date,
        )) {
            return Carbon::parse(
                time: $date,
            );
        }

        return Carbon::parse(
            time: $date['date'],
            timezone: $date['timezone']
        )->timezone(
            value: config(
                key: 'app.timezone',
            ),
        );
    }

    protected function resolve(string $className): object
    {
        $abstract = $className.':'.$this->accessToken;

        app()->singletonIf(
            abstract: $abstract,
            concrete: fn (): Support => new $className(
                service: $this,
                client: $this->client,
            ),
        );

        return resolve(
            name: $abstract,
        );
    }
}
