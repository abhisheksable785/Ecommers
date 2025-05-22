@extends('layout.front.app')
@section('title','shopping-cart')
@section('content')

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @forelse($cartItems as $item)
                            <tr>
                                <td class="product__cart__item">
                                    <div class="product__cart__item__pic">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 80px; height: 80px;">
                                        
                                    </div>
                                    <div class="product__cart__item__text">
                                        <h6>{{ $item->product->name }}</h6>
                                        <h5> ₹{{ number_format($item->price_at_purchase, 2) }}</h5>
                                        @if($item->size)
                                            <p>Size:  {{ $item->size }}</p>
                                        @endif
                                        @if($item->color)
                                            <p>Color: {{ $item->color }}</p>
                                        @endif
                                </div>
                           <td class="quantity__item">
    <div class="quantity">
        <div class="pro-qty" data-id="{{ $item->id }}">
            <button class="qtybtn dec" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
            <input type="text" class="qty-input" value="{{ max(1, $item->quantity) }}" readonly style="width: 20px; text-align: center;">
            <button class="qtybtn inc">+</button>
        </div>
    </div>
</td>



                                @php 
                                    $itemTotal = $item->price_at_purchase * $item->quantity;
                                    $subtotal += $itemTotal;
                                @endphp
                                <td class="cart__price"> ₹{{ number_format($itemTotal, 2) }}</td>
                                <td class="cart__close">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none;">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Your cart is empty</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="{{ route('shop') }}">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="continue__btn update__btn">
    <a href="{{ route('wishlist.index') }}" class="btn btn-outline-dark w-100">
        <i class="fa fa-heart"></i> Add From Wishlist
    </a>
</div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__discount">
                    <h6>Discount codes</h6>
                    <form action="{{ route('apply.coupon') }}" method="POST">
                    @csrf
                    <input type="text" name="coupon_code" placeholder="Enter coupon code">
                    <button type="submit">Apply</button>
                    </form>

                    @if(session('coupon'))
                    <p>Coupon Applied: <strong>{{ session('coupon')['code'] }}</strong></p>
                    @endif
                </div>
                <div class="cart__total">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Subtotal <span>₹{{ number_format($subtotal, 2) }}</span></li>

                            @if(session('coupon'))
                                <li>Discount ({{ session('coupon')['code'] }}) 
                                    <span>- ₹{{ number_format(session('coupon')['discount'], 2) }}</span>
                                </li>
                            @endif
 
                            <li>Total 
                                <span>
                                    ₹{{ number_format($subtotal - (session('coupon')['discount'] ?? 0), 2) }}
                                </span>
                            </li>

                        
                    </ul>
                    <a href="{{ route('checkout') }}" class="primary-btn">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

@endsection
@push('scripts')
<script>
   $(document).ready(function () {
    $('.qtybtn').on('click', function () {
        var button = $(this);
        var parent = button.closest('.pro-qty');
        var input = parent.find('input');
        var currentQty = parseInt(input.val());
        var cartItemId = parent.data('id');

        var newQty = button.hasClass('inc') ? currentQty + 1 : currentQty - 1;

        // Block minus if qty is already 1
        if (newQty < 1) return;

        $.ajax({
            url: "{{ route('cart.update') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantities: [{ id: cartItemId, quantity: newQty }]
            },
            success: function (res) {
                if (res.success) {
                    input.val(newQty);

                    // Update row total
                    var price = parseFloat(parent.closest('tr').find('.product__cart__item__text h5').text().replace(/[₹,]/g, '')) || 0;
                    var newTotal = (price * newQty).toFixed(2);
                    parent.closest('tr').find('.cart__price').text('₹' + newTotal);

                    // Update cart total
                    var subtotal = 0;
                    $('.cart__price').each(function () {
                        subtotal += parseFloat($(this).text().replace(/[₹,]/g, '')) || 0;
                    });
                    $('.cart__total span, .cart__total li span').text('₹' + subtotal.toFixed(2));

                    // Disable/Enable minus button
                    let decBtn = parent.find('.dec');
                    if (newQty <= 1) {
                        decBtn.prop('disabled', true);
                    } else {
                        decBtn.prop('disabled', false);
                    }
                }
            }
        });
    });
});

</script>


@endpush
