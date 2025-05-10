@extends('layout.front.app')
@section('title','Credits')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        {{-- SVG Icon for Credits / Wallet --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="mb-4 text-info">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v10H4V7zm0-2a2 2 0 012-2h12a2 2 0 012 2v2H4V5zm13 6h1a1 1 0 110 2h-1a1 1 0 110-2z" />
        </svg>

        {{-- Message --}}
        <h3 class="text-muted">You Don't Have Any Credits</h3>
        <p class="text-secondary">Earn or add credits to use them on your next purchase.</p>

        {{-- Call-to-Action --}}
        <a href="credit" class="btn btn-info mt-3 text-white">
            View Wallet Options
        </a>
    </div>
</div>

@endsection
