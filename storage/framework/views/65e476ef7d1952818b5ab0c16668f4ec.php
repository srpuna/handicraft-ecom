<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo e($invoice->invoice_number); ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #22c55e;
            padding-bottom: 15px;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: #16a34a;
            line-height: 1;
        }

        .invoice-title {
            font-size: 24px;
            color: #374151;
            margin: 0;
            text-transform: uppercase;
        }

        .meta-data {
            text-align: right;
        }

        .status-badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-issued {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .status-draft {
            background-color: #fef9c3;
            color: #ca8a04;
        }

        .status-voided {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .details-grid {
            width: 100%;
            margin-bottom: 30px;
        }

        .details-grid td {
            vertical-align: top;
            width: 50%;
        }

        .section-title {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .info-text {
            font-size: 13px;
            margin: 0;
            line-height: 1.4;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.items th {
            background-color: #f9fafb;
            color: #374151;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #e5e7eb;
        }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .totals-table {
            width: 300px;
            border-collapse: collapse;
            float: right;
        }

        .totals-table td {
            padding: 5px 10px;
        }

        .grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #374151;
            padding-top: 10px !important;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
            clear: both;
        }

        .void-watermark {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(239, 68, 68, 0.08);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div style="padding: 30px;">
        <?php if($invoice->status === 'voided'): ?>
            <div class="void-watermark">VOID</div>
        <?php endif; ?>

        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="vertical-align: top; border-bottom: 2px solid #22c55e; padding-bottom: 15px;">
                    <div class="logo"><?php echo e(config('app.name', 'OMS Application')); ?></div>
                    <div style="color: #6b7280; font-size: 11px; margin-top: 5px;">
                        123 Commerce Blvd.<br>
                        Suite 400<br>
                        Business City, ST 12345
                    </div>
                </td>
                <td
                    style="vertical-align: top; text-align: right; border-bottom: 2px solid #22c55e; padding-bottom: 15px;">
                    <h1 class="invoice-title">Invoice</h1>
                    <p style="margin: 5px 0;"><strong>#<?php echo e($invoice->invoice_number); ?></strong></p>
                    <span class="status-badge status-<?php echo e($invoice->status); ?>"><?php echo e($invoice->status); ?></span>
                    <p style="margin: 10px 0 0 0; font-size: 11px; color: #6b7280;">Date:
                        <?php echo e(($invoice->issued_at ?? $invoice->created_at)->format('M d, Y')); ?>

                    </p>
                    <p style="margin: 2px 0 0 0; font-size: 11px; color: #6b7280;">Reference: Order
                        #<?php echo e($invoice->order->order_number); ?></p>
                </td>
            </tr>
        </table>

        <?php $c = $invoice->client_snapshot; ?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="border-collapse: collapse; margin-bottom: 30px;">
            <tr>
                <td width="55%" style="vertical-align: top;">
                    <div class="section-title">Billed To</div>
                    <p class="info-text">
                        <strong><?php echo e($c['name'] ?? 'Walk-in Customer'); ?></strong><br>
                        <?php if(!empty($c['company'])): ?> <?php echo e($c['company']); ?><br> <?php endif; ?>
                        <?php if(!empty($c['address'])): ?>
                            <?php echo e($c['address']); ?><br>
                            <?php echo e($c['city'] ?? ''); ?> <?php echo e($c['state'] ? ', ' . $c['state'] : ''); ?>

                            <?php echo e($c['zip_code'] ?? ''); ?><br>
                            <?php echo e($c['country'] ?? ''); ?>

                        <?php endif; ?>
                    </p>
                </td>
                <td width="45%" style="vertical-align: top;">
                    <?php if(!empty($c['email']) || !empty($c['phone'])): ?>
                        <div class="section-title">Contact Info</div>
                        <p class="info-text">
                            <?php if(!empty($c['email'])): ?> <?php echo e($c['email']); ?><br> <?php endif; ?>
                            <?php if(!empty($c['phone'])): ?> <?php echo e($c['phone']); ?> <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php $fin = $invoice->financial_snapshot; ?>

        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th
                        style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: left; font-size: 11px; font-weight: bold;">
                        Description</th>
                    <th style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: center; font-size: 11px; font-weight: bold;"
                        width="50">Qty</th>
                    <th style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: right; font-size: 11px; font-weight: bold;"
                        width="80">Unit Price</th>
                    <th style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: right; font-size: 11px; font-weight: bold;"
                        width="80">Discount</th>
                    <th style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: right; font-size: 11px; font-weight: bold;"
                        width="90">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $fin['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6;">
                            <strong><?php echo e($item['product_name']); ?></strong>
                            <?php if($item['product_sku']): ?> <span style="color: #6b7280; font-size: 10px; display: block;">SKU:
                            <?php echo e($item['product_sku']); ?></span> <?php endif; ?>
                            <?php if(!empty($item['dimensions'])): ?> <span
                                style="color: #6b7280; font-size: 10px; display: block;">Dim:
                            <?php echo e($item['dimensions']); ?></span> <?php endif; ?>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: center;">
                            <?php echo e($item['quantity']); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right;">
                            $<?php echo e(number_format($item['unit_price'], 2)); ?></td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; color: #dc2626; font-size: 11px;">
                            <?php if($item['item_discount_amount'] > 0): ?>
                                -$<?php echo e(number_format($item['item_discount_amount'], 2)); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-weight: bold;">
                            $<?php echo e(number_format($item['line_total'], 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="padding: 4px 0; color: #6b7280;">Subtotal</td>
                            <td style="padding: 4px 0; text-align: right;">$<?php echo e(number_format($fin['subtotal'], 2)); ?>

                            </td>
                        </tr>
                        <?php if($fin['order_discount_amount'] > 0): ?>
                            <tr>
                                <td style="padding: 4px 0; color: #dc2626;">Order Discount</td>
                                <td style="padding: 4px 0; text-align: right; color: #dc2626;">
                                    -$<?php echo e(number_format($fin['order_discount_amount'], 2)); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="padding: 4px 0; color: #6b7280;">Shipping</td>
                            <td style="padding: 4px 0; text-align: right;">
                                $<?php echo e(number_format($fin['shipping_cost'], 2)); ?></td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 10px 0 0 0; font-weight: bold; font-size: 16px; border-top: 1px solid #374151;">
                                Grand Total</td>
                            <td
                                style="padding: 10px 0 0 0; text-align: right; font-weight: bold; font-size: 16px; border-top: 1px solid #374151; color: #16a34a;">
                                $<?php echo e(number_format($fin['grand_total'], 2)); ?>

                                <span
                                    style="font-size: 11px; font-weight: normal; color: #9ca3af;"><?php echo e($fin['currency']); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p style="margin: 0; margin-bottom: 5px;">Thank you for your business!</p>
            <p style="margin: 0;">Payment is due upon receipt. If you have any questions regarding this invoice, please
                contact support at <?php echo e(config('mail.from.address', 'support@example.com')); ?>.</p>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/invoices/pdf.blade.php ENDPATH**/ ?>