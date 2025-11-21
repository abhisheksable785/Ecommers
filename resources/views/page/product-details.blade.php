@extends('layout.front.app')
@section('title', $product->name)

@section('content')
<style>
    :root {
        --primary-color: #1a1a1a;
        --accent-color: #3b82f6;
        --text-color: #4a5568;
        --bg-light: #f8f9fa;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pd-wrapper {
        padding: 4rem 0;
        background-color: #fff;
    }

    /* Gallery Styles */
    .gallery-container {
        position: sticky;
        top: 100px;
    }

    .main-image-frame {
        border-radius: 20px;
        overflow: hidden;
        background: #f8f9fa;
        margin-bottom: 1.5rem;
        position: relative;
        aspect-ratio: 4/5;
        cursor: zoom-in;
    }

    .main-image-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .main-image-frame:hover img {
        transform: scale(1.5);
    }

    .thumb-strip {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .thumb-item {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .thumb-item.active {
        border-color: var(--primary-color);
    }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info Styles */
    .product-brand {
        font-size: 1rem;
        font-weight: 700;
        color: var(--accent-color);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.5rem;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .rating-badge {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary-color);
    }

    .rating-badge i {
        color: #fbbf24;
        margin-right: 0.3rem;
    }

    .price-block {
        margin: 2rem 0;
        display: flex;
        align-items: baseline;
        gap: 1rem;
    }

    .current-price {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .mrp-price {
        font-size: 1.1rem;
        color: #9ca3af;
        text-decoration: line-through;
    }

    .discount-badge {
        background: #dcfce7;
        color: #166534;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* Size Selector */
    .size-selector {
        margin-bottom: 2.5rem;
    }

    .size-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .size-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .size-btn {
        width: 60px;
        height: 60px;
        border: 1px solid #e2e8f0;
        background: #fff;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .size-btn:hover {
        border-color: var(--primary-color);
    }

    .size-btn.active {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

    .size-btn span {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .size-btn small {
        font-size: 0.7rem;
        opacity: 0.8;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .btn-bag {
        flex: 1;
        background: var(--primary-color);
        color: #fff;
        border: none;
        padding: 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        transition: var(--transition);
    }

    .btn-bag:hover {
        background: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }

    .btn-wishlist {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary-color);
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-wishlist:hover {
        border-color: var(--primary-color);
        background: #f8f9fa;
    }

    /* Details Accordion */
    .details-accordion {
        border-top: 1px solid #e2e8f0;
    }

    .accordion-item {
        border-bottom: 1px solid #e2e8f0;
    }

    .accordion-header {
        padding: 1.5rem 0;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .accordion-content {
        padding-bottom: 1.5rem;
        color: var(--text-color);
        line-height: 1.6;
        display: none;
    }

    .accordion-content.active {
        display: block;
    }

    @media (max-width: 991px) {
        .gallery-container {
            position: static;
            margin-bottom: 3rem;
        }
        
        .product-title {
            font-size: 2rem;
        }
    }
</style>

<div class="pd-wrapper">
    <div class="container">
        <div class="row">
            <!-- Gallery Section -->
            <div class="col-lg-6">
                <div class="gallery-container">
                    <div class="main-image-frame" id="mainImageFrame">
                        <img id="mainProductImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    
                    @php
                        $gallery = json_decode($product->pics, true) ?: [];
                        // Add main image to gallery if not present
                        if (!in_array($product->image, $gallery)) {
                            array_unshift($gallery, $product->image);
                        }
                    @endphp

                    @if (count($gallery) > 0)
                        <div class="thumb-strip">
                            @foreach ($gallery as $index => $img)
                                <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" 
                                     onclick="updateMainImage('{{ asset('storage/' . $img) }}', this)">
                                    <img src="{{ asset('storage/' . $img) }}" alt="Product View">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-5 offset-lg-1">
                <div class="product-info">
                    <div class="product-brand">{{ $product->brand ?? 'Premium Collection' }}</div>
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rating-badge">
                            <i class="fa fa-star"></i> 4.5
                        </div>
                        <span class="text-muted small">128 Reviews</span>
                    </div>

                    <div class="price-block">
                        <span class="current-price">₹{{ number_format($product->price) }}</span>
                        @if($product->mrp > $product->price)
                            <span class="mrp-price">₹{{ number_format($product->mrp) }}</span>
                            <span class="discount-badge">{{ round((($product->mrp - $product->price) / $product->mrp) * 100) }}% OFF</span>
                        @endif
                    </div>

                    <div class="size-selector">
                        <div class="size-header">
                            <span>Select Size</span>
                            <a href="#" class="text-decoration-underline text-dark small">Size Guide</a>
                        </div>
                        <div class="size-grid">
                            @foreach ([38, 40, 42, 44, 46, 48] as $size)
                                <div class="size-btn" onclick="selectSize(this, '{{ $size }}')">
                                    <span>{{ $size }}</span>
                                    <small>EU</small>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="action-buttons">
                        <form action="{{ route('bag.add') }}" method="POST" class="flex-grow-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="size" id="selected-size-input" value="">
                            <button type="submit" class="btn-bag" id="addToBagBtn">
                                <i class="fa fa-shopping-bag"></i> Add to Bag
                            </button>
                        </form>

                        <form action="{{ route('wishlist.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-wishlist" title="Add to Wishlist">
                                <i class="fa {{ $isWishlisted ? 'fa-heart' : 'fa-heart-o' }}" 
                                   style="{{ $isWishlisted ? 'color: #ef4444;' : '' }}"></i>
                            </button>
                        </form>
                    </div>

                    <div class="details-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                Description
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="accordion-content active">
                                <p>{{ $product->description }}</p>
                                <p>Designed for modern living, this piece combines style with functionality. Made from premium materials to ensure durability and comfort.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                Material & Care
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <ul class="list-unstyled">
                                    <li>• 100% Premium Cotton</li>
                                    <li>• Machine wash cold</li>
                                    <li>• Do not bleach</li>
                                    <li>• Tumble dry low</li>
                                </ul>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                Shipping & Returns
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Free shipping on orders over ₹999. Easy returns within 30 days of delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <div style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;" class="animate__animated animate__fadeInUp">
        <div class="alert alert-success shadow-lg border-0 rounded-lg px-4 py-3">
            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    </div>
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
@endif

<script>
    // Image Gallery
    function updateMainImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    // Size Selection
    function selectSize(element, size) {
        document.querySelectorAll('.size-btn').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selected-size-input').value = size;
    }

    // Accordion
    function toggleAccordion(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('i');
        
        // Close other items
        document.querySelectorAll('.accordion-content').forEach(item => {
            if (item !== content) {
                item.classList.remove('active');
                item.previousElementSibling.querySelector('i').classList.remove('fa-minus');
                item.previousElementSibling.querySelector('i').classList.add('fa-plus');
            }
        });

        content.classList.toggle('active');
        if (content.classList.contains('active')) {
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-minus');
        } else {
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        }
    }

    // Add to Bag Validation
    document.getElementById('addToBagBtn').addEventListener('click', function(e) {
        const sizeInput = document.getElementById('selected-size-input');
        if (!sizeInput.value) {
            e.preventDefault();
            alert('Please select a size first');
            document.querySelector('.size-selector').scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Zoom Effect
    const mainImageFrame = document.getElementById('mainImageFrame');
    const mainImage = document.getElementById('mainProductImage');

    mainImageFrame.addEventListener('mousemove', function(e) {
        const { left, top, width, height } = this.getBoundingClientRect();
        const x = (e.clientX - left) / width;
        const y = (e.clientY - top) / height;

        mainImage.style.transformOrigin = `${x * 100}% ${y * 100}%`;
        mainImage.style.transform = 'scale(1.5)';
    });

    mainImageFrame.addEventListener('mouseleave', function() {
        mainImage.style.transform = 'scale(1)';
        setTimeout(() => {
            mainImage.style.transformOrigin = 'center center';
        }, 300);
    });
</script>

@endsection
