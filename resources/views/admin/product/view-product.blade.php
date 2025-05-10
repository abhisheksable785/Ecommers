@extends('layout.back.master')
@section('title', 'View Product')
@section('content')

<div class="container mt-4">
    <div class="card shadow-lg p-4" style="max-height: 80vh; overflow-y: auto;">
        <h2 class="text-center mb-4">Product Details</h2>

        <div class="text-center">
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" style="max-width: 200px;">
        </div>

        <table class="table table-bordered mt-3">
            <tbody>
                <tr>
                    <th>Product Name</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>₹{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $product->gender }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $product->category_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <th>Stock Quantity</th>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

@endsection
