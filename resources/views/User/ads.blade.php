@php
    $currentRouteName = Route::currentRouteName();
    $currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@extends('Layouts.master')
@section('page_title')
    Ads
@endsection
@section('content')
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
    <section class="banner-bottom-wthreelayouts py-lg-5 py-3">
		<div class="container-fluid">
<!---728x90--->

			<div class="inner-sec-shop px-lg-4 px-3">
				<div class="about-content py-lg-5 py-3">
					<div class="row">

						<div class="col-lg-6 p-0">
							<img src="{{asset('images/Dashboard/banner_blog.jpg')}}" alt="Goggles" class="img-fluid">
						</div>
						<div class="col-lg-6 about-info">
							<h3 class="tittle-w3layouts text-left mb-lg-5 mb-3">Polysite's Advertisement</h3>
							<p class="my-xl-4 my-lg-3 my-md-4 my-3">
                                Polysite Bottle is a leading company in the packaging industry, specializing in high-quality packaging solutions for a wide range of sectors. Established in the early 2000s, we have continuously innovated and improved our technology to meet the ever-growing demands of our clients. With a team of experienced engineers and designers, Polysite Bottle is committed to delivering durable, eco-friendly products that meet international standards. We take pride in being a trusted partner for many major brands, contributing to the sustainable growth of the global packaging industry.
                            </p>
							<a href="{{route('shop')}}" class="btn btn-sm animated-button gibson-three mt-4">Shop Now</a>

						</div>
					</div>
				</div>
				<h3 class="tittle-w3layouts text-center my-lg-4 my-4">Customer Comments</h3>
				<div class="partners-info">
                    <div class="row mt-lg-5 mt-3">
                        <div class="col-md-3 team-main-gd">
                            <div class="team-grid text-center">
                                <div class="team-img">
                                    <img class="img-fluid rounded" src="{{asset('images/Ads/team1.jpg')}}" alt="">
                                </div>
                                <div class="team-info">
                                    <h4>John Doe</h4>
                                    <span>Customer</span>
                                    <p>"Great service and quality products."</p>
                                    <ul class="d-flex justify-content-center social-icons">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="mx-3">
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 team-main-gd">
                            <div class="team-grid text-center">
                                <div class="team-img">
                                    <img class="img-fluid rounded" src="{{asset('images/Ads/team2.jpg')}}" alt="">
                                </div>
                                <div class="team-info">
                                    <h4>Jane Smith</h4>
                                    <span>Client</span>
                                    <p>"Excellent partner with superb quality and support."</p>
                                    <ul class="d-flex justify-content-center social-icons">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="mx-3">
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 team-main-gd">
                            <div class="team-grid text-center">
                                <div class="team-img">
                                    <img class="img-fluid rounded" src="{{asset('images/Ads/team3.jpg')}}" alt="">
                                </div>
                                <div class="team-info">
                                    <h4>Michael Johnson</h4>
                                    <span>Supplier</span>
                                    <p>"Reliable and innovative. A top choice for packaging."</p>
                                    <ul class="d-flex justify-content-center social-icons">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="mx-3">
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 team-main-gd">
                            <div class="team-grid text-center">
                                <div class="team-img">
                                    <img class="img-fluid rounded" src="{{asset('images/Ads/team4.jpg')}}" alt="">
                                </div>
                                <div class="team-info">
                                    <h4>Emily Davis</h4>
                                    <span>Partner</span>
                                    <p>"Outstanding service and quality products every time."</p>
                                    <ul class="d-flex justify-content-center social-icons">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="mx-3">
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<!-- /grids -->
				<div class="bottom-sub-grid-content py-lg-5 py-3">
                    <div class="row">
                        <div class="col-lg-4 bottom-sub-grid text-center">
                            <div class="bt-icon">
                                <span class="fas fa-thumbs-up"></span>
                            </div>
                            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">Quality Assurance</h4>
                            <p>We ensure the highest quality products with rigorous testing and checks to meet your expectations.</p>
                            <p>
                                <a href="{{route('shop')}}" class="btn btn-sm animated-button gibson-three mt-4">Explore More</a>
                            </p>
                        </div>
                        <!-- /.col-lg-4 -->
                        <div class="col-lg-4 bottom-sub-grid text-center">
                            <div class="bt-icon">
                                <span class="fas fa-handshake"></span>
                            </div>
                            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">Customer Support</h4>
                            <p>Our dedicated support team is available 24/7 to assist you with any questions or issues you may have.</p>
                            <p>
                                <a href="{{route('contact')}}" class="btn btn-sm animated-button gibson-three mt-4">Contact Us</a>
                            </p>
                        </div>
                        <!-- /.col-lg-4 -->
                        <div class="col-lg-4 bottom-sub-grid text-center">
                            <div class="bt-icon">
                                <span class="fas fa-gift"></span>
                            </div>
                            <h4 class="sub-tittle-w3layouts my-lg-4 my-3">Exclusive Offers</h4>
                            <p>Enjoy special discounts and exclusive offers available only to our valued customers.</p>
                            <p>
                                <a href="{{route('about')}}" class="btn btn-sm animated-button gibson-three mt-4">View Offers</a>
                            </p>
                        </div>
                        <!-- /.col-lg-4 -->
                    </div>
                </div>

				<!-- //grids -->
				<div class="row galsses-grids pt-lg-5 pt-3">
                    <div class="col-lg-6 galsses-grid-left">
                        <figure class="effect-lexi">
                            <img src="{{asset('images/Ads/banner4.jpg')}}" alt="" class="img-fluid">
                            <figcaption>
                                <h3>Editor's
                                    <span>Pick</span>
                                </h3>
                                <p>Express your style now.</p>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-lg-6 galsses-grid-left">
                        <figure class="effect-lexi">
                            <img src="{{asset('images/Ads/banner1.jpg')}}" alt="" class="img-fluid">
                            <figcaption>
                                <h3>Editor's
                                    <span>Pick</span>
                                </h3>
                                <p>Discover our top selection.</p>
                            </figcaption>
                        </figure>
                    </div>
                </div>


				<!-- /clients-sec -->
				<div class="testimonials p-lg-5 p-3 mt-4">
					<div class="row last-section">
						<div class="col-lg-3 footer-top-w3layouts-grid-sec">
							<div class="mail-grid-icon text-center">
								<i class="fas fa-gift"></i>
							</div>
							<div class="mail-grid-text-info">
								<h3>Genuine Product</h3>
								<p>Lorem ipsum dolor sit amet, consectetur</p>
							</div>
						</div>
						<div class="col-lg-3 footer-top-w3layouts-grid-sec">
							<div class="mail-grid-icon text-center">
								<i class="fas fa-shield-alt"></i>
							</div>
							<div class="mail-grid-text-info">
								<h3>Secure Products</h3>
								<p>Lorem ipsum dolor sit amet, consectetur</p>
							</div>
						</div>
						<div class="col-lg-3 footer-top-w3layouts-grid-sec">
							<div class="mail-grid-icon text-center">
								<i class="fas fa-dollar-sign"></i>
							</div>
							<div class="mail-grid-text-info">
								<h3>Cash on Delivery</h3>
								<p>Lorem ipsum dolor sit amet, consectetur</p>
							</div>
						</div>
						<div class="col-lg-3 footer-top-w3layouts-grid-sec">
							<div class="mail-grid-icon text-center">
								<i class="fas fa-truck"></i>
							</div>
							<div class="mail-grid-text-info">
								<h3>Easy Delivery</h3>
								<p>Lorem ipsum dolor sit amet, consectetur</p>
							</div>
						</div>
					</div>
				</div>
				<!-- //clients-sec -->

			</div>
		</div>
        <!---728x90--->
	</section>

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
