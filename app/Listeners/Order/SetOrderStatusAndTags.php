<?php

namespace App\Listeners\Order;

use App\Models\Tag;
use App\Enums\SettingType;
use App\Events\Order\OrderCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Orders\Tags\OrderTagChecker;
use App\Jobs\Salla\Push\Orders\CreateOrderTagJob;
use App\Jobs\Salla\Push\Orders\UpdateOrderStatusJob;

class SetOrderStatusAndTags implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $enableOrderAutoTaggingSetting = settings()
            ->whereNull('store_id')
            ->where('type', SettingType::TAGS->value)
            ->where('key', 'enable_order_auto_tagging')
            ->first();

        if (! (bool) $enableOrderAutoTaggingSetting?->value) {
            return;
        }

        $order = $event->order;

        $tags = Tag::query()
            ->forStore($order->store_id)
            ->get();

        foreach ($tags as $tag) {
            if (OrderTagChecker::check(
                order: $order,
                tag: $tag,
            )) {
                $order->tags()->attach($tag->id);
            }
        }

        $defaultStatus = $order->store->orderStatuses
            ->where('slug', 'under_review')
            ->first();

        $toUpdateStatus = $defaultStatus;

        if ($order->tags->isEmpty()) {
            $toUpdateStatus = $order->shipmentBranch
                ?->orderStatuses
                ->where('store_id', $order->store_id)
                ->first()
            ?? $defaultStatus;
        }

        dispatch(new UpdateOrderStatusJob(
            token: $order->store?->user?->sallaToken,
            store: $order->store,
            order: $order,
            status: $toUpdateStatus,
        ));

        foreach ($order->tags as $tag) {
            dispatch(new CreateOrderTagJob(
                token: $order->store?->user?->sallaToken,
                store: $order->store,
                order: $order,
                tag: $tag,
            ));
        }
    }
}
