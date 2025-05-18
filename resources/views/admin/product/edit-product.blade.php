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
         <div class="mb-3">
    <label class="form-label">Gallery Images</label>
    <input type="file" name="pics[]" class="form-control" accept="image/*" multiple>
    <br>
    @php
        $gallery = json_decode($product->pics, true);
    @endphp
    @if($gallery)
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @foreach ($gallery as $index => $img)
                <div style="position: relative; display: inline-block;">
                    <img src="{{ asset('storage/' . $img) }}" width="80" height="80" style="object-fit: cover; border: 1px solid #ccc; padding: 2px;">

                    <!-- Cross sign -->
                    <button type="button" class="remove-img-btn" 
                        data-img-index="{{ $index }}" 
                        style="position: absolute; top: -8px; right: -8px; background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-weight: bold; line-height: 18px;">
                        &times;
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Hidden input to hold indexes of images to remove -->
<input type="hidden" name="remove_pics" id="remove_pics" value="">
            

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeBtns = document.querySelectorAll('.remove-img-btn');
        const removePicsInput = document.getElementById('remove_pics');
        let removedIndexes = [];

        removeBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const imgIndex = this.getAttribute('data-img-index');

                // Add index to removed list if not already added
                if (!removedIndexes.includes(imgIndex)) {
                    removedIndexes.push(imgIndex);
                    removePicsInput.value = removedIndexes.join(',');
                }

                // Hide the image div
                this.parentElement.style.display = 'none';
            });
        });
    });
</script>
