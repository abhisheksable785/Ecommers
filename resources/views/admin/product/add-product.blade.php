@extends('layout.back.master')
@section('title','Product-Add')
@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow-lg p-4" style="width: 50%; max-height: 80vh; overflow-y: auto;">
        <h2 class="mb-4 text-center">Add New Product</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
                  <div class="mb-3">
    <label class="form-label">Gallery Images</label>
    <input type="file" name="pics[]" class="form-control" accept="image/*" multiple>
</div>


            <div class="mb-3">
                <label class="form-label">Price (₹)</label>
                <input type="text" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="Men">Men</option>
                    <option value="Women">Women</option>
                    <option value="Unisex">Unisex</option>
                    
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_name" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Product</button>
        </form>
    </div>
</div>
@endsection
