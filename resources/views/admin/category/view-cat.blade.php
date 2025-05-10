@extends('layout.back.master')

@section('title', 'View Category')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>View Category</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label><strong>Name:</strong></label>
                <p>{{ $category->name }}</p>
            </div>

            <div class="form-group">
                <label><strong>Description:</strong></label>
                <p>{{ $category->description }}</p>
            </div>

            <div class="form-group">
                <label><strong>Image:</strong></label><br>
                <img src="{{ asset($category->image) }}" width="150" height="150" alt="Category Image">
            </div>

            <a href="{{ route('category.list') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>

@endsection
