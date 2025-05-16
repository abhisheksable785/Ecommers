@extends('layout.front.app')
@section('title', $product->name)

@section('content')
<style>
    .product__details__pic {
        border: 1px solid #eee;
        border-radius: 12px;
        background-color: #f8f9fa;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .product__details__pic:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .product__details__pic img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .size-btn.active {
        background: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
    }

    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        min-width: 250px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        border-left: 4px solid #4CAF50;
        display: none;
    }

    @media (max-width: 992px) {
        .product__details__pic {
            height: 400px !important;
            margin-bottom: 30px;
        }
    }

    @media (max-width: 768px) {
        .product__details__pic {
            height: 350px !important;
        }
    }
</style>

<!-- Success Toast -->
<div class="toast-notification p-3">
    <div class="d-flex align-items-center">
        <div class="me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#4CAF50">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="flex-grow-1">
            <strong class="me-auto">Success!</strong>
            <div id="toast-message"></div>
        </div>
        <button type="button" class="btn-close" onclick="hideToast()"></button>
    </div>
</div>

<section class="product-details spad">
    <div class="container">
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('success') }}');
            });
        </script>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3 class="fw-bold mb-3">{{ $product->brand ?? 'BRAND NAME' }}</h3>
                    <p class="text-muted h5 mb-4">{{ $product->name }}</p>

                    <!-- Rating -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-success px-3 py-2">4.1 ★</span>
                        <span class="text-muted">23 Ratings</span>
                    </div>

                    <!-- Price Section -->
                    <div class="bg-light p-3 rounded mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="h3 fw-bold text-danger">₹{{ $product->price }}</span>
                            <span class="text-muted text-decoration-line-through">₹{{ $product->mrp ?? 1999 }}</span>
                            <span class="text-success fw-semibold">Save ₹{{ ($product->mrp ?? 1999) - $product->price }}</span>
                        </div>
                        <div class="text-success small mt-1">Inclusive of all taxes</div>
                    </div>

                    <!-- Size Selection -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="h6">SELECT SIZE</strong>
                            <a href="#" class="text-danger small fw-semibold">SIZE CHART →</a>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach([38, 40, 42, 44, 46, 48, 50, 52] as $size)
                                <button class="btn btn-outline-dark size-select rounded-1 px-4 py-2 position-relative"
                                        data-size="{{ $size }}">
                                    {{ $size }}
                                    <small class="position-absolute bottom-0 start-50 translate-x-n50 text-muted small" 
                                            style="font-size: 0.7rem; line-height: 1">
                                        ₹{{ $size > 46 ? 799 : 699 }}
                                    </small>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex mt-5 gap-3">
                        <form action="{{ route('bag.add') }}" method="POST" class="w-50">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="size" id="selected-size" value="{{ $product->size }}">
                            <input type="hidden" name="color" id="selected-color">
                            
                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-1">
                                <i class="bi bi-bag-fill me-2"></i> ADD TO BAG
                            </button>
                        </form>
                        
                        <form action="{{ route('wishlist.add') }}" method="POST" class="w-50">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-dark w-100 py-3 fw-bold rounded-1">
                                <i class="bi bi-heart me-2"></i> WISHLIST
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Size Selection
    document.querySelectorAll('.size-select').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.size-select').forEach(btn => {
                btn.classList.remove('active', 'btn-primary');
                btn.classList.add('btn-outline-dark');
            });
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-dark');
            document.getElementById('selected-size').value = this.dataset.size;
        });
    });

    // Toast Notification
    function showToast(message) {
        const toast = document.querySelector('.toast-notification');
        const toastMessage = document.getElementById('toast-message');
        toastMessage.textContent = message;
        toast.style.display = 'block';
        setTimeout(hideToast, 3000);
    }

    function hideToast() {
        document.querySelector('.toast-notification').style.display = 'none';
    }

    // Auto-hide toast after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        if(document.querySelector('.toast-notification').style.display === 'block') {
            setTimeout(hideToast, 3000);
        }
    });
</script>
@endsection