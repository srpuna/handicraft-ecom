<?php $__env->startSection('header'); ?>
    <div>
        <h2 class="text-xl font-bold text-gray-800">Order Management</h2>
        <p class="text-sm text-gray-500">Manage orders and inquiries</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-4">

        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex gap-2 flex-wrap">
                <a href="<?php echo e(route('admin.orders.index')); ?>"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(!request('type') ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50'); ?>">
                    All
                </a>
                <a href="<?php echo e(route('admin.orders.index', ['type' => 'order'])); ?>"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request('type') === 'order' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50'); ?>">
                    Orders
                </a>
                <a href="<?php echo e(route('admin.orders.index', ['type' => 'inquiry'])); ?>"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e(request('type') === 'inquiry' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50'); ?>">
                    Inquiries
                </a>
            </div>
            <a href="<?php echo e(route('admin.orders.create')); ?>"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Order / Inquiry
            </a>
        </div>

        
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>"
            class="bg-white rounded-xl border border-gray-200 p-4 flex flex-wrap gap-3 items-end">
            <?php if(request('type')): ?>
                <input type="hidden" name="type" value="<?php echo e(request('type')); ?>">
            <?php endif; ?>
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Order #, client name, buyer ID..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(request('status') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="min-w-[130px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="min-w-[130px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button type="submit"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700 transition-colors">
                Filter
            </button>
            <?php if(request()->hasAny(['search', 'status', 'date_from', 'date_to'])): ?>
                <a href="<?php echo e(route('admin.orders.index', array_filter(['type' => request('type')]))); ?>"
                    class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                    Clear
                </a>
            <?php endif; ?>
        </form>

        
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <?php if($orders->count()): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order #</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Client</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Invoice</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $color = $statusColors[$order->status] ?? 'gray';
                                    $colorMap = [
                                        'gray' => 'bg-gray-100 text-gray-700',
                                        'blue' => 'bg-blue-100 text-blue-700',
                                        'yellow' => 'bg-yellow-100 text-yellow-700',
                                        'purple' => 'bg-purple-100 text-purple-700',
                                        'green' => 'bg-green-100 text-green-700',
                                        'red' => 'bg-red-100 text-red-700',
                                    ];
                                    $badgeClass = $colorMap[$color] ?? 'bg-gray-100 text-gray-700';
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>"
                                            class="font-mono font-semibold text-green-700 hover:underline text-sm">
                                            <?php echo e($order->order_number); ?>

                                        </a>
                                        <?php if($order->is_paid): ?>
                                            <span
                                                class="ml-1 text-xs bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded font-medium">PAID</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="text-xs font-medium <?php echo e($order->type === 'order' ? 'text-indigo-700 bg-indigo-50' : 'text-amber-700 bg-amber-50'); ?> px-2 py-0.5 rounded-full">
                                            <?php echo e(ucfirst($order->type)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if($order->client): ?>
                                            <a href="<?php echo e(route('admin.clients.show', $order->client)); ?>"
                                                class="text-sm font-medium text-gray-800 hover:text-green-600">
                                                <?php echo e($order->client->name); ?>

                                            </a>
                                            <div class="text-xs text-gray-400"><?php echo e($order->client->buyer_id); ?></div>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-400 italic">No client</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($badgeClass); ?>">
                                            <?php echo e($order->status_label); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                        $<?php echo e(number_format($order->grand_total, 2)); ?></td>
                                    <td class="px-4 py-3">
                                        <?php if($order->latestInvoice): ?>
                                            <?php $inv = $order->latestInvoice; ?>
                                            <a href="<?php echo e(route('admin.invoices.show', $inv)); ?>"
                                                class="text-xs font-mono text-indigo-600 hover:underline">
                                                <?php echo e($inv->invoice_number); ?>

                                            </a>
                                            <div
                                                class="text-xs <?php echo e($inv->status === 'issued' ? 'text-green-600' : ($inv->status === 'voided' ? 'text-red-500' : 'text-yellow-600')); ?>">
                                                <?php echo e(ucfirst($inv->status)); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-300">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-500"><?php echo e($order->created_at->format('d M Y')); ?></td>
                                    <td class="px-4 py-3 text-right flex items-center justify-end gap-2">
                                        <?php if($order->type === 'inquiry' && $order->checkout_token && !$order->is_paid): ?>
                                            <button onclick="copyCheckoutLink('<?php echo e(url('/checkout/' . $order->checkout_token)); ?>', this)"
                                                class="relative text-indigo-600 hover:text-indigo-800 p-1.5 rounded-lg hover:bg-indigo-50 transition-colors"
                                                title="Copy Checkout Link">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                <span
                                                    class="copy-feedback absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity whitespace-nowrap pointer-events-none z-50">Copied!</span>
                                            </button>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-medium hover:bg-green-100 transition-colors">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($orders->hasPages()): ?>
                    <div class="px-4 py-3 border-t border-gray-100">
                        <?php echo e($orders->withQueryString()->links()); ?>

                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="font-medium">No orders found</p>
                    <p class="text-sm mt-1">Create a new order or adjust filters</p>
                    <a href="<?php echo e(route('admin.orders.create')); ?>"
                        class="mt-4 inline-block px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                        Create First Order
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php echo e($orders->withQueryString()->links()); ?>

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
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>