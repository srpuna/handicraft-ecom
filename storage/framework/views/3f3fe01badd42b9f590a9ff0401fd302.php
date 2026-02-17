

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inquiry Details #<?php echo e($inquiry->id); ?>

        </h2>
        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Info -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium border-b pb-2 mb-4">Customer Information</h3>
            <p><strong>Name:</strong> <?php echo e($inquiry->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($inquiry->email); ?></p>
            <p><strong>Phone:</strong> <?php echo e($inquiry->phone); ?></p>
            <p class="mt-4"><strong>Address:</strong></p>
            <p><?php echo e($inquiry->address_line); ?></p>
            <p><?php echo e($inquiry->city); ?>, <?php echo e($inquiry->zip_code); ?></p>
            <p><?php echo e($inquiry->country); ?></p>
        </div>

        <!-- Product Info -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium border-b pb-2 mb-4">Product Interest</h3>
            <?php if($inquiry->product): ?>
                <p><strong>Product:</strong> <?php echo e($inquiry->product->name); ?></p>
                <p><strong>Price:</strong> $<?php echo e($inquiry->product->price); ?></p>
                <p><strong>Weight:</strong> <?php echo e($inquiry->product->weight); ?> kg</p>
                <p><strong>Dimensions:</strong>
                    <?php echo e($inquiry->product->length); ?>x<?php echo e($inquiry->product->width); ?>x<?php echo e($inquiry->product->height); ?> cm</p>
                <div class="mt-4">
                    <img src="<?php echo e($inquiry->product->main_image); ?>" alt="Product Image" class="h-32 object-cover rounded">
                </div>
            <?php else: ?>
                <p class="text-red-500">Product no longer exists.</p>
            <?php endif; ?>
        </div>

        <!-- Message & Reply -->
        <div class="bg-white p-6 rounded-lg shadow md:col-span-2">
            <h3 class="text-lg font-medium border-b pb-2 mb-4">Inquiry</h3>
            <div class="bg-gray-50 p-4 rounded mb-6">
                <p class="text-gray-700"><?php echo e($inquiry->message); ?></p>
                <span class="text-xs text-gray-500 mt-2 block"><?php echo e($inquiry->created_at->diffForHumans()); ?></span>
            </div>

            <?php if($inquiry->admin_reply): ?>
                <div class="bg-blue-50 p-4 rounded mb-6 border-l-4 border-blue-500">
                    <h4 class="text-sm font-bold text-blue-700 mb-1">Admin Reply:</h4>
                    <p class="text-gray-700"><?php echo e($inquiry->admin_reply); ?></p>
                    <span class="text-xs text-gray-500 mt-2 block"><?php echo e($inquiry->updated_at->diffForHumans()); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.inquiries.reply', $inquiry)); ?>" method="POST" class="mb-8">
                <?php echo csrf_field(); ?>
                <label class="block text-sm font-medium text-gray-700 mb-2">Reply to Customer</label>
                <textarea name="admin_reply" rows="3"
                    class="w-full border p-2 rounded focus:ring-green-500 focus:border-green-500"
                    placeholder="Type your reply here..."></textarea>
                <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Send
                    Reply</button>
            </form>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium mb-4">Actions</h3>
                <?php if($inquiry->status != 'checkout_sent' && $inquiry->status != 'completed'): ?>
                    <div class="bg-yellow-50 p-4 rounded border border-yellow-200">
                        <p class="mb-2 text-sm text-yellow-800">If the customer is ready to purchase, generate a unique checkout
                            link for them.</p>
                        <form action="<?php echo e(route('admin.inquiries.send-checkout', $inquiry)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">Generate & Send
                                Checkout Link</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="bg-purple-50 p-4 rounded border border-purple-200">
                        <p class="text-purple-800 font-bold">Checkout Link Generated</p>
                        <input type="text" readonly value="<?php echo e(route('checkout', ['token' => $inquiry->checkout_token])); ?>"
                            class="w-full mt-2 p-2 bg-white border rounded text-sm text-gray-600">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/inquiries/show.blade.php ENDPATH**/ ?>