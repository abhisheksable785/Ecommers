@extends('layout.back.master')
@section('title', 'Edit Coupon')
@section('content')
<h2>Edit Coupon</h2>
<form action="{{ route('coupons.update', $coupon) }}" method="POST">
    @method('PUT')
    @include('admin.coupon.form')
</form>
@endsection
