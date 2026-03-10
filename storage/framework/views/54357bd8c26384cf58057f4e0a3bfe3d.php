<?php $__env->startSection('header'); ?>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-gray-400 hover:text-green-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Create Order / Inquiry</h2>
            <p class="text-sm text-gray-500">Draft a new request or order</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div x-data="orderForm()" class="pb-10">
        <form action="<?php echo e(route('admin.orders.store')); ?>" method="POST" id="orderForm">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                
                <div class="lg:col-span-2 space-y-6">

                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">General Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span
                                        class="text-red-500">*</span></label>
                                <select name="type"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="inquiry" <?php echo e(old('type') == 'inquiry' ? 'selected' : ''); ?>>Inquiry (Draft
                                        Request)</option>
                                    <option value="order" <?php echo e(old('type') == 'order' ? 'selected' : ''); ?>>Order (Confirmed)
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Client Profile</label>
                                <select name="client_id" x-model="client_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">-- Select or Walk-in --</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                            <?php echo e($client->name); ?> (<?php echo e($client->buyer_id); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Leave blank to create a manual unnamed order, or
                                    select an existing client.</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4 border-b pb-2">
                            <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
                            <button type="button" @click="addItem()"
                                class="text-sm font-medium text-green-600 hover:text-green-700 bg-green-50 px-3 py-1.5 rounded-lg transition-colors">
                                + Add Item
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in items" :key="item.id">
                                <div class="p-4 border border-gray-100 bg-gray-50 rounded-lg relative group">
                                    <button type="button" @click="removeItem(index)"
                                        class="absolute -top-3 -right-3 w-7 h-7 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                        
                                        <div class="md:col-span-4">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Product</label>
                                            <select :name="`items[${index}][product_id]`" x-model="item.product_id"
                                                @change="populateItemData(index)"
                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                                <option value="">-- Custom Product --</option>
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product->id); ?>"
                                                        data-price="<?php echo e($product->effective_price); ?>"
                                                        data-weight="<?php echo e($product->weight); ?>"
                                                        data-length="<?php echo e($product->length); ?>" data-width="<?php echo e($product->width); ?>"
                                                        data-height="<?php echo e($product->height); ?>">
                                                        <?php echo e($product->name); ?> (<?php echo e($product->sku); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        
                                        <div class="md:col-span-3" x-show="!item.product_id">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Item Name</label>
                                            <input type="text" :name="`items[${index}][product_name]`"
                                                x-model="item.product_name"
                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                                                placeholder="Custom item">
                                        </div>

                                        
                                        <div class="md:col-span-2" :class="item.product_id ? 'md:col-start-5' : ''">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Qty <span
                                                    class="text-red-500">*</span></label>
                                            <input type="number" :name="`items[${index}][quantity]`"
                                                x-model.number="item.quantity" min="1" @input="calculateTotals()"
                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                                                required>
                                        </div>

                                        
                                        <div class="md:col-span-3">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Unit Price ($)
                                                <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" :name="`items[${index}][unit_price]`"
                                                x-model.number="item.unit_price" @input="calculateTotals()"
                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"
                                                required>
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-semibold text-gray-500 mb-1">Weight</label>
                                            <input type="number" step="0.001" :name="`items[${index}][weight_kg]`"
                                                placeholder="kg" x-model.number="item.weight_kg" @input="calculateTotals()"
                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                        </div>
                                        <div class="md:col-span-3 flex gap-1">
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">L(cm)</label>
                                                <input type="number" step="0.01" :name="`items[${index}][length]`"
                                                    x-model.number="item.length"
                                                    class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                            </div>
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">W(cm)</label>
                                                <input type="number" step="0.01" :name="`items[${index}][width]`"
                                                    x-model.number="item.width"
                                                    class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                            </div>
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">H(cm)</label>
                                                <input type="number" step="0.01" :name="`items[${index}][height]`"
                                                    x-model.number="item.height"
                                                    class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                            </div>
                                        </div>

                                        
                                        <div
                                            class="md:col-span-5 md:col-start-1 pt-2 border-t border-gray-200 mt-2 flex gap-3">
                                            <div class="w-1/2">
                                                <label class="block text-xs font-medium text-gray-500 mb-1">Item
                                                    Discount</label>
                                                <select :name="`items[${index}][item_discount_type]`"
                                                    x-model="item.item_discount_type" @change="calculateTotals()"
                                                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                                    <option value="none">None</option>
                                                    <option value="percent">Percentage (%)</option>
                                                    <option value="fixed">Fixed Amount ($)</option>
                                                </select>
                                            </div>
                                            <div class="w-1/2" x-show="item.item_discount_type !== 'none'">
                                                <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                                                <input type="number" step="0.01"
                                                    :name="`items[${index}][item_discount_value]`"
                                                    x-model.number="item.item_discount_value" @input="calculateTotals()"
                                                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                            </div>
                                        </div>

                                        
                                        <div class="md:col-span-3 md:col-start-10 flex flex-col justify-end text-right">
                                            <div class="text-xs text-gray-500 line-through"
                                                x-show="item.item_discount_amount > 0">
                                                $<span x-text="(item.unit_price * item.quantity).toFixed(2)"></span>
                                            </div>
                                            <div class="text-lg font-bold text-gray-800">
                                                $<span x-text="item.line_total.toFixed(2)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="items.length === 0"
                                class="text-center py-6 border-2 border-dashed border-gray-200 rounded-lg text-gray-400">
                                No items added. Click "+ Add Item" to begin.
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Shipping Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                                <select name="shipping_provider_id" x-model="shipping_provider_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Select Provider...</option>
                                    <?php $__currentLoopData = $shippingProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->id); ?>"><?php echo e($p->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                                <input type="text" name="tracking_number"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Order Notes</h3>
                        <textarea name="notes" rows="3"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Internal notes, special instructions..."></textarea>
                    </div>
                </div>

                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Financial Summary</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-700 font-medium">
                                <span>Subtotal</span>
                                <span>$<span x-text="afterItemDisc.toFixed(2)"></span></span>
                            </div>

                            <div class="border-t border-gray-100 pt-3 mt-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Order-level Discount</label>
                                <div class="flex gap-2">
                                    <select name="order_discount_type" x-model="order_discount_type"
                                        @change="calculateTotals()" class="w-1/2 text-sm border-gray-300 rounded-md">
                                        <option value="none">None</option>
                                        <option value="percent">Percent (%)</option>
                                        <option value="fixed">Fixed ($)</option>
                                    </select>
                                    <input type="number" step="0.01" name="order_discount_value"
                                        x-model.number="order_discount_value" x-show="order_discount_type !== 'none'"
                                        @input="calculateTotals()" class="w-1/2 text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="text-right text-xs text-red-500 mt-1" x-show="order_discount_amount > 0">
                                    -$<span x-text="order_discount_amount.toFixed(2)"></span>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-3 mt-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Shipping Cost ($)</label>
                                <div class="flex gap-2">
                                    <input type="number" step="0.01" name="shipping_cost" x-model.number="shipping_cost"
                                        @input="calculateTotals()" class="w-2/3 text-sm border-gray-300 rounded-md">
                                    <button type="button" @click="autoCalculateShipping()" :disabled="isCalculatingShipping"
                                        class="w-1/3 bg-gray-100 border border-gray-300 hover:bg-gray-200 rounded-md text-xs font-medium px-2 py-1 flex items-center justify-center transition-colors">
                                        <span x-show="!isCalculatingShipping">Auto Calc</span>
                                        <span x-show="isCalculatingShipping" class="flex gap-1 items-center">
                                            <svg class="animate-spin h-3 w-3 text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Calc...
                                        </span>
                                    </button>
                                </div>
                                <div x-show="shippingError" class="text-red-500 text-xs mt-1" x-text="shippingError"></div>
                                <div x-show="shippingSuccess" class="text-green-600 text-xs mt-1">Shipping updated via
                                    calculator!</div>
                            </div>

                            <div class="pt-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Delivery Target (Days from
                                    Dispatch)</label>
                                <input type="number" name="delivery_period_days" value="14"
                                    class="w-full text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="border-t-2 border-gray-200 pt-4 mt-4 flex justify-between items-end">
                                <div>
                                    <div class="text-gray-900 font-bold text-lg">Grand Total</div>
                                    <div class="text-xs text-gray-500">Total Wt: <span
                                            x-text="total_weight.toFixed(2)"></span> kg</div>
                                </div>
                                <div class="text-2xl font-black text-green-700">
                                    $<span x-text="grand_total.toFixed(2)"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-green-700 transition-colors shadow-sm cursor-pointer"
                                :disabled="items.length === 0">
                                Create Record
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        function orderForm() {
            return {
                items: [],
                nextId: 1,

                client_id: '',
                shipping_provider_id: '',

                // Totals
                subtotal_gross: 0,
                afterItemDisc: 0,
                item_discount_total: 0,
                order_discount_type: 'none',
                order_discount_value: 0,
                order_discount_amount: 0,
                shipping_cost: 0,
                total_weight: 0,
                grand_total: 0,

                // Calculation State
                isCalculatingShipping: false,
                shippingError: '',
                shippingSuccess: false,

                init() {
                    this.addItem(); // Start with one empty row
                },

                addItem() {
                    this.items.push({
                        id: this.nextId++,
                        product_id: '',
                        product_name: '',
                        quantity: 1,
                        unit_price: 0,
                        weight_kg: 0,
                        length: null,
                        width: null,
                        height: null,
                        item_discount_type: 'none',
                        item_discount_value: 0,
                        item_discount_amount: 0,
                        line_total: 0
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                    this.calculateTotals();
                },

                populateItemData(index) {
                    const selectEl = document.querySelector(`select[name="items[${index}][product_id]"]`);
                    if (selectEl && selectEl.selectedIndex > 0) {
                        const option = selectEl.options[selectEl.selectedIndex];
                        this.items[index].unit_price = parseFloat(option.dataset.price) || 0;
                        this.items[index].weight_kg = parseFloat(option.dataset.weight) || 0;
                        this.items[index].length = parseFloat(option.dataset.length) || null;
                        this.items[index].width = parseFloat(option.dataset.width) || null;
                        this.items[index].height = parseFloat(option.dataset.height) || null;
                    } else {
                        this.items[index].unit_price = 0;
                        this.items[index].weight_kg = 0;
                        this.items[index].length = null;
                        this.items[index].width = null;
                        this.items[index].height = null;
                    }
                    this.calculateTotals();
                },

                calculateTotals() {
                    let gross = 0;
                    let itemDisc = 0;
                    let wt = 0;
                    let afterItemDisc = 0;

                    this.items.forEach(item => {
                        // Ensure numbers
                        item.quantity = parseInt(item.quantity) || 0;
                        item.unit_price = parseFloat(item.unit_price) || 0;
                        item.weight_kg = parseFloat(item.weight_kg) || 0;
                        item.item_discount_value = parseFloat(item.item_discount_value) || 0;

                        let rowGross = item.unit_price * item.quantity;
                        item.item_discount_amount = 0;

                        if (item.item_discount_type === 'percent') {
                            item.item_discount_amount = (rowGross * (item.item_discount_value / 100));
                        } else if (item.item_discount_type === 'fixed') {
                            item.item_discount_amount = Math.min(item.item_discount_value, rowGross);
                        }

                        item.line_total = Math.max(0, rowGross - item.item_discount_amount);

                        gross += rowGross;
                        itemDisc += item.item_discount_amount;
                        wt += (item.weight_kg * item.quantity);
                        afterItemDisc += item.line_total;
                    });

                    this.subtotal_gross = gross;
                    this.afterItemDisc = afterItemDisc;
                    this.item_discount_total = itemDisc;
                    this.total_weight = wt;

                    // Order level discount
                    this.order_discount_amount = 0;
                    let orderVal = parseFloat(this.order_discount_value) || 0;

                    if (this.order_discount_type === 'percent') {
                        this.order_discount_amount = (afterItemDisc * (orderVal / 100));
                    } else if (this.order_discount_type === 'fixed') {
                        this.order_discount_amount = Math.min(orderVal, afterItemDisc);
                    }

                    let sc = parseFloat(this.shipping_cost) || 0;

                    this.grand_total = Math.max(0, afterItemDisc - this.order_discount_amount + sc);
                },

                async autoCalculateShipping() {
                    this.shippingError = '';
                    this.shippingSuccess = false;

                    const clientId = this.client_id;
                    const providerId = this.shipping_provider_id;

                    if (!clientId) {
                        this.shippingError = 'Please select a Client Profile first.';
                        return;
                    }

                    if (!providerId) {
                        this.shippingError = 'Please select a Shipping Provider.';
                        return;
                    }

                    if (this.items.length === 0) {
                        this.shippingError = 'Please add line items first.';
                        return;
                    }

                    this.isCalculatingShipping = true;

                    try {
                        const response = await fetch('<?php echo e(route("admin.orders.calculate-shipping")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                client_id: clientId,
                                shipping_provider_id: providerId,
                                items: this.items
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || 'Failed to calculate shipping');
                        }

                        this.shipping_cost = parseFloat(data.cost);
                        this.calculateTotals();
                        this.shippingSuccess = true;

                        setTimeout(() => { this.shippingSuccess = false; }, 3000);

                    } catch (err) {
                        this.shippingError = err.message;
                    } finally {
                        this.isCalculatingShipping = false;
                    }
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/admin/orders/create.blade.php ENDPATH**/ ?>