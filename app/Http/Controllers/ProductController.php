<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\tbl_category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection\Paginator;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
 // Show all products
 public function index()
 {
    $count = 0;
     $products = Product::join("tbl_category","tbl_product.category","=","tbl_category.id")
     ->select("tbl_category.name as category_name","tbl_product.*")->paginate(15);
     return view('admin.product.show-product', compact('products','count'));

 }
 public function apiIndex(){
    $products = Product::all();

    return response()->json([
        'status'=> true,
        'message'=> 'Retrive all Products',
        'data' => ['products' =>  $products]
    ]);
 }

 // Show single product
 //for admin page
 public function show($id)
 {
    $product = Product::findOrFail($id);
    return view('admin.product.view-product', compact('product'));
    
 }
 public function product_details($id)
{
    $product = Product::findOrFail($id);
    $isWishlisted = false;

    if (Auth::check()) {
        $isWishlisted = Wishlist::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->exists();
    }
    return view('page.product-details', compact('product','isWishlisted'));
}
 public function home()
{
    $product = Product::all();
    return view('page.home', compact('product'));
}
 // Show add product form
 public function create()
 {
     $categories = tbl_category::all();
     return view('admin.product.add-product', compact('categories'));
 }

 // Store product
// Store product
public function store(Request $request)
{
     
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'gender' => 'required|string',
        'description' => 'nullable|string',
        'category_name' => 'required',
        'stock_quantity' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'pics.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Save main image
    $imagePath = $request->file('image')->store('products', 'public');

    // Save gallery images
    $galleryPaths = [];
    if ($request->hasFile('pics')) {
        foreach ($request->file('pics') as $pic) {
            $picPath = $pic->store('products/gallery', 'public');
            $galleryPaths[] = $picPath;
        }
    }

    // Save product
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->gender = $request->gender;
    $product->description = $request->description;
    $product->category = $request->category_name;
    $product->stock_quantity = $request->stock_quantity;
    $product->image = $imagePath;
    $product->pics = json_encode($galleryPaths); // Save as JSON
    $product->save();

    return redirect()->route('products.index')->with('success', 'Product added successfully!');
}


 
 public function edit($id)
 {
     $product = Product::findOrFail($id);
     $categories = DB::table("tbl_category")->select("id", "name")->get();
     return view('admin.product.edit-product', compact('product','categories'));
 }

public function update(Request $request, $id)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'category' => 'required|exists:tbl_category,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'pics.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'gender' => 'required|in:Men,Women,Unisex',
        'stock_quantity' => 'required|integer|min:0',
    ]);

    $product = Product::findOrFail($id);
    if ($request->has('remove_pics')) {
    $removeIndexes = explode(',', $request->remove_pics);
    $existingPics = json_decode($product->pics, true) ?: [];

    // Remove images by index
    foreach ($removeIndexes as $idx) {
        if (isset($existingPics[$idx])) {
            // Optionally, delete the file from storage here if needed:
            // Storage::disk('public')->delete($existingPics[$idx]);

            unset($existingPics[$idx]);
        }
    }

    // Reindex array and save
    $existingPics = array_values($existingPics);
    $product->pics = json_encode($existingPics);
}


    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('products', 'public');
    }

    // Append new gallery images to existing ones
    $existingPics = json_decode($product->pics, true) ?? [];
    if ($request->hasFile('pics')) {
        foreach ($request->file('pics') as $pic) {
            $existingPics[] = $pic->store('products/gallery', 'public');
        }
    }

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->category = $request->category;
    $product->gender = $request->gender;
    $product->stock_quantity = $request->stock_quantity;
    $product->pics = json_encode($existingPics); // Update gallery
    $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


 

 // Delete product
 public function destroy($id)
 {
     $product = Product::findOrFail($id);
     $product->delete();

     return redirect()->back()->with('success', 'Product deleted successfully.');
 }

 ////CRUD End
public function categoryProducts($id, Request $request)
{
    $category = tbl_category::findOrFail($id);
    $categories = tbl_category::all();

    $query = Product::where('category', $id);

    // Sort by price
    if ($request->sort == 'low_high') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort == 'high_low') {
        $query->orderBy('price', 'desc');
    }

    $products = $query->paginate(12)->appends(['sort' => $request->sort]); // keep sort in pagination links

    return view('page.catproducts', compact('products', 'categories', 'category'));
}


public function shop(Request $request)
{
    $categories = tbl_category::all();
    
    $wishlisted = [];

    if (Auth::check()) {
        $wishlisted = Auth::user()->wishlist->pluck('id')->toArray();
    }

    $query = Product::query(); // Start product query

    // Sorting Logic
    if ($request->sort == 'low_high') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort == 'high_low') {
        $query->orderBy('price', 'desc');
    }

    // Pagination (12 per page) + Keep 'sort' in links
    $products = $query->paginate(12)->appends(['sort' => $request->sort]);

    return view('page.shop', compact('products', 'categories','wishlisted')); // Pass products to view
}


}
