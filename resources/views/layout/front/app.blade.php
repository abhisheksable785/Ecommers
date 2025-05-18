<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BMT Fashion</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>


</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">

        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo.png" alt="" height="50px" width="50px"></a>
                    </div>
                </div> --}}
                <div class="col-lg-12 col-md-12">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="/">Home</a></li>
                            <li><a href="{{ route('shop') }}">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="about">About Us</a></li>
                                    <li><a href="{{ route('cart') }}">Shopping Cart</a></li>
                                    <li><a href="{{ route('checkout') }}">Check Out</a></li>
                                
                                </ul>
                            </li>
                            <li><a href="">Blog</a></li>
                            <li><a href="contact">Contacts</a></li>
                            <li></li>
                            <li></li>


                            <li><a href="#" class="search-switch">
                                <img src="img/icon/search.png" alt="">
                            </a></li>

                            <li>  <a href="wishlist">
                                <img src="img/icon/heart.png" alt="">
                            </a></li>
                            <li> <a href="cart">
                                <img src="img/icon/cart.png" alt=""> <span></span>
                            </a></li>
                            <li>
                                <a href="#" class="profile-toggle">
                                    <img src="img/icon/profile.png" alt="" height="30px" width="30px">
                                </a>
                                <ul class="dropdown1">
                            
                                    @guest
                                        <!-- Show this if user is NOT logged in -->
                                        <li><h4 style="color: white">Welcome</h4></li>
                                        <li><h6 style="color: white">To access your account and manage orders</h6></li>
                                        <li><a href="{{ route('login') }}">Login / Sign Up</a></li>
                                    @else
                                        <!-- Show this if user IS logged in -->
                                        <li><h6 style="color: white">{{ Auth::user()->name }}</h6></li>
                                        <li><a href="orders">My Orders</a></li>
                                        <li><a href="wishlist">Wishlist</a></li>
                                        <li><a href="gift">Gift Cards</a></li>
                                        <li><a href="'credit">BMT Credits</a></li>
                                       
                            
                                        <!-- Logout using a form for security -->
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; color: white; text-align: left;">Logout</button>
                                            </form>
                                        </li>
                                    @endguest
                            
                                </ul>
                            </li>
                            
                            
                            <li> <div class="price">$0.00</div></li>


                        </ul>
                    </nav>
                </div>
             
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->
    <div>
        <!-- Breadcrumb Section Begin -->
 {{-- <section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shop</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Home</a>
                        <span>@yield('title')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!-- Breadcrumb Section End -->

    @yield('content')
</div>

     <!-- Footer Section Begin -->
     <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="contact">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            All rights reserved | Developed by Abhishek Sabale <i class="fa fa-heart-o"
                            aria-hidden="true"></i>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->
        <!-- Search Begin -->
        <div class="search-model">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <div class="search-close-switch">+</div>
                <form class="search-model-form">
                    <input type="text" id="search-input" placeholder="Search here.....">
                </form>
            </div>
        </div>
        <!-- Search End -->
    
        <!-- Js Plugins -->
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
        <script src="{{ asset('js/mixitup.min.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script>
            document.getElementById('update-cart').addEventListener('click', function(e) {
                e.preventDefault();
                let quantities = [];
                
                document.querySelectorAll('.pro-qty-2 input').forEach((input, index) => {
                    quantities.push({
                        id: input.closest('tr').dataset.id,
                        quantity: input.value
                    });
                });
                
                fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({quantities})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    }
                });
            });
            </script>
        
        {{-- <script>
            const profileToggle = document.querySelector('.profile-toggle');
            const dropdown = document.querySelector('.dropdown-profile ul');
        
            profileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
            });
        
            // Optional: close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-profile')) {
                    dropdown.style.display = 'none';
                }
            });
        </script> --}}
        
    </body>
    
    </html>