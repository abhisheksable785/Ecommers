@extends('layout.back.master')

@section('title', 'Product Reviews')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Product Reviews</h4>

    <div class="card">
        <h5 class="card-header">Reviews List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($reviews as $review)
                    <tr>
                        <td>
                            @if($review->product)
                                <a href="{{ route('product.details', $review->product->id) }}" target="_blank">
                                    {{ Str::limit($review->product->name, 30) }}
                                </a>
                            @else
                                <span class="text-danger">Product Deleted</span>
                            @endif
                        </td>
                        <td>{{ $review->user->name ?? 'Unknown User' }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ti ti-star{{ $i <= $review->rating ? '-filled text-warning' : '' }}"></i>
                            @endfor
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}">
                                View Comment
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review Comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ $review->comment }}</p>
                                            @if($review->images->count() > 0)
                                                <div class="d-flex gap-2 mt-3">
                                                    @foreach($review->images as $image)
                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Review Image" class="img-thumbnail" style="max-height: 100px;">
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge bg-label-success me-1">Approved</span>
                            @else
                                <span class="badge bg-label-warning me-1">Pending</span>
                            @endif
                        </td>
                        <td>{{ $review->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="ti ti-check me-1"></i> Approve</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="ti ti-trash me-1"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No reviews found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
