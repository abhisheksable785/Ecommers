@extends('layout.front.app')
@section('title', 'Orders')
@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            @forelse ($orders as $order)
                <div class="col-12 mb-4 d-flex justify-content-center">
                    <div class="card order-card">
                        <div class="card-body">
                            <h5 class="card-title">Order #{{ $order->id }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Product: {{ $order->product->name ?? 'N/A' }}</h6>

                            @if ($order->image)
                                <img src="{{ asset('storage/' . $order->image) }}" alt="Product Image">
                            @endif

                            <p class="card-text mt-2">Total: ${{ number_format($order->total, 2) }}</p>
                            <p class="card-text">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
                            <a href="{{ route('user.orders', $order->id) }}"
                                class="btn btn-outline-primary btn-sm mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5" class="mb-4 text-secondary">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h18M9 3v2m6-2v2M4 7h16M6 10h12l-1 10H7L6 10z" />
                    </svg>
                    <h3 class="text-muted">You haven't placed any orders yet!</h3>
                    <p class="text-secondary">When you make a purchase, your order will appear here.</p>
                    <a href="{{ url('shop') }}" class="btn btn-primary mt-3">Start Shopping</a>
                </div>
            @endforelse
        </div>
    </div>

@endsection
