

<?php $__env->startSection('header'); ?>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.orders.show', $invoice->order)); ?>"
            class="text-gray-400 hover:text-green-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold flex items-center gap-2">
                Invoice <span class="font-mono text-indigo-700"><?php echo e($invoice->invoice_number); ?></span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded
                        <?php echo e($invoice->status === 'issued' ? 'bg-green-100 text-green-700' : ''); ?>

                        <?php echo e($invoice->status === 'voided' ? 'bg-red-100 text-red-700' : ''); ?>

                        <?php echo e($invoice->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : ''); ?>">
                    <?php echo e(strtoupper($invoice->status)); ?>

                </span>
            </h2>
            <p class="text-sm text-gray-500">For Order #<?php echo e($invoice->order->order_number); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto space-y-6">

        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <strong>Generated on:</strong> <?php echo e($invoice->created_at->format('d M Y, H:i')); ?> by
                <?php echo e($invoice->generatedBy?->name ?? 'System'); ?>

                <?php if($invoice->status === 'issued'): ?>
                    <br><strong>Issued on:</strong> <?php echo e($invoice->issued_at->format('d M Y, H:i')); ?>

                <?php elseif($invoice->status === 'voided'): ?>
                    <br><strong>Voided on:</strong> <?php echo e($invoice->voided_at->format('d M Y, H:i')); ?>

                    by <?php echo e($invoice->voidedBy?->name ?? 'System'); ?> — <span class="italic text-red-600">Reason:
                        <?php echo e($invoice->void_reason); ?></span>
                <?php endif; ?>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.invoices.download', $invoice)); ?>"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>

                <?php if($invoice->status === 'draft' && auth()->user()->hasPermission('manage_invoices')): ?>
                    <form action="<?php echo e(route('admin.invoices.issue', $invoice)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-sm transition-colors"
                            onclick="return confirm('Ensure all details are correct. Issuing an invoice makes it an official record. Proceed?')">
                            Issue Invoice
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($invoice->isVoidable() && auth()->user()->hasPermission('void_invoices')): ?>
                    <button type="button"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm transition-colors"
                        onclick="document.getElementById('voidModal').classList.remove('hidden')">
                        Void Invoice
                    </button>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-6 text-center border-b pb-4">Invoice
                Preview (Snapshot Data)</h3>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h4 class="text-gray-400 font-semibold mb-2">Billed To</h4>
                    <div class="text-gray-800 text-sm">
                        <strong><?php echo e($invoice->client_snapshot['name'] ?? 'Walk-in Customer'); ?></strong><br>
                        <?php if(isset($invoice->client_snapshot['company']) && $invoice->client_snapshot['company']): ?>
                            <?php echo e($invoice->client_snapshot['company']); ?><br>
                        <?php endif; ?>
                        <?php if(isset($invoice->client_snapshot['address'])): ?>
                            <?php echo e($invoice->client_snapshot['address']); ?><br>
                            <?php echo e($invoice->client_snapshot['city'] ?? ''); ?>

                            <?php echo e($invoice->client_snapshot['state'] ? ', ' . $invoice->client_snapshot['state'] : ''); ?>

                            <?php echo e($invoice->client_snapshot['zip_code'] ?? ''); ?><br>
                            <?php echo e($invoice->client_snapshot['country'] ?? ''); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="text-gray-400 font-semibold mb-2">Details</h4>
                    <div class="text-gray-800 text-sm">
                        <strong>Invoice #:</strong> <?php echo e($invoice->invoice_number); ?><br>
                        <strong>Date:</strong> <?php echo e(($invoice->issued_at ?? $invoice->created_at)->format('d M Y')); ?><br>
                        <strong>Order Ref:</strong> <?php echo e($invoice->order->order_number); ?>

                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-800 text-gray-800">
                        <th class="py-2">Description</th>
                        <th class="py-2 text-right">Qty</th>
                        <th class="py-2 text-right">Unit Price</th>
                        <th class="py-2 text-right">Discount</th>
                        <th class="py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    <?php $__currentLoopData = $invoice->financial_snapshot['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="py-3">
                                <span class="font-medium text-gray-900"><?php echo e($item['product_name']); ?></span>
                                <?php if($item['product_sku']): ?>
                                <div class="text-xs text-gray-400">SKU: <?php echo e($item['product_sku']); ?></div> <?php endif; ?>
                            </td>
                            <td class="py-3 text-right"><?php echo e($item['quantity']); ?></td>
                            <td class="py-3 text-right">$<?php echo e(number_format($item['unit_price'], 2)); ?></td>
                            <td class="py-3 text-right text-xs">
                                <?php if($item['item_discount_amount'] > 0): ?>
                                    -$<?php echo e(number_format($item['item_discount_amount'], 2)); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-3 text-right font-medium text-gray-900">$<?php echo e(number_format($item['line_total'], 2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="flex justify-end border-t-2 border-gray-800 pt-4">
                <div class="w-64 space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>$<?php echo e(number_format($invoice->financial_snapshot['subtotal'], 2)); ?></span>
                    </div>
                    <?php if($invoice->financial_snapshot['item_discount_total'] > 0): ?>
                        <div class="flex justify-between text-red-500">
                            <span>Item Discounts</span>
                            <span>-$<?php echo e(number_format($invoice->financial_snapshot['item_discount_total'], 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($invoice->financial_snapshot['order_discount_amount'] > 0): ?>
                        <div class="flex justify-between text-red-500">
                            <span>Order Discount</span>
                            <span>-$<?php echo e(number_format($invoice->financial_snapshot['order_discount_amount'], 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between border-b pb-2">
                        <span>Shipping</span>
                        <span>$<?php echo e(number_format($invoice->financial_snapshot['shipping_cost'], 2)); ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-2">
                        <span>Total Due</span>
                        <span>$<?php echo e(number_format($invoice->financial_snapshot['grand_total'], 2)); ?></span>
                    </div>
                </div>
            </div>

            <?php if($invoice->status === 'voided'): ?>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden">
                    <div
                        class="text-9xl font-black text-red-600 opacity-10 transform -rotate-12 select-none border-8 border-red-600 rounded-3xl px-8">
                        VOID</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($invoice->isVoidable() && auth()->user()->hasPermission('void_invoices')): ?>
        <div id="voidModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
                <h3 class="text-xl font-bold text-red-600 mb-2">Void Invoice</h3>
                <p class="text-sm text-gray-600 mb-4">Are you absolutely sure you want to void Invoice
                    #<?php echo e($invoice->invoice_number); ?>? This action requires a mandatory reason and cannot be undone.</p>

                <form action="<?php echo e(route('admin.invoices.void', $invoice)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Voiding <span
                            class="text-red-500">*</span></label>
                    <textarea name="void_reason" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 mb-4"
                        required></textarea>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium text-sm transition-colors"
                            onclick="document.getElementById('voidModal').classList.add('hidden')">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium text-sm hover:bg-red-700 transition-colors">Confirm
                            Void</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/invoices/show.blade.php ENDPATH**/ ?>