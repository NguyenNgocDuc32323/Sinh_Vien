@extends('Layouts.master')
@section('page_title')
    Contact
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
<div class="container contact-block text-center">
    <div class="contact-info">
        <div class="info-wrap w-100 p-md-5 p-4">
            <h3>Let's get in touch</h3>
            <p class="mb-4" style="padding: 1rem 0;">We're open for any suggestion or just to have a chat</p>
    <div class="dbox w-100 d-flex align-items-start">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-map-marker"></span>
        </div>
        <div class="text-info-company pl-3">
        <p><span>Address:</span>185 Doi Can,Ba Dinh,Ha Noi,Viet Nam.</p>
      </div>
  </div>
    <div class="dbox w-100 d-flex align-items-center">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-phone"></span>
        </div>
        <div class="text-info-company pl-3">
        <p><span>Phone:</span>+ 1235 2355 98</p>
      </div>
  </div>
    <div class="dbox w-100 d-flex align-items-center">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-paper-plane"></span>
        </div>
        <div class="text-info-company pl-3">
        <p><span>Email:</span>polysite@gmail.com</p>
      </div>
  </div>
    <div class="dbox w-100 d-flex align-items-center">
        <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-globe"></span>
        </div>
        <div class="text-info-company pl-3">
        <p><span>Website:</span> <a href="{{route('home')}}">polysite.com</a></p>
      </div>
  </div>
</div>
    </div>
    <div class="contact-forms">
        <h2>Contact To Post</h2>
        <form id="contact-form" method="POST" action="{{ route('send-contact-form') }}">
            @csrf

            <label for="name">Your name </label>
            <input type="text" id="username" name="username"
                value="{{ auth()->check() ? auth()->user()->username : '' }}"
                {{ auth()->check() ? 'readonly' : 'required' }}>

            <label for="email">Your Email </label>
            <input type="email" id="email" name="email"
                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                {{ auth()->check() ? 'readonly' : 'required' }}>

            <label for="phone">Your Phone Number</label>
            <input type="tel" id="phone" name="phone"
                value="{{ auth()->check() && auth()->user()->phone ? auth()->user()->phone : '' }}"
                {{ auth()->check() ? '' : '' }}>

            <label for="title">Title Contact</label>
            <input type="text" id="title" name="title" required></input>

            <label for="content" class="mb-3">What's on your mind?</label>
            <textarea class="form-control mb-4" id="content" placeholder="Enter The Content" name="content" style="min-height: 300px; width: 100%;"></textarea>

            <button type="submit" class="mt-4">Send it</button>
        </form>

        <div id="response-message"></div>
    </div>
</div>
@endsection
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('input[type="text"], input[type="email"],input[type="password"],input[type="number"], textarea');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
                });
            });
        });
        //CK EDITOR
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    ckfinder: {
                        uploadUrl: '{{ route('upload-image') }}?_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                    editor.plugins.get('ImageUpload').on('uploadSuccess', (evt, { data: { url } }) => {
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
        //
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
