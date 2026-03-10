<?php $__env->startSection('header'); ?>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.clients.index')); ?>" class="text-gray-400 hover:text-green-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold flex items-center gap-2">
                <?php echo e(isset($client) ? 'Edit Client: ' . $client->name : 'Create New Client'); ?>

            </h2>
            <p class="text-sm text-gray-500">Record buyer details for order management.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl max-w-full space-y-6">
        <form action="<?php echo e(isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store')); ?>"
            method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($client)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6 pb-2">
                <div class="border-b border-gray-100 pb-2">
                    <h3 class="text-lg font-bold text-gray-800">Primary Contact</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name', $client->name ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Company / Organization</label>
                        <input type="text" name="company_name"
                            value="<?php echo e(old('company_name', $client->company_name ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email', $client->email ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="<?php echo e(old('phone', $client->phone ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-2 border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800">Billing / Shipping Address</h3>
                    <p class="text-xs text-gray-500">This address will be copied into order snapshots.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 mt-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Street Address</label>
                        <textarea name="address_line" rows="2"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"><?php echo e(old('address_line', $client->address_line ?? '')); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                        <input type="text" name="city" value="<?php echo e(old('city', $client->city ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">State / Province</label>
                        <input type="text" name="state" value="<?php echo e(old('state', $client->state ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Postal / Zip Code</label>
                        <input type="text" name="zip_code" value="<?php echo e(old('zip_code', $client->zip_code ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                        <input type="text" name="country" value="<?php echo e(old('country', $client->country ?? '')); ?>"
                            class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-2 border-t pt-6">
                    <h3 class="text-lg font-bold text-gray-800">Internal Remarks</h3>
                </div>
                <div class="pb-6 mt-4">
                    <textarea name="notes" rows="3"
                        class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                        placeholder="Sales rep notes, preferred communication methods, tax exemptions..."><?php echo e(old('notes', $client->notes ?? '')); ?></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="<?php echo e(isset($client) ? route('admin.clients.show', $client) : route('admin.clients.index')); ?>"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                <button type="submit"
                    class="px-5 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                    <?php echo e(isset($client) ? 'Save Updates' : 'Create Profile'); ?>

                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/admin/clients/create.blade.php ENDPATH**/ ?>