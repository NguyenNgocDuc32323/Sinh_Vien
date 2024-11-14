@php
    $currentRouteName = Route::currentRouteName();
    $currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@extends('Layouts.master')
@section('page_title')
    Blog
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
    <div class="banner d-flex align-items-center justify-content-center"
        style="background-image: url({{ asset('images/Dashboard/banner_shop_4.webp') }})">
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
    <div id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-section">
                        <h2>Welcome To Polysite Company</h2>
                        <img src="{{ asset('images/Blog/under-heading.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <h4>Explore Bottle Designs</h4>
                        <p>Discover the latest trends in bottle design. From innovative shapes to eco-friendly materials, stay updated on what's making waves in the world of bottles.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                        <h4>Latest Bottle Reviews</h4>
                        <p>Get detailed reviews on a wide range of bottles, from water bottles to decorative pieces. Find the perfect bottle that suits your style and needs.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-bell"></i>
                        </div>
                        <h4>Bottle Care Tips</h4>
                        <p>Learn the best practices for maintaining your bottles. Whether it's cleaning, storage, or avoiding damage, our tips will help you keep your bottles in top condition.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h4>Community Favorites</h4>
                        <p>Join our community of bottle enthusiasts. Share your favorites, see what's trending, and connect with others who appreciate the art of bottle design.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="latest-blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-section">
                        <h2>Latest blog posts</h2>
                        <img src="{{ asset('images/Blog/under-heading.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $blog)
                <div class="col-md-4 col-sm-6">
                    <div class="blog-post">
                        <div class="blog-thumb">
                            <img src="{{ asset($blog->image) }}" alt="" />
                        </div>
                        <div class="blog-content">
                            <div class="content-show">
                                <h4><a href="{{route('blog-detail',$blog->id)}}">{{$blog->name}}</a></h4>
                                <span>29 Sep 2024</span>
                            </div>
                            <div class="content-hide">
                                <p>{{$blog->title}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {



            $("div.blog-post").hover(
                function() {
                    $(this).find("div.content-hide").slideToggle("fast");
                },
                function() {
                    $(this).find("div.content-hide").slideToggle("fast");
                }
            );
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
