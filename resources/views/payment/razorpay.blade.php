@extends('layout.front.app')
@section('title', 'Payment')
@section('content') 



<div class="container mt-5">
    <h3>Complete your payment</h3>
    <form action="{{ route('razorpay.success') }}" method="POST">
        @csrf
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ $key }}"
            data-amount="{{ $amount }}"
            data-currency="INR"
            data-order_id="{{ $razorpayOrderId }}"
            data-buttontext="Pay Now"
            data-name="BMT Fashion"
            data-description="Order Payment"
            data-prefill.name="{{ $customer['full_name'] }}"
            data-prefill.email="{{ $customer['email'] }}"
            data-prefill.contact="{{ $customer['mobile_number'] }}"
            data-theme.color="#F37254">
        </script>
    </form>
</div>

@endsection