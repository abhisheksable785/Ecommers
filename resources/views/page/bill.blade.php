@extends('layout.front.app')
@section('title','Check Out')
@section('content')

 <div class="row">
        <div class="col-8">
           @if (session('success'))
    <div class="alert alert-success" id="successAlert">
        {{ session('success') }}
    </div>

    <script>
        // Hide success message after 3 seconds
        setTimeout(function() {
            var alertBox = document.getElementById('successAlert');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 3000); // 3000ms = 3 seconds
    </script>
@endif

        </div>
    </div>
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="#">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            
                            <h6 class="checkout__title">Billing Details</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Fist Name<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Last Name<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Country<span>*</span></p>
                                <input type="text" id="country">
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" placeholder="Street Address" id="address" class="checkout__input__add">
                            
                            </div>
                            <div class="checkout__input">
                                <p>Town/City<span>*</span></p>
                                <input type="text" id="city">
                            </div>
                            <div class="checkout__input">
                                <p>Country/State<span>*</span></p>
                                <input type="text" id="state">
                            </div>
                            <div class="checkout__input">
                                <p>Postcode / ZIP<span>*</span></p>
                                <input type="text" id="zipcode">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text">
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
                                            <span>${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span> ₹{{ number_format($subtotal, 2) }}</span></li>
                                    <li>Total <span> ₹{{ number_format($subtotal, 2) }}</span></li>
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

                    document.getElementById('country').value = addr.country || '';
                    document.getElementById('address').value = `${addr.road || ''}, ${addr.suburb || ''}`;
                    
                    // Smart fallback for city
                    document.getElementById('city').value =
                        addr.city ||
                        addr.town ||
                        addr.village ||
                        addr.hamlet ||
                        addr.municipality ||
                        addr.locality ||
                        '';

                    document.getElementById('state').value = addr.state || addr.county || '';
                    document.getElementById('zipcode').value = addr.postcode || '';
                })
                .catch(error => {
                    console.error('Geocoding error:', error);
                });
        }, function (error) {
            alert("Location access denied or unavailable.");
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});
</script>

