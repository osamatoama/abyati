<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Dto\Orders\OrderItemDto;
use App\Dto\Products\ProductDto;
use App\Services\Concerns\HasInstance;
use App\Services\Products\ProductService;

final class OrderItemService
{
    use HasInstance;

    public function updateOrCreate(OrderItemDto $orderItemDto): OrderItem
    {
        return OrderItem::query()
            ->updateOrCreate(
                attributes: [
                    'remote_id' => $orderItemDto->remoteId,
                    'order_id' => $orderItemDto->orderId,
                ],
                values: [
                    'product_id' => $orderItemDto->productId,
                    'variant_id' => $orderItemDto->variantId,
                    'name' => $orderItemDto->name,
                    'quantity' => $orderItemDto->quantity,
                    'amounts' => $orderItemDto->amounts,
                ],
            );
    }

    public function updateOrCreateForDecomposedProductGroups(OrderItemDto $orderItemDto): OrderItem
    {
        return OrderItem::query()
            ->whereNull('remote_id')
            ->updateOrCreate(
                attributes: [
                    'order_id' => $orderItemDto->orderId,
                    'product_id' => $orderItemDto->productId,
                ],
                values: [
                    'variant_id' => $orderItemDto->variantId,
                    'name' => $orderItemDto->name,
                    'quantity' => $orderItemDto->quantity,
                    'amounts' => $orderItemDto->amounts,
                ],
            );
    }

    public function saveSallaOrderItem(Order $order, array $sallaOrderItem, int $storeId): void
    {
        $product = ProductService::instance()
            ->first(
                productDto: ProductDto::fromSallaOrderItemApi(
                    sallaOrderItem: $sallaOrderItem,
                    storeId: $storeId,
                ),
            );

        if (! $product) {
            /**
             * TODO: Pull this product
             */
            throw new \Exception('Product not found');
        }

        $this->updateOrCreate(
            orderItemDto: OrderItemDto::fromSalla(
                sallaOrderItem: $sallaOrderItem,
                orderId: $order->id,
            ),
        );

        if ($product->isGroup() && filled($sallaOrderItem['consisted_products'] ?? [])) {
            $this->decomposeProductGroup(
                order: $order,
                product: $product,
                sallaOrderItem: $sallaOrderItem,
            );
        }
    }

    public function saveSallaOrderItemFromWebhook(Order $order, array $sallaOrderItem, int $storeId): void
    {
        $product = ProductService::instance()
            ->firstOrCreate(
                productDto: ProductDto::fromSallaOrderItemWebhook(
                    sallaOrderItemProduct: $sallaOrderItem['product'],
                    storeId: $storeId,
                ),
            );

        $this->updateOrCreate(
            orderItemDto: OrderItemDto::fromSallaWebhook(
                sallaOrderItem: $sallaOrderItem,
                orderId: $order->id,
                productId: $product->id,
            ),
        );

        if ($product->isGroup() && filled($sallaOrderItem['consisted_products'] ?? [])) {
            $this->decomposeProductGroup(
                order: $order,
                product: $product,
                sallaOrderItem: $sallaOrderItem,
            );
        }
    }

    private function decomposeProductGroup(Order $order, Product $product, array $sallaOrderItem): void
    {
        $consistedProducts = Product::query()
            ->whereIn('remote_id', array_column($sallaOrderItem['consisted_products'], 'id'))
            ->get();

        foreach ($sallaOrderItem['consisted_products'] as $sallaConsistedProduct) {
            if (! $consistedProduct = $consistedProducts->firstWhere('remote_id', $sallaConsistedProduct['id'])) {
                continue;
            }

            $this->updateOrCreateForDecomposedProductGroups(
                orderItemDto: OrderItemDto::fromSallaDecomposedProductGroup(
                    order: $order,
                    sallaConsistedProduct: $sallaConsistedProduct,
                    consistedProduct: $consistedProduct,
                    groupQuantity: $sallaOrderItem['quantity'],
                ),
            );
        }
    }
}
