@extends('layout.front.app')
@section('title', 'cat-products')
@section('content')

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="{{ route('product.search') }}" method="GET">
                                <input type="text" name="query" placeholder="Search..." required>
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach ($categories as $cat)
                                                        <li>
                                                            <a href="{{ route('category.products', $cat->id) }}"
                                                                style="
                                                                    display: block;
                                                                    color:white;
                                                                    padding: 5px 10px;
                                                                    border-radius: 5px;
                                                                    text-decoration: none;
                                                                    color: {{ isset($category) && $category->id == $cat->id ? '#FFFFFFFF' : '#000' }};
                                                                    font-weight: {{ isset($category) && $category->id == $cat->id ? '600' : 'normal' }};
                                                                    background-color: {{ isset($category) && $category->id == $cat->id ? '#000000AA' : 'transparent' }};
                                                                ">
                                                                {{ $cat->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">

                                    @if (isset($category))
                                        <h3 class="mb-2 text-primary">Category: {{ $category->name }}</h3>
                                    @endif

                                    {{-- <p>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p> --}}

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <form action="" method="GET">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="">Default</option>
                                            <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>
                                                Low To High</option>
                                            <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>
                                                High To Low</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="product__item"
                                    style="border-radius: 15px; overflow: hidden; background-color: #fff; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: relative;">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="{{ asset('storage/' . $product->image) }}"
                                        style="cursor: pointer; height: 300px; width: 100%; background-size: cover; background-position: center; position: relative; transition: transform 0.3s ease;"
                                        onclick="window.location.href='{{ route('details.show', $product->id) }}'">

                                        <div class="product__actions"
                                            style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 12px;">
                                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit"
                                                    style="border: none; background: rgba(255,255,255,0.95); 
                                           border-radius: 50%; width: 40px; height: 40px; 
                                           display: flex; align-items: center; justify-content: center;
                                           box-shadow: 0 3px 8px rgba(0,0,0,0.15); transition: all 0.2s ease;
                                           transform: translateY(0);">
                                                    <img src="{{ asset('img/icon/heart.png') }}" alt="wishlist"
                                                        style="width: 20px; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));">
                                                </button>
                                            </form>
                                            <a href="simileir"
                                                style="background: rgba(255,255,255,0.95); border-radius: 50%; 
                                  width: 40px; height: 40px; display: flex; align-items: center; 
                                  justify-content: center; box-shadow: 0 3px 8px rgba(0,0,0,0.15);
                                  transition: all 0.2s ease; transform: translateY(0);">
                                                <img src="{{ asset('img/icon/compare.png') }}" alt="compare"
                                                    style="width: 20px; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="product__item__text" style="padding: 20px; position: relative;">
                                        <div style="margin-bottom: 12px;">
                                            <h6 style="margin: 0; font-weight: 600; font-size: 1.05rem;">
                                                <a href="{{ route('details.show', $product->id) }}"
                                                    style="color: #2d3748; text-decoration: none; transition: color 0.2s ease;">
                                                    {{ $product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                        <h5 style="color: #3b82f6; font-weight: 700; margin: 0; font-size: 1.25rem;">
                                            ₹{{ number_format($product->price) }}
                                        </h5>
                                    </div>

                                    <!-- Hover Effects -->
                                    <style>
                                        .product__item:hover {
                                            transform: translateY(-5px);
                                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                                        }

                                        .product__item:hover .product__item__pic {
                                            transform: scale(1.03);
                                        }

                                        button:hover,
                                        .product__actions a:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
                                        }

                                        .product__item__text a:hover {
                                            color: #3b82f6;
                                        }
                                    </style>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <div class="product__pagination">

                                {{-- Previous Button --}}
                                @if ($products->onFirstPage())
                                    <a class="disabled" href="#">&lt;</a>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}">&lt;</a>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $current = $products->currentPage();
                                    $last = $products->lastPage();
                                @endphp

                                @for ($i = 1; $i <= $last; $i++)
                                    @if ($i == 1 || $i == $last || abs($i - $current) <= 1)
                                        @if ($i == $current)
                                            <a class="active" href="#">{{ $i }}</a>
                                        @else
                                            <a href="{{ $products->url($i) }}">{{ $i }}</a>
                                        @endif
                                    @elseif ($i == 2 && $current > 3)
                                        <span>...</span>
                                    @elseif ($i == $last - 1 && $current < $last - 2)
                                        <span>...</span>
                                    @endif
                                @endfor

                                {{-- Next Button --}}
                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}">&gt;</a>
                                @else
                                    <a class="disabled" href="#">&gt;</a>
                                @endif

                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>

    </section>
    <!-- Shop Section End -->

@endsection
