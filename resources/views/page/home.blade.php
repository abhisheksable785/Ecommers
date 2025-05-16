@extends('layout.front.app')
@section('title','Home')
@section('content')

 <!-- Hero Section Begin -->
 <section class="hero">
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
    <div class="container" >
        <div class="row" >
            
            @foreach ($categories as $category)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4" >
                    <div class="card text-center border-0 shadow-sm" >
                        <div class="card-body p-2 d-flex flex-column align-items-center" style="background-color: rgb(255, 255, 255); border-radius: 12px; box-shadow: 3px 5px 6px #000;">
                            {{-- Category Image --}}
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                class="img-fluid mb-2 rounded"
                                style="height: 160px; object-fit: contain; width: 100%; border-radius: 10px;">

                            {{-- Category Name --}}
                            <h6 class="fw-semibold text-dark mb-1">{{ $category->name }}</h6>

                            {{-- Discount (example random here) --}}
                            <b class="text-success fw-bold mb-1" style="font-size: 14px;">
                                {{ $category->discount ?? 'UP TO 70% OFF' }}
                            </b>

                            {{-- Shop Now --}}
                           <h2 href="" class="text-primary fw-medium" style="font-size: 13px; font-weight: 700 ">
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


 <!-- Categories Section Begin -->

<!-- Categories Section End -->
@endsection