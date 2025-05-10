<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\tbl_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
 // Show all products
 public function index()
 {
    $count = 0;
     $products = Product::join("tbl_category","tbl_product.category","=","tbl_category.id")
     ->select("tbl_category.name as category_name","tbl_product.*")->get();
     return view('admin.product.show-product', compact('products','count'));

 }

 // Show single product
 public function show($id)
 {
    $product = Product::findOrFail($id);
    return view('admin.product.view-product', compact('product'));
    
 }
 public function product_details($id)
{
    $product = Product::findOrFail($id);
    return view('page.product-details', compact('product'));
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
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  
    ]);

    
    $imagePath = $request->file('image')->store('products', 'public');

    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->gender = $request->gender;
    $product->description = $request->description;
    $product->category = $request->category_name;
    $product->stock_quantity = $request->stock_quantity;
    $product->image = $imagePath; 
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gender' => 'required|in:Men,Women,Unisex',
        'stock_quantity' => 'required|integer|min:0',
    ]);

    $product = Product::findOrFail($id);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->category = $request->category;
    $product->gender = $request->gender;
    $product->stock_quantity = $request->stock_quantity;
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

 public function categoryProducts($id)
{
    $category = tbl_category::findOrFail($id);
    $products = Product::where('category', $id)->get();
    $categories = tbl_category::all();

    return view('page.catproducts', compact('products', 'categories', 'category'));
}

public function shop(Request $request){
    $products = Product::all();
    $categories = tbl_category::all();
    return view ('page.shop',compact('products','categories'));

 }
}
