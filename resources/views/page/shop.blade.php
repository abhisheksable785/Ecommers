@extends('layout.front.app')
@section('title', 'Shop')
@section('content')

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <div class="shop__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
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
                                                @foreach ($categories as $category)
                                                <li><a href="{{ route('category.products', $category->id) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__brand">
                                            <ul>
                                                <li><a href="#">Louis Vuitton</a></li>
                                                <li><a href="#">Chanel</a></li>
                                                <li><a href="#">Hermes</a></li>
                                                <li><a href="#">Gucci</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                </div>
                                <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__price">
                                            <ul>
                                                <li><a href="#">₹0.00 - ₹50.00</a></li>
                                                <li><a href="#">₹50.00 - ₹100.00</a></li>
                                                <li><a href="#">₹100.00 - ₹150.00</a></li>
                                                <li><a href="#">₹150.00 - ₹200.00</a></li>
                                                <li><a href="#">₹200.00 - ₹250.00</a></li>
                                                <li><a href="#">₹250.00+</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                </div>
                                <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__size">
                                            <label for="xs">xs
                                                <input type="radio" id="xs">
                                            </label>
                                            <label for="sm">s
                                                <input type="radio" id="sm">
                                            </label>
                                            <label for="md">m
                                                <input type="radio" id="md">
                                            </label>
                                            <label for="xl">xl
                                                <input type="radio" id="xl">
                                            </label>
                                            <label for="2xl">2xl
                                                <input type="radio" id="2xl">
                                            </label>
                                            <label for="xxl">xxl
                                                <input type="radio" id="xxl">
                                            </label>
                                            <label for="3xl">3xl
                                                <input type="radio" id="3xl">
                                            </label>
                                            <label for="4xl">4xl
                                                <input type="radio" id="4xl">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                </div>
                                <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__color">
                                            <label class="c-1" for="sp-1">
                                                <input type="radio" id="sp-1">
                                            </label>
                                            <label class="c-2" for="sp-2">
                                                <input type="radio" id="sp-2">
                                            </label>
                                            <label class="c-3" for="sp-3">
                                                <input type="radio" id="sp-3">
                                            </label>
                                            <label class="c-4" for="sp-4">
                                                <input type="radio" id="sp-4">
                                            </label>
                                            <label class="c-5" for="sp-5">
                                                <input type="radio" id="sp-5">
                                            </label>
                                            <label class="c-6" for="sp-6">
                                                <input type="radio" id="sp-6">
                                            </label>
                                            <label class="c-7" for="sp-7">
                                                <input type="radio" id="sp-7">
                                            </label>
                                            <label class="c-8" for="sp-8">
                                                <input type="radio" id="sp-8">
                                            </label>
                                            <label class="c-9" for="sp-9">
                                                <input type="radio" id="sp-9">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                </div>
                                <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__tags">
                                            <a href="#">Product</a>
                                            <a href="#">Bags</a>
                                            <a href="#">Shoes</a>
                                            <a href="#">Fashio</a>
                                            <a href="#">Clothing</a>
                                            <a href="#">Hats</a>
                                            <a href="#">Accessories</a>
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

                                {{-- 🟡 Category Name Display --}}
                                @if(isset($category))
                                <h3 class="mb-2 text-primary">Category: {{ $category->name }}</h3>
                            @else
                                <h3 class="mb-2 text-primary">Category: All</h3>
                            @endif
                            

                                <p>Showing 1–12 of 126 results</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shop__product__option__right">
                                <p>Sort by Price:</p>
                                <select>
                                    <option value="">Low To High</option>
                                    <option value="">₹0 - ₹55</option>
                                    <option value="">₹55 - ₹100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="product__item" style="border-radius: 15px; overflow: hidden; background-color: #fff; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: relative;">
                <div class="product__item__pic set-bg"
                     data-setbg="{{ asset('storage/' . $product->image) }}"
                     style="cursor: pointer; height: 300px; width: 100%; background-size: cover; background-position: center; position: relative; transition: transform 0.3s ease;"
                     onclick="window.location.href='{{ route('details.show', $product->id) }}'">
                     
                    <div class="product__actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 12px;">
                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline;">
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
                    button:hover, .product__actions a:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 5px 12px rgba(0,0,0,0.2);
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
