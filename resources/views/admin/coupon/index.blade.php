@extends('layout.back.master')
@section('title', 'Coupons')    
@section('content')
<h2>Coupons</h2>
<a href="{{ route('coupons.create') }}" class="btn btn-success mb-3">Add New Coupon</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Code</th>
            <th>Type</th>
            <th>Value</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <td>{{ $coupon->code }}</td>
            <td>{{ ucfirst($coupon->type) }}</td>
            <td>{{ $coupon->type == 'percent' ? $coupon->value . '%' : '₹' . $coupon->value }}</td>
            <td>
                <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this coupon?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $coupons->links() }}


@endsection