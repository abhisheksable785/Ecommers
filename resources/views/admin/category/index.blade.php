@extends('layout.back.master')
@section('title', 'Category List')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <h4 class="fw-bold mb-0" style="font-size: 28px;">📌 Category List</h4>
                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas"
                    data-bs-target="#addCategoryCanvas">
                    <i class="ti ti-plus me-1"></i> Add Category
                </button>
            </div>

            <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="datatables-category-list table border-top">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="width: 150px;">Name</th>
                                    <th>Image</th>
                                    <th style="width: 400px;">Description</th>
                                    <th>Total Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <img src="{{ asset($category->image) }}" width="50" height="50"
                                                alt="Category Image" class="rounded">
                                        </td>
                                        <td>{{ $category->description }}</td>
                                        <td>{{ $category->products_count }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon editCategoryBtn"
                                                data-id="{{ $category->id }}" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <button class="btn btn-sm btn-icon btn-danger deleteCategoryBtn"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Category Offcanvas -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="addCategoryCanvas">
                    <div class="offcanvas-header">
                        <h5>Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data"
                            id="addCategoryForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="image" id="add_image" accept="image/*"
                                    required>
                                <img id="add_image_preview" src="" width="100" class="d-none mt-2 rounded border"
                                    alt="Preview">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save</button>
                            <button type="button" class="btn btn-secondary w-100 mt-2"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Category Offcanvas -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="editCategoryCanvas">
                    <div class="offcanvas-header">
                        <h5>Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" id="edit_id">

                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <img id="edit_image_preview" src="" width="100"
                                    class="d-block mb-2 rounded border">
                                <label class="form-label">Change Image (Optional)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update</button>
                            <button type="button" class="btn btn-secondary w-100 mt-2"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="ti ti-alert-triangle text-warning me-2"></i>
                                    Confirm Deletion
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <i class="ti ti-trash text-danger" style="font-size: 48px;"></i>
                                </div>
                                <p class="text-center mb-0">
                                    Are you sure you want to delete the category
                                    <strong id="delete_category_name" class="text-danger"></strong>?
                                </p>
                                <p class="text-center text-muted small mt-2">
                                    This action cannot be undone.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <form id="deleteCategoryForm" method="POST" style="display:inline;">
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

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Edit Category Button Click
                $(document).on('click', '.editCategoryBtn', function() {
                    let id = $(this).data('id');

                    // Show loading state
                    $('#edit_name').val('Loading...');
                    $('#edit_description').val('');
                    $('#edit_image_preview').attr('src', '');

                    $.ajax({
                        url: "{{ url('category/view') }}/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            console.log('Category data:', response);

                            // Populate form fields
                            $('#edit_id').val(response.id);
                            $('#edit_name').val(response.name);
                            $('#edit_description').val(response.description || '');

                            // Set image preview with proper path
                            let imagePath = response.image;
                            if (!imagePath.startsWith('http')) {
                                imagePath = '/' + imagePath;
                            }
                            $('#edit_image_preview').attr('src', imagePath);

                            // Set form action using named route
                            $('#editCategoryForm').attr('action', "{{ url('category/update') }}/" +
                                response.id);

                            // Show offcanvas
                            let offcanvas = new bootstrap.Offcanvas('#editCategoryCanvas');
                            offcanvas.show();
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX ERROR:", xhr.responseText);
                            alert('Error loading category data. Please try again.');
                        }
                    });
                });

                // Delete Category Button Click
                $(document).on('click', '.deleteCategoryBtn', function() {
                    let id = $(this).data('id');
                    let name = $(this).data('name');

                    // Set category name in modal
                    $('#delete_category_name').text(name);

                    // Set form action
                    $('#deleteCategoryForm').attr('action', "{{ url('category/destroy') }}/" + id);

                    // Show modal
                    let modal = new bootstrap.Modal('#deleteModal');
                    modal.show();
                });

                // Preview image in ADD modal when file is selected
                $('#add_image').on('change', function(e) {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#add_image_preview').attr('src', e.target.result).removeClass('d-none');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        $('#add_image_preview').attr('src', '').addClass('d-none');
                    }
                });

                // Preview image in EDIT modal when file is changed
                $('#editCategoryForm input[name="image"]').on('change', function(e) {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#edit_image_preview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Reset ADD form when modal is closed
                $('#addCategoryCanvas').on('hidden.bs.offcanvas', function() {
                    $('#addCategoryForm')[0].reset();
                    $('#add_image_preview').attr('src', '').addClass('d-none');
                });
            });
        </script>
    @endpush

@endsection
