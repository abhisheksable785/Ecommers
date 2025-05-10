@extends('layout.back.master')
@section('title','Product-Edit')
@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="card shadow-lg p-4" style="width: 50%; max-height: 80vh; overflow-y: auto;">
        <h2 class="mb-4 text-center">Edit Product</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <!-- Product Image -->
            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <br>
                <img src="{{ asset('storage/' . $product->image) }}" width="100">
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label class="form-label">Price (₹)</label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="Men" {{ $product->gender == 'Men' ? 'selected' : '' }}>Men</option>
                    <option value="Women" {{ $product->gender == 'Women' ? 'selected' : '' }}>Women</option>
                    <option value="Unisex" {{ $product->gender == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            

            <!-- Stock Quantity -->
            <div class="mb-3">
                <label class="form-label">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Update Product</button>
        </form>
    </div>
</div>
@endsection
