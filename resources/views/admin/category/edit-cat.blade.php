@extends('layout.back.master')

@section('title', 'Edit Category')

@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Edit Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Current Image</label><br>
                    <img src="{{ asset($category->image) }}" width="100" height="100" alt="Category Image">
                </div>

                <div class="form-group">
                    <label>Change Image (Optional)</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success mt-3">Update Category</button>
            </form>
        </div>
    </div>
</div>

@endsection
