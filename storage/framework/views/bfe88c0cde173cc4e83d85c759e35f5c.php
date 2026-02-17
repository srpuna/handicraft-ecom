

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Roles & Permissions</h1>
            <p class="text-gray-600 mt-1">Manage roles and their associated permissions</p>
        </div>
        <a href="<?php echo e(route('admin.roles.create')); ?>"
            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Role
        </a>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg shadow-sm p-6 <?php echo e($role->name === 'super_admin' ? 'border-2 border-purple-200' : ''); ?>">
            <!-- Role Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-semibold <?php echo e($role->name === 'super_admin' ? 'text-purple-700' : 'text-gray-800'); ?>">
                        <?php echo e($role->display_name); ?>

                    </h3>
                    <?php if($role->description): ?>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($role->description); ?></p>
                    <?php endif; ?>
                </div>
                <?php if($role->name === 'super_admin'): ?>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                    System
                </span>
                <?php endif; ?>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-sm text-gray-500">Users</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($role->users_count); ?></div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-sm text-gray-500">Permissions</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($role->permissions_count); ?></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-2 pt-4 border-t">
                <a href="<?php echo e(route('admin.roles.show', $role)); ?>" 
                    class="flex-1 text-center bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </a>
                
                <?php if($role->name !== 'super_admin'): ?>
                <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" 
                    class="flex-1 text-center bg-green-50 text-green-600 px-4 py-2 rounded-lg hover:bg-green-100 transition-colors text-sm font-medium">
                    Edit
                </a>

                <?php if($role->users_count === 0): ?>
                <form action="<?php echo e(route('admin.roles.destroy', $role)); ?>" method="POST" 
                    onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this role.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                        class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                        Delete
                    </button>
                </form>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>