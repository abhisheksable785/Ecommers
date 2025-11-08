@extends('layout.back.master')
@section('title', 'View Product')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">eCommerce /</span><span class="fw-medium"> View Product Details</span>
    </h4>

    <div class="app-ecommerce">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Product Details</h4>
                <p class="text-muted">View product information (Read Only)</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Product List</a>
                </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-name">Name</label>
                            <input type="text" class="form-control" id="product-name" value="{{ $product->name }}" disabled>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label" for="product-sku">SKU</label>
                                <input type="text" class="form-control" id="product-sku" value="{{ $product->sku }}" disabled>
                            </div>
                            <div class="col">
                                <label class="form-label" for="product-barcode">Barcode</label>
                                <input type="text" class="form-control" id="product-barcode" value="{{ $product->barcode }}" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="product-description">Description</label>
                            <textarea class="form-control" id="product-description" rows="5" readonly>{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">Product Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Main Image</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="rounded border"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                        @php
                            $gallery = json_decode($product->gallery_images, true);
                        @endphp
                        @if($gallery && count($gallery) > 0)
                        <div class="mb-3">
                            <label class="form-label">Gallery Images</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($gallery as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $img) }}"
                                             class="rounded border"
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Variants</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $variants = json_decode($product->variants, true) ?? [];
                        @endphp

                        @if(count($variants) > 0)
                            @foreach($variants as $variant)
                            <div class="variant-item mb-3">
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        <label class="form-label">Option Type</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($variant['type']) }}" disabled>
                                    </div>
                                    <div class="col-md-7 mb-2">
                                        <label class="form-label">Value</label>
                                        <input type="text" class="form-control" value="{{ $variant['value'] }}" disabled>
                                    </div>
                                    </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No variants configured for this product.</p>
                        @endif
                        </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Inventory</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 mx-auto card-separator">
                                <div class="d-flex justify-content-between flex-column mb-3 mb-md-0 pe-md-3">
                                    <ul class="nav nav-align-left nav-pills flex-column">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link py-2 active" data-bs-toggle="tab" data-bs-target="#restock">
                                                <i class="ti ti-box me-2"></i>
                                                <span class="align-middle">Stock</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#shipping">
                                                <i class="ti ti-car me-2"></i>
                                                <span class="align-middle">Shipping</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#attributes">
                                                <i class="ti ti-link me-2"></i>
                                                <span class="align-middle">Attributes</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 pt-4 pt-md-0">
                                <div class="tab-content p-0 ps-md-3">
                                    <div class="tab-pane fade show active" id="restock" role="tabpanel">
                                        <h6 class="mb-3">Stock Management</h6>
                                        <div class="mb-3">
                                            <label class="form-label" for="stock-quantity">Stock Quantity</label>
                                            <input type="number" class="form-control" id="stock-quantity" value="{{ $product->stock_quantity }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="low-stock">Low Stock Threshold</label>
                                            <input type="number" class="form-control" id="low-stock" value="{{ $product->low_stock_threshold }}" disabled>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                                        <h6 class="mb-4">Shipping Information</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Weight (kg)</label>
                                                <input type="text" class="form-control" value="{{ $product->weight }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dimensions (cm)</label>
                                                <input type="text" class="form-control" value="{{ $product->dimensions }}" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="free-shipping" {{ $product->free_shipping ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="free-shipping">Free Shipping Available</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="attributes" role="tabpanel">
                                        <h6 class="mb-4">Product Attributes</h6>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="fragile" {{ $product->is_fragile ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="fragile">
                                                <span class="fw-medium">Fragile Product</span>
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="featured" {{ $product->is_featured ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="featured">
                                                <span class="fw-medium">Featured Product</span>
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="new-arrival" {{ $product->is_new ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="new-arrival">
                                                <span class="fw-medium">New Arrival</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pricing</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-price">Base Price (₹)</label>
                            <input type="text" class="form-control" id="product-price" value="{{ $product->price }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="discount-price">Discounted Price (₹)</label>
                            <input type="text" class="form-control" id="discount-price" value="{{ $product->discount_price }}" disabled>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="charge-tax" {{ $product->charge_tax ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="charge-tax">Charge tax on this product</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <h6 class="mb-0">In Stock</h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="in-stock" {{ $product->in_stock ? 'checked' : '' }} disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Organize</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" disabled>
                                <option selected>{{ $product->gender }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" disabled>
                                @foreach($categories as $category)
                                    @if($product->category == $category->id)
                                         <option selected>{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" value="{{ $product->brand }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" disabled>
                                <option selected>{{ ucfirst($product->status) }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product-tags">Tags</label>
                            <input type="text" class="form-control" id="product-tags" value="{{ $product->tags }}" disabled>
                        </div>
                    </div>
                </div>
                </div>
            </div>
    </div>
</div>

@endsection