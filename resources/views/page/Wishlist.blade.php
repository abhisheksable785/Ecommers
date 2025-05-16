@extends('layout.front.app')
@section('title','Wishlist')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        {{-- SVG Icon for Wishlist --}}
        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="mb-4 text-danger">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 21 3.172 10.828a4 4 0 010-5.656z" />
        </svg> --}}

        {{-- Message --}}
        <h2 class="text-danger mb-4">Your Wishlist</h2>

       @forelse ($wishlists  as $wishlist)
        <div class="card mb-3" style="width: 18rem;">
            <img src="{{ asset('storage/' . $wishlist->product->image) }}" class="card-img-top" alt="{{ $wishlist->product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $wishlist->product->name }}</h5>
                <p class="card-text">Price: ₹{{ $wishlist->product->price }}</p>    
           
       @empty
       <h3 class="text-muted">Your Wishlist is Empty!</h3>
        <p class="text-secondary">Add products to your wishlist to keep track of what you love.</p>
       @endforelse

        {{-- Call-to-Action --}}
        <a href="shop" class="btn btn-outline-danger mt-3">
            Browse Products
        </a>
    </div>
</div>

@endsection
