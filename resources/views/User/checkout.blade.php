@php
    $currentRouteName = Route::currentRouteName();
    $currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@extends('Layouts.master')
@section('page_title')
    Check Out
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
    <div class="page-section section">
        <section class="bg-light py-5">
            <div class="container">
                <form action="{{route('checkout-post')}}" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-8 col-lg-8 mb-4">
                        <div class="card shadow-0 border">
                            <div class="p-4">
                                <h5 class="card-title mb-3 fw-bold guest-checkout-title">Guest checkout</h5>
                                <div class="row">
                                    <div class="col-12 d-none">
                                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                                    </div>
                                    <div class="col-12 mb-3 checkout-item">
                                        <p class="mb-0">Full Name</p>
                                        <div class="form-outline">
                                            <input type="text" id="full_name" placeholder="Full Name"
                                                class="form-control" name="full_name" value="{{$user->username}}" required/>
                                        </div>
                                        @error('payment_id')
                                            <span class='text-danger-login'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3 checkout-item">
                                        <p class="mb-0">Phone</p>
                                        <div class="form-outline">
                                            <input type="tel" id="typePhone" class="form-control" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Phone Number" required/>
                                        </div>
                                        @error('phone')
                                            <span class='text-danger-login'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3 checkout-item">
                                        <p class="mb-0">Email</p>
                                        <div class="form-outline">
                                            <input type="email" id="typeEmail" placeholder="example@gmail.com"
                                                class="form-control" name="email" value="{{$user->email}}" required/>
                                        </div>
                                        @error('email')
                                            <span class='text-danger-login'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="my-4" />

                                <h5 class="card-title mb-3 shipping-info-title">Shipping info</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="shipping_method" id="delivery-express" value="Express Delivery" checked />
                                                <label class="form-check-label" for="delivery-express">
                                                    Express delivery <br />
                                                    <small class="text-muted">3-4 days via Fedex</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="shipping_method" id="delivery-postal" value="Postal Delivery"/>
                                                <label class="form-check-label" for="delivery-postal">
                                                    Postal Delivery<br />
                                                    <small class="text-muted">20-30 days via post</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="shipping_method" id="delivery-pickup" value="Self Pick-Up"/>
                                                <label class="form-check-label" for="delivery-pickup">
                                                    Self Pick-Up <br />
                                                    <small class="text-muted">Come to our shop</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('shipping_method')
                                        <span class='text-danger-login'>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 mb-3 checkout-item">
                                        <p class="mb-0">Country</p>
                                        <div class="form-outline">
                                            <input type="text" id="country" placeholder="Country"
                                                class="form-control" name="country" required/>
                                        </div>
                                        @error('country')
                                            <span class='text-danger-login'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3 checkout-item">
                                        <p class="mb-0">Province</p>
                                        <div class="form-outline">
                                            <input type="text" id="province" placeholder="Province"
                                                class="form-control" name="province" required/>
                                        </div>
                                    @error('province')
                                        <span class='text-danger-login'>{{ $message }}</span>
                                    @enderror
                                    </div>

                                    <div class="col-sm-6 mb-3 checkout-item">
                                        <p class="mb-0">District</p>
                                        <div class="form-outline">
                                            <input type="text" id="district" placeholder="District"
                                                class="form-control" name="district" required/>
                                        </div>
                                    @error('district')
                                        <span class='text-danger-login'>{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3 checkout-item">
                                        <p class="mb-0">House Number</p>
                                        <div class="form-outline">
                                            <input type="text" id="houseNumber" placeholder="House Number"
                                                class="form-control" name="houseNumber" required/>
                                        </div>
                                    @error('houseNumber')
                                        <span class='text-danger-login'>{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="mb-3 checkout-item">
                                    <p class="mb-0">Message to seller</p>
                                    <div class="form-outline">
                                        <textarea class="form-control" id="textAreaExample1" rows="2" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 d-flex justify-content-center justify-content-lg-end">
                        <div class="ms-lg-4 mt-4 mt-lg-0 cart-summary">
                            <h6 class="mb-3 fw-bold summary-title">Summary</h6>
                            <div class="d-flex justify-content-between summary-item">
                                <p class="mb-2">Total price:</p>
                                <p class="mb-2" id="sub-total-price-cart"></p>
                            </div>
                            <div class="d-flex justify-content-between summary-item">
                                <p class="mb-2">Discount:</p>
                                <p class="mb-2 text-danger" id="discount-price-cart">- </p>
                            </div>
                            <div class="d-flex justify-content-between summary-item">
                                <p class="mb-2">Shipping cost:</p>
                                <p class="mb-2" id="shipping-price-cart">+ </p>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between summary-item pd-10">
                                <p class="mb-2">Total price:</p>
                                <p class="mb-2 fw-bold" id="total-price-cart">$</p>
                            </div>
                            {{-- get value --}}
                            <input type="hidden" name="sub_total" id="hidden-sub-total">
                            <input type="hidden" name="shipping_cost" id="hidden-shipping-cost">
                            <input type="hidden" name="discount" id="hidden-discount">
                            <input type="hidden" name="total" id="hidden-total">
                            <hr />
                            <h6 class="text-dark fw-bold my-4 summary-title">Items in cart</h6>

                            <div id="prd-checkout-block">

                            </div>
                            {{-- get data prd --}}
                            <input type="hidden" name="products" id="hidden-products">
                            <div class="checkout-method" id="checkout-method" style="display: none;">
                                <div class="payment-methods">
                                    <h4>Select Payment Method</h4>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_id" id="credit-card" value="1" checked>
                                        <label class="form-check-label" for="credit-card">Credit Card</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_id" id="Banking" value="3">
                                        <label class="form-check-label" for="Banking">Banking</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_id" id="pay-later" value="2">
                                        <label class="form-check-label" for="pay-later">Pay on Delivery</label>
                                    </div>
                                    @if ($errors->has('payment_id'))
                                        <span class='text-danger-login'>{{ $errors->first('payment_id') }}</span>
                                    @endif
                                </div>

                                <div class="card-block" id="payment-details">
                                    <div class="card px-4">
                                        <p class="h4 py-3">Payment Details</p>
                                        <div class="row gx-3">
                                            <div class="col-12">
                                                <div class="d-flex flex-column">
                                                    <p class="text mb-1">Person Name</p>
                                                    <input id="person-name" class="form-control mb-3" type="text" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex flex-column">
                                                    <p class="text mb-1">Card Number</p>
                                                    <input id="card-number" class="form-control mb-3" type="text" placeholder="1234 5678 435678">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <p class="text mb-1">Expiry</p>
                                                    <input id="expiry" class="form-control mb-3" type="text" placeholder="MM/YYYY">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <p class="text mb-1">CVV/CVC</p>
                                                    <input id="cvv" class="form-control mb-3 pt-2" type="password" placeholder="***">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="qr-code-block text-center" id="qr-code-block" style="display: none">
                                    <h4>Scan to Pay</h4>
                                    <img src="{{asset('images/Dashboard/qr.jpg')}}" alt="Bank QR Code" style="width: 200px; height: auto;">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="ps-3">Pay $243</span>
                                        <span class="fas fa-arrow-right"></span>
                                    </button>
                                    <a href="{{route('cart')}}" class="btn btn-cancle mb-3">
                                        <span class="ps-3">Back To Cart</span>
                                        <span class="fas fa-arrow-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
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
        document.addEventListener('DOMContentLoaded', function() {
            var productDetailUrl = "{{ route('product-detail', ['id' => ':id']) }}";
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
                    discountText.innerHTML = '-$' + discount.toFixed(2); // Added '-' for discount
                }
                if (totalText) {
                    totalText.innerHTML = '$' + total.toFixed(2);
                }

                // Update hidden inputs
                document.querySelector('#hidden-sub-total').value = subtotal.toFixed(2);
                document.querySelector('#hidden-shipping-cost').value = shipping.toFixed(2);
                document.querySelector('#hidden-discount').value = discount.toFixed(2);
                document.querySelector('#hidden-total').value = total.toFixed(2);

                return total;
            }

            function viewCheckout(orderId) {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const prdCart = document.querySelector('#prd-checkout-block');
                const paymentMethodContainer = document.querySelector('.payment-methods');
                const paymentDetails = document.querySelector('#payment-details');
                const payButton = document.querySelector('.btn.btn-primary .ps-3');
                const checkoutMethod = document.querySelector('#checkout-method');
                const productsInput = document.querySelector('#hidden-products');

                const totalAmount = totalPriceCart();

                if (prdCart) {
                    if (cart.length === 0) {
                        prdCart.innerHTML = `
                            <div class="text-center back-shop">
                                <p class="mb-4">Your cart is empty.</p>
                                <a href="{{ route('shop') }}" class="btn btn-back">Shop Now</a>
                            </div>
                        `;
                        if (paymentMethodContainer) {
                            paymentMethodContainer.classList.remove('show');
                        }
                        if (paymentDetails) {
                            paymentDetails.classList.remove('show');
                        }
                        if (payButton) {
                            payButton.textContent = `Pay $0.00`;
                        }
                        if (checkoutMethod) {
                            checkoutMethod.style.display = 'none';
                        }
                    } else {
                        prdCart.innerHTML = '';
                        let productsHTML = '';
                        cart.forEach((item) => {
                            let { name, id, image, price, color, size, quantity } = item;
                            color = color || 'White';
                            size = size || 'M';

                            const detailUrl = `${productDetailUrl.replace(':id', id)}`;
                            const total = price * quantity;

                            prdCart.innerHTML += `
                                <div class="d-flex align-items-center mb-4 checkout-block-item" data-index="${id}-${color}-${size}">
                                    <button class="btn-remove-cart" data-id="${id}" data-color="${color}" data-size="${size}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <div class="me-3 position-relative">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                                            ${quantity}
                                        </span>
                                        <img src="${image}" class="img-sm rounded border" />
                                    </div>
                                    <div class="">
                                        <a href="${detailUrl}" class="nav-link">
                                            ${name} - ${color} - ${size}
                                        </a>
                                        <div class="price text-muted">Total: $${total.toFixed(2)}</div>
                                    </div>
                                </div>
                            `;

                            productsHTML += `${id},${name},${price},${image},${quantity},${color},${size}; `;
                        });

                        if (paymentMethodContainer) {
                            paymentMethodContainer.classList.add('show');
                        }
                        if (paymentDetails) {
                            paymentDetails.classList.add('show');
                        }
                        if (payButton) {
                            payButton.textContent = `Pay $${totalAmount.toFixed(2)}`;
                        }
                        if (checkoutMethod) {
                            checkoutMethod.style.display = 'block';
                        }

                        productsInput.value = productsHTML.trim();

                        document.querySelectorAll('.btn-remove-cart').forEach(button => {
                            button.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                const color = this.getAttribute('data-color');
                                const size = this.getAttribute('data-size');
                                removeFromCartCheckOut(`${id}-${color}-${size}`);
                            });
                        });
                        const paymentMethods = document.querySelectorAll('input[name="payment_id"]');
                        paymentMethods.forEach(method => {
                            method.addEventListener('change', function () {
                                const selectedPaymentMethod = document.querySelector('input[name="payment_id"]:checked')?.value || '3';
                                if (selectedPaymentMethod === '3') {
                                    payButton.textContent = `Banking Now ($${totalAmount.toFixed(2)})`;
                                } else if (selectedPaymentMethod === '2') {
                                    payButton.textContent = `Order Now ($${totalAmount.toFixed(2)})`;
                                } else {
                                    payButton.textContent = `Pay $${totalAmount.toFixed(2)}`;
                                }
                            });
                        });
                    }
                } else {
                    if (prdCart) {
                        prdCart.innerHTML = `
                            <div class="text-center back-shop">
                                <p class="mb-4">Your cart is empty.</p>
                                <a href="{{ route('shop') }}" class="btn btn-back">Shop Now</a>
                            </div>
                        `;
                    }
                    if (paymentMethodContainer) {
                        paymentMethodContainer.classList.remove('show');
                    }
                    if (paymentDetails) {
                        paymentDetails.classList.remove('show');
                    }
                    if (checkoutMethod) {
                        checkoutMethod.style.display = 'none';
                    }
                }
                updateCartCount();
                updateCartButtons();
            }
            function removeFromCartCheckOut(idColor) {
                var cart = localStorage.getItem('cart');
                if (cart) {
                    try {
                        var old_data = JSON.parse(cart);
                        old_data = old_data.filter(function(item) {
                            return item.id + '-' + item.color !== idColor;
                        });
                        localStorage.setItem('cart', JSON.stringify(old_data));
                        viewCheckout();
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
                totalPriceCart();
            }
            viewCheckout();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const paymentDetails = document.getElementById('payment-details');
            const qrCodeBlock = document.getElementById('qr-code-block');
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_id"]');

            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.id === 'credit-card') {
                        paymentDetails.style.display = 'block';
                        qrCodeBlock.style.display = 'none';
                    } else if (this.id === 'Banking') {
                        qrCodeBlock.style.display = 'block';
                        paymentDetails.style.display = 'none';
                    } else {
                        paymentDetails.style.display = 'none';
                        qrCodeBlock.style.display = 'none';
                    }
                });
            });
        });
        document.querySelectorAll('input[name="payment_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                var paymentId = this.value;
                var paymentDetails = document.getElementById('payment-details');
                var personName = document.getElementById('person-name');
                var cardNumber = document.getElementById('card-number');
                var expiry = document.getElementById('expiry');
                var cvv = document.getElementById('cvv');

                if (paymentId == '1') {
                    paymentDetails.style.display = 'block';
                    personName.setAttribute('required', true);
                    cardNumber.setAttribute('required', true);
                    expiry.setAttribute('required', true);
                    cvv.setAttribute('required', true);
                } else {
                    paymentDetails.style.display = 'none';
                    personName.removeAttribute('required');
                    cardNumber.removeAttribute('required');
                    expiry.removeAttribute('required');
                    cvv.removeAttribute('required');
                }
            });
        });
    </script>
@endpush
