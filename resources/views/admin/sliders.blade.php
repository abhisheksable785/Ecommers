@extends('layout.back.master')

@section('content')
<div class="container mt-4">

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add Slider</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ url('api/slider/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Select Slider Image</label>
                            <input type="file" name="image" class="form-control" required>
                            @error('image') 
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Upload Slider
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List of Sliders -->
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Slider List</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($slider->image) }}" 
                                             width="120" height="60" 
                                             style="object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>
                                        <form action="{{ url('slider/delete/'.$slider->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No sliders found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
