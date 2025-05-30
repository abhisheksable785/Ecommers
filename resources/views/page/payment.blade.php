@extends('layout.front.app')
@section('title', 'Razorpay Payment')

@section('content')
<div class="container mt-5">
    <h4>Redirecting to Razorpay...</h4>
    <form action="{{ route('payment.success') }}" method="GET" id="razorpay-form">
        <script src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ $key }}"
            data-amount="{{ $amount }}"
            data-currency="INR"
            data-order_id="{{ $razorpayOrderId }}"
            data-buttontext="Pay with Razorpay"
            data-name="Your Store"
            data-description="Test Transaction"
            data-prefill.name="{{ $customer['full_name'] }}"
            data-prefill.email="{{ $customer['email'] }}"
            data-prefill.contact="{{ $customer['mobile_number'] }}"
            data-theme.color="#F37254">
        </script>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</div>
@endsection
