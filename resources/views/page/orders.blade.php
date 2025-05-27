@extends('layout.front.app')
@section('title', 'Orders')
@section('content')

<div class="container py-5">
    <h1 class="mb-4">Your Orders</h1>
    
    @if($orders->isEmpty())
    <div class="text-center py-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-box-seam text-secondary mb-4" viewBox="0 0 16 16">
            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
        </svg>
        <h3 class="text-muted mt-3">No Orders Found</h3>
        <p class="text-secondary">Your order history will appear here once you make purchases.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary mt-3 px-5">
            Start Shopping <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
    @else
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($orders as $order)
        <div class="col">
            <div class="card h-100 shadow-sm hover-shadow-lg transition">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        Order #{{ $order->id }}
                        <span class="badge bg-primary float-end">{{ $order->created_at->format('M d, Y') }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $order->image) }}" 
                                 class="img-fluid rounded-2" 
                                 alt="Order image"
                                 style="max-height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-8">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-2">
                                    <span class="fs-5 fw-bold">${{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="mt-auto">
                                    <span class="badge 
                                        @if($order->status == 'Completed') bg-success 
                                        @elseif($order->status == 'Processing') bg-warning text-dark 
                                        @else bg-secondary @endif">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="" 
                       class="btn btn-outline-primary btn-sm">
                        View Details <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection