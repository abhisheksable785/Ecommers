@extends('layout.front.app')
@section('title', $product->name)

@section('content')
<style>
    .product__details__pic {
        border: 1px solid #eee;
        border-radius: 8px;
        width: 100%;
        background-color: #f8f9fa;
        b
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
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic" style="border-image:">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3 class="fw-bold">{{ $product->brand ?? 'BRAND NAME' }}</h3>
                    <p class="text-muted">{{ $product->name }}</p>
            
                    <!-- Rating -->
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-success">4.1 ★</span>
                        <span class="text-muted">23 Ratings</span>
                    </div>
            
                    <!-- Price & Discount -->
                    <div class="mb-2">
                        <span class="h4 fw-bold text-dark">₹{{ $product->price }}</span>
                        <span class="text-muted text-decoration-line-through ms-2">₹{{ $product->mrp ?? 1999 }}</span>
                        <span class="text-danger ms-2">(Rs. {{ ($product->mrp ?? 1999) - $product->price }} OFF)</span>
                    </div>
            
                    <div class="text-success mb-3">inclusive of all taxes</div>
            
                    <!-- Size Selection -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>SELECT SIZE</strong>
                            <a href="#" class="text-danger small fw-semibold">SIZE CHART ></a>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach([38, 40, 42, 44, 46, 48, 50, 52] as $size)
                                <button class="btn btn-outline-secondary rounded-pill px-3 py-1">
                                    {{ $size }} <br>
                                    <small>Rs. {{ $size > 46 ? 799 : 699 }}</small>
                                </button>
                            @endforeach
                        </div>
                    </div>
            
                    <!-- Action Buttons -->
                                    <!-- Action Buttons with more space -->
                  <!-- Action Buttons -->
                  <div class="d-flex mt-4 gap-3">
                    <form action="{{ route('bag.add') }}" method="POST" class="w-50">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <input type="hidden" name="size" id="selected-size">
                        <input type="hidden" name="color" id="selected-color">
                        
                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold" style="margin-right: 20px">
                            <i class="bi bi-bag-fill me-1"></i> ADD TO BAG
                        </button>
                    </form>
                    
                    <form action="{{ route('wishlist.add') }}" method="POST" class="w-50">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-secondary w-100 py-2 fw-semibold">
                            <i class="bi bi-heart me-1"></i> WISHLIST
                        </button>
                    </form>
                </div>
                
            
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection
<script>
    document.querySelectorAll('.size-select').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.size-select').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            document.getElementById('selected-size').value = this.dataset.size;
        });
    });
    
    // Similar for color selection if you have it
    </script>