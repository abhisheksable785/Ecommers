<!-- resources/views/wishlist.blade.php -->
@extends('layout.front.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-8">
                @if (session('success'))
                    <div class="alert alert-success" id="successAlert">
                        {{ session('success') }}
                    </div>

                    <script>
                        // Hide success message after 3 seconds
                        setTimeout(function() {
                            var alertBox = document.getElementById('successAlert');
                            if (alertBox) {
                                alertBox.style.display = 'none';
                            }
                        }, 3000); // 3000ms = 3 seconds
                    </script>
                @endif

            </div>
        </div>
        <div class="row">

            @forelse($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp

                <div class="col-md-2 mb-4">
                    <div class="card h-100 position-relative border-0 shadow-sm">

                        <!-- ❌ Remove Button -->
                        <form action="{{ route('wishlist.delete', $wishlist->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm position-absolute top-0 end-0 m-2"
                                style="background: none; border: none; font-size: 18px;">×</button>
                            <button class="btn btn-sm position-absolute top-0 end-0 m-2"
                                onclick="removeFromWishlist({{ $wishlist->id }})"
                                style="background: none; border: none; font-size: 18px;">×</button>
                        </form>

                        <!-- Product Image -->
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                            style="height: 220px; object-fit: contain;" alt="{{ $product->name }}">

                        <!-- Product Details -->
                        <div class="card-body text-center p-2">
                            <p class="mb-1" style="font-size: 14px;">{{ Str::limit($product->name, 30) }}</p>

                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <span class="fw-bold text-primary">Rs.{{ $product->price }}</span>
                                <span class="text-muted text-decoration-line-through"
                                    style="font-size: 13px;">{{ $product->mrp }}</span>
                                <span class="text-danger" style="font-size: 13px;">
                                    ({{ $product->mrp > 0 ? round((($product->mrp - $product->selling_price) / $product->mrp) * 100) : 0 }}%
                                    OFF)
                                </span>

                            </div>
                        </div>

                        <!-- Move to Bag Button -->
                        <div class="card-footer bg-white text-center p-2 border-top-0">
                            <form action="{{ route('wishlist.moveToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-link text-danger fw-bold p-0" type="submit">
                                    MOVE TO BAG
                                </button>
                            </form>
                        </div>


                    </div>
                </div>

            @empty
                <p>No items in wishlist.</p>
            @endforelse

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function removeFromWishlist(id) {
            fetch('/wishlist/delete/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(res => location.reload());
        }

        function moveToBag(productId) {
            fetch('/wishlist/move-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            }).then(res => location.reload());
        }
    </script>
@endsection
