@php
$currentRouteName = Route::currentRouteName();
$currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@extends('Layouts.master')
@section('page_title')
    Blog Detail
@endsection
@section('content')
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.success('{{ session('
            success ') }}');
    });
</script>
@endif
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.error('{{ session('
            error ') }}');
    });
</script>
@endif
<div class="banner d-flex align-items-center justify-content-center" style="background-image: url({{ asset('images/Dashboard/banner_shop_4.webp') }})">
    <div class="container">
        <div class="dz-bnr-inr-entry">
            <h1>
                @if (strpos($currentRouteName, 'shop') !== false)
                Shop
                @else
                {{ $currentRouteDisplay }}
                @endif
            </h1>
            <nav aria-label="breadcrumb" class="breadcrumb-row">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item breadcrumb-route">
                        {{ $currentRouteDisplay }}
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div id="product-post">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-section">
                    <h2>Blog Detail Post</h2>
                    <img src="{{asset('images/Blog/under-heading.png')}}" alt="" />
                </div>
            </div>
        </div>
        <div id="single-blog" class="page-section first-section">
            <div class="container">
                <div class="row">
                    <div class="product-item col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                    <div class="blog-detail-content">
                                        {!! $blog->content !!}
                                    </div>
                                    <div class="comments-title">
                                        <div class="comment-section">
                                            <h4>4 comments</h4>
                                        </div>
                                    </div>
                                    <div class="all-comments">
                                        <div class="view-comments">
                                            <div class="comments">
                                                <div class="author-thumb">
                                                    <img src="{{asset('images/Blog/author-comment1.jpg')}}" alt="">
                                                </div>
                                                <div class="comment-body">
                                                    <h6>Cindy Venna</h6>
                                                    <span class="date">11 Sep 2084 - 12:25 PM</span>
                                                    <a href="#" class="hidden-xs">Reply</a>
                                                    <p>Nulla ac elementum nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam erat volutpat. Donec rhoncus quam sit amet sodales finibus. Donec pellentesque non massa eu maximus. In non tellus id sem tempor gravida.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="replyed-form">
                                            <div class="comments replyed">
                                                <div class="author-thumb">
                                                    <img src="{{asset('images/Blog/author-comment2.jpg')}}" alt="">
                                                </div>
                                                <div class="comment-body">
                                                    <h6>George Tanya</h6>
                                                    <span class="date">12 Sep 2084 - 8:48 AM</span>
                                                    <a href="#" class="hidden-xs">Reply</a>
                                                    <p>In pulvinar venenatis odio. Sed in ex sit amet ipsum posuere mollis. Nam nec risus feugiat dui ultrices dignissim. Morbi ex purus, commodo a tristique eu, mollis a nisi. Pellentesque in enim sit amet tellus ornare fringilla eget eu arcu.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-comments">
                                            <div class="comments">
                                                <div class="author-thumb">
                                                    <img src="{{asset('images/Blog/author-comment3.jpg')}}" alt="">
                                                </div>
                                                <div class="comment-body">
                                                    <h6>Brooker Aung</h6>
                                                    <span class="date">12 Sep 2084 - 10:40 AM</span>
                                                    <a href="#" class="hidden-xs">Reply</a>
                                                    <p>Duis rutrum, libero eu blandit gravida, massa orci cursus nisi, vehicula facilisis purus neque dignissim urna. Etiam molestie elementum elit at tempus. Suspendisse quis consectetur nisi, vitae consequat sem. In et quam id libero venenatis venenatis. Morbi vitae justo vulputate, auctor augue eu, pulvinar augue.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-comments">
                                            <div class="comments">
                                                <div class="author-thumb">
                                                    <img src="{{asset('images/Blog/author-comment4.jpg')}}" alt="">
                                                </div>
                                                <div class="comment-body">
                                                    <h6>Crystal Mya</h6>
                                                    <span class="date">14 Sep 2084 - 05:16 PM</span>
                                                    <a href="#" class="hidden-xs">Reply</a>
                                                    <p>Suspendisse vitae maximus nisl, non finibus ante. Suspendisse neque nisl, luctus ullamcorper erat a, fermentum mollis nibh. Aliquam vulputate augue vel metus suscipit euismod. Quisque id purus massa. Sed condimentum facilisis eros, ultrices tincidunt libero facilisis eget. Integer eget cursus velit.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divide-line">
                                    <img src="{{asset('images/Blog/div-line.png')}}" alt="" />
                                    </div>
                            </div>
                            <div class="col-md-3 col-md-offset-1">
                                <div class="side-bar">
                                    <div class="news-letters">
                                        <h4>Archives</h4>
                                        <div class="archives-list">
                                            <ul>
                                                <li><a href="{{route('home')}}"><i class="fa fa-angle-right"></i>Home</a></li>
                                                <li><a href="{{route('shop')}}"><i class="fa fa-angle-right"></i>Shop</a></li>
                                                <li><a href="{{route('about')}}"><i class="fa fa-angle-right"></i>About Us</a></li>
                                                <li><a href="{{route('contact')}}"><i class="fa fa-angle-right"></i>Contact</a></li>
                                                <li><a href="{{route('ads')}}"><i class="fa fa-angle-right"></i>Ads</a></li>
                                                <li><a href="{{route('blog')}}"><i class="fa fa-angle-right"></i>Blog</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="recent-post">
                                        <h4>Recent Posts</h4>
                                        <div class="posts">
                                            <div class="recent-post">
                                                <div class="recent-post-thumb">
                                                    <img src="{{asset('images/Blog/recent-post1.jpg')}}" alt="">
                                                </div>
                                                <div class="recent-post-info">
                                                    <h6><a href="{{route('shop-filter-category',['category' => 'PET'])}}">PET Bottles</a></h6>
                                                    <span>24 Sep 2084</span>
                                                </div>
                                            </div>
                                            <div class="recent-post">
                                                <div class="recent-post-thumb">
                                                    <img src="{{asset('images/Blog/recent-post2.jpg')}}" alt="">
                                                </div>
                                                <div class="recent-post-info">
                                                    <h6><a href="{{route('shop-filter-category',['category' => 'PC'])}}">PC Bottles</a></h6>
                                                    <span>22 Sep 2084</span>
                                                </div>
                                            </div>
                                            <div class="recent-post">
                                                <div class="recent-post-thumb">
                                                    <img src="{{asset('images/Blog/recent-post3.jpg')}}" alt="">
                                                </div>
                                                <div class="recent-post-info">
                                                    <h6><a href="{{route('shop-filter-category',['category' => 'PP'])}}">PP Bottles</a></h6>
                                                    <span>21 Sep 2084</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advertisement">
                                        <h4>Flickr news</h4>
                                        <div class="flickr-images">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image1.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image2.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image3.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image4.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image1.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image2.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image3.jpg')}}" alt="">
                                                </div>
                                                <div class="col-md-4 col-sm-2 col-xs-3">
                                                    <img src="{{asset('images/Blog/flickr-image4.jpg')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<script>
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
