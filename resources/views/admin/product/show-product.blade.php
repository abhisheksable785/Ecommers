@extends('layout.back.master')
@section('title','Product-list')
@section('content')
<div class="container">


     <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <h4 class="fw-bold mb-0" style="font-size: 28px;">📌 Product List</h4>
                <a href="{{ route('products.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-plus me-1"></i> Add Product
                </a>
            </div>
  
    <br>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Scrollable Table Wrapper -->
    <div style="overflow-y: auto;">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Gender</th>
                    <th>Category</th>
                    <th>Discription</th>
                    <th>Stock</th>
                    <th style="width:250px;">Actions</th>
                </tr>
            </thead>
            <tbody>                     
                @foreach($products as $product)
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $product->image) }}" width="50" height="50" alt="Product Image" >
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->gender }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm"  title="View">
                            View
                        </a>
                    
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div
        class="mt-5">
    {{ $products->links() }}
        </div>
    </div>
    </div>
</div>
@endsection
