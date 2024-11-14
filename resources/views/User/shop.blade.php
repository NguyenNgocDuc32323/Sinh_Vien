@extends('Layouts.master_shop')
@section('page_title')
    Shop
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
    <section class="mt-5">
        <div class="search-history {{ session()->has('search_history') ? 'active' : '' }}">
            @if (session('search_history'))
                <div class="search-history-content d-flex align-items-center gap-3">
                    <h4>Search History</h4>
                    <div class="search-history-details">
                        @if (isset($searchHistory['category']))
                            <span>
                                Category: {{ $searchHistory['category'] }}
                                <button class="btn-hidden-search">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </span>
                        @endif
                        @if (isset($searchHistory['colors']) && is_array($searchHistory['colors']))
                            <span>
                                Colors: {{ implode(', ', $searchHistory['colors']) }}
                                <button class="btn-hidden-search">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </span>
                        @endif
                        @if (isset($searchHistory['minPrice']) && isset($searchHistory['maxPrice']))
                            <span>
                                Price: {{ $searchHistory['minPrice'] }}$ - {{ $searchHistory['maxPrice'] }}$
                                <button class="btn-hidden-search">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </span>
                        @endif
                    </div>
                </div>
            @else
                <p>No search history found.</p>
            @endif
        </div>
        <div class="product-wrapper-grid">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-grid-box col-xxl-4 col-xl-4 col-md-4 col-sm-12">
                        <div class="product-box">
                            <div id="product-{{ $product->id }}">
                                <div class="img-wrapper">
                                    <div class="lable-block">
                                        <span class="lable3">{{ $product->label_name }}</span>
                                    </div>
                                    <div class="front">
                                        <a href="{{ route('product-detail', $product->id) }}" class="">
                                            <img src="{{ asset($product->image[0]) }}"
                                                class="img-fluid bg-img media product-image" alt="trim dress">
                                        </a>
                                    </div>
                                    <div class="back">
                                        <a href="{{ route('product-detail', $product->id) }}" class="">
                                            <img src="{{ asset($product->image[1]) }}" alt=""
                                                class="img-fluid m-auto media">
                                        </a>
                                    </div>
                                    <div class="cart-info cart-wrap">
                                        <a data-toggle="modal" data-target="#modal-cart" title="Add to cart"
                                            variant="primary" class="btn-add-to-cart" id="cart-{{ $product->id }}" onclick="add_to_cart(this.id)">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                        <button title="Wishlist" class="btn_wishlist" id="wishlist-{{ $product->id }}" onclick="add_wishlist(this.id)">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div class="rating">
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
                                    <a href="{{ route('product-detail', $product->id) }}" class="product-name">
                                        <h4>{{ $product->name }}</h4>
                                    </a>
                                    <h5 id="product-price-{{ $product->id }}" class="product-price"
                                        data-base-price="{{ $product->price }}">
                                        ${{ $product->price }}
                                    </h5>
                                    <ul class="color-variant">
                                        @foreach ($product->colors_with_prices as $color => $ratio_price)
                                            <li>
                                                <a href="javascript:void(0);" class="color-option"
                                                    data-product-id="{{ $product->id }}" data-price="{{ $ratio_price }}"
                                                    data-color="{{ $color }}"
                                                    style="background-color: {{ $color }};">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center mt-5 not-found-block">
                        <p class="fw-bold prd-not-found">No products found</p>
                    </div>
                @endforelse
                @if ($products)
                    <div class="d-flex justify-content-center ml-2 paginate mt-5">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('custom-scripts')
    <script>
        var productDetailUrl = "{{ route('product-detail', ['id' => ':id']) }}";
        document.addEventListener('DOMContentLoaded', function() {
            const colorOptions = document.querySelectorAll('.color-variant a');
            colorOptions.forEach(option => {
                option.addEventListener('click', function(event) {
                    event.preventDefault();
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
        document.querySelectorAll('.btn-hidden-search').forEach(button => {
            button.addEventListener('click', function() {
                const searchHistory = document.querySelector('.search-history');
                searchHistory.classList.add('hidden');
            });
        });
        //color selected
        document.addEventListener('DOMContentLoaded', function() {
            const colorOptions = document.querySelectorAll('.color-option');

            colorOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    const productId = option.getAttribute('data-product-id');
                    const colorPrice = parseFloat(option.getAttribute('data-price'));
                    const basePriceElement = document.querySelector(`#product-price-${productId}`);
                    const basePrice = parseFloat(basePriceElement.getAttribute(
                        'data-base-price')) || 0;
                    console.log(colorPrice);
                    // Calculate the new price
                    const newPrice = (basePrice * colorPrice).toFixed(2);

                    // Update the price element with the new price
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
            var nameElement = productElement.querySelector('.product-name h4');
            var name = nameElement ? nameElement.innerText : 'No name';

            var basePriceElement = productElement.querySelector('.product-price');
            var basePrice = basePriceElement ? parseFloat(basePriceElement.getAttribute('data-base-price')) : 0;

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
            cartList.innerHTML = ''; // remove current cart list
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

            // Add event listeners for remove buttons
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
