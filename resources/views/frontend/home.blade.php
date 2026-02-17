@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row gap-12">

            <!-- Sidebar Filter -->
            <aside class="w-full md:w-1/4 relative z-30">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="text-xl font-serif mb-6 text-gray-800">Categories</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home', request()->only('filter')) }}"
                                class="flex justify-between items-center text-gray-600 hover:text-green-premium transition group">
                                <span class="{{ !request('category') ? 'font-bold text-green-premium' : '' }}">All
                                    Products</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li class="relative group/category">
                                <a href="{{ route('home', array_merge(request()->only('filter'), ['category' => $category->slug])) }}"
                                    class="flex justify-between items-center text-gray-600 hover:text-green-premium transition group">
                                    <span
                                        class="{{ request('category') == $category->slug ? 'font-bold text-green-premium' : '' }}">{{ $category->name }}</span>
                                    <span
                                        class="text-xs bg-gray-100 text-gray-500 rounded-full px-2 py-0.5 group-hover:bg-green-50 group-hover:text-green-700 transition">{{ $category->products_count }}</span>
                                </a>
                                
                                <!-- Subcategories Dropdown on Hover -->
                                @if($category->subCategories && $category->subCategories->count() > 0)
                                    <!-- Wrapper with padding to create "bridge" for hover -->
                                    <div class="absolute left-full top-0 pl-2 hidden group-hover/category:block z-20 min-w-[220px] -mt-2">
                                        <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-3 relative">
                                            <!-- Tiny arrow pointing left -->
                                            <div class="absolute top-4 -left-1.5 w-3 h-3 bg-white border-l border-t border-gray-100 transform -rotate-45"></div>
                                            
                                            <h4 class="px-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 border-b border-gray-50">Subcategories</h4>
                                            
                                            @foreach($category->subCategories as $subCategory)
                                                <a href="{{ route('home', array_merge(request()->only('filter'), ['category' => $category->slug, 'subcategory' => $subCategory->slug])) }}"
                                                    class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-green-50 hover:text-green-premium hover:pl-5 transition-all duration-200">
                                                    {{ $subCategory->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <!-- Filter Tabs -->
                <div class="mb-8">
                    <div class="flex flex-wrap gap-2 mb-6">
                        <a href="{{ route('home', request()->only('category', 'subcategory')) }}"
                            class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 {{ !request('filter') ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All Products
                        </a>
                        @if(isset($newArrivalsCount) && $newArrivalsCount > 0)
                            <a href="{{ route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'new-arrivals'])) }}"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request('filter') == 'new-arrivals' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                New Arrivals
                                <span class="{{ request('filter') == 'new-arrivals' ? 'bg-white/20' : 'bg-green-100 text-green-700' }} px-2 py-0.5 rounded-full text-xs">{{ $newArrivalsCount }}</span>
                            </a>
                        @endif
                        @if(isset($featuredCount) && $featuredCount > 0)
                            <a href="{{ route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'featured'])) }}"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request('filter') == 'featured' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Featured
                                <span class="{{ request('filter') == 'featured' ? 'bg-white/20' : 'bg-blue-100 text-blue-700' }} px-2 py-0.5 rounded-full text-xs">{{ $featuredCount }}</span>
                            </a>
                        @endif
                        @if(isset($recommendedCount) && $recommendedCount > 0)
                            <a href="{{ route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'recommended'])) }}"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request('filter') == 'recommended' ? 'bg-purple-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                Recommended
                                <span class="{{ request('filter') == 'recommended' ? 'bg-white/20' : 'bg-purple-100 text-purple-700' }} px-2 py-0.5 rounded-full text-xs">{{ $recommendedCount }}</span>
                            </a>
                        @endif
                        @if(isset($onSaleCount) && $onSaleCount > 0)
                            <a href="{{ route('home', array_merge(request()->only('category', 'subcategory'), ['filter' => 'on-sale'])) }}"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 flex items-center gap-2 {{ request('filter') == 'on-sale' ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                On Sale
                                <span class="{{ request('filter') == 'on-sale' ? 'bg-white/20' : 'bg-red-100 text-red-700' }} px-2 py-0.5 rounded-full text-xs">{{ $onSaleCount }}</span>
                            </a>
                        @endif
                    </div>

                    <!-- Title based on filter -->
                    @php
                        $filterTitles = [
                            'new-arrivals' => 'New Arrivals',
                            'featured' => 'Featured Products',
                            'recommended' => 'Recommended For You',
                            'on-sale' => 'On Sale',
                        ];
                        $currentTitle = $filterTitles[request('filter')] ?? 'All Products';
                    @endphp
                    <h1 class="text-4xl font-serif text-gray-900 mb-2">{{ $currentTitle }}</h1>
                    <p class="text-gray-500 text-sm">Showing {{ $products->total() }} products</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <div
                            class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <!-- Image -->
                            <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                                @if($product->main_image)
                                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif

                                <!-- Discount Badge -->
                                @if($product->discount_price && $product->price > $product->discount_price)
                                    @php
                                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                    @endphp
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full font-bold shadow-lg">
                                            -{{ $discountPercent }}%
                                        </span>
                                    </div>
                                @endif

                                <!-- Actions Overlay -->
                                <div
                                    class="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center pb-6 bg-gradient-to-t from-black/50 to-transparent">
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                        class="bg-white text-gray-900 px-6 py-2 rounded-full font-medium hover:bg-green-premium hover:text-white transition shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 text-center">
                                <div class="mb-2">
                                    @if($product->is_order_now_enabled)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase tracking-wider font-bold">In
                                            Stock</span>
                                    @else
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase tracking-wider font-bold">Inquiry
                                            Only</span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-serif font-bold text-gray-900 mb-2 truncate">{{ $product->name }}</h3>
                                <div class="text-green-premium font-bold text-xl">
                                    @if($product->discount_price)
                                        <span class="text-gray-400 line-through text-base mr-2">${{ number_format($product->price, 2) }}</span>
                                        <span>${{ number_format($product->discount_price, 2) }}</span>
                                    @else
                                        <span>${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500 text-lg">No products found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
