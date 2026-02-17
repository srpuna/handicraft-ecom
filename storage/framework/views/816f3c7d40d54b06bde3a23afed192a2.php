<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-8">Shopping Cart</h1>

        <?php if(count($cartItems) > 0): ?>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <?php if($item['product']->main_image): ?>
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="<?php echo e($item['product']->main_image); ?>" alt="">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($item['product']->name); ?></div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                                    </svg>
                                                    <?php echo e($item['product']->formatted_length); ?> × <?php echo e($item['product']->formatted_width); ?> × <?php echo e($item['product']->formatted_height); ?> cm
                                                </span>
                                                <span class="mx-2">|</span>
                                                <span class="inline-flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                                    </svg>
                                                    <?php echo e($item['product']->formatted_weight); ?> kg
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php if($item['product']->discount_price): ?>
                                        <span class="text-gray-400 line-through mr-1">$<?php echo e(number_format($item['product']->price, 2)); ?></span>
                                        <span class="text-green-premium font-bold">$<?php echo e(number_format($item['product']->discount_price, 2)); ?></span>
                                    <?php else: ?>
                                        $<?php echo e(number_format($item['product']->price, 2)); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                                        <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" 
                                            min="<?php echo e($item['product']->min_quantity); ?>" 
                                            class="w-20 border rounded p-1 text-center"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    $<?php echo e(number_format($item['subtotal'], 2)); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-8">
                <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-bold text-gray-900">$<?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    <p class="text-xs text-gray-500 mb-6">Shipping & taxes calculated at checkout.</p>
                    <a href="<?php echo e(route('checkout')); ?>"
                        class="block w-full bg-green-premium text-white text-center py-3 rounded-lg font-bold hover:bg-green-800 transition">Proceed
                        to Checkout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg mb-6">Your cart is empty.</p>
                <a href="<?php echo e(route('home')); ?>" class="text-green-premium hover:underline">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/frontend/cart/index.blade.php ENDPATH**/ ?>