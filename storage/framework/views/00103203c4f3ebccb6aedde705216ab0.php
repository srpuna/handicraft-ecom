<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
    </h2>
<?php $__env->stopSection(); ?>

<?php
    use Illuminate\Support\Facades\Cache;
?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Total Products</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e($totalProducts ?? 0); ?></p>
        </a>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Total Categories</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e($totalCategories ?? 0); ?></p>
        </a>
        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-gray-500 text-sm font-medium uppercase">Total Inquiries</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e($totalInquiries ?? 0); ?></p>
        </a>
    </div>

    <!-- Maintenance Mode Toggle -->
    <div class="col-span-1 md:col-span-3 mb-6 bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">System Status</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Current Status: 
                    <?php if(Cache::get('maintenance_mode')): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Maintenance Mode
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Live
                        </span>
                    <?php endif; ?>
                </p>
            </div>
            <button onclick="document.getElementById('maintenanceModal').classList.remove('hidden')" 
                class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition">
                <?php echo e(Cache::get('maintenance_mode') ? 'Disable Maintenance' : 'Enable Maintenance'); ?>

            </button>
        </div>
    </div>

    <!-- Modal -->
    <div id="maintenanceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Action</h3>
                <div class="mt-2 px-1">
                    <p class="text-sm text-gray-500">
                        Enter your password to <?php echo e(Cache::get('maintenance_mode') ? 'disable' : 'enable'); ?> maintenance mode.
                    </p>
                    <form action="<?php echo e(route('admin.maintenance.toggle')); ?>" method="POST" class="mt-4">
                        <?php echo csrf_field(); ?>
                        <input type="password" name="password" placeholder="Confirm Password" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2 mb-4">
                        <div class="flex gap-2 justify-center">
                             <button type="button" onclick="document.getElementById('maintenanceModal').classList.add('hidden')"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Activity</h3>
        <p class="text-gray-500">No recent activity.</p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>