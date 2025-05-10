@extends('layout.front.app')
@section('title','Orders')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        {{-- SVG Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="mb-4 text-secondary">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M9 3v2m6-2v2M4 7h16M6 10h12l-1 10H7L6 10z" />
        </svg>

        {{-- Message --}}
        <h3 class="text-muted">You haven't placed any orders yet!</h3>
        <p class="text-secondary">When you make a purchase, your order will appear here.</p>

        {{-- Call-to-Action --}}
        <a href="shop" class="btn btn-primary mt-3">
            Start Shopping
        </a>
    </div>
</div>

@endsection
