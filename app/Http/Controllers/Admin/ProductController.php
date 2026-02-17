<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::with('subCategories')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'required|numeric', // Important for shipping
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'main_image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = $this->generateUniqueSlug($request->name);
        // Toggle handling
        $data['is_order_now_enabled'] = $request->has('is_order_now_enabled');
        
        // Carousel options handling
        $data['is_new_arrival'] = $request->has('is_new_arrival');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_recommended'] = $request->has('is_recommended');
        $data['is_on_sale'] = $request->has('is_on_sale');
        $data['carousel_priority'] = $request->input('carousel_priority', 0);

        // Main Image Upload
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $data['main_image'] = '/storage/' . $path;
        }

        // Multiple Images Upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = '/storage/' . $path;
            }
            $data['images'] = $imagePaths;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::with('subCategories')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'main_image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->name !== $product->name) {
            $data['slug'] = $this->generateUniqueSlug($request->name, $product->id);
        }
        $data['is_order_now_enabled'] = $request->has('is_order_now_enabled');
        
        // Carousel options handling
        $data['is_new_arrival'] = $request->has('is_new_arrival');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_recommended'] = $request->has('is_recommended');
        $data['is_on_sale'] = $request->has('is_on_sale');
        $data['carousel_priority'] = $request->input('carousel_priority', 0);

        // Main Image Upload
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $data['main_image'] = '/storage/' . $path;
        }

        // Multiple Images Upload
        if ($request->hasFile('images')) {
            $imagePaths = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = '/storage/' . $path;
            }
            $data['images'] = $imagePaths;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    /**
     * Generate a unique slug for the product.
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Product::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Bulk Operations

    public function templateProductsCsv(): StreamedResponse
    {
        $headers = [
            'name',
            'sku',
            'category',
            'sub_category',
            'price',
            'discount_price',
            'min_quantity',
            'material',
            'weight',
            'length',
            'width',
            'height',
            'description',
            'long_description',
            'is_order_now_enabled',
            'is_new_arrival',
            'is_featured',
            'is_recommended',
            'is_on_sale',
            'carousel_priority'
        ];

        $exampleRows = [
            [
                'Handcrafted Wooden Chair',
                'CH001',
                'Furniture',
                'Chairs',
                '150.00',
                '120.00',
                '1',
                'Oak Wood',
                '5.5',
                '45',
                '45',
                '80',
                'Beautiful handcrafted chair',
                'This elegant chair is made from premium oak wood...',
                'true',
                'true',
                'false',
                'false',
                'true',
                '0'
            ],
            [
                'Modern Coffee Table',
                'TB002',
                'Furniture',
                '',
                '299.99',
                '',
                '1',
                'Walnut',
                '15.2',
                '120',
                '60',
                '45',
                'Contemporary design coffee table',
                '',
                'true',
                'false',
                'true',
                'false',
                'false',
                '5'
            ]
        ];

        $filename = 'products-template-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($headers, $exampleRows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($exampleRows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportProducts(): StreamedResponse
    {
        $products = Product::with('category', 'subCategory')->get();
        $filename = 'products-export-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($products) {
            $handle = fopen('php://output', 'w');
            
            // Header
            fputcsv($handle, [
                'name',
                'sku',
                'category',
                'sub_category',
                'price',
                'discount_price',
                'min_quantity',
                'material',
                'weight',
                'length',
                'width',
                'height',
                'description',
                'long_description',
                'is_order_now_enabled',
                'is_new_arrival',
                'is_featured',
                'is_recommended',
                'is_on_sale',
                'carousel_priority'
            ]);

            // Data rows
            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->name,
                    $product->sku,
                    $product->category->name ?? '',
                    $product->subCategory->name ?? '',
                    $product->price,
                    $product->discount_price ?? '',
                    $product->min_quantity,
                    $product->material ?? '',
                    $product->weight,
                    $product->length,
                    $product->width,
                    $product->height,
                    $product->description ?? '',
                    $product->long_description ?? '',
                    $product->is_order_now_enabled ? 'true' : 'false',
                    $product->is_new_arrival ? 'true' : 'false',
                    $product->is_featured ? 'true' : 'false',
                    $product->is_recommended ? 'true' : 'false',
                    $product->is_on_sale ? 'true' : 'false',
                    $product->carousel_priority
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'products_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('products_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        if (!$handle) {
            return back()->with('error', 'Unable to read CSV file.');
        }

        // Read header row
        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return back()->with('error', 'CSV file is empty or invalid.');
        }

        $imported = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];

        DB::beginTransaction();
        
        try {
            while (($row = fgetcsv($handle)) !== false) {
                try {
                    $data = array_combine($headers, $row);
                    
                    // Required fields validation
                    if (empty($data['name']) || empty($data['sku']) || empty($data['price']) || empty($data['category'])) {
                        $errors[] = "Row skipped: Missing required fields (name, sku, price, or category)";
                        $failed++;
                        continue;
                    }

                    // Find or fail category
                    $category = Category::where('name', $data['category'])
                        ->orWhere('slug', Str::slug($data['category']))
                        ->first();
                    
                    if (!$category) {
                        $errors[] = "Row '{$data['name']}': Category '{$data['category']}' not found";
                        $failed++;
                        continue;
                    }

                    // Find sub_category if provided
                    $subCategoryId = null;
                    if (!empty($data['sub_category'])) {
                        $subCategory = SubCategory::where('category_id', $category->id)
                            ->where(function($q) use ($data) {
                                $q->where('name', $data['sub_category'])
                                  ->orWhere('slug', Str::slug($data['sub_category']));
                            })
                            ->first();
                        
                        if ($subCategory) {
                            $subCategoryId = $subCategory->id;
                        }
                    }

                    // Prepare product data (sanitize text to avoid encoding issues)
                    $productData = [
                        'name' => $this->sanitizeText($data['name']),
                        'category_id' => $category->id,
                        'sub_category_id' => $subCategoryId,
                        'price' => $data['price'],
                        'discount_price' => !empty($data['discount_price']) ? $data['discount_price'] : null,
                        'min_quantity' => $data['min_quantity'] ?? 1,
                        'material' => $this->sanitizeText($data['material'] ?? null),
                        'weight' => $data['weight'] ?? 0,
                        'length' => $data['length'] ?? 0,
                        'width' => $data['width'] ?? 0,
                        'height' => $data['height'] ?? 0,
                        'description' => $this->sanitizeText($data['description'] ?? null),
                        'long_description' => $this->sanitizeText($data['long_description'] ?? null),
                        'is_order_now_enabled' => $this->parseBool($data['is_order_now_enabled'] ?? 'true'),
                        'is_new_arrival' => $this->parseBool($data['is_new_arrival'] ?? 'false'),
                        'is_featured' => $this->parseBool($data['is_featured'] ?? 'false'),
                        'is_recommended' => $this->parseBool($data['is_recommended'] ?? 'false'),
                        'is_on_sale' => $this->parseBool($data['is_on_sale'] ?? 'false'),
                        'carousel_priority' => $data['carousel_priority'] ?? 0,
                    ];

                    // Check if product exists by SKU
                    $existingProduct = Product::where('sku', $data['sku'])->first();
                    
                    if ($existingProduct) {
                        // Update existing
                        $productData['slug'] = $this->generateUniqueSlug($data['name'], $existingProduct->id);
                        $existingProduct->update($productData);
                        $updated++;
                    } else {
                        // Create new
                        $productData['sku'] = $data['sku'];
                        $productData['slug'] = $this->generateUniqueSlug($data['name']);
                        Product::create($productData);
                        $imported++;
                    }
                    
                } catch (\Exception $e) {
                    $errors[] = "Row error: " . $e->getMessage();
                    $failed++;
                }
            }

            DB::commit();
            fclose($handle);

            $message = "Import completed: {$imported} products created, {$updated} updated.";
            if ($failed > 0) {
                $message .= " {$failed} rows failed.";
            }

            if (!empty($errors) && count($errors) <= 10) {
                $message .= " Errors: " . implode('; ', $errors);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function bulkUploadImages(Request $request)
    {
        $request->validate([
            'images_zip' => 'required|file|mimes:zip|max:51200' // 50MB max
        ]);

        $zipFile = $request->file('images_zip');
        $zip = new ZipArchive();
        
        if ($zip->open($zipFile->getRealPath()) !== true) {
            return back()->with('error', 'Unable to open ZIP file.');
        }

        $tempDir = storage_path('app/temp-images-' . time());
        mkdir($tempDir, 0755, true);

        $zip->extractTo($tempDir);
        $zip->close();

        $updated = 0;
        $skipped = 0;
        $errors = [];

        try {
            // Recursively get all files in the temp directory
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($tempDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            
            foreach ($iterator as $file) {
                if ($file->isDir()) {
                    continue;
                }
                
                $filePath = $file->getPathname();
                $filename = $file->getFilename();
                
                // Skip hidden files
                if ($filename[0] === '.') {
                    continue;
                }

                // Extract SKU from filename
                // Format: SKU.ext (main), SKU_0.ext (secondary), SKU_1.ext, SKU_2.ext, etc.
                // Use pathinfo to correctly handle filenames with multiple dots.
                $info = pathinfo($filename);
                if (empty($info['filename']) || empty($info['extension'])) {
                    $skipped++;
                    Log::warning('Bulk image upload: invalid filename format', [
                        'filename' => $filename,
                    ]);
                    continue;
                }

                $nameWithoutExt = $info['filename'];
                $extension = $info['extension'];

                // Check if it's main, secondary, or additional image
                // Format: SKU_N where N is the image number
                if (strpos($nameWithoutExt, '_') !== false) {
                    $imageParts = explode('_', $nameWithoutExt);
                    $sku = $imageParts[0];
                    $imageNumber = isset($imageParts[1]) ? intval($imageParts[1]) : -1;
                } else {
                    // No underscore means it's the main image
                    $sku = $nameWithoutExt;
                    $imageNumber = -1; // -1 indicates main image
                }

                // Find product by SKU
                $product = Product::where('sku', $sku)->first();
                
                if (!$product) {
                    $errors[] = "Product not found for SKU: {$sku}";
                    $skipped++;
                    Log::warning('Bulk image upload: product not found for SKU', [
                        'filename' => $filename,
                        'sku' => $sku,
                    ]);
                    continue;
                }

                // Move image to storage
                $storagePath = 'products/' . uniqid() . '.' . $extension;
                Storage::disk('public')->put($storagePath, file_get_contents($filePath));
                $publicPath = '/storage/' . $storagePath;

                // Assign to appropriate field
                if ($imageNumber === -1) {
                    // Main image (SKU.ext)
                    $product->main_image = $publicPath;
                } elseif ($imageNumber === 0) {
                    // Secondary image (SKU_0.ext)
                    $product->secondary_image = $publicPath;
                } else {
                    // Additional images (SKU_1.ext, SKU_2.ext, etc.)
                    $images = $product->images ?? [];
                    $images[] = $publicPath;
                    $product->images = $images;
                }

                $product->save();
                $updated++;
            }

            // Clean up temp directory
            $this->deleteDirectory($tempDir);

            $message = "Bulk image upload completed: {$updated} products updated.";
            if ($skipped > 0) {
                $message .= " {$skipped} files skipped.";
            }

            $errorCount = count($errors);
            if ($errorCount > 0) {
                $message .= " {$errorCount} files had errors.";
                $sampleErrors = array_slice($errors, 0, 5);
                $message .= " Sample errors: " . implode('; ', $sampleErrors);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            $this->deleteDirectory($tempDir);
            return back()->with('error', 'Image upload failed: ' . $e->getMessage());
        }
    }

    private function parseBool($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        
        $value = strtolower(trim($value));
        return in_array($value, ['true', '1', 'yes', 'y'], true);
    }

    /**
     * Sanitize imported text to avoid encoding issues (e.g. non-breaking spaces).
     */
    private function sanitizeText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        // Normalize non-breaking spaces and similar whitespace to regular spaces
        $value = preg_replace('/\x{00A0}+/u', ' ', $value);

        // Optionally trim extra whitespace
        return trim($value);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
