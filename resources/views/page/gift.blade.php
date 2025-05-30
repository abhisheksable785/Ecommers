@extends('layout.front.app')
@section('title', 'Gift Cards')
@section('content')

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="text-center">
            {{-- SVG Icon for Gift Card --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.5" class="mb-4 text-warning">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 17h16M12 7v10M4 12h16" />
            </svg>

            {{-- Message --}}
            <h3 class="text-muted">No Gift Cards Found!</h3>
            <p class="text-secondary">Looks like you haven’t ordered any gift cards yet.</p>

            {{-- Call-to-Action --}}
            <a href="gift" class="btn btn-warning mt-3 text-white">
                Explore Gift Cards
            </a>
        </div>
    </div>

@endsection
