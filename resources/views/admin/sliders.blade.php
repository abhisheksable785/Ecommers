@extends('layout.back.master')

@section('title', 'Slider Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">App /</span> Sliders</h4>

    <div class="row">
        <!-- Add Slider Section -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Slider</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="ti ti-check me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form action="{{ url('api/slider/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="sliderImage">Slider Image</label>
                            <div class="card-body border-dashed border-2 rounded-3 text-center p-4" id="drop-zone" style="cursor: pointer; border-color: #d9dee3;">
                                <i class="ti ti-cloud-upload fs-1 text-muted mb-2"></i>
                                <p class="text-muted mb-1">Click to upload or drag and drop</p>
                                <p class="text-muted small">SVG, PNG, JPG or GIF</p>
                                <input type="file" name="image" id="sliderImage" class="d-none" accept="image/*" required onchange="previewImage(event)">
                            </div>
                            @error('image') 
                                <div class="text-danger mt-1 small">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div class="mb-3 d-none" id="preview-container">
                            <label class="form-label">Preview</label>
                            <div class="position-relative">
                                <img id="preview-img" src="" class="img-fluid rounded border" alt="Preview">
                                <button type="button" class="btn btn-icon btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-pill" onclick="removeImage()">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-upload me-1"></i> Upload Slider
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Slider List Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0">Slider List</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Preview</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="avatar avatar-xl" style="width: 120px; height: 60px;">
                                            <img src="{{ asset($slider->image) }}" alt="Slider" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $slider->created_at ? $slider->created_at->format('d M Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ url('slider/delete/'.$slider->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-label-danger waves-effect">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-photo-off fs-1 mb-2"></i>
                                            <p>No sliders found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Click on drop zone to trigger file input
    document.getElementById('drop-zone').addEventListener('click', function() {
        document.getElementById('sliderImage').click();
    });

    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('preview-img');
        const dropZone = document.getElementById('drop-zone');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('d-none');
                dropZone.classList.add('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('sliderImage');
        const previewContainer = document.getElementById('preview-container');
        const dropZone = document.getElementById('drop-zone');
        
        input.value = '';
        previewContainer.classList.add('d-none');
        dropZone.classList.remove('d-none');
    }
</script>
@endpush
@endsection
