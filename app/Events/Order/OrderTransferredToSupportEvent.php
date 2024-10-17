<?php

namespace App\Events\Order;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderTransferredToSupportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue = 'broadcast';

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Order $order,
    )
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('order-transfer-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order-transferred-to-support-event';
    }

    public function broadcastWith(): array
    {
        return [
            'reference_id' => $this->order->reference_id,
            'branch_id' => $this->order->branch_id,
            'message' => __('support.orders.notifications.order_has_quantity_issue', ['id' => $this->order->reference_id]),
        ];
    }
}
