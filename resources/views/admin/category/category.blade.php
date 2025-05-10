@extends('layout.back.master')

@section('title', 'Category List')

@section('content')
<div class="container">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Table container with fixed height and vertical scroll -->
        <!-- End of scrollable div -->
    </div>
    <h2 class="mb-4">Category List</h2>
    <div class="card-header d-flex justify-content-between">
        <a href="{{ route('category.add') }}" class="btn btn-black">
            <span class="btn-label"><i class="fa fa-"></i></span>Add Category
        </a>
    </div>
    <div style="max-height: 500px; overflow-y: auto; border: 1px solid #ddd;">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td><img src="{{ asset($category->image) }}" width="50" height="50" alt="Category Image"></td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="form-button-action">
                                <a href="{{ route('category.view', $category->id) }}" class="btn btn-info btn-sm" style="margin-right: 10px" title="View">
                                    View
                                </a>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm" title="Edit"> Edit</a>

                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-category" style="margin-left: 10px"> 
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.delete-category').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');

                if (confirm('Are you sure you want to delete this category?')) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
