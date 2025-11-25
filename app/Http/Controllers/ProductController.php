<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\tbl_category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products
   // Replace your index() method in ProductController with this:

public function index(Request $request)
{
    $count = 0;
    
    // Statistics for widget cards
    $totalProducts = Product::count();
    $publishedProducts = Product::where('status', 'published')->count();
    $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count();
    $outOfStockProducts = Product::where('stock_quantity', 0)->count();
    
    // Get categories for filter
    $categories = tbl_category::all();
    
    // Base query with category join
    $query = Product::leftJoin("tbl_category", "tbl_product.category", "=", "tbl_category.id")
        ->select("tbl_category.name as category_name", "tbl_product.*");
    
    // Apply filters
    if ($request->filled('status')) {
        $query->where('tbl_product.status', $request->status);
    }
    
    if ($request->filled('category')) {
        $query->where('tbl_product.category', $request->category);
    }
    
    if ($request->filled('stock')) {
        switch ($request->stock) {
            case 'in_stock':
                $query->where('tbl_product.stock_quantity', '>', DB::raw('tbl_product.low_stock_threshold'));
                break;
            case 'low_stock':
                $query->whereColumn('tbl_product.stock_quantity', '<=', 'tbl_product.low_stock_threshold')
                      ->where('tbl_product.stock_quantity', '>', 0);
                break;
            case 'out_of_stock':
                $query->where('tbl_product.stock_quantity', 0);
                break;
        }
    }
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('tbl_product.name', 'like', "%{$search}%")
              ->orWhere('tbl_product.sku', 'like', "%{$search}%")
              ->orWhere('tbl_product.description', 'like', "%{$search}%");
        });
    }
    
    // Order by newest first
    $query->orderBy('tbl_product.created_at', 'desc');
    
    // Paginate
    $products = $query->paginate(15);
    
    return view('admin.product.index', compact(
        'products', 
        'count', 
        'totalProducts', 
        'publishedProducts', 
        'lowStockProducts', 
        'outOfStockProducts',
        'categories'
    ));
}

    public function apiIndex()
    {
        $products = Product::inRandomOrder()->get();

        return response()->json([
            'status' => true,
            'message' => 'Retrieve all Products',
            'data' => ['products' => $products]
        ]);
    }

    public function getProductsByCategory($id)
    {
        $products = Product::where('category', $id)
            ->where('status', 'published')
            ->where('in_stock', true)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Retrieve products by category',
            'data' => ['products' => $products]
        ]);
    }

    // Show single product (admin)
   public function show($id , Request $request)
{
    $product = Product::where('status','published')->findOrFail($id);

    
    if($request->is('*/api') || $request->wantsJson()){
        return response()->json([
            'status' => true,
            'message' => 'Product details retrieved successfully',
            'data' => ['product' => $product]
        ]);
    }

    
    // Fetch categories so the read-only dropdown can display the correct name
    $categories = tbl_category::all();

    return view('admin.product.read', compact('product', 'categories'));
}

    // Product details (frontend)
    public function product_details($id)
    {
        $product = Product::findOrFail($id);
        $isWishlisted = false;

        if (Auth::check()) {
            $isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }

        // Increment views
        $product->increment('views');

        return view('page.product-details', compact('product', 'isWishlisted'));
    }

    public function home()
    {
        $product = Product::where('status', 'published')
            ->where('in_stock', true)
            ->latest()
            ->take(12)
            ->get();
        return view('page.home', compact('product'));
    }

    // Show add product form
    public function create()
    {
        $categories = tbl_category::all();
        return view('admin.product.create', compact('categories'));
    }

    // Store product
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:tbl_product,sku',
            'barcode' => 'nullable|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pics.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'charge_tax' => 'nullable|boolean',
            'gender' => 'required|in:Men,Women,Unisex,Kids',
            'category_name' => 'required|exists:tbl_category,id',
            'brand' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'in_stock' => 'nullable|boolean',
            'variant_type.*' => 'nullable|string',
            'variant_value.*' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'free_shipping' => 'nullable|boolean',
            'is_fragile' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'status' => 'nullable|in:published,draft,inactive',
            'tags' => 'nullable|string',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string',
        ]);

        // Handle main image
        $imagePath = $request->file('image')->store('products', 'public');

        // Handle gallery images
        $galleryPaths = [];
        if ($request->hasFile('pics')) {
            foreach ($request->file('pics') as $pic) {
                $picPath = $pic->store('products/gallery', 'public');
                $galleryPaths[] = $picPath;
            }
        }

        // Handle variants
        $variants = [];
        if ($request->has('variant_type') && $request->has('variant_value')) {
            $types = $request->variant_type;
            $values = $request->variant_value;
            
            for ($i = 0; $i < count($types); $i++) {
                if (!empty($types[$i]) && !empty($values[$i])) {
                    $variants[] = [
                        'type' => $types[$i],
                        'value' => $values[$i]
                    ];
                }
            }
        }

        // Determine status based on action button
        $status = $request->input('action') === 'draft' ? 'draft' : ($request->status ?? 'published');

        // Create product
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        $product->image = $imagePath;
        $product->gallery_images = !empty($galleryPaths) ? json_encode($galleryPaths) : null;
        
        // Pricing
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->charge_tax = $request->has('charge_tax') ? true : false;
        
        // Classification
        $product->gender = $request->gender;
        $product->category = $request->category_name;
        $product->brand = $request->brand;
        
        // Inventory
        $product->stock_quantity = $request->stock_quantity;
        $product->low_stock_threshold = $request->low_stock_threshold ?? 10;
        $product->in_stock = $request->has('in_stock') ? true : false;
        
        // Variants
        $product->variants = !empty($variants) ? json_encode($variants) : null;
        
        // Shipping
        $product->weight = $request->weight;
        $product->dimensions = $request->dimensions;
        $product->free_shipping = $request->has('free_shipping') ? true : false;
        
        // Attributes
        $product->is_fragile = $request->has('is_fragile') ? true : false;
        $product->is_featured = $request->has('is_featured') ? true : false;
        $product->is_new = $request->has('is_new') ? true : false;
        
        // Organization
        $product->status = $status;
        $product->tags = $request->tags;
        $product->sizes = $request->sizes;
        
        $product->save();

        $message = $status === 'draft' ? 'Product saved as draft!' : 'Product published successfully!';
        return redirect()->route('products.index')->with('success', $message);
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = tbl_category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:tbl_product,sku,' . $id,
            'barcode' => 'nullable|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pics.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'gender' => 'required|in:Men,Women,Unisex,Kids',
            'category_name' => 'required|exists:tbl_category,id',

            'stock_quantity' => 'required|integer|min:0',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string',
        ]);

        $product = Product::findOrFail($id);

        // Update main image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        // Handle gallery images removal
        if ($request->has('remove_pics')) {
            $removeIndexes = explode(',', $request->remove_pics);
            $existingPics = json_decode($product->gallery_images, true) ?: [];

            foreach ($removeIndexes as $idx) {
                if (isset($existingPics[$idx])) {
                    // Delete file from storage
                    if (Storage::disk('public')->exists($existingPics[$idx])) {
                        Storage::disk('public')->delete($existingPics[$idx]);
                    }
                    unset($existingPics[$idx]);
                }
            }

            $existingPics = array_values($existingPics);
            $product->gallery_images = json_encode($existingPics);
        }

        // Add new gallery images
        $existingPics = json_decode($product->gallery_images, true) ?? [];
        if ($request->hasFile('pics')) {
            foreach ($request->file('pics') as $pic) {
                $existingPics[] = $pic->store('products/gallery', 'public');
            }
            $product->gallery_images = json_encode($existingPics);
        }

        // Handle variants
        $variants = [];
        if ($request->has('variant_type') && $request->has('variant_value')) {
            $types = $request->variant_type;
            $values = $request->variant_value;
            
            for ($i = 0; $i < count($types); $i++) {
                if (!empty($types[$i]) && !empty($values[$i])) {
                    $variants[] = [
                        'type' => $types[$i],
                        'value' => $values[$i]
                    ];
                }
            }
        }

        // Update all fields
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        
        // Pricing
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->charge_tax = $request->has('charge_tax') ? true : false;
        
        // Classification
        $product->gender = $request->gender;
        $product->category = $request->category_name;
        $product->brand = $request->brand;
        
        // Inventory
        $product->stock_quantity = $request->stock_quantity;
        $product->low_stock_threshold = $request->low_stock_threshold ?? 10;
        $product->in_stock = $request->has('in_stock') ? true : false;
        
        // Variants
        $product->variants = !empty($variants) ? json_encode($variants) : null;
        
        // Shipping
        $product->weight = $request->weight;
        $product->dimensions = $request->dimensions;
        $product->free_shipping = $request->has('free_shipping') ? true : false;
        
        // Attributes
        $product->is_fragile = $request->has('is_fragile') ? true : false;
        $product->is_featured = $request->has('is_featured') ? true : false;
        $product->is_new = $request->has('is_new') ? true : false;
        
        // Organization
        $product->status = $request->status ?? 'published';
        $product->tags = $request->tags;
        $product->sizes = $request->sizes;
        
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete main image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery images
        if ($product->gallery_images) {
            $galleryImages = json_decode($product->gallery_images, true);
            foreach ($galleryImages as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    // Category products
    public function categoryProducts($id, Request $request)
    {
        $category = tbl_category::findOrFail($id);
        $categories = tbl_category::all();

        $query = Product::where('category', $id)
            ->where('status', 'published')
            ->where('in_stock', true);

        // Sort by price
        if ($request->sort == 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'high_low') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort == 'popular') {
            $query->orderBy('sales_count', 'desc');
        }

        $products = $query->paginate(12)->appends(['sort' => $request->sort]);

        return view('page.catproducts', compact('products', 'categories', 'category'));
    }

    // Shop page
    public function shop(Request $request)
    {
        $categories = tbl_category::all();
        
        $wishlisted = [];
        if (Auth::check()) {
            $wishlisted = Auth::user()->wishlist->pluck('id')->toArray();
        }

        $query = Product::where('status', 'published')->where('in_stock', true);

        // Sorting Logic
        if ($request->sort == 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'high_low') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort == 'popular') {
            $query->orderBy('sales_count', 'desc');
        } elseif ($request->sort == 'featured') {
            $query->where('is_featured', true);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by gender
        if ($request->has('gender') && $request->gender) {
            $query->where('gender', $request->gender);
        }

        // Price range filter
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('tags', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(12)->appends($request->except('page'));

        return view('page.shop', compact('products', 'categories', 'wishlisted'));
    }

    // Featured products
    // public function featured()
    // {
    //     $products = Product::where('is_featured', true)
    //         ->where('status', 'published')
    //         ->where('in_stock', true)
    //         ->latest()
    //         ->paginate(12);

    //     return view('page.featured', compact('products'));
    // }

    // New arrivals
    // public function newArrivals()
    // {
    //     $products = Product::where('is_new', true)
    //         ->where('status', 'published')
    //         ->where('in_stock', true)
    //         ->latest()
    //         ->paginate(12);

    //     return view('page.new-arrivals', compact('products'));
    // }
}