

<?php $__env->startSection('header'); ?>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.clients.index')); ?>" class="text-gray-400 hover:text-green-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold flex items-center gap-2">
                <?php echo e($client->name); ?> <span
                    class="text-sm font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded"><?php echo e($client->buyer_id); ?></span>
            </h2>
            <p class="text-sm text-gray-500">Client Profile & Order History</p>
        </div>
        <div class="ml-auto">
            <a href="<?php echo e(route('admin.clients.edit', $client)); ?>"
                class="px-4 py-2 border border-green-600 text-green-700 rounded-lg text-sm font-medium hover:bg-green-50 transition-colors bg-white">Edit
                Profile</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        
        <div class="xl:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Contact Details</h3>
                    <span class="text-xs text-gray-400">Since <?php echo e($client->created_at->format('M Y')); ?></span>
                </div>

                <div class="p-6 space-y-4 text-sm text-gray-700">
                    <div class="flex justify-between items-start">
                        <span class="font-medium text-gray-500">Company</span>
                        <span class="font-semibold text-right"><?php echo e($client->company_name ?? '-'); ?></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-medium text-gray-500">Email</span>
                        <span class="text-right"><a href="mailto:<?php echo e($client->email); ?>"
                                class="text-green-600 hover:underline"><?php echo e($client->email ?? '-'); ?></a></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-medium text-gray-500">Phone</span>
                        <span class="text-right"><?php echo e($client->phone ?? '-'); ?></span>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h4 class="font-medium text-gray-500 mb-2">Primary Address</h4>
                        <address
                            class="not-italic text-right text-gray-800 leading-relaxed font-medium bg-gray-50 p-3 rounded border border-gray-100">
                            <?php echo nl2br(e($client->full_address)); ?>

                            <?php if(!$client->full_address): ?> <span class="text-gray-400 italic">No address recorded</span> <?php endif; ?>
                        </address>
                    </div>

                    <?php if($client->notes): ?>
                        <div class="pt-4 border-t border-gray-100">
                            <h4 class="font-medium text-gray-500 mb-2">Remarks</h4>
                            <p
                                class="whitespace-pre-wrap text-xs bg-yellow-50 text-amber-900 border border-yellow-200 p-3 rounded">
                                <?php echo e($client->notes); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Order & Inquiry History</h3>
                    <a href="<?php echo e(route('admin.orders.create', ['client_id' => $client->id])); ?>"
                        class="text-xs bg-green-50 text-green-700 px-3 py-1.5 rounded-lg hover:bg-green-100 font-medium font-semibold shadow-sm">+
                        Create Order</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b text-gray-600">
                                <th class="px-6 py-3 font-semibold">Number</th>
                                <th class="px-6 py-3 font-semibold">Type</th>
                                <th class="px-6 py-3 font-semibold">Date</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 font-semibold text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $client->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('admin.orders.show', $o)); ?>"
                                            class="font-mono font-semibold text-green-700 hover:underline"><?php echo e($o->order_number); ?></a>
                                        <?php if($o->is_paid): ?> <span
                                            class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.2 ml-1 rounded">PAID</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-xs <?php echo e($o->type === 'order' ? 'text-indigo-600 bg-indigo-50' : 'text-amber-600 bg-amber-50'); ?> px-2 py-0.5 rounded-full font-medium"><?php echo e(ucfirst($o->type)); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo e($o->created_at->format('d M Y')); ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $c = \App\Models\Order::STATUS_COLORS[$o->status] ?? 'gray';
                                            $map = ['gray' => 'bg-gray-100 text-gray-700', 'blue' => 'bg-blue-100 text-blue-700', 'yellow' => 'bg-yellow-100 text-yellow-700', 'purple' => 'bg-purple-100 text-purple-700', 'green' => 'bg-green-100 text-green-700', 'red' => 'bg-red-100 text-red-700'];
                                        ?>
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($map[$c]); ?>"><?php echo e($o->status_label); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-900">
                                        $<?php echo e(number_format($o->grand_total, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">This client has no orders or
                                        inquiries yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/clients/show.blade.php ENDPATH**/ ?>