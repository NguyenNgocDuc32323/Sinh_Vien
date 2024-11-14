@extends('layouts.master')
@section('page_title')
    Home
@endsection
@section('content')
    @if(session('clear_cart'))
        <script>
            localStorage.removeItem('cart');
        </script>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success('{{ session('success') }}');
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.error('{{ session('error') }}');
            });
        </script>
    @endif

        <section id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($slides as $index => $slide)
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $index }}"
                        aria-label="Slide {{ $index + 1 }}"
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}">
                    </button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($slides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url({{ asset($slide->images) }});">
                        <div class="carousel-caption">
                            <h3>{{ $slide->name }}</h3>
                            <h2>{{ $slide->description }}</h2>
                            <p><a class="btn btn-lg btn-primary mt-4" href="{{ route('shop') }}">Shop Now</a></p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </section>
        @if ($search)
            @if ($products)
                <section class="tab-block">
                    <div class="mt-4 text-center">
                        <div class="container-fluid">
                            <div class="product-slider swiper">
                                <div class="swiper-wrapper search-swipper">
                                    @foreach ($products as $product)
                                        <div class="box swiper-slide" id="product-{{ $product->id }}">
                                            <a href="{{ route('product-detail', $product->id) }}" class="product-img">
                                                @php
                                                    $imageUrls = explode(',', $product->image);
                                                    $firstImageUrl = isset($imageUrls[0]) ? $imageUrls[0] : '';
                                                @endphp
                                                <img src="{{ asset($firstImageUrl) }}" alt="Product Image">
                                                @if ($product->label_name)
                                                    <div class="product-label">
                                                        <span class="label-content">{{ $product->label_name }}</span>
                                                    </div>
                                                @endif
                                            </a>
                                            <div class="cart-info cart-wrap">
                                                <a data-toggle="modal" data-target="#modal-cart" title="Add to cart"
                                                    variant="primary" class="btn-add-to-cart">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </a>
                                                <button title="Wishlist" class="btn_wishlist" id="{{ $product->id }}"
                                                    onclick="add_wishlist(this.id)">
                                                    <i class="fa-regular fa-heart"></i>
                                                </button>
                                            </div>
                                            <h2><a href="{{ route('product-detail', $product->id) }}">{{ $product->name }}</a>
                                            </h2>
                                            <div class="product-price">
                                                <span class="price-content" id="product-price-{{ $product->id }}"
                                                    data-base-price="{{ $product->price }}">
                                                    ${{ $product->price }}
                                                </span>
                                            </div>
                                            <div class="stars">
                                                @php
                                                    $rating = round($product->product_reviews, 2);
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                @endphp
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @if ($halfStar)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @endif
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <p>Not Found Product</p>
            @endif
        @else
        {{-- Tabpane --}}
        <section class="tab-block">
            <div class="mt-4 text-center">
                <div class="tab-list">
                    <!-- Buttons to switch tabs -->
                    <div class="container">
                        <div class="btn-group">
                            <button class="btn btn-tab-item active" onclick="showTab('PET')">PET Bottles</button>
                            <button class="btn btn-tab-item" onclick="showTab('PP')">PP Bottles</button>
                            <button class="btn btn-tab-item" onclick="showTab('PC')">PC Bottles</button>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="PET" role="tabpanel">
                            <div class="products" id="products">
                                <div class="product-slider swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($petProducts as $petProduct)
                                            <div class="box swiper-slide" id="product-{{ $petProduct->id }}">
                                                <a href="{{ route('product-detail', $petProduct->id) }}"
                                                    class="product-img">
                                                    <img src="{{ $petProduct->image[0] }}" alt=""
                                                        class="product-image">
                                                    @if ($petProduct->label_name)
                                                        <div class="product-label">
                                                            <span
                                                                class="label-content">{{ $petProduct->label_name }}</span>
                                                        </div>
                                                    @endif
                                                </a>
                                                <div class="cart-info cart-wrap">
                                                    <a data-toggle="modal" data-target="#modal-cart" title="Add to cart"
                                                        variant="primary" class="btn-add-to-cart"
                                                        id="cart-{{ $petProduct->id }}" onclick="add_to_cart(this.id)">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                    </a>
                                                    <button title="Wishlist" class="btn_wishlist"
                                                        id="wishlist-{{ $petProduct->id }}"
                                                        onclick="add_wishlist(this.id)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </button>
                                                </div>
                                                <h2><a href="{{ route('product-detail', $petProduct->id) }}"
                                                        class="product-name">{{ $petProduct->name }}</a></h2>
                                                <div class="product-price">
                                                    <span class="price-content" id="product-price-{{ $petProduct->id }}"
                                                        data-base-price="{{ $petProduct->price }}">
                                                        ${{ $petProduct->price }}
                                                    </span>
                                                </div>
                                                <div class="stars">
                                                    @php
                                                        $rating = round($petProduct->product_reviews, 2);
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor

                                                    @if ($halfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="container view-more-block">
                                <a href="{{ route('shop') }}" class="btn btn-view-more"><span
                                        class="view-more-content">View
                                        More</span></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="PP" role="tabpanel">
                            <div class="products" id="products">
                                <div class="product-slider swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($ppProducts as $ppProduct)
                                            <div class="box swiper-slide" id="product-{{ $ppProduct->id }}">
                                                <a href="{{ route('product-detail', $ppProduct->id) }}"
                                                    class="product-img">
                                                    <img src="{{ $ppProduct->image[0] }}" alt=""
                                                        class="product-image">
                                                    @if ($ppProduct->label_name)
                                                        <div class="product-label">
                                                            <span
                                                                class="label-content">{{ $ppProduct->label_name }}</span>
                                                        </div>
                                                    @endif
                                                </a>
                                                <div class="cart-info cart-wrap">
                                                    <a data-toggle="modal" data-target="#modal-cart" title="Add to cart"
                                                        variant="primary" class="btn-add-to-cart"
                                                        id="cart-{{ $ppProduct->id }}" onclick="add_to_cart(this.id)">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                    </a>
                                                    <button title="Wishlist" class="btn_wishlist"
                                                        id="wishlist-{{ $ppProduct->id }}"
                                                        onclick="add_wishlist(this.id)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </button>
                                                </div>
                                                <h2><a href="{{ route('product-detail', $ppProduct->id) }}"
                                                        class="product-name">{{ $ppProduct->name }}</a></h2>
                                                <div class="product-price">
                                                    <span class="price-content" id="product-price-{{ $ppProduct->id }}"
                                                        data-base-price="{{ $ppProduct->price }}">
                                                        ${{ $ppProduct->price }}
                                                    </span>
                                                </div>
                                                <div class="stars">
                                                    @php
                                                        $rating = round($ppProduct->product_reviews, 2);
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor

                                                    @if ($halfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="container view-more-block">
                                <a href="{{ route('shop') }}" class="btn btn-view-more"><span
                                        class="view-more-content">View
                                        More</span></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="PC" role="tabpanel">
                            <div class="products" id="products">
                                <div class="product-slider swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($pcProducts as $pcProduct)
                                            <div class="box swiper-slide" id="product-{{ $pcProduct->id }}">
                                                <a href="{{ route('product-detail', $pcProduct->id) }}"
                                                    class="product-img">
                                                    <img src="{{ $pcProduct->image[0] }}" alt=""
                                                        class="product-image">
                                                    @if ($pcProduct->label_name)
                                                        <div class="product-label">
                                                            <span
                                                                class="label-content">{{ $pcProduct->label_name }}</span>
                                                        </div>
                                                    @endif
                                                </a>
                                                <div class="cart-info cart-wrap">
                                                    <a data-toggle="modal" data-target="#modal-cart" title="Add to cart"
                                                        variant="primary" class="btn-add-to-cart"
                                                        id="cart-{{ $pcProduct->id }}" onclick="add_to_cart(this.id)">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                    </a>
                                                    <button title="Wishlist" class="btn_wishlist"
                                                        id="wishlist-{{ $pcProduct->id }}"
                                                        onclick="add_wishlist(this.id)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </button>
                                                </div>
                                                <h2><a href="{{ route('product-detail', $pcProduct->id) }}"
                                                        class="product-name">{{ $pcProduct->name }}</a></h2>
                                                <div class="product-price">
                                                    <span class="price-content" id="product-price-{{ $pcProduct->id }}"
                                                        data-base-price="{{ $pcProduct->price }}">
                                                        ${{ $pcProduct->price }}
                                                    </span>
                                                </div>
                                                <div class="stars">
                                                    @php
                                                        $rating = round($pcProduct->product_reviews, 2);
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor

                                                    @if ($halfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="container view-more-block">
                                <a href="{{ route('shop') }}" class="btn btn-view-more"><span
                                        class="view-more-content">View
                                        More</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Collection --}}
        <section class="row collection-block d-flex align-items-center w-100">
            @foreach ($top_Ads as $top)
                <div class="col-lg-4 col-md-6 col-sm-12 collection-item text-center d-flex align-items-center justify-content-center"
                    style="background-image: url({{ asset($top->image) }})">
                    <div class="collection-item-content">
                        <h3>{{ $top->name }}</h3>
                        <h2>{{ $top->description }}</h2>
                        <a href="#" class="btn-collection">Shop Bottles</a>
                    </div>
                </div>
            @endforeach

        </section>
        {{-- Best Seller --}}
        <section class="best-seller mt-5 align-items-center justify-content-center text-center mb-5">
            <h2 class="d-flex align-items-center justify-content-center text-center">Best Seller</h2>
            <div class="product-slider swiper">
                <div class="swiper-wrapper">
                    @foreach ($bestSellerPrds as $bestSellerPrd)
                        <div class="box swiper-slide" id="product-{{ $bestSellerPrd->id }}">
                            <a href="{{ route('product-detail', $bestSellerPrd->id) }}" class="product-img">
                                <img src="{{ $bestSellerPrd->image[0] }}" alt="" class="product-image">
                                @if ($bestSellerPrd->label_name)
                                    <div class="product-label">
                                        <span class="label-content">{{ $bestSellerPrd->label_name }}</span>
                                    </div>
                                @endif
                            </a>
                            <div class="cart-info cart-wrap">
                                <a data-toggle="modal" data-target="#modal-cart" title="Add to cart" variant="primary"
                                    class="btn-add-to-cart" id="cart-{{ $bestSellerPrd->id }}"
                                    onclick="add_to_cart(this.id)">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                <button title="Wishlist" class="btn_wishlist" id="wishlist-{{ $bestSellerPrd->id }}"
                                    onclick="add_wishlist(this.id)">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                            <h2><a href="{{ route('product-detail', $bestSellerPrd->id) }}"
                                    class="product-name">{{ $bestSellerPrd->name }}</a></h2>
                            <div class="product-price">
                                <span class="price-content" id="product-price-{{ $bestSellerPrd->id }}"
                                    data-base-price="{{ $bestSellerPrd->price }}">
                                    ${{ $bestSellerPrd->price }}
                                </span>
                            </div>
                            <div class="total-sold">
                                <p>Total Sales: <span>{{ $bestSellerPrd->total_sold }}</span></p>
                            </div>
                            <div class="stars">
                                @php
                                    $rating = round($bestSellerPrd->product_reviews, 2);
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor

                                @if ($halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif

                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="container view-more-block">
                <a href="{{ route('shop') }}" class="btn btn-view-more"><span class="view-more-content">View
                        More</span></a>
            </div>
        </section>
        {{-- post --}}
        <section class="mt-3 row post-block gx-3 mb-4">
            @foreach ($down_Ads as $down)
                <div class="col-lg-4 col-md-6 col-sm-12 post-item d-flex align-items-center justify-content-center"
                    style="background-image: url({{ asset($down->image) }});">
                    <div class="post-item-content text-center">
                        <h3>{{ $down->name }}</h3>
                        <h2>{{ $down->description }}</h2>
                        <a href="{{ route('shop') }}" class="btn-post">Shop Bottles</a>
                    </div>
                </div>
            @endforeach
        </section>
        {{-- action --}}
        <section class="action-block text-center align-items-center mt-4 container">
            <h2>Our Mission in Action</h2>
            <div class="text-container">
                <p class="fw-bold">
                    From the very beginning, Klean Kanteens have been built with love — the love of adventure, the love of
                    conserving wild places and the love of replacing single-use plastic. We use our business as a force for
                    good, prioritizing the well being of people and the planet and by designing sustainable,
                    high-performance
                    products.
                </p>
            </div>
            <div class="action-img-block row mt-5">
                <div class="col-lg-4 col-md-6 col-sm-12 action-img-item mb-3">
                    <img src="https://cdn.shopify.com/s/files/1/0607/0325/files/logo_BCorp_icon_white_green.webp?v=1672787458"
                        alt="">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 action-img-item mb-3">
                    <img src="https://cdn.shopify.com/s/files/1/0607/0325/files/logo_1ftp_icon_white_green.webp?v=1672787458"
                        alt="">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 action-img-item mb-3">
                    <img src="https://cdn.shopify.com/s/files/1/0607/0325/files/logo_BCorp_icon_white_green.webp?v=1672787458"
                        alt="">
                </div>
            </div>
        </section>
        {{-- feed back form --}}
        <div class="container d-flex justify-content-center align-items-center feedback-block mt-100">
            <div class="m-1 feedback-form">
                <h2>Feedback</h2>
                <div class="mb-4 small">
                    <p>Please provide your feedback in the form below</p>
                </div>
                <form name="feedback_form" id="feedback_form" method="post" action="{{ route('sendFeedbackForm') }}">
                    @csrf
                    <label>How do you rate your overall experience?</label>
                    <div class="mb-3 d-flex flex-row py-1">
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="radio" name="title" id="rating_bad"
                                value="bad">
                            <label class="form-check-label" for="rating_bad">
                                Bad
                            </label>
                        </div>
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="title" id="rating_good"
                                value="good">
                            <label class="form-check-label" for="rating_good">
                                Good
                            </label>
                        </div>
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="title" id="rating_excellent"
                                value="excellent">
                            <label class="form-check-label" for="rating_excellent">
                                Excellent!
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="ckeditor_comment">Comments:</label>
                        <textarea class="form-control" id="content" placeholder="Enter The Comment" name="content"
                            style="min-height: 300px; width: 100%;"></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="name">Your Name:</label>
                            <input type="text" required name="name" class="form-control" id="name"
                                value="{{ auth()->check() ? auth()->user()->username : '' }}"
                                {{ auth()->check() ? 'readonly' : '' }} />
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" name="email" required class="form-control" id="email"
                                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                {{ auth()->check() ? 'readonly' : '' }} />
                        </div>
                        <div class="col mb-4">
                            <label class="form-label" for="phone">Phone:</label>
                            <input type="text" name="phone" required class="form-control" id="phone"
                                value="{{ auth()->check() ? auth()->user()->phone : '' }}"
                                {{ auth()->check() ? 'readonly' : '' }} />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit btn-lg">SEND</button>
                </form>
            </div>
        </div>
    @endif
@endsection
@push('custom-scripts')
    <script>
        //input
        document.addEventListener('DOMContentLoaded', function() {
            var inputs = document.querySelectorAll(
                'input[type="text"], input[type="email"],input[type="password"],input[type="number"], textarea');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
                });
            });
        });
        var productDetailUrl = "{{ route('product-detail', ['id' => ':id']) }}";
        // show tabpane
        function showTab(tabId) {
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
            document.querySelector(`#${tabId}`).classList.add('show', 'active');
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('active');
        }
        // slider product
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".product-slider", {
                loop: true,
                autoplay: {
                    delay: 20000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                    },
                    1100: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1400: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                },
            });
        });
        //wishlist
        function updateWishlistCount() {
            var wishlist = localStorage.getItem('wishlist');
            var count = 0;

            if (wishlist) {
                try {
                    var wishlistItems = JSON.parse(wishlist);
                    count = wishlistItems.length;
                } catch (e) {
                    console.error("Failed to parse wishlist JSON:", e);
                }
            }
            var countElement = document.querySelector('.count-wishlist');
            if (countElement) {
                countElement.textContent = count;
            }
        }

        function updateWishlistButtons() {
            var wishlist = localStorage.getItem('wishlist');
            if (wishlist) {
                try {
                    var wishlistItems = JSON.parse(wishlist);
                    wishlistItems.forEach(function(item) {
                        var wishlistButton = document.getElementById(item.id);
                        if (wishlistButton) {
                            wishlistButton.classList.add('wishlist-added');
                        }
                    });
                } catch (e) {
                    console.error("Failed to parse wishlist JSON:", e);
                }
            }
        }

        function add_wishlist(clicked_id) {
            var id = clicked_id.replace('wishlist-', '');
            var productElement = document.getElementById('product-' + id);

            if (!productElement) {
                console.error("Product element not found.");
                return;
            }

            // Xác định cấu trúc của phần tử sản phẩm
            var imageElement, nameElement, basePriceElement;
            var products = productElement.querySelector('.product-img img') !== null;

            if (products) {
                imageElement = productElement.querySelector('.product-img img');
                nameElement = productElement.querySelector('h2 a');
                basePriceElement = productElement.querySelector('.product-price .price-content');
            } else {
                imageElement = productElement.querySelector('.img-wrapper .front img');
                nameElement = productElement.querySelector('.product-detail .product-name h4');
                basePriceElement = productElement.querySelector('.product-price');
            }

            var image = imageElement ? imageElement.src : 'No image';
            var name = nameElement ? nameElement.innerText : 'No name';
            var basePrice = basePriceElement ? parseFloat(basePriceElement.getAttribute('data-base-price') ||
                basePriceElement.innerText.replace('$', '')) : 0;

            // Nếu cần, xử lý giá biến động theo màu sắc
            var selectedColorElement = productElement.querySelector('.color-option.selected');
            if (!selectedColorElement) {
                selectedColorElement = productElement.querySelector('.color-option');
            }
            var ratioPrice = selectedColorElement ? parseFloat(selectedColorElement.getAttribute('data-price')) : 1;

            var price = (basePrice * ratioPrice).toFixed(2);

            var newItem = {
                id: id,
                image: image,
                name: name,
                price: price
            };

            var wishlist = localStorage.getItem('wishlist');
            var old_data = [];
            if (wishlist) {
                try {
                    old_data = JSON.parse(wishlist);
                } catch (e) {
                    console.error("Failed to parse wishlist JSON:", e);
                }
            }

            var itemIndex = old_data.findIndex(function(obj) {
                return obj.id == id;
            });

            if (itemIndex !== -1) {
                old_data.splice(itemIndex, 1);
                localStorage.setItem('wishlist', JSON.stringify(old_data));

                $('#wishlist_list').find(`[data-index="${id}"]`).remove();

                var wishlistButton = document.getElementById('wishlist-' + id);
                if (wishlistButton) {
                    wishlistButton.classList.remove('wishlist-added');
                }

                Toastify({
                    text: "Item removed from wishlist!",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                    gravity: "top",
                    position: "center"
                }).showToast();
            } else {
                old_data.push(newItem);
                $('#wishlist_list').append(`
                    <li class="media d-flex align-items-center" data-index="${id}">
                        <div class="media-left media-middle">
                            <a href="/product-detail/${id}">
                                <img src="${image}" alt="Product Image">
                            </a>
                        </div>
                        <div class="media-body media-middle">
                            <button class="btn-remove-wishlist" onclick="removeFromWishlist('${id}')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <p class="darklinks"><a href="/product-detail/${id}">${name}</a></p>
                            <span class="product-quantity">
                                <span class="price">$${price}</span>
                            </span>
                        </div>
                    </li>
                `);
                localStorage.setItem('wishlist', JSON.stringify(old_data));

                var wishlistButton = document.getElementById('wishlist-' + id);
                if (wishlistButton) {
                    wishlistButton.classList.add('wishlist-added');
                }

                Toastify({
                    text: "Item added to wishlist!",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #28a745, #218838)",
                    gravity: "top",
                    position: "center"
                }).showToast();
            }
            updateWishlistCount();
            updateWishlistButtons();
        }

        function removeFromWishlist(id) {
            var wishlist = localStorage.getItem('wishlist');
            if (wishlist) {
                try {
                    var old_data = JSON.parse(wishlist);
                    old_data = old_data.filter(function(item) {
                        return item.id !== id;
                    });
                    localStorage.setItem('wishlist', JSON.stringify(old_data));

                    $('#wishlist_list').find(`[data-index="${id}"]`).remove();

                    var wishlistButton = document.getElementById(id);
                    if (wishlistButton) {
                        wishlistButton.classList.remove('wishlist-added');
                    }

                    Toastify({
                        text: "Item removed from wishlist!",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                        gravity: "top",
                        position: "center"
                    }).showToast();
                } catch (e) {
                    console.error("Failed to parse wishlist JSON:", e);
                }
            }
            updateWishlistCount();
            updateWishlistButtons();
        }
        //Cart
        function updateCartCount() {
            var cart = localStorage.getItem('cart');
            var count = 0;

            if (cart) {
                try {
                    var cartItems = JSON.parse(cart);
                    count = cartItems.length;
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
            var countElement = document.querySelector('.count-cart');
            if (countElement) {
                countElement.textContent = count;
            }
        }

        function totalPrice() {
            var cart = localStorage.getItem('cart');
            var total = 0;
            var totalText = document.querySelector('#total-price');
            if (cart) {
                try {
                    var old_data = JSON.parse(cart);
                    old_data.forEach(function(item) {
                        total += item.price * item.quantity;
                    });
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
            if (totalText) {
                totalText.innerHTML = '$' + total.toFixed(2);
            }
            return total;
        }

        function updateCartButtons() {
            var cart = localStorage.getItem('cart');
            if (cart) {
                try {
                    var cartItems = JSON.parse(cart);
                    cartItems.forEach(function(item) {
                        var cartButton = document.getElementById(item.id);
                        if (cartButton) {
                            cartButton.classList.add('cart-added');
                        }
                    });
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
        }

        function add_to_cart(clicked_id) {
            var id = clicked_id.replace('cart-', '');
            var productElement = document.getElementById('product-' + id);
            if (!productElement) {
                console.error("Product element not found.");
                return;
            }

            var imageElement = productElement.querySelector('.product-image');
            var image = imageElement ? imageElement.src : 'No image';
            var nameElement = productElement.querySelector('.product-name');
            var name = nameElement ? nameElement.innerText : 'No name';
            var basePriceElement = productElement.querySelector('.product-price');
            var basePrice = basePriceElement ? parseFloat(basePriceElement.getAttribute('data-base-price') ||
                basePriceElement.innerText.replace('$', '')) : 0;
            var selectedColorElement = productElement.querySelector('.color-option.selected');
            if (!selectedColorElement) {
                selectedColorElement = productElement.querySelector('.color-option');
            }
            var ratioPrice = selectedColorElement ? parseFloat(selectedColorElement.getAttribute('data-price')) : 1;
            var color = selectedColorElement ? selectedColorElement.getAttribute('data-color') : 'default';
            var price = (basePrice * ratioPrice).toFixed(2);
            var quantity = 1;

            var newItem = {
                id: id,
                image: image,
                name: name,
                price: price,
                color: color,
                quantity: quantity
            };

            if (quantity < 1) {
                toastr.error('Quantity must be greater than 0');
                return;
            }
            if (quantity > 1000) {
                toastr.error('Quantity must not exceed 1000!');
                return;
            }

            var cart = localStorage.getItem('cart');
            var old_data = [];
            if (cart) {
                try {
                    old_data = JSON.parse(cart);
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }

            var itemIndex = old_data.findIndex(function(obj) {
                return obj.id == id && obj.color == color;
            });

            if (itemIndex !== -1) {
                var cartButton = document.getElementById('cart-' + id);
                if (cartButton) {
                    cartButton.classList.add('cart-added');
                }
                // Increment quantity
                old_data[itemIndex].quantity += 1;
                Toastify({
                    text: "Quantity updated in cart!",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #28a745, #218838)",
                    gravity: "top",
                    position: "center"
                }).showToast();
            } else {
                // Add new item
                old_data.push(newItem);
                Toastify({
                    text: "Item added to cart!",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #28a745, #218838)",
                    gravity: "top",
                    position: "center"
                }).showToast();
            }
            localStorage.setItem('cart', JSON.stringify(old_data));
            var cartButton = document.getElementById('cart-' + id);
            if (cartButton) {
                cartButton.classList.add('cart-added');
            }
            updateCartList();
            updateCartCount();
            updateCartButtons();
            totalPrice();
        }

        function updateCartList() {
            var cart = localStorage.getItem('cart');
            var old_data = [];
            if (cart) {
                try {
                    old_data = JSON.parse(cart);
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
            var cartList = document.querySelector('#cart_list');
            cartList.innerHTML = '';
            //update cart list
            old_data.forEach(function(item) {
                cartList.insertAdjacentHTML('beforeend', `
                    <li class="media d-flex align-items-center" data-index="${item.id}-${item.color}">
                        <div class="media-left media-middle">
                            <a href="/product-detail/${item.id}">
                                <img src="${item.image}" alt="${item.name}">
                            </a>
                        </div>
                        <div class="media-body media-middle">
                            <button class="btn-remove-cart" data-index="${item.id}-${item.color}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <p class="darklinks"><a href="/product-detail/${item.id}">${item.name}</a></p>
                            <span class="product-quantity">
                                <span class="price">$${item.price}</span>
                                <div class="quantity-navbar d-flex align-items-center justify-content-between" data-item-id="${item.id}" data-item-color="${item.color}">
                                    <button class="qty-btn dec-qty-navbar">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input class="qty-input-navbar" type="text" name="qty-navbar" value="${item.quantity}" min="0">
                                    <button class="qty-btn inc-qty-navbar">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </span>
                        </div>
                    </li>
                `);
            });
            // remove prd
            const removeButtons = document.querySelectorAll('.btn-remove-cart');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    removeFromCart(index);
                });
            });
            //update qty
            const decButtons = document.querySelectorAll('.dec-qty-navbar');
            const incButtons = document.querySelectorAll('.inc-qty-navbar');
            const inputQtys = document.querySelectorAll('.qty-input-navbar');

            function updateCart(id, color, qty) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const itemIndex = cart.findIndex(item => item.id === id && item.color === color);
                if (itemIndex !== -1) {
                    cart[itemIndex].quantity = qty;
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                updateCartButtons();
            }

            decButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const qtyInput = this.closest('.quantity-navbar').querySelector('.qty-input-navbar');
                    let currentValue = parseInt(qtyInput.value, 10);
                    const itemId = this.closest('.quantity-navbar').dataset.itemId;
                    const itemColor = this.closest('.quantity-navbar').dataset.itemColor;

                    if (currentValue > 1) {
                        qtyInput.value = currentValue - 1;
                        updateCart(itemId, itemColor, currentValue - 1);
                    } else {
                        removeFromCart(`${itemId}-${itemColor}`);
                    }
                    totalPrice();
                });
            });

            incButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const qtyInput = this.closest('.quantity-navbar').querySelector('.qty-input-navbar');
                    let currentValue = parseInt(qtyInput.value, 10);
                    const itemId = this.closest('.quantity-navbar').dataset.itemId;
                    const itemColor = this.closest('.quantity-navbar').dataset.itemColor;

                    if (currentValue < 1000) {
                        qtyInput.value = currentValue + 1;
                        updateCart(itemId, itemColor, currentValue + 1);
                    } else {
                        Toastify({
                            text: "Quantity must not exceed 1000!",
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #ff5f5f, #ff0000)",
                            gravity: "top",
                            position: "center"
                        }).showToast();
                    }
                    totalPrice();
                });
            });

            inputQtys.forEach(input => {
                input.addEventListener('input', function() {
                    let currentValue = parseInt(this.value, 10);
                    if (isNaN(currentValue) || currentValue < 1) {
                        currentValue = 1;
                        this.value = currentValue;
                    }
                    if (currentValue > 1000) {
                        Toastify({
                            text: "Quantity must not exceed 1000!",
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #ff5f5f, #ff0000)",
                            gravity: "top",
                            position: "center"
                        }).showToast();
                        this.value = 1000;
                        currentValue = 1000;
                    }
                    const itemId = this.closest('.quantity-navbar').dataset.itemId;
                    const itemColor = this.closest('.quantity-navbar').dataset.itemColor;
                    updateCart(itemId, itemColor, currentValue);
                    totalPrice();
                });
            });
            totalPrice();
        }

        function removeFromCart(idColor) {
            var cart = localStorage.getItem('cart');
            if (cart) {
                try {
                    var old_data = JSON.parse(cart);
                    old_data = old_data.filter(function(item) {
                        return item.id + '-' + item.color !== idColor;
                    });
                    localStorage.setItem('cart', JSON.stringify(old_data));

                    $('#cart_list').find(`[data-index="${idColor}"]`).remove();

                    var [id, color] = idColor.split('-');
                    var cartButton = document.getElementById(id);
                    if (cartButton) {
                        cartButton.classList.remove('cart-added');
                    }

                    Toastify({
                        text: "Item removed from cart!",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                        gravity: "top",
                        position: "center"
                    }).showToast();
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
            updateCartCount();
            updateCartButtons();
            totalPrice();
        }
        //CK EDITOR
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    ckfinder: {
                        uploadUrl: '{{ route('upload-image') }}?_token=' + document.querySelector(
                            'meta[name="csrf-token"]').getAttribute('content'),
                    },
                    config: {
                        entities: false,
                        entities_processNumerical: false,
                    },
                    link: {
                        addTargetToExternalLinks: true
                    },
                })
                .then(editor => {
                    editor.plugins.get('ImageUpload').on('uploadSuccess', (evt, {
                        data: {
                            url
                        }
                    }) => {
                        console.log('Hình ảnh được tải lên thành công:', url);
                    });

                    editor.plugins.get('ImageUpload').on('uploadError', (error) => {
                        console.error('Lỗi khi tải lên hình ảnh:', error);
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi khởi tạo CKEditor:', error);
                });
        });
        function totalPriceCart() {
            var cart = localStorage.getItem('cart');
            var subtotal = 0;
            var shipping = 0;
            var discount = 0;

            var subTotalText = document.querySelector('#sub-total-price-cart');
            var shippingText = document.querySelector('#shipping-price-cart');
            var discountText = document.querySelector('#discount-price-cart');
            var totalText = document.querySelector('#total-price-cart');

            if (cart) {
                try {
                    var old_data = JSON.parse(cart);
                    old_data.forEach(function(item) {
                        subtotal += item.price * item.quantity;
                    });
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }

            // shipping
            if (subtotal > 200) {
                shipping = 0;
            } else if (subtotal < 100) {
                shipping = subtotal * 0.10;
            } else {
                shipping = subtotal * 0.05;
            }

            // discount
            if (subtotal >= 200 && subtotal < 500) {
                discount = subtotal * 0.05;
            } else if (subtotal >= 500 && subtotal < 1000) {
                discount = subtotal * 0.10;
            } else if (subtotal >= 1000) {
                discount = subtotal * 0.15;
            }

            // total
            var total = subtotal + shipping - discount;

            if (subTotalText) {
                subTotalText.innerHTML = '$' + subtotal.toFixed(2);
            }
            if (shippingText) {
                shippingText.innerHTML = '$' + shipping.toFixed(2);
            }
            if (discountText) {
                discountText.innerHTML = '-$' + discount.toFixed(2);
            }
            if (totalText) {
                totalText.innerHTML = '$' + total.toFixed(2);
            }

            return total;
        }
    </script>
@endpush
