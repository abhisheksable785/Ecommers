@extends('layout.back.master')
@section('title','Product-Add')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">eCommerce /</span><span class="fw-medium"> Add Product</span>
    </h4>

    <div class="app-ecommerce">
        <!-- Header Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Add a new Product</h4>
                <p class="text-muted">Create and manage your store products</p>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-label-secondary">Discard</a>
                    <button type="submit" form="productForm" name="action" value="draft" class="btn btn-label-primary">Save draft</button>
                </div>
                <button type="submit" form="productForm" name="action" value="publish" class="btn btn-primary">Publish product</button>
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
                <h6 class="mb-2">Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                <label class="form-label" for="product-name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="product-name" name="name" 
                                       placeholder="Product title" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="product-sku">SKU</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" id="product-sku" name="sku" 
                                           placeholder="SKU-001" value="{{ old('sku') }}">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label" for="product-barcode">Barcode</label>
                                    <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="product-barcode" name="barcode" 
                                           placeholder="0123-4567" value="{{ old('barcode') }}">
                                    @error('barcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label" for="product-description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="product-description" name="description" 
                                          rows="5" placeholder="Product description..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                            <div class="mb-3">
                                <label class="form-label">Main Product Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Upload main product image (Required, Max: 2MB)</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" name="pics[]" class="form-control @error('pics') is-invalid @enderror @error('pics.*') is-invalid @enderror" accept="image/*" multiple>
                                @error('pics')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('pics.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Upload multiple images for product gallery (Optional, Max: 2MB each)</small>
                            </div>
                        </div>
                    </div>
                    <!-- /Media -->

                    <!-- Variants -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Variants (Optional)</h5>
                        </div>
                        <div class="card-body">
                            <div id="variants-container">
                                <div class="variant-item mb-3">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Option Type</label>
                                            <select class="form-select @error('variant_type.0') is-invalid @enderror" name="variant_type[]">
                                                <option value="">Select Type</option>
                                                <option value="size">Size</option>
                                                <option value="color">Color</option>
                                                <option value="weight">Weight</option>
                                                <option value="material">Material</option>
                                            </select>
                                        </div>
                                        <div class="col-md-7 mb-2">
                                            <label class="form-label">Value</label>
                                            <input type="text" class="form-control @error('variant_value.0') is-invalid @enderror" name="variant_value[]" 
                                                   placeholder="Enter value (e.g., Small, Red, 100g)">
                                        </div>
                                        <div class="col-md-1 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="add-variant">
                                <i class="ti ti-plus me-1"></i>Add another option
                            </button>
                        </div>
                    </div>
                    <!-- /Variants -->

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
                                                <label class="form-label" for="stock-quantity">Stock Quantity <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock-quantity" 
                                                       name="stock_quantity" placeholder="100" 
                                                       value="{{ old('stock_quantity') }}" required min="0">
                                                @error('stock_quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="low-stock">Low Stock Threshold</label>
                                                <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" id="low-stock" 
                                                       name="low_stock_threshold" placeholder="10" 
                                                       value="{{ old('low_stock_threshold', 10) }}" min="0">
                                                @error('low_stock_threshold')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Alert when stock falls below this number</small>
                                            </div>
                                        </div>

                                        <!-- Shipping Tab -->
                                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                                            <h6 class="mb-4">Shipping Information</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Weight (kg)</label>
                                                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                                           name="weight" placeholder="0.5" value="{{ old('weight') }}">
                                                    @error('weight')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dimensions (cm)</label>
                                                    <input type="text" class="form-control @error('dimensions') is-invalid @enderror" name="dimensions" 
                                                           placeholder="10x10x5" value="{{ old('dimensions') }}">
                                                    @error('dimensions')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="free_shipping" 
                                                           id="free-shipping" value="1" {{ old('free_shipping') ? 'checked' : '' }}>
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
                                                       id="fragile" value="1" {{ old('is_fragile') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fragile">
                                                    <span class="fw-medium">Fragile Product</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_featured" 
                                                       id="featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured">
                                                    <span class="fw-medium">Featured Product</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_new" 
                                                       id="new-arrival" value="1" {{ old('is_new') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="new-arrival">
                                                    <span class="fw-medium">New Arrival</span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- /Attributes Tab -->
                                    </div>
                                </div>
                                <!-- /Options -->
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
                                <label class="form-label" for="product-price">Base Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="product-price" 
                                       name="price" placeholder="999.00" value="{{ old('price') }}" required min="0">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="discount-price">Discounted Price (₹)</label>
                                <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" id="discount-price" 
                                       name="discount_price" placeholder="799.00" value="{{ old('discount_price') }}" min="0">
                                @error('discount_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty if no discount</small>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="charge_tax" value="1"
                                       id="charge-tax" {{ old('charge_tax', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="charge-tax">
                                    Charge tax on this product
                                </label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <h6 class="mb-0">In Stock</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="in_stock" value="1"
                                           id="in-stock" {{ old('in_stock', true) ? 'checked' : '' }}>
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
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Select Gender</option>
                                    <option value="Men" {{ old('gender') == 'Men' ? 'selected' : '' }}>Men</option>
                                    <option value="Women" {{ old('gender') == 'Women' ? 'selected' : '' }}>Women</option>
                                    <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                    <option value="Kids" {{ old('gender') == 'Kids' ? 'selected' : '' }}>Kids</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between align-items-center">
                                    <span>Category <span class="text-danger">*</span></span>
                                    <a href="{{ route('category.create') }}" class="fw-medium small">Add new category</a>
                                </label>
                                <select name="category_name" class="form-select @error('category_name') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_name') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Brand -->
                            <div class="mb-3">
                                <label class="form-label" for="brand">Brand</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" 
                                       placeholder="Enter brand name" value="{{ old('brand') }}">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label class="form-label" for="product-tags">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="product-tags" name="tags" 
                                       placeholder="e.g., Summer, Casual, Sale" value="{{ old('tags') }}">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

@endsection