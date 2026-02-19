<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 sm:px-6 py-12">
        <div class="flex flex-col md:flex-row gap-12">

            <!-- Sidebar Filter -->
            <aside class="w-full md:w-1/4 relative z-30">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="text-xl font-serif mb-6 text-gray-800">Categories</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo e(route('home', request()->only('filter'))); ?>"
                                class="flex justify-between items-center text-gray-600 hover:text-green-premium transition group">
                                <span class="<?php echo e(!request('category') ? 'font-bold text-green-premium' : ''); ?>">All
                                    Products</span>
                            </a>
                        </li>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="relative group">
                                <div class="flex justify-between items-center gap-2">
                                    <a href="<?php echo e(route('home', array_merge(request()->only('filter'), ['category' => $category->slug]))); ?>"
                                        class="flex-1 min-w-0 flex items-center text-gray-600 hover:text-green-premium transition">
                                        <span class="truncate <?php echo e(request('category') == $category->slug ? 'font-bold text-green-premium' : ''); ?>"><?php echo e($category->name); ?></span>
                                    </a>

                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span
                                            class="text-xs bg-gray-100 text-gray-500 rounded-full px-2 py-0.5 group-hover:bg-green-50 group-hover:text-green-700 transition"><?php echo e($category->products_count); ?></span>

                                        <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                                            <button
                                                type="button"
                                                class="md:hidden inline-flex items-center justify-center h-8 w-8 rounded-full border border-gray-200 bg-white text-gray-500 hover:text-green-premium hover:border-green-premium transition"
                                                data-subcat-toggle="subcats-<?php echo e($category->id); ?>"
                                                aria-controls="subcats-<?php echo e($category->id); ?>"
                                                aria-expanded="false"
                                                aria-label="Toggle subcategories"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Subcategories Dropdown on Hover -->
                                <?php if($category->subCategories && $category->subCategories->count() > 0): ?>
                                    <!-- Mobile inline subcategories (tap to expand) -->
                                    <div id="subcats-<?php echo e($category->id); ?>" class="hidden md:hidden mt-2 ml-4">
                                        <div class="bg-white rounded-xl border border-gray-100 py-2">
                                            <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(route('home', array_merge(request()->only('filter'), ['category' => $category->slug, 'subcategory' => $subCategory->slug]))); ?>"
                                                    class="block px-4 py-2 text-sm text-gray-600 hover:bg-green-50 hover:text-green-premium transition">
                                                    <?php echo e($subCategory->name); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                    <!-- Desktop flyout subcategories (hover) -->
                                    <div class="hidden group-hover:!block absolute left-full top-0 z-50 min-w-[220px]">
                                        <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-3 relative">
                                            <!-- Tiny arrow pointing left -->
                                            <div class="absolute top-4 -left-1.5 w-3 h-3 bg-white border-l border-t border-gray-100 transform -rotate-45"></div>
                                            
                                            <h4 class="px-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 border-b border-gray-50">Subcategories</h4>
                                            
                                            <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(route('home', array_merge(request()->only('filter'), ['category' => $category->slug, 'subcategory' => $subCategory->slug]))); ?>"
                                                    class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-green-50 hover:text-green-premium hover:pl-5 transition-all duration-200">
                                                    <?php echo e($subCategory->name); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <!-- Filter Tabs -->
                <div class="mb-8">
                    <div class="flex flex-wrap gap-2 mb-6">
                        <a href="<?php echo e(route('home', request()->only('category', 'subcategory'))); ?>"
                            class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 <?php echo e(!request('filter') ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                            All Products
                        </a>
                        <?php if(isset($newArrivalsCount) && $newArrivalsCount > 0): ?>
                            <a href="<?php echo e(route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'new-arrivals']))); ?>"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 <?php echo e(request('filter') == 'new-arrivals' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                New Arrivals
                                <span class="<?php echo e(request('filter') == 'new-arrivals' ? 'bg-white/20' : 'bg-green-100 text-green-700'); ?> px-2 py-0.5 rounded-full text-xs"><?php echo e($newArrivalsCount); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if(isset($featuredCount) && $featuredCount > 0): ?>
                            <a href="<?php echo e(route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'featured']))); ?>"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 <?php echo e(request('filter') == 'featured' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Featured
                                <span class="<?php echo e(request('filter') == 'featured' ? 'bg-white/20' : 'bg-blue-100 text-blue-700'); ?> px-2 py-0.5 rounded-full text-xs"><?php echo e($featuredCount); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if(isset($recommendedCount) && $recommendedCount > 0): ?>
                            <a href="<?php echo e(route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'recommended']))); ?>"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 <?php echo e(request('filter') == 'recommended' ? 'bg-purple-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                Recommended
                                <span class="<?php echo e(request('filter') == 'recommended' ? 'bg-white/20' : 'bg-purple-100 text-purple-700'); ?> px-2 py-0.5 rounded-full text-xs"><?php echo e($recommendedCount); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if(isset($onSaleCount) && $onSaleCount > 0): ?>
                            <a href="<?php echo e(route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'on-sale']))); ?>"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 <?php echo e(request('filter') == 'on-sale' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                On Sale
                                <span class="<?php echo e(request('filter') == 'on-sale' ? 'bg-white/20' : 'bg-red-100 text-red-700'); ?> px-2 py-0.5 rounded-full text-xs"><?php echo e($onSaleCount); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Title based on filter -->
                    <?php
                        $filterTitles = [
                            'new-arrivals' => 'New Arrivals',
                            'featured' => 'Featured Products',
                            'recommended' => 'Recommended For You',
                            'on-sale' => 'On Sale',
                            'discounted' => 'Discounted',
                            'most-sold' => 'Most Sold',
                        ];
                        $currentTitle = $filterTitles[request('filter')] ?? 'All Products';
                    ?>
                    <h1 class="text-4xl font-serif text-gray-900 mb-2"><?php echo e($currentTitle); ?></h1>
                    <p class="text-gray-500 text-sm">Showing <?php echo e($products->total()); ?> products</p>
                </div>

                <div class="mb-8">
                    <form method="GET" action="<?php echo e(route('home')); ?>" class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-center">
                        <?php if(request('category')): ?>
                            <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                        <?php endif; ?>
                        <?php if(request('subcategory')): ?>
                            <input type="hidden" name="subcategory" value="<?php echo e(request('subcategory')); ?>">
                        <?php endif; ?>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                            <div class="sm:w-64">
                                <label for="shop-filter" class="block text-xs font-semibold text-gray-500 mb-1">Filter</label>
                                <div class="relative">
                                    <select id="shop-filter" name="filter"
                                        class="w-full appearance-none bg-white border-2 border-gray-200 rounded-full py-2.5 pl-4 pr-10 text-sm leading-6 focus:outline-none focus:border-green-premium focus:ring-2 focus:ring-green-100 shadow-sm transition-all duration-200">
                                        <option value="" <?php echo e(request('filter') ? '' : 'selected'); ?>>All Products</option>
                                        <option value="most-sold" <?php echo e(request('filter') === 'most-sold' ? 'selected' : ''); ?>>Most Sold</option>
                                        <option value="discounted" <?php echo e(request('filter') === 'discounted' ? 'selected' : ''); ?>>Discounted</option>
                                    </select>
                                    <svg class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="sm:w-64">
                                <label for="shop-sort" class="block text-xs font-semibold text-gray-500 mb-1">Sort by</label>
                                <div class="relative">
                                    <select id="shop-sort" name="sort"
                                        class="w-full appearance-none bg-white border-2 border-gray-200 rounded-full py-2.5 pl-4 pr-10 text-sm leading-6 focus:outline-none focus:border-green-premium focus:ring-2 focus:ring-green-100 shadow-sm transition-all duration-200">
                                        <option value="" <?php echo e(request('sort') ? '' : 'selected'); ?>>Newest</option>
                                        <option value="newest" <?php echo e(request('sort') === 'newest' ? 'selected' : ''); ?>>Newest</option>
                                        <option value="oldest" <?php echo e(request('sort') === 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                                        <option value="price-asc" <?php echo e(request('sort') === 'price-asc' ? 'selected' : ''); ?>>Price: Low → High</option>
                                        <option value="price-desc" <?php echo e(request('sort') === 'price-desc' ? 'selected' : ''); ?>>Price: High → Low</option>
                                        <option value="name-asc" <?php echo e(request('sort') === 'name-asc' ? 'selected' : ''); ?>>Name: A → Z</option>
                                        <option value="name-desc" <?php echo e(request('sort') === 'name-desc' ? 'selected' : ''); ?>>Name: Z → A</option>
                                    </select>
                                    <svg class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end gap-3">
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-green-premium text-white px-6 py-2.5 text-sm font-semibold hover:bg-green-800 transition">
                                Apply
                            </button>
                            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center justify-center rounded-full border-2 border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:border-gold hover:text-gold transition">Clear</a>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div
                            class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <!-- Image -->
                            <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                                <?php if($product->main_image): ?>
                                    <img src="<?php echo e($product->main_image); ?>" alt="<?php echo e($product->name); ?>"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                <?php endif; ?>

                                <!-- Discount Badge -->
                                <?php if($product->discount_price && $product->price > $product->discount_price): ?>
                                    <?php
                                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                    ?>
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">
                                            -<?php echo e($discountPercent); ?>%
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Actions Overlay -->
                                <div
                                    class="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center pb-6 bg-gradient-to-t from-black/50 to-transparent">
                                    <a href="<?php echo e(route('products.show', $product->slug ?? $product->id)); ?>"
                                        class="bg-white text-gray-900 px-6 py-2 rounded-full font-medium hover:bg-green-premium hover:text-white transition shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 text-center">
                                <div class="mb-2">
                                    <?php if($product->is_order_now_enabled): ?>
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase tracking-wider font-bold">In
                                            Stock</span>
                                    <?php else: ?>
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase tracking-wider font-bold">Inquiry
                                            Only</span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="text-lg font-serif font-bold text-gray-900 mb-2 truncate"><?php echo e($product->name); ?></h3>
                                <div class="text-green-premium font-bold text-xl">
                                    <?php if($product->discount_price): ?>
                                        <span class="text-gray-400 line-through text-base mr-2">$<?php echo e(number_format($product->price, 2)); ?></span>
                                        <span>$<?php echo e(number_format($product->discount_price, 2)); ?></span>
                                    <?php else: ?>
                                        <span>$<?php echo e(number_format($product->price, 2)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">No products found matching your criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-12">
                    <?php echo e($products->appends(request()->query())->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile-only: tap-to-expand subcategories (hover doesn't exist on touch devices)
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[data-subcat-toggle]');
            if (!btn) return;

            const targetId = btn.getAttribute('data-subcat-toggle');
            const target = document.getElementById(targetId);
            if (!target) return;

            const isHidden = target.classList.contains('hidden');
            target.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\handmade handicraft\Desktop\Dev\ecom\resources\views/frontend/home.blade.php ENDPATH**/ ?>