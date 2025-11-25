@extends('layout.back.master')
@section('title', 'Order Details #' . $order->id)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">eCommerce /</span> Order Details
    </h4>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center gap-2 gap-sm-0">
            <h5 class="mb-1 mt-3 d-flex flex-wrap gap-2 align-items-end">
                Order #{{ $order->order_number ?? $order->id }}
                @if($order->payment_status == 'paid')
                    <span class="badge bg-label-success">Paid</span>
                @elseif($order->payment_status == 'unpaid')
                    <span class="badge bg-label-danger">Unpaid</span>
                @else
                    <span class="badge bg-label-warning">Pending Payment</span>
                @endif

                @switch($order->status)
                    @case('completed')
                        <span class="badge bg-label-success">Completed</span>
                        @break
                    @case('processing')
                        <span class="badge bg-label-info">Processing</span>
                        @break
                    @case('cancelled')
                        <span class="badge bg-label-danger">Cancelled</span>
                        @break
                    @default
                        <span class="badge bg-label-secondary">{{ ucfirst($order->status) }}</span>
                @endswitch
            </h5>
            <p class="text-body">{{ $order->created_at->format('M d, Y, h:i A') }}</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-2">
            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-label-danger delete-order">Delete Order</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Order details</h5>
                    </div>
                <div class="table-responsive">
                    <table class="table border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-50">Product</th>
                                <th class="w-25">Price</th>
                                <th class="w-25">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(optional($item->product)->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="me-2 rounded" width="40">
                                        @else
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-secondary">
                                                    {{ strtoupper(substr($item->product->name ?? 'P', 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="d-flex flex-column">
                                            <h6 class="m-0">
                                                @if($item->product)
                                                    <a href="{{ route('products.show', $item->product_id) }}" class="text-body">
                                                        {{ $item->product->name }}
                                                    </a>
                                                @else
                                                    <span class="text-body">Product Deleted</span>
                                                @endif
                                            </h6>
                                            <small class="text-muted">SKU: {{ optional($item->product)->sku ?? 'N/A' }}</small>
                                            @if($item->size)
                                                <br>
                                                <small class="text-muted">Size: {{ $item->size }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>₹{{ number_format($item->price_at_purchase, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end fw-medium">₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end align-items-center m-3 mb-2 p-1">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0">₹{{ number_format($order->total_amount, 2) }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Discount:</span>
                                <h6 class="mb-0">₹0.00</h6> 
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Tax:</span>
                                <h6 class="mb-0">₹0.00</h6>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0 text-primary">₹{{ number_format($order->total_amount, 2) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title m-0">Shipping activity</h5>
                </div>
                <div class="card-body">
                    <ul class="timeline pb-0 mb-0">
                        <li class="timeline-item timeline-item-transparent border-primary">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header">
                                    <h6 class="mb-0">Order was placed (ID: #{{ $order->order_number ?? $order->id }})</h6>
                                    <small class="text-muted">{{ $order->created_at->format('D, M d, H:i A') }}</small>
                                </div>
                                <p class="mt-2">Your order has been placed successfully</p>
                            </div>
                        </li>
                        
                        @if($order->status == 'processing' || $order->status == 'completed')
                        <li class="timeline-item timeline-item-transparent border-primary">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event">
                                <div class="timeline-header">
                                    <h6 class="mb-0">Processing</h6>
                                    <small class="text-muted">{{ $order->updated_at->format('D, M d') }}</small>
                                </div>
                                <p class="mt-2">We are preparing your order</p>
                            </div>
                        </li>
                        @endif

                        @if($order->status == 'completed')
                        <li class="timeline-item timeline-item-transparent border-transparent pb-0">
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header">
                                    <h6 class="mb-0">Delivered</h6>
                                    <small class="text-muted">{{ $order->updated_at->format('D, M d, H:i A') }}</small>
                                </div>
                                <p class="mt-2 mb-0">Package has been delivered</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">Customer details</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                {{ strtoupper(substr($order->user->name ?? 'G', 0, 2)) }}
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="javascript:void(0)" class="text-body text-nowrap">
                                <h6 class="mb-0">{{ $order->full_name ?? ($order->user->name ?? 'Guest') }}</h6>
                            </a>
                            <small class="text-muted">Customer ID: #{{ $order->user_id ?? 'N/A' }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <span class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center">
                            <i class="ti ti-shopping-cart ti-sm"></i>
                        </span>
                        <h6 class="text-body text-nowrap mb-0">
                            {{ $order->user ? $order->user->orders()->count() . ' Orders' : '1 Order' }}
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Contact info</h6>
                    </div>
                    <p class="mb-1">Email: {{ $order->email ?? ($order->user->email ?? 'N/A') }}</p>
                    <p class="mb-0">Mobile: {{ $order->mobile_number ?? ($userProfile->mobile_number ?? 'N/A') }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">Shipping address</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        {{ $order->address ?? ($userProfile->address ?? 'N/A') }} <br />
                        {{ $order->city ?? ($userProfile->city ?? '') }}, {{ $order->state ?? ($userProfile->state ?? '') }} <br />
                        {{ $order->country ?? ($userProfile->country ?? '') }} - {{ $order->pincode ?? ($userProfile->pincode ?? '') }}<br />
                        {{ $order->mobile_number ?? '' }}
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">Billing address</h6>
                </div>
                <div class="card-body">
                     <p class="mb-4">
                        <span class="badge bg-label-secondary mb-2">Same as Shipping</span><br>
                        {{ $order->address ?? ($userProfile->address ?? 'N/A') }} <br />
                        {{ $order->city ?? ($userProfile->city ?? '') }} {{ $order->pincode ?? '' }}
                    </p>
                    <h6 class="mb-0 pb-2">Payment Method</h6>
                    <p class="mb-0">
                        {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                        @if($order->payment_status == 'paid')
                            <i class="ti ti-circle-check-filled text-success ms-1"></i>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('admin.orders.partials.modals') 

</div>

@endsection