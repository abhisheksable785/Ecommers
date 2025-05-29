@extends('layout.back.master')
@section('title','Order Index')
@section('content')
<div class="container">
    
<h2>Order Index</h2>

<div style="max-height:100%; overflow-y: auto;">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr> 
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Delivery Address</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th style="width: 230px;">Actions</th>
            </tr>
        </thead>
        <tbody>


            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $profile->full_name ??'N/A' }}</td>
                <td>{{ $profile->email  ??'N/A'}}</td>
                <td>{{ $profile->address ??'N/A' }}</td>
                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.view', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     {{ $orders->links() }}
</div>
</div>
@endsection
