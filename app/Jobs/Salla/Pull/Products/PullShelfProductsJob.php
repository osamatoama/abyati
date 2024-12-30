<?php

namespace App\Jobs\Salla\Pull\Products;

use Exception;
use App\Models\Shelf;
use App\Models\Product;
use App\Enums\ProductStatus;
use App\Models\ProductShelf;
use Illuminate\Bus\Queueable;
use App\Enums\Queues\QueueName;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Concerns\HandleExceptions;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\Concerns\InteractsWithBatches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PullShelfProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithBatches, HandleExceptions, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly int $storeId,
        public readonly Shelf $shelf,
    ) {
        $this->maxAttempts = 5;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $productRemoteIds = Product::query()
                ->addSelect([
                    'attached_at' => ProductShelf::query()
                        ->select('created_at')
                        ->whereColumn('product_shelf.product_id', 'products.id')
                        ->where('product_shelf.shelf_id', $this->shelf->id)
                        ->limit(1),
                ])
                ->where('status', '!=', ProductStatus::DELETED->value)
                ->whereHas('shelves', fn ($query) =>
                    $query->where('shelves.id', $this->shelf->id)
                )
                ->with([
                    'quantities' => fn($q) => $q->where('branch_id', $this->shelf->warehouse->branch_id),
                ])
                ->orderBy('attached_at', 'desc')
                ->pluck('remote_id')
                ->toArray();

            if (empty($productRemoteIds)) {
                return;
            }

            dispatch(new PullCustomProductsJob(
                    accessToken: $this->accessToken,
                    storeId: $this->storeId,
                    remoteIds: $productRemoteIds,
                    markAsSynced: true,
                    batchSuffix: "shelf." . $this->shelf->id,
                ))
                ->onQueue(
                    queue: QueueName::PULL,
                );
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }
}
