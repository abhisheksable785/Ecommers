@extends('layout.back.master') 
@section('title', 'Order Details')
@section('content')


<div class="container-fluid order-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h6>Order Details</h6>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>

                <div class="card-body">
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Order #{{ $order->id }}</h5>
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1"><strong>Customer:</strong> {{ $profile->full_name  }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $profile->email }}</p>
                                    <p class="mb-0"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Delivery Information</h5>
                                    <p class="mb-1"><strong>Address:</strong></p>
                                    <p class="mb-1">{{ $profile->address ?? 'N/A' }}</p>
                                    <p class="mb-0"><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h6>Order Items ({{ count($order->items) }})</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="avatar avatar-sm me-3" alt="{{ $item->product->name }}">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $item->product->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">ID: {{ $item->product->id }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>₹{{ number_format($item->product->price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₹{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
           

        <form action="{{ route('invoice.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-primary">
                Add to Invoice
            </button>
        </form>
    </div>

                    <!-- Order Total -->
                    <div class="row mt-4">
                        <div class="col-md-5 ms-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-sm">Subtotal:</span>
                                        <span class="text-sm">₹{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-sm">Shipping:</span>
                                        <span class="text-sm">₹0.00</span>
                                    </div>
                                    <hr class="horizontal dark">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-sm font-weight-bold">Total:</span>
                                        <span class="text-sm font-weight-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
</div> <!-- container -->

@endsection
