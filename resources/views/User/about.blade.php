@extends('Layouts.master')
@section('page_title')
    About Us
@endsection
@section('content')
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.success('{{ session('success') }}');
        });
    </script>
    @endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.error('{{ session('error') }}');
        });
    </script>
@endif
<div class="fixed-bg">
    <div class="bgr-1">
        <img src="{{asset('images/About/tải xuống.avif')}}" alt="">
    </div>
    <div class="bgr-2">
        <h1>We're Celebrating 20 Years of Action!</h1>
        <p>Here at Klean Kanteen, we’ve been getting after it for 20 years. Every day, we pour our hearts into bold action, big adventures, and using our business as a force for good.</p>
    </div>
</div>
<div class="content">
    <div class="content-1">
        <h1>In 2004 we kicked off the Bring Your Own™ revolution by offering the first reusable stainless steel water bottles in the United States.</h1>
        <h5>Back in the early 2000s, the popularity of bottled water was on the rise. Suddenly, everyone seemed to be sipping from single-use plastic bottles as they went about their days. At the time, few people understood the human health risks of plastic or could foresee just how many of those plastic bottles would end up littering the planet. Enter Chico-based inventor Robert Seals. Using materials from his local hardware store, Robert prototyped the first reusable stainless steel water bottle in the United States. Unlike its European forerunners, Robert’s bottle was free of aluminum and BPA liners, making it safer and more sustainable.  </h5>
    </div>
    <div class="content-2">
        <div>
            <img src="{{asset('images/About/anh1.webp')}}" alt="">
            <p>Sister-and-brother duo Michelle Kalberer and Jeff Cresswell</p>
        </div>
        <div>
            <img src="{{asset('images/About/anh2.webp')}}" alt="">
            <p>Jeff Cresswell pulling early Kanteens off the line</p>
        </div>
    </div>
    <div class="content-3">
        <h5>
            In 2004, Robert founded Klean Kanteen to sell his revolutionary stainless steel water bottles at music festivals, environmental fairs, outdoor recreation events and other gatherings. Soon, sister-and-brother duo Michelle Kalberer and Jeff Cresswell, along with their father Darrel “the Dude” Cresswell, joined Robert to help with backend operations. The family quickly saw the potential to kick-off a worldwide Bring Your Own™ revolution and to build a brand that is both a force for good and loved the world over. In 2005, Robert passed the Klean Kanteen torch to the Cresswell family. </h5>
    </div>
</div>
<div class="fixed-bg-1">
    <h1>Today our company continues to revolutionize reusables by making them more sustainable, durable, and functional than ever before.</h1>
</div>
<div class="content_1">
    <div class="content_2">
        <h1>In 20 years, the average person uses 3,120 single-use plastic bottles.</h1>
        <p>Good thing Klean Kanteen fans are far from average. One Klean Kanteen has the power to save piles of plastic from polluting the planet. All it takes is one.</p>
        <a href="{{route('shop')}}">Shop Bottles</a>
    </div>
    <div class="content_3">
        <img src="{{asset('images/About/anh3.webp')}}" alt="">
    </div>
</div>
<div class="content">
    <h5 class="width-70">While our original to-go bottle is still a Classic, we’ve gone beyond the bottle to design alternatives to disposable coffee cups, drinkware, to-go cartons, food storage containers, straws and more. All while taking care of our people and the planet. Since 2008, Klean Kanteen has donated more than $4.3 million to environmental non-profits through 1% for the Planet. We are also a certified B Corp and certified Climate Neutral in our operations. Living Klean is what fills us up day after day, year after year. </h5>
</div>
<div class="fixed-bg-2">
    <h1>Here's to 20 Years of Action - And Cheers to Many More!</h1>
    <img src="{{asset('images/About/plannet.avif')}}" width height style alt="Certified B Corp, 1% for the Planet Member, and Climate Neutral Certified" class="shogun-image " decoding="async" loading="lazy">
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
