@extends('layout.back.master')
@section('title','Product-list')
@section('content')
<div class="container">
    <h2 class="mb-4">Product List</h2>

    <div class="card-header d-flex justify-content-between">
        <a href="{{ route('products.create') }}" class="btn btn-black">
            <span class="btn-label"><i class="fa fa-archive"></i></span> Add Product
        </a>
    </div>
    <br>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Scrollable Table Wrapper -->
    <div style="max-height: 500px; overflow-y: auto;">
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
