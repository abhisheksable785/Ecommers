@extends('layout.front.app')
@section('title','Bag')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        {{-- Shopping Bag SVG Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="mb-4 text-primary">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 10-8 0v4M4 8h16l-1.5 12.5a1 1 0 01-1 .5H6a1 1 0 01-1-.5L4 8z" />
        </svg>

        {{-- Main Message --}}
        <h3 class="fw-bold text-dark">Oops! Your Bag is Empty</h3>
        <p class="text-secondary">Looks like you haven't added anything yet. Start shopping now!</p>

        {{-- CTA Button --}}
        <a href="wishlist" class="btn btn-outline-primary mt-3 px-4 py-2 fw-semibold">
            Add Items from Wishlist
        </a>
    </div>
</div>

@endsection
