@extends('layout.front.app')
@section('title', 'Home')
@section('content')

<style>
    :root {
        --primary-color: #1a1a1a;
        --accent-color: #3b82f6;
        --text-color: #4a5568;
        --bg-light: #f8f9fa;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Nunito Sans', sans-serif;
        color: var(--text-color);
    }

    /* Hero Section */
    .hero-modern {
        position: relative;
        height: 85vh;
        min-height: 600px;
        overflow: hidden;
    }

    .hero-modern .hero__slider .hero__items {
        height: 85vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .hero-modern .hero__items::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 40%, rgba(255,255,255,0) 100%);
        z-index: 1;
    }

    .hero-modern .container {
        position: relative;
        z-index: 2;
    }

    .hero-modern h6 {
        color: var(--accent-color);
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 1rem;
        opacity: 0;
        animation: fadeInUp 0.8s forwards 0.3s;
    }

    .hero-modern h2 {
        font-size: 4.5rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.1;
        margin-bottom: 1.5rem;
        opacity: 0;
        animation: fadeInUp 0.8s forwards 0.5s;
    }

    .hero-modern p {
        font-size: 1.1rem;
        max-width: 500px;
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: fadeInUp 0.8s forwards 0.7s;
    }

    .btn-modern {
        display: inline-flex;
        align-items: center;
        padding: 1rem 2.5rem;
        background: var(--primary-color);
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        transition: var(--transition);
        opacity: 0;
        animation: fadeInUp 0.8s forwards 0.9s;
    }

    .btn-modern:hover {
        background: var(--accent-color);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    /* Categories Section */
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title span {
        color: var(--accent-color);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 0.5rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .category-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: var(--transition);
        height: 100%;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .category-card .img-wrapper {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-card .content {
        padding: 1.5rem;
        text-align: center;
    }

    .category-card h5 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
    }

    .category-card .discount {
        color: var(--accent-color);
        font-weight: 800;
        font-size: 0.9rem;
    }

    /* Product Section */
    .product-card-modern {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        transition: var(--transition);
        position: relative;
        margin-bottom: 2rem;
    }

    .product-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .product-card-modern .img-box {
        position: relative;
        height: 320px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .product-card-modern .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card-modern:hover .img-box img {
        transform: scale(1.05);
    }

    .product-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transform: translateX(20px);
        transition: var(--transition);
    }

    .product-card-modern:hover .product-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        background: var(--accent-color);
        color: #fff;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-category {
        font-size: 0.8rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: block;
        text-decoration: none;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--accent-color);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Filter Controls */
    .filter__controls {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .filter__controls li {
        display: inline-block;
        font-size: 1.1rem;
        font-weight: 700;
        color: #b7b7b7;
        margin: 0 15px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .filter__controls li.active,
    .filter__controls li:hover {
        color: var(--primary-color);
    }
</style>

<!-- Hero Section Begin -->
<section class="hero-modern">
    <div class="hero__slider owl-carousel">
        <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Summer Collection 2025</h6>
                            <h2>Elevate Your Style</h2>
                            <p>Discover our curated collection of luxury essentials. Ethically crafted with an unwavering commitment to exceptional quality and timeless design.</p>
                            <a href="{{ route('shop') }}" class="btn-modern">Shop Collection <i class="fa fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>New Arrivals</h6>
                            <h2>Fall - Winter 2025</h2>
                            <p>Experience the perfect blend of comfort and sophistication. Our new season pieces are designed to make a statement.</p>
                            <a href="{{ route('shop') }}" class="btn-modern">Explore Now <i class="fa fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container py-5">
        <div class="section-title">
            <span>Collections</span>
            <h2>Shop by Category</h2>
        </div>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="category-card" onclick="window.location.href='{{ route('category.products', $category->id) }}'">
                        <div class="img-wrapper">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                        </div>
                        <div class="content">
                            <h5>{{ $category->name }}</h5>
                            <span class="discount">{{ $category->discount ?? 'New Arrival' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="section-title">
            <span>Trending</span>
            <h2>Featured Products</h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All Products</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".hot-sales">Best Sellers</li>
                </ul>
            </div>
        </div>
        <div class="row product__filter">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product-card-modern">
                        <div class="img-box" onclick="window.location.href='{{ route('product.details', $product->id) }}'" style="cursor: pointer;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            <div class="product-actions">
                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn" title="Add to Wishlist">
                                        <i class="fa fa-heart-o"></i>
                                    </button>
                                </form>
                                <a href="#" class="action-btn" title="Compare">
                                    <i class="fa fa-exchange"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Clothing</div>
                            <a href="{{ route('product.details', $product->id) }}" class="product-title">{{ $product->name }}</a>
                            <div class="product-price">₹{{ number_format($product->price) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Product Section End -->

@if (session('success'))
    <div style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;" class="animate__animated animate__fadeInUp">
        <div class="alert alert-success shadow-lg border-0 rounded-lg">
            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    </div>
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
@endif

@endsection
