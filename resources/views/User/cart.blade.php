@php
    $currentRouteName = Route::currentRouteName();
    $currentRouteDisplay = ucfirst(str_replace(['-', '.'], ' ', $currentRouteName));
@endphp
@extends('Layouts.master')
@section('page_title')
    Cart
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
    <div class="cart-page mt-100">
        <div class="container-fluid">
            <div class="cart-page-wrapper">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-12">
                        <table class="cart-table w-100">
                            <thead>
                                <tr>
                                    <th class="cart-caption heading_18 text-left">Image</th>
                                    <th class="cart-caption heading_18 text-left">Name</th>
                                    <th class="cart-caption text-center heading_18 text-left">Quantity</th>
                                    <th class="cart-caption text-end heading_18 text-left">Price</th>
                                </tr>
                            </thead>
                            <tbody id="cart-block">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="cart-total-area">
                            <h3 class="cart-total-title d-none d-lg-block mb-0">Cart Totals</h3>
                            <div class="cart-total-box mt-4">
                                <div class="subtotal-item subtotal-box">
                                    <h4 class="subtotal-title">Subtotals:</h4>
                                    <p class="subtotal-value" id="sub-total-price-cart"></p>
                                </div>
                                <div class="subtotal-item shipping-box">
                                    <h4 class="subtotal-title">Shipping:</h4>
                                    <p class="subtotal-value" id="shipping-price-cart"></p>
                                </div>
                                <div class="subtotal-item discount-box">
                                    <h4 class="subtotal-title">Discount:</h4>
                                    <p class="subtotal-value" id="discount-price-cart"></p>
                                </div>
                                <hr>
                                <div class="subtotal-item discount-box">
                                    <h4 class="subtotal-title">Total:</h4>
                                    <p class="subtotal-value" id="total-price-cart"></p>
                                </div>
                                <p class="shipping_text">Shipping &amp; taxes calculated at checkout</p>
                                <div class="d-flex justify-content-center mt-4">
                                    <a id="checkout-button" href="{{ route('checkout') }}" class="position-relative btn-checkout text-uppercase">
                                        Proceed to checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="featured-prd-cart mt-100 home-section overflow-hidden">
        <div class="section-header d-flex align-items-center justify-content-center">
            <h2 class="section-heading">Featured products</h2>
        </div>
        <div class="product-slider swiper">
            <div class="swiper-wrapper">
                @foreach ($relate_products as $relate_product)
                    <div class="box swiper-slide" id="product-{{ $relate_product->id }}">
                        <a href="{{ route('product-detail', $relate_product->id) }}" class="product-img">
                            <img src="{{ asset($relate_product->image[0]) }}" class="product-image">
                            <div class="product-label">
                                <span class="label-content">{{ $relate_product->label_name }}</span>
                            </div>
                        </a>
                        <div class="cart-info cart-wrap">
                            <a data-toggle="modal" data-target="#modal-cart" title="Add to cart" variant="primary"
                                class="btn-add-to-cart" id="cart-{{ $relate_product->id }}" onclick="add_to_cart(this.id)">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            <button title="Wishlist" class="btn_wishlist" id="wishlist-{{ $relate_product->id }}"
                                onclick="add_wishlist(this.id)">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                        <h2><a href="{{ route('product-detail', $relate_product->id) }}"
                                class="product-title product-name">{{ $relate_product->name }}</a></h2>
                        <div class="product-price">
                            <span class="price-content" id="product-price-{{ $relate_product->id }}"
                                data-base-price="{{ $relate_product->price }}">
                                ${{ $relate_product->price }}
                            </span>
                        </div>
                        <div class="product-variant-wrapper">
                            <ul class="color-variant">
                                @foreach ($relate_product->colors_with_prices as $color => $ratio_price)
                                    <li>
                                        <a href="javascript:void(0);" class="color-option"
                                            data-product-id="{{ $relate_product->id }}" data-price="{{ $ratio_price }}"
                                            data-color="{{ $color }}"
                                            style="background-color: {{ $color }};">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="stars">
                            @php
                                $rating = round($relate_product->product_reviews, 2);
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
@endsection
@push('custom-scripts')
    <script>
        var productDetailUrl = "{{ route('product-detail', ['id' => ':id']) }}";
        //product slide
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
        //color selected
        document.addEventListener('DOMContentLoaded', function() {
            const colorOptions = document.querySelectorAll('.color-option');

            colorOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    colorOptions.forEach(el => el.classList.remove('selected'));

                    option.classList.add('selected');

                    const productId = option.getAttribute('data-product-id');
                    const colorPrice = parseFloat(option.getAttribute('data-price'));
                    const basePriceElement = document.querySelector(`#product-price-${productId}`);
                    const basePrice = parseFloat(basePriceElement.getAttribute(
                        'data-base-price')) || 0;
                    const newPrice = (basePrice * colorPrice).toFixed(2);

                    if (basePriceElement) {
                        basePriceElement.textContent = `$${newPrice}`;
                    } else {
                        console.error('Base price element is missing');
                    }
                });
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

            var newItem = {
                id: id,
                image: image,
                name: name,
                price: price,
                color: color
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
                return obj.id == id && obj.color == color;
            });
            if (itemIndex !== -1) {
                old_data.splice(itemIndex, 1);
                localStorage.setItem('wishlist', JSON.stringify(old_data));
                $('#wishlist_list').find(`[data-index="${id}-${color}"]`).remove();

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
                    <li class="media d-flex align-items-center" data-index="${id}-${color}">
                        <div class="media-left media-middle">
                            <a href="/product-detail/${id}">
                                <img src="${image}" alt="Product Image">
                            </a>
                        </div>
                        <div class="media-body media-middle">
                            <button class="btn-remove-wishlist" onclick="removeFromWishlist('${id}-${color}')">
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

        function removeFromWishlist(idColor) {
            var wishlist = localStorage.getItem('wishlist');
            if (wishlist) {
                try {
                    var old_data = JSON.parse(wishlist);
                    old_data = old_data.filter(function(item) {
                        return item.id + '-' + item.color !== idColor;
                    });
                    localStorage.setItem('wishlist', JSON.stringify(old_data));

                    $('#wishlist_list').find(`[data-index="${idColor}"]`).remove();

                    var [id, color] = idColor.split('-');
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
        //cart
        function viewCartPage() {
            if (localStorage.getItem('cart') != null) {
                var cart = JSON.parse(localStorage.getItem('cart'));
                const prdCart = document.querySelector('#cart-block');
                if (prdCart) {
                    prdCart.innerHTML = '';
                    cart.forEach((item, index) => {
                        const {
                            name,
                            id,
                            image,
                            price,
                            color,
                            quantity
                        } = item;
                        const detailUrl = `${productDetailUrl.replace(':id', id)}`;
                        prdCart.innerHTML += `
                            <tr class="cart-item" data-index="${id}-${color}">
                                <td class="cart-item-media">
                                    <div class="mini-img-wrapper">
                                        <a href="/product-detail/${id}">
                                            <img class="mini-img" src="${image}" alt="img">
                                        </a>
                                    </div>
                                </td>
                                <td class="cart-item-details">
                                    <h2 class="product-name"><a href="/product-detail/${id}">${name}</a></h2>
                                    <p class="product-vendor text-capitalize">Color: ${color}</p>
                                </td>
                                <td class="cart-item-quantity">
                                    <div class="quantity-cart d-flex align-items-center justify-content-between" data-item-id="${id}" data-item-color="${color}">
                                        <button class="qty-btn dec-qty-cart">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input class="qty-input-cart" type="text" name="qty-cart" value="${quantity}" min="0">
                                        <button class="qty-btn inc-qty-cart">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                    <a href="javascript:void(0)" class="product-remove mt-2" onclick="removeFromCartPage('${id}-${color}')">Remove</a>
                                </td>
                                <td class="cart-item-price text-end">
                                    <div class="product-price">$${price}</div>
                                </td>
                            </tr>
                        `;
                    });
                    // Update qty
                    const decButtons = document.querySelectorAll('.dec-qty-cart');
                    const incButtons = document.querySelectorAll('.inc-qty-cart');
                    const inputQtys = document.querySelectorAll('.qty-input-cart');

                    function updateCart(id, color, qty) {
                        let cart = JSON.parse(localStorage.getItem('cart')) || [];
                        const itemIndex = cart.findIndex(item => item.id === id && item.color === color);
                        if (itemIndex !== -1) {
                            cart[itemIndex].quantity = qty;
                            localStorage.setItem('cart', JSON.stringify(cart));
                            totalPriceCart();
                        }
                    }

                    decButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const qtyInput = this.closest('.quantity-cart').querySelector(
                                '.qty-input-cart');
                            let currentValue = parseInt(qtyInput.value, 10);
                            const itemId = this.closest('.quantity-cart').dataset.itemId;
                            const itemColor = this.closest('.quantity-cart').dataset.itemColor;

                            if (currentValue > 1) {
                                qtyInput.value = currentValue - 1;
                                updateCart(itemId, itemColor, currentValue - 1);
                            } else {
                                removeFromCartPage(`${itemId}-${itemColor}`);
                            }
                        });
                    });

                    incButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const qtyInput = this.closest('.quantity-cart').querySelector(
                                '.qty-input-cart');
                            let currentValue = parseInt(qtyInput.value, 10);
                            const itemId = this.closest('.quantity-cart').dataset.itemId;
                            const itemColor = this.closest('.quantity-cart').dataset.itemColor;

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
                            const itemId = this.closest('.quantity-cart').dataset.itemId;
                            const itemColor = this.closest('.quantity-cart').dataset.itemColor;
                            updateCart(itemId, itemColor, currentValue);
                        });
                    });
                }
            }
            totalPriceCart();
        }
        //NAVBAR
        function viewCart() {
            if (localStorage.getItem('cart') != null) {
                var cart = JSON.parse(localStorage.getItem('cart'));
                const prdCart = document.querySelector('.cart_list');
                if (prdCart) {
                    prdCart.innerHTML = '';
                    cart.forEach((item, index) => {
                        const {
                            name,
                            id,
                            image,
                            price,
                            color,
                            quantity
                        } = item;
                        const detailUrl = `${productDetailUrl.replace(':id', id)}`;
                        prdCart.innerHTML += `
                            <li class="media d-flex align-items-center" data-index="${id}-${color}">
                                <div class="media-left media-middle">
                                    <a href="/product-detail/${id}">
                                        <img src="${image}" alt="">
                                    </a>
                                </div>
                                <div class="media-body media-middle">
                                    <button class="btn-remove-cart" onclick="removeFromCart('${id}-${color}')">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <p class="darklinks"><a href="/product-detail/${id}">${name}</a></p>
                                    <span class="product-quantity">
                                        <span class="price">$${price}</span>
                                        <div class="quantity-navbar d-flex align-items-center justify-content-between" data-item-id="${id}" data-item-color="${color}">
                                            <button class="qty-btn dec-qty-navbar">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <input class="qty-input-navbar" type="text" name="qty-navbar" value="${quantity}" min="0">
                                            <button class="qty-btn inc-qty-navbar">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </span>
                                </div>
                            </li>
                        `;

                        // Kiểm tra và thêm class cart-added nếu cần
                        var cartButton = document.getElementById('cart-' + id);
                        if (cartButton && cart.some(product => product.id === id && product.name === name && product
                                .price === price)) {
                            cartButton.classList.add('cart-added');
                        }
                    });

                    // Update qty
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
                        totalPrice(); // Cập nhật tổng giá trị giỏ hàng
                    }

                    decButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const qtyInput = this.closest('.quantity-navbar').querySelector(
                                '.qty-input-navbar');
                            let currentValue = parseInt(qtyInput.value, 10);
                            const itemId = this.closest('.quantity-navbar').dataset.itemId;
                            const itemColor = this.closest('.quantity-navbar').dataset.itemColor;

                            if (currentValue > 1) {
                                qtyInput.value = currentValue - 1;
                                updateCart(itemId, itemColor, currentValue - 1);
                            } else {
                                removeFromCart(`${itemId}-${itemColor}`);
                            }
                        });
                    });

                    incButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const qtyInput = this.closest('.quantity-navbar').querySelector(
                                '.qty-input-navbar');
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
                        });
                    });
                }
            }
            updateCartCount();
            updateCartButtons();
            totalPrice();
        }
        viewCartPage();
        viewCart();
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

            // shpping
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
            //total
            var total = subtotal + shipping - discount;

            if (subTotalText) {
                subTotalText.innerHTML = '$' + subtotal.toFixed(2);
            }
            if (shippingText) {
                shippingText.innerHTML = '$' + shipping.toFixed(2);
            }
            if (discountText) {
                discountText.innerHTML = '$' + discount.toFixed(2);
            }
            if (totalText) {
                totalText.innerHTML = '$' + total.toFixed(2);
            }
            return total;
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
                // Increment quantity
                old_data[itemIndex].quantity += 1;
                var cartButton = document.getElementById('cart-' + id);
                if (cartButton) {
                    cartButton.classList.add('cart-added');
                }
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
            updateCartListCart();
            updateCartCount();
            updateCartButtons();
            totalPriceCart();
            viewCart();
        }
        function updateCartListCart() {
        var cart = localStorage.getItem('cart');
        var old_data = [];
        if (cart) {
            try {
                old_data = JSON.parse(cart);
            } catch (e) {
                console.error("Failed to parse cart JSON:", e);
            }
        }

        var cartList = document.querySelector('#cart-block');
        cartList.innerHTML = '';

        var cartListNav = document.querySelector('#cart_list');
        cartListNav.innerHTML = '';

        old_data.forEach(function(item) {
            // Add items to the cart table
            cartList.insertAdjacentHTML('beforeend', `
                <tr class="cart-item" data-index="${item.id}-${item.color}">
                    <td class="cart-item-media">
                        <div class="mini-img-wrapper">
                            <a href="/product-detail/${item.id}">
                                <img class="mini-img" src="${item.image}" alt="${item.name}">
                            </a>
                        </div>
                    </td>
                    <td class="cart-item-details">
                        <h2 class="product-name"><a href="/product-detail/${item.id}">${item.name}</a></h2>
                        <p class="product-vendor text-capitalize">Color: ${item.color}</p>
                    </td>
                    <td class="cart-item-quantity">
                        <div class="quantity-cart d-flex align-items-center justify-content-between" data-item-id="${item.id}" data-item-color="${item.color}">
                            <button class="qty-btn dec-qty-cart">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input class="qty-input-cart" type="text" name="qty-cart" value="${item.quantity}" min="0">
                            <button class="qty-btn inc-qty-cart">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <a href="javascript:void(0)" class="product-remove mt-2" onclick="removeFromCartPage('${item.id}-${item.color}')">Remove</a>
                    </td>
                    <td class="cart-item-price text-end">
                        <div class="product-price">$${item.price}</div>
                    </td>
                </tr>
            `);

            // Add items to the navbar
            cartListNav.insertAdjacentHTML('beforeend', `
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

        // Function to update cart and navbar quantity
        function updateCart(id, color, qty) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const itemIndex = cart.findIndex(item => item.id === id && item.color === color);
            if (itemIndex !== -1) {
                cart[itemIndex].quantity = qty;
                localStorage.setItem('cart', JSON.stringify(cart));
            }
            updateCartCount();
            updateCartButtons();
            updateCartNav(id, color, qty);
        }

        // Update quantity in cart and navbar
        function updateCartNav(id, color, qty) {
            let cartListNavItems = document.querySelectorAll(`#cart_list [data-index="${id}-${color}"]`);
            cartListNavItems.forEach(item => {
                const qtyInputNav = item.querySelector('.qty-input-navbar');
                if (qtyInputNav) {
                    qtyInputNav.value = qty;
                }
            });
        }

        // Event listeners for cart quantity changes
        const decButtons = document.querySelectorAll('.dec-qty-cart');
        const incButtons = document.querySelectorAll('.inc-qty-cart');
        const inputQtys = document.querySelectorAll('.qty-input-cart');

        decButtons.forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.closest('.quantity-cart').querySelector('.qty-input-cart');
                let currentValue = parseInt(qtyInput.value, 10);
                const itemId = this.closest('.quantity-cart').dataset.itemId;
                const itemColor = this.closest('.quantity-cart').dataset.itemColor;

                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                    updateCart(itemId, itemColor, currentValue - 1);
                } else {
                    removeFromCartPage(`${itemId}-${itemColor}`);
                }
                totalPriceCart();
                viewCart();
            });
        });

        incButtons.forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.closest('.quantity-cart').querySelector('.qty-input-cart');
                let currentValue = parseInt(qtyInput.value, 10);
                const itemId = this.closest('.quantity-cart').dataset.itemId;
                const itemColor = this.closest('.quantity-cart').dataset.itemColor;

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
                totalPriceCart();
                viewCart();
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
                const itemId = this.closest('.quantity-cart').dataset.itemId;
                const itemColor = this.closest('.quantity-cart').dataset.itemColor;
                updateCart(itemId, itemColor, currentValue);
                totalPriceCart();
                viewCart();
            });
        });

        // Event listeners for navbar quantity changes
        const decButtonNav = document.querySelectorAll('.dec-qty-navbar');
        const incButtonsNav = document.querySelectorAll('.inc-qty-navbar');
        const inputQtysNav = document.querySelectorAll('.qty-input-navbar');

        decButtonNav.forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.closest('.quantity-navbar').querySelector('.qty-input-navbar');
                let currentValue = parseInt(qtyInput.value, 10);
                const itemId = this.closest('.quantity-navbar').dataset.itemId;
                const itemColor = this.closest('.quantity-navbar').dataset.itemColor;

                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                    updateCart(itemId, itemColor, currentValue - 1);
                } else {
                    removeFromCartPage(`${itemId}-${itemColor}`);
                }
                totalPriceCart();
            });
        });

        incButtonsNav.forEach(button => {
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
                totalPriceCart();
            });
        });

        inputQtysNav.forEach(input => {
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
                totalPriceCart();
            });
        });

        updateCartCount();
        updateCartButtons();
        }

        function removeFromCartPage(idColor) {
            var cart = localStorage.getItem('cart');
            if (cart) {
                try {
                    var old_data = JSON.parse(cart);
                    old_data = old_data.filter(function(item) {
                        return item.id + '-' + item.color !== idColor;
                    });
                    localStorage.setItem('cart', JSON.stringify(old_data));
                    document.querySelector(`#cart-block [data-index="${idColor}"]`).remove();
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
            totalPriceCart();
            viewCart();
        }
        // button
        document.addEventListener('DOMContentLoaded', function() {
            var cartItems = JSON.parse(localStorage.getItem('cart'));
            var checkoutButton = document.getElementById('checkout-button');
            if (!cartItems || cartItems.length === 0) {
                checkoutButton.textContent = 'Shop Now';
                checkoutButton.href = '{{ route('shop') }}';
            }
        });
    </script>
@endpush
