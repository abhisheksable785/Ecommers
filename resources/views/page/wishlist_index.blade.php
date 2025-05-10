@extends('layout.front.app')
@section('title', 'Your Wishlist')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">My Wishlist</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($wishlist->isEmpty())
        <p>You haven’t added any products to your wishlist yet.</p>
    @else
        <div class="row">
            @foreach($wishlist as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ $product->price }}</p>

                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="mt-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">Remove from Wishlist</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
