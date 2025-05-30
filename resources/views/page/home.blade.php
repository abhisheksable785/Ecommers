@extends('layout.front.app')
@section('title', 'Home')
@section('content')

    <!-- Hero Section Begin -->
    <section class="hero">
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
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2025</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2025</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="category-grid py-5" style="background-color: #dcdad3">
        <div class="container">
            <div class="row">

                @foreach ($categories as $category)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4" class="card-product"
                        style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body p-2 d-flex flex-column align-items-center"
                                style=" cursor: pointer;background-color: rgb(255, 255, 255); border-radius: 12px;transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 3px 5px 6px #000;">
                                {{-- Category Image --}}
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                    class="img-fluid mb-2 rounded"
                                    onclick="window.location.href='{{ route('category.products', $category->id) }}'"
                                    style="height: 160px; object-fit: contain; width: 200px; border-radius: 10px;">

                                {{-- Category Name --}}
                                <h6 class="fw-semibold text-dark mb-1">{{ $category->name }}</h6>

                                {{-- Discount (example random here) --}}
                                <b class="text-success fw-bold mb-1" style="font-size: 14px;">
                                    {{ $category->discount ?? 'UP TO 70% OFF' }}
                                </b>

                                {{-- Shop Now --}}
                                <h2 href="" class="text-primary fw-medium"
                                    style="font-size: 13px; font-weight: 700 ">
                                    SHOP NOW
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Banner Section End -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                        <li data-filter=".hot-sales">Hot Sales</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="product__item"
                            style="border-radius: 15px; overflow: hidden; background-color: #fff; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: relative;">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/' . $product->image) }}"
                                style="cursor: pointer; height: 300px; width: 100%; background-size: cover; background-position: center; position: relative; transition: transform 0.3s ease;"
                                onclick="window.location.href='{{ route('product.details', $product->id) }}'">

                                <div class="product__actions"
                                    style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 12px;">
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="border: none; background: rgba(255,255,255,0.95); 
                                           border-radius: 50%; width: 40px; height: 40px; 
                                           display: flex; align-items: center; justify-content: center;
                                           box-shadow: 0 3px 8px rgba(0,0,0,0.15); transition: all 0.2s ease;
                                           transform: translateY(0);">
                                            <img src="{{ asset('img/icon/heart.png') }}" alt="wishlist"
                                                style="width: 20px; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));">
                                        </button>
                                    </form>
                                    <a href="simileir"
                                        style="background: rgba(255,255,255,0.95); border-radius: 50%; 
                                  width: 40px; height: 40px; display: flex; align-items: center; 
                                  justify-content: center; box-shadow: 0 3px 8px rgba(0,0,0,0.15);
                                  transition: all 0.2s ease; transform: translateY(0);">
                                        <img src="{{ asset('img/icon/compare.png') }}" alt="compare"
                                            style="width: 20px; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));">
                                    </a>
                                </div>
                            </div>

                            <div class="product__item__text" style="padding: 20px; position: relative;">
                                <div style="margin-bottom: 12px;">
                                    <h6 style="margin: 0; font-weight: 600; font-size: 1.05rem;">
                                        <a href="{{ route('product.details', $product->id) }}"
                                            style="color: #2d3748; text-decoration: none; transition: color 0.2s ease;">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                </div>
                                <h5 style="color: #3b82f6; font-weight: 700; margin: 0; font-size: 1.25rem;">
                                    ₹{{ number_format($product->price) }}
                                </h5>

                            </div>

                            <!-- Hover Effects -->
                            <style>
                                .product__item:hover {
                                    transform: translateY(-5px);
                                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                                }

                                .product__item:hover .product__item__pic {
                                    transform: scale(1.03);
                                }

                                button:hover,
                                .product__actions a:hover {
                                    transform: translateY(-2px);
                                    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
                                }

                                .product__item__text a:hover {
                                    color: #3b82f6;
                                }
                            </style>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Categories Section Begin -->

    <!-- Categories Section End -->
@endsection
