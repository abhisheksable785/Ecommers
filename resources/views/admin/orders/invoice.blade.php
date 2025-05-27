@extends('layout.back.master')
@section('title','Invoice')
@section('content')

<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4><i class="bi bi-cart4 me-2"></i> Ecommerce Surface</h4>
            <p class="mb-1">Invoice Number: {{ $invoice->id }}</p>
            <p>Date: {{ $invoice->created_at->format('d/m/Y') }}</p>
        </div>
        <div>
            <h1 class="text-primary fw-bold">INVOICE</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Bill From:</h6>
            <p>
                BMT Fashion <br>
                I-step-Up, 413102<br>
                94954XXXX
            </p>
        </div>
        <div class="col-md-6 text-md-end">
            <h6>Bill To:</h6>
            <p>
                {{ $invoice->user->name ??'N/A' }}<br>
                {{ $invoice->user->address ??'N/A' }}<br>
                {{ $invoice->user->phone  ??'N/A'}}
            </p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Tax</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>$0.00</td>
                <td>${{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <p><strong>Terms & Conditions:</strong> <br> Thank you for your business!</p>
    </div>

    <div class="d-flex justify-content-end">
        <table class="table table-borderless w-auto">
            <tr>
                <th>Subtotal:</th>
                <td>${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <th>Discount:</th>
                <td>$0.00</td>
            </tr>
            <tr>
                <th>Tax:</th>
                <td>$0.00</td>
            </tr>
            <tr>
                <th>Paid:</th>
                <td>$0.00</td>
            </tr>
            <tr class="bg-primary text-white">
                <th>Total</th>
                <td><strong>${{ number_format($invoice->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</div>

@endsection