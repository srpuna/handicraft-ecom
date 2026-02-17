<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-6 py-12" x-data="checkout()">
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="flex flex-col md:flex-row gap-12">
            <!-- Form Section -->
            <div class="w-full md:w-2/3">
                <form action="#" method="POST" id="checkout-form"> <!-- Action would be process order -->
                    <?php echo csrf_field(); ?>

                    <!-- Contact Info -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6">
                        <h2 class="text-xl font-bold mb-4">Contact Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" value="<?php echo e($inquiry->name ?? ''); ?>" placeholder="Full Name"
                                class="w-full p-3 bg-gray-50 border rounded-lg" required>
                            <input type="email" name="email" value="<?php echo e($inquiry->email ?? ''); ?>" placeholder="Email Address"
                                class="w-full p-3 bg-gray-50 border rounded-lg" required>
                            <input type="text" name="phone" value="<?php echo e($inquiry->phone ?? ''); ?>" placeholder="Phone Number"
                                class="w-full p-3 bg-gray-50 border rounded-lg" required>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6">
                        <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
                        <div class="space-y-4">
                            <input type="text" name="address" value="<?php echo e($inquiry->address_line ?? ''); ?>"
                                placeholder="Address" class="w-full p-3 bg-gray-50 border rounded-lg" required>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="city" value="<?php echo e($inquiry->city ?? ''); ?>" placeholder="City"
                                    class="w-full p-3 bg-gray-50 border rounded-lg" required>
                                <input type="text" name="zip_code" value="<?php echo e($inquiry->zip_code ?? ''); ?>"
                                    placeholder="Zip Code" class="w-full p-3 bg-gray-50 border rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Country (Important for shipping)</label>
                                <select name="country" x-model="country" @change="fetchShippingRates"
                                    class="w-full p-3 bg-gray-50 border rounded-lg" required>
                                    <option value="">Select Country</option>
                                    <?php $__currentLoopData = $availableCountriesOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($opt['value']); ?>" <?php echo e(($inquiry->country ?? '') == $opt['value'] ? 'selected' : ''); ?>><?php echo e($opt['label']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-xs text-red-500 mt-1" x-show="shippingError" x-text="shippingError"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6" x-show="rates.length > 0">
                        <h2 class="text-xl font-bold mb-4">Shipping Method</h2>
                        <div class="space-y-3">
                            <template x-for="rate in rates" :key="rate.provider_name + rate.price">
                                <label
                                    class="flex items-center justify-between p-4 border rounded cursor-pointer hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_rate" :value="rate.price"
                                            @change="selectShipping(rate)"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900"
                                                x-text="rate.provider_name"></span>
                                            <span class="block text-xs text-gray-500"
                                                x-text="'Zone: ' + rate.details.zone"></span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900" x-text="'$' + rate.price"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- Payment (Mock) -->
                    <div class="bg-white p-6 rounded-lg shadow mb-6">
                        <h2 class="text-xl font-bold mb-4">Payment</h2>
                        <p class="text-gray-500 text-sm mb-4">Payment providers configured by admin.</p>
                        <div class="border p-4 rounded bg-gray-50 text-center text-gray-500 italic">
                            Payment Form Placeholder
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-premium text-white text-lg font-bold py-4 rounded-lg hover:bg-green-800 transition">Place
                        Order</button>
                </form>
            </div>

            <!-- Summary Section -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow sticky top-24">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Summary</h3>
                    <div class="space-y-4 mb-4">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b border-gray-100 pb-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 font-medium"><?php echo e($item['product']->name); ?> (x<?php echo e($item['quantity']); ?>)</span>
                                    <span class="font-medium">$<?php echo e(number_format($item['subtotal'], 2)); ?></span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1 flex items-center gap-3">
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                        <?php echo e($item['product']->formatted_length); ?> × <?php echo e($item['product']->formatted_width); ?> × <?php echo e($item['product']->formatted_height); ?> cm
                                    </span>
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                        </svg>
                                        <?php echo e($item['product']->formatted_weight); ?> kg
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">$<?php echo e(number_format($subtotal, 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium" x-text="shippingCost > 0 ? '$' + shippingCost : '--'">--</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                            <span>Total</span>
                            <span x-text="'$' + (parseFloat(<?php echo e($subtotal); ?>) + parseFloat(shippingCost)).toFixed(2)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkout() {
            return {
                country: '<?php echo e($inquiry->country ?? ''); ?>',
                rates: [],
                shippingCost: 0,
                shippingError: null,
                token: '<?php echo e($token ?? ''); ?>',

                init() {
                    if (this.country) {
                        this.fetchShippingRates();
                    }
                },

                async fetchShippingRates() {
                    if (!this.country) return;

                    this.shippingError = null;
                    this.rates = [];

                    try {
                        const response = await fetch('<?php echo e(route("checkout.calculate-shipping")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                country: this.country,
                                token: this.token
                            })
                        });

                        const data = await response.json();

                        if (data.rates && data.rates.length > 0) {
                            this.rates = data.rates;
                        } else {
                            this.shippingError = 'No shipping rates found for this location.';
                        }
                    } catch (e) {
                        console.error(e);
                        this.shippingError = 'Error calculating shipping.';
                    }
                },

                selectShipping(rate) {
                    this.shippingCost = rate.price;
                }
            }
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/frontend/cart/checkout.blade.php ENDPATH**/ ?>