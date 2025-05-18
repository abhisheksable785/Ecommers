<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\tbl_category;
use App\Models\tbl_contact;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = tbl_category::all();
        return view('admin.category.category', compact('categories'));
    }
     public function shop(){
        $categories = tbl_category::all();
        return view('page.shop',compact('categories'));
     }
  
   

    public function create()
    {
        return view('admin.category.add-cat');
    }
   
 public function store(Request $request)
{
    $request->validate([
    'name' => 'required|unique:tbl_category|max:255',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    'description' => 'nullable|string',
]);


    $imageName = time().'.'.$request->image->extension();
    $request->image->move(public_path('uploads/category'), $imageName);

    tbl_category::create([
        'name' => $request->name,
        'image' => 'uploads/category/'.$imageName,
        'description' => $request->description,
    ]);

    return redirect()->route('category.list')->with('success', 'Category added successfully!');
}

    public function edit($id)
    {
        $category = tbl_category::findOrFail($id);
        return view('admin.category.edit-cat', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = tbl_category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Update Image if new one is uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = 'storage/' . $imagePath;
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('category.list')->with('success', 'Category updated successfully!');
    }
    public function view($id)
    {
        $category = tbl_category::findOrFail($id);
        return view('admin.category.view-cat', compact('category'));
    }
    public function destroy($id)
    {
        $category = tbl_category::findOrFail($id);

        // Delete Image from Storage
        if (file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('category.list')->with('success', 'Category deleted successfully!');
    }
    public function cathome(){
        $products = Product::limit(8)->get();
        $categories = tbl_category::all();
        return view('page.home', compact('categories','products'));


    }


}
