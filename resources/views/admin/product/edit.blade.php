@extends('layout.back.master')
@section('title','Product-Edit')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">eCommerce /</span><span class="fw-medium"> Edit Product</span>
    </h4>

    <div class="app-ecommerce">
        <!-- Header Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Edit Product</h4>
                <p class="text-muted">Update product information</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-label-secondary">Cancel</a>
                    <button type="submit" form="productEditForm" name="action" value="draft" class="btn btn-label-primary">Save as draft</button>
                </div>
                <button type="submit" form="productEditForm" name="action" value="publish" class="btn btn-primary">Update & Publish</button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="productEditForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Hidden input for removing gallery images -->
            <input type="hidden" name="remove_pics" id="remove_pics" value="">

            <div class="row">
                <!-- First column -->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="product-name">Name</label>
                                <input type="text" class="form-control" id="product-name" name="name" 
                                       placeholder="Product title" value="{{ old('name', $product->name) }}" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="product-sku">SKU</label>
                                    <input type="text" class="form-control" id="product-sku" name="sku" 
                                           placeholder="SKU-001" value="{{ old('sku', $product->sku) }}">
                                </div>
                                <div class="col">
                                    <label class="form-label" for="product-barcode">Barcode</label>
                                    <input type="text" class="form-control" id="product-barcode" name="barcode" 
                                           placeholder="0123-4567" value="{{ old('barcode', $product->barcode) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="product-description">Description</label>
                                <textarea class="form-control" id="product-description" name="description" 
                                          rows="5" placeholder="Product description..." required>{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Information -->

                    <!-- Media -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0 card-title">Product Media</h5>
                        </div>
                        <div class="card-body">
                            <!-- Current Main Image -->
                            <div class="mb-3">
                                <label class="form-label">Current Main Image</label>
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded border"
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                </div>
                            </div>

                            <!-- Upload New Main Image -->
                            <div class="mb-3">
                                <label class="form-label">Change Main Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>

                            <!-- Current Gallery Images -->
                            @php
                                $gallery = json_decode($product->gallery_images, true);
                            @endphp
                            @if($gallery && count($gallery) > 0)
                            <div class="mb-3">
                                <label class="form-label">Current Gallery Images</label>
                                <div class="d-flex gap-2 flex-wrap" id="gallery-container">
                                    @foreach ($gallery as $index => $img)
                                        <div class="position-relative gallery-image-item" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/' . $img) }}" 
                                                 class="rounded border"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm position-absolute remove-gallery-img" 
                                                    data-img-index="{{ $index }}"
                                                    style="top: -8px; right: -8px; width: 24px; height: 24px; padding: 0; border-radius: 50%;">
                                                <i class="ti ti-x" style="font-size: 14px;"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Add New Gallery Images -->
                            <div class="mb-3">
                                <label class="form-label">Add Gallery Images</label>
                                <input type="file" name="pics[]" class="form-control" accept="image/*" multiple>
                                <small class="text-muted">Upload multiple images for product gallery</small>
                            </div>
                        </div>
                    </div>
                    <!-- /Media -->

                    <!-- Variants -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Variants</h5>
                        </div>
                        <div class="card-body">
                            <div id="variants-container">
                                @php
                                    $variants = json_decode($product->variants, true) ?? [];
                                @endphp
                                
                                @if(count($variants) > 0)
                                    @foreach($variants as $variant)
                                    <div class="variant-item mb-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Option Type</label>
                                                <select class="form-select" name="variant_type[]">
                                                    <option value="">Select Type</option>
                                                    <option value="size" {{ $variant['type'] == 'size' ? 'selected' : '' }}>Size</option>
                                                    <option value="color" {{ $variant['type'] == 'color' ? 'selected' : '' }}>Color</option>
                                                    <option value="weight" {{ $variant['type'] == 'weight' ? 'selected' : '' }}>Weight</option>
                                                    <option value="material" {{ $variant['type'] == 'material' ? 'selected' : '' }}>Material</option>
                                                </select>
                                            </div>
                                            <div class="col-md-7 mb-2">
                                                <label class="form-label">Value</label>
                                                <input type="text" class="form-control" name="variant_value[]" 
                                                       value="{{ $variant['value'] }}" placeholder="Enter value">
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="variant-item mb-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Option Type</label>
                                                <select class="form-select" name="variant_type[]">
                                                    <option value="">Select Type</option>
                                                    <option value="size">Size</option>
                                                    <option value="color">Color</option>
                                                    <option value="weight">Weight</option>
                                                    <option value="material">Material</option>
                                                </select>
                                            </div>
                                            <div class="col-md-7 mb-2">
                                                <label class="form-label">Value</label>
                                                <input type="text" class="form-control" name="variant_value[]" 
                                                       placeholder="Enter value">
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary" id="add-variant">
                                <i class="ti ti-plus me-1"></i>Add another option
                            </button>
                        </div>
                    </div>
                    <!-- /Variants -->
<!-- Size Chart -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Size Chart</h5>
        <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-light" id="selectAllSizes">
            <i class="ti ti-checks me-1"></i> Select All
        </button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label mb-3">Select Available Sizes</label>
            <div class="demo-inline-spacing">
                @php
                    $productSizes = $product->sizes ?? [];
                @endphp
                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'] as $size)
                <div class="form-check form-check-inline form-check-primary custom-option custom-option-basic">
                    <label class="form-check-label custom-option-content" for="size-{{ $size }}">
                        <input class="form-check-input size-checkbox" type="checkbox" name="sizes[]" 
                               value="{{ $size }}" id="size-{{ $size }}"
                               {{ in_array($size, old('sizes', $productSizes)) ? 'checked' : '' }}>
                        <span class="custom-option-body">
                            <span class="custom-option-title fw-bold fs-5">{{ $size }}</span>
                        </span>
                    </label>
                </div>
                @endforeach
            </div>
            @error('sizes')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<!-- /Size Chart -->

                    <!-- Inventory -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Inventory</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Navigation -->
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
                                <!-- /Navigation -->
                                
                                <!-- Options -->
                                <div class="col-12 col-md-8 pt-4 pt-md-0">
                                    <div class="tab-content p-0 ps-md-3">
                                        <!-- Stock Tab -->
                                        <div class="tab-pane fade show active" id="restock" role="tabpanel">
                                            <h6 class="mb-3">Stock Management</h6>
                                            <div class="mb-3">
                                                <label class="form-label" for="stock-quantity">Stock Quantity</label>
                                                <input type="number" class="form-control" id="stock-quantity" 
                                                       name="stock_quantity" placeholder="100" 
                                                       value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="low-stock">Low Stock Threshold</label>
                                                <input type="number" class="form-control" id="low-stock" 
                                                       name="low_stock_threshold" placeholder="10" 
                                                       value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 10) }}" min="0">
                                                <small class="text-muted">Alert when stock falls below this number</small>
                                            </div>
                                        </div>

                                        <!-- Shipping Tab -->
                                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                                            <h6 class="mb-4">Shipping Information</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Weight (kg)</label>
                                                    <input type="number" step="0.01" class="form-control" 
                                                           name="weight" placeholder="0.5" value="{{ old('weight', $product->weight) }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dimensions (cm)</label>
                                                    <input type="text" class="form-control" name="dimensions" 
                                                           placeholder="10x10x5" value="{{ old('dimensions', $product->dimensions) }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="free_shipping" 
                                                           id="free-shipping" {{ old('free_shipping', $product->free_shipping) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="free-shipping">
                                                        Free Shipping Available
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Attributes Tab -->
                                        <div class="tab-pane fade" id="attributes" role="tabpanel">
                                            <h6 class="mb-4">Product Attributes</h6>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_fragile" 
                                                       id="fragile" {{ old('is_fragile', $product->is_fragile) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fragile">
                                                    <span class="fw-medium">Fragile Product</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_featured" 
                                                       id="featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured">
                                                    <span class="fw-medium">Featured Product</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_new" 
                                                       id="new-arrival" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
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
                    <!-- /Inventory -->
                </div>
                <!-- /First column -->

                <!-- Second column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="product-price">Base Price (₹)</label>
                                <input type="number" step="0.01" class="form-control" id="product-price" 
                                       name="price" placeholder="999.00" value="{{ old('price', $product->price) }}" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="discount-price">Discounted Price (₹)</label>
                                <input type="number" step="0.01" class="form-control" id="discount-price" 
                                       name="discount_price" placeholder="799.00" value="{{ old('discount_price', $product->discount_price) }}" min="0">
                                <small class="text-muted">Leave empty if no discount</small>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="charge_tax" 
                                       id="charge-tax" {{ old('charge_tax', $product->charge_tax ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="charge-tax">
                                    Charge tax on this product
                                </label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <h6 class="mb-0">In Stock</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="in_stock" 
                                           id="in-stock" {{ old('in_stock', $product->in_stock ?? true) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Pricing Card -->

                    <!-- Organize Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Organize</h5>
                        </div>
                        <div class="card-body">
                            <!-- Gender -->
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Men" {{ old('gender', $product->gender) == 'Men' ? 'selected' : '' }}>Men</option>
                                    <option value="Women" {{ old('gender', $product->gender) == 'Women' ? 'selected' : '' }}>Women</option>
                                    <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                    <option value="Kids" {{ old('gender', $product->gender) == 'Kids' ? 'selected' : '' }}>Kids</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_name" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_name', $product->category) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand -->
                            <div class="mb-3">
                                <label class="form-label" for="brand">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand" 
                                       placeholder="Enter brand name" value="{{ old('brand', $product->brand) }}">
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label class="form-label" for="product-tags">Tags</label>
                                <input type="text" class="form-control" id="product-tags" name="tags" 
                                       placeholder="e.g., Summer, Casual, Sale" value="{{ old('tags', $product->tags) }}">
                                <small class="text-muted">Separate tags with commas</small>
                            </div>
                        </div>
                    </div>
                    <!-- /Organize Card -->
                </div>
                <!-- /Second column -->
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery image removal
    const removedIndexes = [];
    const removePicsInput = document.getElementById('remove_pics');
    
    document.querySelectorAll('.remove-gallery-img').forEach(btn => {
        btn.addEventListener('click', function() {
            const imgIndex = this.getAttribute('data-img-index');
            const imgItem = this.closest('.gallery-image-item');
            
            if (!removedIndexes.includes(imgIndex)) {
                removedIndexes.push(imgIndex);
                removePicsInput.value = removedIndexes.join(',');
            }
            
            imgItem.style.display = 'none';
        });
    });

    // Add variant functionality
    document.getElementById('add-variant').addEventListener('click', function() {
        const container = document.getElementById('variants-container');
        const variantHTML = `
            <div class="variant-item mb-3">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Option Type</label>
                        <select class="form-select" name="variant_type[]">
                            <option value="">Select Type</option>
                            <option value="size">Size</option>
                            <option value="color">Color</option>
                            <option value="weight">Weight</option>
                            <option value="material">Material</option>
                        </select>
                    </div>
                    <div class="col-md-7 mb-2">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control" name="variant_value[]" 
                               placeholder="Enter value">
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-variant">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', variantHTML);
    });

    // Remove variant functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant') || e.target.closest('.remove-variant')) {
            const variantItem = e.target.closest('.variant-item');
            if (document.querySelectorAll('.variant-item').length > 1) {
                variantItem.remove();
            } else {
                alert('At least one variant option is required');
            }
        }
    });
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllBtn = document.getElementById('selectAllSizes');
    const sizeCheckboxes = document.querySelectorAll('.size-checkbox');
    
    selectAllBtn.addEventListener('click', function() {
        const allChecked = Array.from(sizeCheckboxes).every(checkbox => checkbox.checked);
        
        sizeCheckboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
        
        // Update button text
        if (allChecked) {
            selectAllBtn.innerHTML = '<i class="fas fa-check-double me-1"></i> Select All';
        } else {
            selectAllBtn.innerHTML = '<i class="fas fa-times me-1"></i> Deselect All';
        }
    });
    
    // Update button text on individual checkbox change
    sizeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(sizeCheckboxes).every(cb => cb.checked);
            if (allChecked) {
                selectAllBtn.innerHTML = '<i class="fas fa-times me-1"></i> Deselect All';
            } else {
                selectAllBtn.innerHTML = '<i class="fas fa-check-double me-1"></i> Select All';
            }
        });
    });
});
</script>

@endsection