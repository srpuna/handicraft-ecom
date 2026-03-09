<?php

namespace App\Services;

use App\Mail\Orders\QuotationSentMail;
use App\Mail\Orders\OrderProcessedMail;
use App\Mail\Orders\OrderDispatchedMail;
use App\Mail\Orders\OrderDeliveredMail;
use App\Models\Order;
use App\Models\OrderNotification;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Dispatch notification for a given order event.
     */
    public function notify(Order $order, string $eventType): void
    {
        $order->load('client');
        $email = $order->client?->email
            ?? ($order->client_snapshot['email'] ?? null);

        if (!$email) {
            return; // No recipient — skip
        }

        $mailable = match ($eventType) {
            Order::STATUS_QUOTATION_SENT => new QuotationSentMail($order),
            Order::STATUS_PROCESSED => new OrderProcessedMail($order),
            Order::STATUS_DISPATCHED => new OrderDispatchedMail($order),
            Order::STATUS_DELIVERED => new OrderDeliveredMail($order),
            default => null,
        };

        if (!$mailable) {
            return;
        }

        try {
            Mail::to($email)->queue($mailable);

            OrderNotification::create([
                'order_id' => $order->id,
                'notifiable_email' => $email,
                'channel' => 'email',
                'event_type' => $eventType,
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            OrderNotification::create([
                'order_id' => $order->id,
                'notifiable_email' => $email,
                'channel' => 'email',
                'event_type' => $eventType,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
