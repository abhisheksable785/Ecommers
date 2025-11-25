<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\tbl_category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = tbl_category::withCount('products')->get();

        // If request is from API/Postman, return JSON
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Categories retrieved successfully',
                'data' => ['cat' => $categories],
            ]);
        }

        // Return view for web
        return view('admin.category.index', compact('categories'));
    }

    // FIXED: This method fetches category data for edit modal
    public function view($id)
    {
        $category = tbl_category::findOrFail($id);

        // Return JSON for AJAX requests
        if (request()->ajax()) {
            return response()->json($category);
        }

        // Return view for normal requests
        return view('admin.category.view-cat', compact('category'));
    }

    public function shop()
    {
        $categories = tbl_category::all();

        return view('page.shop', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.add-cat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tbl_category|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'description' => 'nullable|string',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('storage/categories'), $imageName);

        tbl_category::create([
            'name' => $request->name,
            'image' => 'storage/categories/'.$imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('category.index')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = tbl_category::findOrFail($id);

        return view('admin.category.edit-cat', compact('category'));
    }

    // FIXED: Update method with proper image handling
    public function update(Request $request, $id)
    {
        $category = tbl_category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tbl_category,name,'.$id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if (file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/categories'), $imageName);

            $category->image = 'storage/categories/'.$imageName;
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = tbl_category::findOrFail($id);

        // Delete Image from Storage
        if (file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }

    public function cathome()
    {
        $products = Product::limit(8)->get();
        $categories = tbl_category::all();

        return view('page.home', compact('categories', 'products'));
    }
}
