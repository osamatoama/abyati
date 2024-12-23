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

class OrderProcessingDelayedEvent implements ShouldBroadcast
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
            new PrivateChannel('order-delay-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order-processing-delayed-event';
    }

    public function broadcastWith(): array
    {
        return [
            'reference_id' => $this->order->reference_id,
            'employee_id' => $this->order->employee_id,
            // 'message' => __('employee.orders.notifications.order_assigned_to_you', ['id' => $this->order->reference_id]),
        ];
    }
}
