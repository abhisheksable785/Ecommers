@extends('layout.back.master')
@section('content')
<h2>Add Coupon</h2>
<form action="{{ route('coupons.store') }}" method="POST">
    @include('admin.coupon.form')
</form>
@endsection
