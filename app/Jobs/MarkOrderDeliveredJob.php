<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\AuditLogService;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkOrderDeliveredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $orderId)
    {
    }

    public function handle(NotificationService $notificationService): void
    {
        $order = Order::find($this->orderId);

        if (!$order) {
            return; // Order deleted
        }

        // Only auto-deliver if still dispatched
        if ($order->status !== Order::STATUS_DISPATCHED) {
            return;
        }

        $order->status = Order::STATUS_DELIVERED;
        $order->save();

        // Log as system action (no user)
        AuditLogService::log(
            'auto_delivered',
            $order,
            null,
            ['status' => Order::STATUS_DISPATCHED],
            ['status' => Order::STATUS_DELIVERED],
            null,
            "Order #{$order->order_number} automatically marked as Delivered after delivery period.",
            null
        );

        // Send notification
        $notificationService->notify($order, Order::STATUS_DELIVERED);
    }
}
