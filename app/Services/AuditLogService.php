<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderAuditLog;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogService
{
    /**
     * Log an action to the audit trail.
     */
    public static function log(
        string $actionType,
        ?Order $order,
        ?Invoice $invoice,
        array $oldValues,
        array $newValues,
        ?User $user,
        string $description = '',
        ?string $ipAddress = null
    ): OrderAuditLog {
        return OrderAuditLog::create([
            'order_id' => $order?->id,
            'invoice_id' => $invoice?->id,
            'user_id' => $user?->id,
            'action_type' => $actionType,
            'description' => $description,
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'ip_address' => $ipAddress ?? request()->ip(),
        ]);
    }

    /**
     * Log a simple action without old/new value comparison.
     * Order and Invoice can be null (e.g. for client-level actions).
     */
    public static function logSimple(
        string $actionType,
        ?Order $order,
        string $description,
        ?User $user = null,
        array $context = []
    ): OrderAuditLog {
        return self::log($actionType, $order, null, [], $context, $user, $description);
    }

    /**
     * Log a status change with from/to values.
     */
    public static function logStatusChange(
        Order $order,
        string $oldStatus,
        string $newStatus,
        ?User $user = null,
        string $extra = ''
    ): OrderAuditLog {
        $oldLabel = Order::STATUS_LABELS[$oldStatus] ?? $oldStatus;
        $newLabel = Order::STATUS_LABELS[$newStatus] ?? $newStatus;
        $desc = "Status changed from '{$oldLabel}' to '{$newLabel}'." . ($extra ? " {$extra}" : '');

        return self::log(
            'status_changed',
            $order,
            null,
            ['status' => $oldStatus],
            ['status' => $newStatus],
            $user,
            $desc
        );
    }
}
