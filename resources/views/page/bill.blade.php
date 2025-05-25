@extends('layout.front.app')
@section('title', 'Check Out')

@section('content')
<div class="row">
    <div class="col-8">
        @if (session('success'))
        <div class="alert alert-success" id="successAlert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                var alertBox = document.getElementById('successAlert');
                if (alertBox) {
                    alertBox.style.display = 'none';
                }
            }, 3000);
        </script>
        @endif
    </div>
</div>

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form action="{{ route('checkout.place') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">Billing Details</h6>

                        <div class="checkout__input">
                            <p>Name <span>*</span></p>
                            <input type="text" id="full_name" name="full_name" class="checkout__input__add"
                                value="{{ old('full_name', $profile->full_name ?? '') }}">
                        </div>

                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" id="address" name="address" class="checkout__input__add"
                                value="{{ old('address', $profile->address ?? '') }}">
                        </div>

                        <div class="checkout__input">
                            <p>Country<span>*</span></p>
                            <input type="text" id="country" name="country" value="{{ old('country', $profile->country ?? '') }}">
                        </div>

                        <div class="checkout__input">
                            <p>City<span>*</span></p>
                            <input type="text" id="city" name="city"
                                value="{{ old('city', $profile->city ?? '') }}">
                        </div>

                        <div class="checkout__input">
                            <p>State<span>*</span></p>
                            <input type="text" id="state" name="state" value="{{ old('state', $profile->state ?? '') }}">
                        </div>

                        <div class="checkout__input">
                            <p>PINCODE / ZIP<span>*</span></p>
                            <input type="text" id="zipcode" name="zipcode"
                                value="{{ old('zipcode', $profile->zipcode ?? $profile->pincode ?? '') }}">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text" id="phone" name="phone"
                                        value="{{ old('phone', $profile->mobile_number ?? '') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $profile->email ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">Your order</h4>
                            <div class="checkout__order__products">Product <span>Total</span></div>
                            <ul class="checkout__total__products">
                                @php $count = 1; @endphp
                                @foreach($cartItems as $item)
                                <li>{{ $count++ }}. {{ $item->product->name }} x {{ $item->quantity }}
                                    <span>₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</span>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="checkout__total__all">
                                <li>Subtotal <span>₹{{ number_format($subtotal, 2) }}</span></li>
                                <li>Total <span>₹{{ number_format($subtotal, 2) }}</span></li>
                            </ul>

                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`)
                .then(response => response.json())
                .then(data => {
                    const addr = data.address;
                    // Only auto-fill Country and State
                    document.getElementById('country').value = addr.country || '';
                    document.getElementById('state').value = addr.state || addr.county || '';
                })
                .catch(error => {
                    console.error('Geocoding error:', error);
                });
        }, function (error) {
            console.warn("Geolocation error:", error.message);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});
</script>
@endsection
