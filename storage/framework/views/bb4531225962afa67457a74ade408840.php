<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Client Management</h2>
            <p class="text-sm text-gray-500">Manage buyers, wholesale clients, and contact details</p>
        </div>
        <a href="<?php echo e(route('admin.clients.create')); ?>"
            class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">+
            New Client</a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-4">
        <form method="GET" action="<?php echo e(route('admin.clients.index')); ?>"
            class="bg-white p-4 rounded-xl border border-gray-200 flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Search Clients</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Name, Email, Phone, Buyer ID..."
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <button type="submit"
                class="px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gray-800 hover:bg-gray-900">Search</button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.clients.index')); ?>"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Clear</a>
            <?php endif; ?>
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 font-semibold text-gray-600">Client / Company</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">ID</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Contact</th>
                        <th class="px-6 py-3 font-semibold text-gray-600 text-center">Orders</th>
                        <th class="px-6 py-3 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900"><?php echo e($c->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($c->company_name ?? '-'); ?></div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600"><?php echo e($c->buyer_id); ?></td>
                            <td class="px-6 py-4">
                                <div class="text-gray-800"><?php echo e($c->email ?? '-'); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($c->phone ?? ''); ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-indigo-600 rounded-full"><?php echo e($c->orders_count); ?></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?php echo e(route('admin.clients.show', $c)); ?>"
                                    class="text-green-600 hover:text-green-800 font-medium px-2 py-1 bg-green-50 rounded">View /
                                    Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No clients found matching your
                                criteria.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php echo e($clients->withQueryString()->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/admin/clients/index.blade.php ENDPATH**/ ?>