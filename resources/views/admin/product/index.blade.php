@extends('layout.back.master')
@section('title','Product-list')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">eCommerce /</span> Product List
    </h4>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                                <h6 class="mb-2">Total Products</h6>
                                <h4 class="mb-2">{{ $totalProducts ?? 0 }}</h4>
                                <p class="mb-0">
                                    <span class="text-muted me-2">All items</span>
                                    <span class="badge bg-label-success">Active</span>
                                </p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-shopping-cart text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4" />
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h6 class="mb-2">Published</h6>
                                <h4 class="mb-2">{{ $publishedProducts ?? 0 }}</h4>
                                <p class="mb-0">
                                    <span class="text-muted me-2">Live products</span>
                                    <span class="badge bg-label-success">Online</span>
                                </p>
                            </div>
                            <span class="avatar p-2 me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-eye text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h6 class="mb-2">Low Stock</h6>
                                <h4 class="mb-2">{{ $lowStockProducts ?? 0 }}</h4>
                                <p class="mb-0">
                                    <span class="text-muted">Need restock</span>
                                </p>
                            </div>
                            <span class="avatar p-2 me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-alert-triangle text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2">Out of Stock</h6>
                                <h4 class="mb-2">{{ $outOfStockProducts ?? 0 }}</h4>
                                <p class="mb-0">
                                    <span class="text-muted me-2">Not available</span>
                                    <span class="badge bg-label-danger">Critical</span>
                                </p>
                            </div>
                            <span class="avatar p-2">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-package-off text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Products</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Add Product
            </a>
        </div>

        <div class="card-header border-bottom">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <select name="stock" class="form-select">
                        <option value="">All Stock</option>
                        <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="card-datatable table-responsive">
            <table class="table border-top">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </th>
                        <th style="width: 80px;">Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th class="text-center">Stock</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-center">
                            <input class="form-check-input product-checkbox" type="checkbox" value="{{ $product->id }}">
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="rounded"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <h6 class="mb-0">{{ $product->name }}</h6>
                                <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                @if($product->is_featured)
                                    <span class="badge bg-label-warning badge-sm mt-1" style="width: fit-content;">Featured</span>
                                @endif
                                @if($product->is_new)
                                    <span class="badge bg-label-info badge-sm mt-1" style="width: fit-content;">New</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-label-primary">{{ $product->category_name }}</span>
                        </td>
                        <td class="text-center">
                            @if($product->stock_quantity == 0)
                                <span class="badge bg-label-danger">Out of Stock</span>
                            @elseif($product->stock_quantity <= $product->low_stock_threshold)
                                <span class="badge bg-label-warning">Low Stock</span>
                            @else
                                <span class="badge bg-label-success">In Stock</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">{{ $product->sku ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">₹{{ number_format($product->price, 2) }}</span>
                                @if($product->discount_price)
                                    <small class="text-muted text-decoration-line-through">₹{{ number_format($product->discount_price, 2) }}</small>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-label-secondary">{{ $product->stock_quantity }}</span>
                        </td>
                        <td class="text-center">
                            @if($product->status == 'published')
                                <span class="badge bg-label-success">Published</span>
                            @elseif($product->status == 'draft')
                                <span class="badge bg-label-warning">Draft</span>
                            @else
                                <span class="badge bg-label-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
                                        <i class="ti ti-eye me-2"></i> View
                                    </a>
                                    <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                        <i class="ti ti-pencil me-2"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button"
                                            class="dropdown-item text-danger delete-product-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteProductModal"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-delete-url="{{ route('products.destroy', $product->id) }}">
                                        <i class="ti ti-trash me-2"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="ti ti-package-off text-muted" style="font-size: 48px;"></i>
                                <h5 class="mt-3">No products found</h5>
                                <p class="text-muted">Start by adding your first product</p>
                                <a href="{{ route('products.create') }}" class="btn btn-primary mt-2">
                                    <i class="ti ti-plus me-1"></i> Add Product
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} entries
                </div>
                <div>
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle text-warning me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="ti ti-trash text-danger" style="font-size: 48px;"></i>
                </div>
                <p class="text-center mb-0">
                    Are you sure you want to delete the product
                    <strong id="delete_product_name" class="text-danger"></strong>?
                </p>
                <p class="text-center text-muted small mt-2">
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form id="deleteProductForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Individual checkbox change
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(productCheckboxes).some(cb => cb.checked);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Delete Modal Functionality
    const deleteModal = document.getElementById('deleteProductModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            const button = event.relatedTarget;

            // Extract info from data-* attributes
            const productName = button.getAttribute('data-product-name');
            const deleteUrl = button.getAttribute('data-delete-url');

            // Update the modal's content
            const modalProductName = deleteModal.querySelector('#delete_product_name');
            const deleteForm = deleteModal.querySelector('#deleteProductForm');

            modalProductName.textContent = productName;
            deleteForm.action = deleteUrl;
        });
    }
});
</script>

<style>
.card-widget-separator .card-widget-1::after,
.card-widget-separator .card-widget-2::after,
.card-widget-separator .card-widget-3::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 50%;
    width: 1px;
    background-color: rgba(0, 0, 0, 0.1);
}

@media (max-width: 991.98px) {
    .card-widget-separator .card-widget-1::after,
    .card-widget-separator .card-widget-2::after,
    .card-widget-separator .card-widget-3::after {
        display: none;
    }
}

.table td {
    vertical-align: middle;
}

.dropdown-menu {
    min-width: 150px;
}

.badge-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>

@endsection