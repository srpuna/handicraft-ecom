@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row gap-12 bg-white p-8 rounded-2xl shadow-sm">
            <!-- Image Section -->
            <div class="md:w-1/2">
                <!-- Main Image Display -->
                <!-- Main Image Display -->
                <div class="relative z-10">
                    <div id="imageContainer" class="rounded-xl overflow-hidden mb-4 bg-gray-50 h-[50vh] md:h-[90vh] flex items-center justify-center relative cursor-crosshair">
                        @if($product->main_image)
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}"
                                class="max-h-full max-w-full object-contain" id="mainProductImage">
                        @else
                            <span class="text-gray-400 text-lg">No Image</span>
                        @endif
                    </div>
                
                    <!-- Zoom Result Container (Side View) -->
                    <div id="zoomResult" class="hidden fixed md:absolute left-0 md:left-[105%] top-0 md:top-0 w-full md:w-[500px] h-[500px] bg-white border border-gray-200 shadow-2xl z-50 rounded-lg overflow-hidden"></div>
                </div>

                <script>
                    const container = document.getElementById('imageContainer');
                    const img = document.getElementById('mainProductImage');
                    const result = document.getElementById('zoomResult');

                    if (container && img && result) {
                        // Wait for image to load to get natural dimensions
                        img.addEventListener('load', function() {
                            setupZoom();
                        });
                        
                        // Setup immediately if image already loaded
                        if (img.complete) {
                            setupZoom();
                        }

                        function setupZoom() {
                            container.addEventListener('mousemove', handleMouseMove);
                            container.addEventListener('mouseleave', () => {
                                result.classList.add('hidden');
                            });
                        }

                        function handleMouseMove(e) {
                            const rect = container.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            
                            // Check if cursor is within the container
                            if (x < 0 || x > rect.width || y < 0 || y > rect.height) {
                                result.classList.add('hidden');
                                return;
                            }

                            // Show result
                            result.classList.remove('hidden');
                            
                            // Set background image
                            result.style.backgroundImage = `url('${img.src}')`;
                            result.style.backgroundRepeat = 'no-repeat';
                            
                            // Use natural image dimensions with zoom factor
                            const zoomLevel = 2.5;
                            const naturalWidth = img.naturalWidth;
                            const naturalHeight = img.naturalHeight;
                            
                            // Calculate size maintaining aspect ratio
                            result.style.backgroundSize = `${naturalWidth * zoomLevel}px ${naturalHeight * zoomLevel}px`;
                            
                            // Calculate background position
                            const xRatio = x / rect.width;
                            const yRatio = y / rect.height;
                            
                            // Position background so cursor position appears in center of result
                            const bgX = xRatio * 100;
                            const bgY = yRatio * 100;
                            
                            result.style.backgroundPosition = `${bgX}% ${bgY}%`;
                        }
                    }
                </script>
                
                <!-- Horizontal Scrollable Thumbnails -->
                @if($product->main_image || $product->secondary_image || ($product->images && count($product->images) > 0))
                    <div class="relative">
                        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <!-- Main image thumbnail -->
                            @if($product->main_image)
                                <img src="{{ $product->main_image }}" 
                                    onclick="document.getElementById('mainProductImage').src='{{ $product->main_image }}'"
                                    class="h-20 w-20 object-cover rounded-lg border-2 border-green-premium cursor-pointer hover:opacity-75 transition flex-shrink-0"
                                    alt="Main">
                            @endif
                            <!-- Secondary image thumbnail -->
                            @if($product->secondary_image)
                                <img src="{{ $product->secondary_image }}" 
                                    onclick="document.getElementById('mainProductImage').src='{{ $product->secondary_image }}'"
                                    class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-green-premium hover:opacity-75 transition flex-shrink-0"
                                    alt="Secondary">
                            @endif
                            <!-- Additional images -->
                            @foreach($product->images ?? [] as $image)
                                <img src="{{ $image }}" 
                                    onclick="document.getElementById('mainProductImage').src='{{ $image }}'"
                                    class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-green-premium hover:opacity-75 transition flex-shrink-0"
                                    alt="Product image">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="md:w-1/2">
                <div class="mb-4">
                    <span
                        class="text-gray-500 uppercase tracking-widest text-sm font-semibold">{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>

                <h1 class="text-4xl font-serif font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <div class="text-3xl font-bold text-green-premium mb-6">
                    @if($product->discount_price)
                        <span class="text-gray-400 line-through text-xl mr-2">${{ number_format($product->price, 2) }}</span>
                        <span>${{ number_format($product->discount_price, 2) }}</span>
                    @else
                        <span>${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                @if($product->description)
                    <div class="prose text-gray-600 mb-8 max-w-none">
                        <p>{{ $product->description }}</p>
                    </div>
                @endif

                <div class="bg-gray-50 border border-gray-100 rounded-lg p-6 mb-8">
                    <h3 class="font-serif font-bold text-lg mb-4 text-gray-800">Product Specifications</h3>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-4 text-sm">
                        <dt class="text-gray-500">Dimensions (L x W x H)</dt>
                        <dd class="font-medium text-gray-900">{{ $product->formatted_length }}cm x {{ $product->formatted_width }}cm x
                            {{ $product->formatted_height }}cm</dd>

                        <dt class="text-gray-500">Weight</dt>
                        <dd class="font-medium text-gray-900">{{ $product->formatted_weight }} kg</dd>

                        <dt class="text-gray-500">Material</dt>
                        <dd class="font-medium text-gray-900">{{ $product->material ?? 'N/A' }}</dd>

                        <dt class="text-gray-500">SKU</dt>
                        <dd class="font-medium text-gray-900">{{ $product->sku ?? 'N/A' }}</dd>
                    </dl>
                </div>

                <div class="flex flex-col gap-4">
                    {{-- Order Now Button --}}
                    @if($product->is_order_now_enabled)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center gap-4 mb-4">
                                <label class="font-medium text-gray-700">Quantity:</label>
                                <input type="number" name="quantity" value="{{ $product->min_quantity }}"
                                    min="{{ $product->min_quantity }}" class="w-20 border rounded p-2 text-center">
                            </div>
                            <button type="submit"
                                class="w-full bg-green-premium text-white text-lg font-bold py-4 rounded-full shadow-lg hover:bg-green-800 transition transform hover:-translate-y-1">
                                Add to Cart
                            </button>
                            <p class="text-xs text-center text-gray-500 mt-2">Free shipping calculation at checkout.</p>
                        </form>
                    @endif

                    {{-- Inquiry Button / Form Toggle --}}
                    <div x-data="{ open: false }" class="mt-4">
                        <div class="flex gap-3">
                            <button @click="open = !open"
                                class="flex-1 bg-cream border-2 border-green-premium text-green-premium font-bold py-3 rounded-full hover:bg-green-premium hover:text-white transition">
                                Make an Inquiry
                            </button>

                            @if(!empty($siteSettings['whatsapp_number']))
                                <a href="https://wa.me/{{ $siteSettings['whatsapp_number'] }}?text={{ urlencode('Hi! I am interested in: ' . $product->name . ' (' . url()->current() . ')') }}" 
                                   target="_blank"
                                   class="flex items-center justify-center gap-2 bg-[#25D366] text-white font-bold py-3 px-6 rounded-full hover:bg-[#128C7E] transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </a>
                            @endif
                        </div>

                        <div x-show="open" class="mt-6 border-t pt-6" x-transition>
                            <h3 class="font-serif font-bold text-xl mb-4 text-center">Interested? Send us an inquiry</h3>
                            <form action="{{ route('inquiry.store', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="name" placeholder="Full Name" required
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                    <input type="email" name="email" placeholder="Email Address" required
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="phone" placeholder="Phone Number" required
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                    <input type="text" name="country" placeholder="Country" required
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                </div>
                                <input type="text" name="address_line" placeholder="Address Line" required
                                    class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="city" placeholder="City"
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                    <input type="text" name="zip_code" placeholder="Zip Code"
                                        class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium">
                                </div>
                                <textarea name="message" rows="3" placeholder="I am interested in this product..."
                                    class="w-full p-3 bg-gray-50 border rounded-lg focus:ring-green-premium focus:border-green-premium"></textarea>

                                <button type="submit"
                                    class="w-full bg-gray-800 text-white font-bold py-3 rounded-lg hover:bg-black transition">Send
                                    Inquiry</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Long Description Section -->
        @if($product->long_description)
            <div class="mt-12 bg-white p-8 rounded-2xl shadow-sm">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-6 border-b pb-4">Product Details</h2>
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! nl2br(e($product->long_description)) !!}
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-8 border-b pb-4">You May Also Like</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedProducts as $relProduct)
                        <!-- Simple Card -->
                        <a href="{{ route('products.show', $relProduct->slug ?? $relProduct->id) }}" class="group block">
                            <div class="bg-gray-100 aspect-[3/4] rounded-lg overflow-hidden mb-4">
                                <img src="{{ $relProduct->main_image }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-bold text-lg group-hover:text-green-premium">{{ $relProduct->name }}</h3>
                            <div class="text-green-premium font-bold">
                                @if($relProduct->discount_price)
                                    <span class="text-gray-400 line-through text-sm mr-2">${{ number_format($relProduct->price, 2) }}</span>
                                    <span>${{ number_format($relProduct->discount_price, 2) }}</span>
                                @else
                                    <span>${{ number_format($relProduct->price, 2) }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
    {{-- Alpine JS for interaction --}}
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection