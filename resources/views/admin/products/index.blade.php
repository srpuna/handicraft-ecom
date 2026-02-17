@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Products
    </h2>
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium">All Products</h3>
        <a href="{{ route('admin.products.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            + Add New Product
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Bulk Operations Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Bulk Operations</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- CSV Import/Export -->
            <div class="border border-gray-200 rounded-lg p-4 bg-gradient-to-br from-blue-50 to-blue-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Step 1: CSV Product Data
                </h3>
                <p class="text-sm text-gray-600 mb-4">Import or export product information (no images)</p>
                
                <div class="space-y-3">
                    <!-- Download Template -->
                    <a href="{{ route('admin.products.template') }}" 
                        class="block w-full bg-white text-blue-600 border-2 border-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors text-center font-medium">
                        📄 Download Template CSV
                    </a>

                    <!-- Export Products -->
                    <a href="{{ route('admin.products.export') }}" 
                        class="block w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center font-medium">
                        📤 Export Current Products
                    </a>

                    <!-- Import Products -->
                    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                        @csrf
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700 mb-1 block">Upload CSV File:</span>
                            <input type="file" name="products_file" accept=".csv" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </label>
                        <button type="submit" 
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            📥 Import Products
                        </button>
                    </form>
                </div>

                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-xs text-gray-700">
                    <strong>Required fields:</strong> name, sku, category, price, weight, length, width, height<br>
                    <strong>Category lookup:</strong> Use exact category name from your system<br>
                    <strong>Booleans:</strong> Use true/false or 1/0
                </div>
            </div>

            <!-- Bulk Image Upload -->
            <div class="border border-gray-200 rounded-lg p-4 bg-gradient-to-br from-purple-50 to-purple-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Step 2: Bulk Image Upload
                </h3>
                <p class="text-sm text-gray-600 mb-4">Upload ZIP file with product images</p>

                <form action="{{ route('admin.products.bulk-images') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700 mb-1 block">Upload ZIP File (max 50MB):</span>
                        <input type="file" name="images_zip" accept=".zip" required
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    </label>
                    <button type="submit" 
                        class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors font-medium">
                        🖼️ Upload Product Images
                    </button>
                </form>

                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded text-xs text-gray-700 space-y-1">
                    <strong>Image Naming Convention:</strong>
                    <ul class="list-disc list-inside ml-2 space-y-1">
                        <li><code class="bg-white px-1 rounded">SKU.jpg</code> → Main image</li>
                        <li><code class="bg-white px-1 rounded">SKU_0.jpg</code> → Secondary image</li>
                        <li><code class="bg-white px-1 rounded">SKU_1.jpg</code>, <code class="bg-white px-1 rounded">SKU_2.jpg</code> → Additional images (3rd, 4th, etc.)</li>
                    </ul>
                    <p class="mt-2"><strong>Example:</strong> CH001.jpg, CH001_0.jpg, CH001_1.png, CH001_2.jpg</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Product Name or SKU"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
            </div>
            <div class="w-full md:w-64">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition">Filter</button>
            @if(request()->anyFilled(['search', 'category_id']))
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 px-4 py-2">Clear</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dimensions (L
                        x W x H)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Now
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($product->main_image)
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ $product->main_image }}" alt="">
                                @else
                                    <div
                                        class="h-10 w-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mr-3 text-xs">
                                        No Img</div>
                                @endif
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($product->discount_price)
                                <span class="text-gray-400 line-through text-xs mr-1">${{ number_format($product->price, 2) }}</span>
                                <span class="font-bold">${{ number_format($product->discount_price, 2) }}</span>
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->length }} x {{ $product->width }} x {{ $product->height }} cm
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->weight }} kg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->material ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->sku ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_order_now_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_order_now_enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block"
                                onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this product.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection