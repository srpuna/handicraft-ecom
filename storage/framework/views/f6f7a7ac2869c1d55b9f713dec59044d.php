<?php $__env->startSection('header'); ?>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-gray-400 hover:text-green-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold flex items-center gap-2">
                Order <span class="font-mono text-green-700"><?php echo e($order->order_number); ?></span>
                <?php if($order->is_paid): ?>
                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">PAID</span>
                <?php endif; ?>
            </h2>
            <p class="text-sm text-gray-500">
                Created <?php echo e($order->created_at->format('M d, Y H:i')); ?> by <?php echo e($order->creator?->name ?? 'System'); ?>

            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        
        <div class="xl:col-span-2 space-y-6">

            
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Current Status</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-semibold 
                                                <?php echo e($statusColors[$order->status] === 'gray' ? 'bg-gray-100 text-gray-700' : ''); ?>

                                                <?php echo e($statusColors[$order->status] === 'blue' ? 'bg-blue-100 text-blue-700' : ''); ?>

                                                <?php echo e($statusColors[$order->status] === 'yellow' ? 'bg-yellow-100 text-yellow-700' : ''); ?>

                                                <?php echo e($statusColors[$order->status] === 'purple' ? 'bg-purple-100 text-purple-700' : ''); ?>

                                                <?php echo e($statusColors[$order->status] === 'green' ? 'bg-green-100 text-green-700' : ''); ?>

                                                <?php echo e($statusColors[$order->status] === 'red' ? 'bg-red-100 text-red-700' : ''); ?>">
                            <?php echo e($order->status_label); ?>

                        </span>
                        <?php if($order->is_merged): ?>
                            <span
                                class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Merged into #<?php echo e(clone $order->mergedIntoOrder()->first()?->order_number ?? '?'); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <?php if(!$order->isFinanciallyLocked() && !$order->is_merged && !in_array($order->status, ['cancelled', 'delivered'])): ?>
                        <a href="<?php echo e(route('admin.orders.edit', $order)); ?>"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">Edit
                            Details</a>
                    <?php endif; ?>

                    <?php if($order->type === 'inquiry' && $order->checkout_token && !$order->is_paid): ?>
                        <button onclick="copyCheckoutLink('<?php echo e(url('/checkout/' . $order->checkout_token)); ?>', this)"
                            class="px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors flex items-center gap-2 relative">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Copy Link
                            <span
                                class="copy-feedback absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity whitespace-nowrap pointer-events-none fade-out shadow-md blur-none z-50">Copied!</span>
                        </button>
                    <?php endif; ?>

                    <?php if(!$order->is_paid && auth()->user()->hasAnyRole(['super_admin', 'admin'])): ?>
                        <form action="<?php echo e(route('admin.orders.mark-paid', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium flex items-center gap-2"
                                onclick="return confirm('Mark as PAID? This will lock order totals. Proceed?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mark Paid
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Order Items</h3>
                    <span class="text-sm text-gray-500"><?php echo e($order->items->sum('quantity')); ?> items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 border-b">
                                <th class="px-6 py-3 font-medium">Product</th>
                                <th class="px-6 py-3 font-medium text-right">Price</th>
                                <th class="px-6 py-3 font-medium text-center">Qty</th>
                                <th class="px-6 py-3 font-medium text-right">Discount</th>
                                <th class="px-6 py-3 font-medium text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900"><?php echo e($item->product_name); ?></div>
                                        <div class="text-xs text-gray-500">SKU: <?php echo e($item->product_sku); ?> | Wt:
                                            <?php echo e($item->weight_kg); ?>kg
                                            <?php if(isset($item->product_snapshot['length']) && $item->product_snapshot['length']): ?>
                                                | Dim:
                                                <?php echo e($item->product_snapshot['length']); ?>x<?php echo e($item->product_snapshot['width']); ?>x<?php echo e($item->product_snapshot['height']); ?>cm
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <?php $netPrice = $item->quantity > 0 ? $item->line_total / $item->quantity : $item->unit_price; ?>
                                        $<?php echo e(number_format($netPrice, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4 text-center font-medium"><?php echo e($item->quantity); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <?php if($item->item_discount_amount > 0): ?>
                                            <div class="text-red-500">Ref: -$<?php echo e(number_format($item->item_discount_amount, 2)); ?></div>
                                            <div class="text-[10px] text-gray-400">
                                                orig: $<?php echo e(number_format($item->unit_price, 2)); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-300">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                        $<?php echo e(number_format($item->line_total, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    <div class="w-full max-w-sm space-y-2 text-sm">
                        <div class="flex justify-between text-gray-700 font-medium">
                            <span>Subtotal (Net)</span>
                            <span>$<?php echo e(number_format($order->subtotal, 2)); ?></span>
                        </div>
                        <?php if($order->order_discount_amount > 0): ?>
                            <div class="flex justify-between text-red-500">
                                <span>Order Discount
                                    (<?php echo e($order->order_discount_type === 'percent' ? $order->order_discount_value . '%' : 'Fixed'); ?>)</span>
                                <span>-$<?php echo e(number_format($order->order_discount_amount, 2)); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-gray-600 pb-2 border-b border-gray-200">
                            <span>Shipping Cost</span>
                            <span>+$<?php echo e(number_format($order->shipping_cost, 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Grand Total</span>
                            <span>$<?php echo e(number_format($order->grand_total, 2)); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Client Information
                    <?php if($order->client_snapshot): ?> <span class="text-xs font-normal text-gray-400 ml-2">(Snapshot at order
                    creation)</span> <?php endif; ?>
                </h3>
                <?php $c = $order->client_snapshot ?? ($order->client ? app(\App\Services\OrderService::class)->buildClientSnapshot($order->client) : null); ?>

                <?php if($c): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Name</p>
                            <p class="font-medium text-gray-900"><?php echo e($c['name']); ?> <span
                                    class="text-gray-400 text-sm ml-1"><?php echo e($c['buyer_id'] ?? ''); ?></span></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Company</p>
                            <p class="text-gray-900"><?php echo e($c['company'] ?? '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Contact Details</p>
                            <p class="text-gray-900"><?php echo e($c['email'] ?? 'No email'); ?></p>
                            <p class="text-gray-900"><?php echo e($c['phone'] ?? 'No phone'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Shipping Address</p>
                            <address class="text-gray-900 not-italic">
                                <?php echo e($c['address']); ?><br>
                                <?php echo e($c['city']); ?> <?php echo e($c['state'] ? ', ' . $c['state'] : ''); ?> <?php echo e($c['zip_code']); ?><br>
                                <?php echo e($c['country']); ?>

                            </address>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic">No client associated with this order.</p>
                <?php endif; ?>
                
                <?php if($order->notes): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <h3 class="font-bold text-gray-800">Notes / Inquiry Message</h3>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-700 whitespace-pre-wrap text-sm leading-relaxed"><?php echo e($order->notes); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="space-y-6">

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2 flex justify-between items-center">
                        Invoices
                        <?php if(!$order->hasActiveInvoice() && auth()->user()->hasPermission('manage_invoices')): ?>
                            <form action="<?php echo e(route('admin.invoices.store', $order)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-100 font-medium">+
                                    Generate</button>
                            </form>
                        <?php endif; ?>
                    </h3>

                    <?php if($order->invoices->isEmpty()): ?>
                        <p class="text-sm text-gray-500 italic">No invoices generated yet.</p>
                    <?php else: ?>
                        <ul class="space-y-3">
                            <?php $__currentLoopData = $order->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                                    <div>
                                        <a href="<?php echo e(route('admin.invoices.show', $inv)); ?>"
                                            class="font-mono text-sm text-indigo-600 hover:underline font-semibold"><?php echo e($inv->invoice_number); ?></a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="text-xs font-medium <?php echo e($inv->status === 'issued' ? 'text-green-600' : ($inv->status === 'voided' ? 'text-red-500' : 'text-yellow-600')); ?>">
                                                <?php echo e(strtoupper($inv->status)); ?>

                                            </span>
                                            <span class="text-xs text-gray-400"><?php echo e($inv->created_at->format('M d')); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('admin.invoices.download', $inv)); ?>"
                                        class="text-gray-400 hover:text-indigo-600" title="Download PDF">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-2 border-b pb-2">Update Status</h3>

                    <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST"
                        x-data="{ nextStatus: '<?php echo e(empty($allowedTransitions) ? '' : $allowedTransitions[0]); ?>' }">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-3 pt-2">
                            <select name="status" x-model="nextStatus"
                                class="w-full text-sm border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500">
                                <option value="">-- Manual Override --</option>
                                <?php $__currentLoopData = $allowedTransitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($statusKey); ?>"><?php echo e(\App\Models\Order::STATUS_LABELS[$statusKey]); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div x-show="nextStatus === ''"
                                class="mt-2 p-3 bg-red-50 border border-red-100 rounded-lg text-sm text-red-700">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="override" value="1"
                                        class="text-red-500 border-red-300 focus:ring-red-500">
                                    <strong>Enable Override</strong> (Admin only)
                                </label>
                                <p class="text-xs mt-1 text-red-600 ml-6">Warning: Bypassing workflow rules may disrupt
                                    logic.
                                </p>
                                <select name="status"
                                    class="w-full mt-2 text-sm border-red-300 rounded-lg text-red-900 focus:border-red-500 focus:ring-red-500"
                                    x-show="nextStatus === ''">
                                    <?php $__currentLoopData = \App\Models\Order::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sk); ?>" <?php echo e($sk === $order->status ? 'disabled' : ''); ?>>
                                            <?php echo e(\App\Models\Order::STATUS_LABELS[$sk]); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div x-show="nextStatus === 'dispatched'"
                                class="space-y-3 mt-3 p-3 bg-purple-50 rounded-lg border border-purple-100">
                                <div>
                                    <label class="block text-xs font-semibold text-purple-700 mb-1">Provider *</label>
                                    <select name="shipping_provider_id" class="w-full text-sm border-purple-300 rounded-lg">
                                        <option value="">Select Provider...</option>
                                        <?php $__currentLoopData = $shippingProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->id); ?>" <?php echo e($order->shipping_provider_id == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-purple-700 mb-1">Tracking Number
                                        *</label>
                                    <input type="text" name="tracking_number" value="<?php echo e($order->tracking_number); ?>"
                                        class="w-full text-sm border-purple-300 rounded-lg">
                                </div>
                            </div>

                            
                            <div x-show="nextStatus === 'cancelled'"
                                class="space-y-3 mt-3 p-3 bg-red-50 rounded-lg border border-red-100">
                                <div>
                                    <label class="block text-xs font-semibold text-red-700 mb-1">Reason for Cancellation
                                        *</label>
                                    <textarea name="cancellation_reason" rows="2"
                                        class="w-full text-sm border-red-300 rounded-lg" placeholder="Required"></textarea>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <h3 class="font-bold text-gray-800 p-4 border-b bg-gray-50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Activity Timeline
                    </h3>
                    <div class="p-4 max-h-[400px] overflow-y-auto">
                        <div class="relative border-l-2 border-gray-200 ml-3 space-y-6 pb-4">
                            <?php $__currentLoopData = $order->auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="relative pl-6">
                                    <span
                                        class="absolute -left-[14px] bg-white rounded-full text-lg shadow-sm border border-gray-100 w-6 h-6 flex items-center justify-center">
                                        <?php echo $log->action_icon; ?>

                                    </span>
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm font-semibold text-gray-800"><?php echo e($log->action_label); ?></p>
                                        <span
                                            class="text-[10px] text-gray-400 font-mono"><?php echo e($log->created_at->format('M d, H:i')); ?></span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5">by <?php echo e($log->user?->name ?? 'System'); ?></p>
                                    <?php if($log->description): ?>
                                        <p class="text-sm text-gray-700 mt-1.5 bg-gray-50 p-2 rounded border border-gray-100">
                                            <?php echo e($log->description); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<?php $__env->stopSection(); ?>

    <?php $__env->startSection('scripts'); ?>
        <script>
            function copyCheckoutLink(url, btn) {
                navigator.clipboard.writeText(url).then(() => {
                    const feedback = btn.querySelector('.copy-feedback');
                    if (feedback) {
                        feedback.classList.remove('opacity-0');
                        feedback.classList.add('opacity-100');
                        setTimeout(() => {
                            feedback.classList.remove('opacity-100');
                            feedback.classList.add('opacity-0');
                        }, 2000);
                    }
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                    alert("Could not copy link to clipboard.");
                });
            }
        </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>