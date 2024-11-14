<div class="navbar">
    <div class="page_header_wrapper w-100">
        <div class="page_header">
            <div class="container-fluid mobile-container">
                <div class="row">
                    <div class="col-sm-12 d-flex align-items-center justify-content-between position-relative">
                        <div class="header_left_logo order-1">
                            <a href="{{ route('home') }}">
                                <img id="logo" src="{{ asset('images/Dashboard/logo_1.png') }}" alt="logo">
                            </a>
                        </div>
                        {{-- Menu Desktop --}}
                        <div class="header_mainmenu text-center flex-grow-1 order-2">
                            <nav class="mainmenu_wrapper nav justify-content-center">
                                <ul class="mainmenu d-flex">
                                    <button class="close-mainmenu">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    @php
                                        $currentRoute = Route::currentRouteName();
                                    @endphp
                                    <li class="nav-item {{ $currentRoute == 'home' || $currentRoute == 'user-profile' || $currentRoute == 'user-profile-edit' ? 'active' : '' }}">
                                        <a href="{{ route('home') }}" class="sf-with-ul nav-link">Home</a>
                                    </li>
                                    <li
                                        class="nav-item {{ in_array($currentRoute, ['shop', 'product-detail']) || $currentRoute == 'shop-filter-price' || $currentRoute == 'shop-filter-color' || $currentRoute == 'shop-filter-category' ? 'active' : '' }}">
                                        <a href="{{ route('shop') }}" class="sf-with-ul nav-link">Shop</a>
                                    </li>
                                    <li class="nav-item {{ $currentRoute == 'about' ? 'active' : '' }}">
                                        <a href="{{ route('about') }}" class="sf-with-ul nav-link">About Us</a>
                                    </li>
                                    <li class="nav-item {{ $currentRoute == 'contact' ? 'active' : '' }}">
                                        <a href="{{ route('contact') }}" class="sf-with-ul nav-link">Contact Us</a>
                                    </li>
                                    <li class="nav-item {{ $currentRoute == 'blog' || $currentRoute == 'blog-detail'  ? 'active' : '' }}">
                                        <a href="{{route('blog')}}" class="sf-with-ul nav-link">Blog</a>
                                    </li>
                                    <li class="nav-item {{ $currentRoute == 'ads' ? 'active' : '' }}">
                                        <a href="{{ route('ads') }}" class="sf-with-ul nav-link">Ads</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div id="menu-button" class="d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="overlay"></div>
                        <div class="header_right_buttons text-right d-flex align-items-center order-3">
                            <a id="search-icon-home" title="Search Product" href="#" role="button"
                                aria-expanded="false" aria-haspopup="true"
                                class="theme_button small_button round_button bg_button margin_0 mx-2 icon-button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <a id="heart-icon-home" title="Wish List" href="#" role="button"
                                aria-expanded="false" aria-haspopup="true"
                                class="theme_button small_button round_button bg_button margin_0 mx-2 icon-button">
                                <i class="fa-solid fa-heart"></i>
                                <span class="count-wishlist"></span>
                            </a>
                            <div class="dropdown-menu-wishlist" aria-labelledby="heart-icon-home">
                                <div class="widget widget_shopping_cart">
                                    <div class="widget_shopping_cart_content">
                                        <ul id="wishlist_list" class="product_list_widget">
                                        </ul>
                                        <hr>
                                        <div class="d-flex align-items-center mb-3 text-center">
                                            <button class="btn-clear-wishlist btn btn-secondary"
                                                onclick="clearWishlist()">Clear All</button>
                                            <p class="buttons">
                                                <a href="javascript:void(0);" class="btn btn-primary"
                                                    id="add-to-cart-btn">Add To Cart</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a id="cart-icon-home" title="Cart" href="#" role="button" aria-expanded="false"
                                class="theme_button small_button round_button bg_button margin_0 mx-2 icon-button">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <span class="count-cart" id="count-cart"></span>
                            </a>
                            <div class="dropdown-menu-cart" aria-labelledby="cart-icon-home">
                                <div class="widget widget_shopping_cart">
                                    <div class="widget_shopping_cart_content">
                                        <ul id="cart_list" class="product_list_widget cart_list">

                                        </ul>
                                        <hr>
                                        <div class="d-flex justify-content-end mb-3">
                                            <button class="btn-clear-cart" onclick="clearCart()">Clear All</button>
                                        </div>
                                        <p class="total grey"><span>Subtotal:</span> <span class="total-price"
                                                id="total-price"></span>
                                        </p>
                                        <p class="buttons">
                                            <a href="{{ route('cart') }}" class="theme_button">View cart</a>
                                            <a href="{{route('checkout')}}" class="theme_button color1">Checkout</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if (count($messages) > 0)
                                <a id="message-icon-home" title="Message" href="#" role="button"
                                    aria-expanded="false"
                                    class="theme_button small_button round_button bg_button margin_0 mx-2 icon-button">
                                    <i class="fa-solid fa-envelope" style="padding-top: 5px;"></i>
                                    <span class="count-message" id="count-message">
                                        {{ count($messages) }}
                                    </span>
                                </a>
                            @elseif($user)
                                <a id="message-icon-home" title="Message" href="#" role="button"
                                    aria-expanded="false"
                                    class="theme_button small_button round_button bg_button margin_0 mx-2 icon-button">
                                    <i class="fa-solid fa-envelope" style="padding-top: 5px;"></i>
                                    <span class="count-message" id="count-message">
                                        0
                                    </span>
                                </a>
                            @endif
                            <div class="drop-menu-message">
                                @if (count($messages) > 0)
                                    @foreach ($messages as $message)
                                        <a class="dropdown-item preview-item">
                                            <div class="preview-thumbnail">
                                                <img src="{{ asset('images/Dashboard/admin.png') }}"
                                                    alt="image" class="img-sm profile-pic">
                                            </div>
                                            <div class="preview-item-content flex-grow py-2">
                                                <p class="preview-subject ellipsis fw-medium text-dark">Admin</p>
                                                <p class="fw-light small-text mb-0" style="white-space: pre-wrap;">{!! $message->message !!}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-muted">No Contact Replies</p>
                                @endif
                                <hr>
                                <a href="{{ route('contact') }}" class="btn btn-contact">Contact Now</a>
                            </div>

                            <div class="dropdown login-dropdown">
                                <button class="btn btn-primary dropdown-toggle" title="User" type="button"
                                    id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user"></i>
                                </button>
                                <ul class="dropdown-menu user-infor @auth auth-infor @else guest-infor @endauth"
                                    aria-labelledby="loginDropdown">
                                    @guest
                                        <li><a class="dropdown-item" href="{{ route('login') }}">Log in</a></li>
                                        <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                    @else
                                        <li>
                                            <a href="{{ route('user-profile', $user->id) }}"
                                                class="d-flex justify-content-center align-items-center rounded-circle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                @if($user->role == 'admin')
                                                    <img src="{{ asset('images/Dashboard/admin.png') }}" class="user-image object-fit-cover rounded-circle" alt="Admin Image">
                                                @else
                                                <img src="{{ asset($user->avatar ? $user->avatar : 'images/Admin/user.png') }}" class="user-image object-fit-cover rounded-circle" alt="User Image">
                                                @endif
                                            </a>
                                        </li>
                                        <li>
                                            <div class="user-infor-item">
                                                <h6 class="drop-user-name">{{ $user->username }}</h6>
                                            </div>
                                        </li>
                                        <hr>
                                        <li><a class="dropdown-item"
                                                href="{{ route('user-profile', ['id' => $user->id]) }}">My Account</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}">
                                                Logout
                                            </a>
                                        </li>
                                        @if($user->role == 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin') }}">
                                                    Admin Page
                                                </a>
                                            </li>
                                        @endif
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="search-wrapper">
    <div class="container-search">
        <form action="{{ route('search-product') }}" class="search-form d-flex align-items-center">
            <button type="submit" class="search-submit bg-transparent pl-0 text-start">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div class="search-input mr-4">
                <input type="text" placeholder="Search your products..." autocomplete="off" name="search">
            </div>
            <button class="search-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </form>
    </div>
</div>
@push('custom-scripts')
    <script>
        var productDetailUrl = "{{ route('product-detail', ['id' => ':id']) }}";
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const logo = document.getElementById('logo');
            const menuButton = document.getElementById('menu-button');
            const mainMenu = document.querySelector('.header_mainmenu');
            const closeMenuButton = document.querySelector('.close-mainmenu');
            const overlay = document.querySelector('.overlay');
            const body = document.querySelector('body');
            const cartIcon = document.getElementById('cart-icon-home');
            const dropdownMenuCart = document.querySelector('.dropdown-menu-cart');
            const wishlistIcon = document.getElementById('heart-icon-home');
            const dropdownMenuWishlist = document.querySelector('.dropdown-menu-wishlist');
            const messageIcon = document.getElementById('message-icon-home');
            const dropdownMenuMessage = document.querySelector('.drop-menu-message');
            // Change navbar style on scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                    logo.src = '{{ asset('images/Dashboard/logo_admin.png') }}';
                } else {
                    navbar.classList.remove('scrolled');
                    logo.src = '{{ asset('images/Dashboard/logo_1.png') }}';
                }
            });

            // Toggle mobile menu
            menuButton.addEventListener('click', function() {
                mainMenu.classList.add('open');
                overlay.classList.add('open');
                body.classList.add('no-scroll');
            });

            closeMenuButton.addEventListener('click', function() {
                mainMenu.classList.remove('open');
                overlay.classList.remove('open');
                body.classList.remove('no-scroll');
            });

            overlay.addEventListener('click', function() {
                mainMenu.classList.remove('open');
                overlay.classList.remove('open');
                body.classList.remove('no-scroll');
            });

            // Toggle cart dropdown
            cartIcon.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenuCart.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (!cartIcon.contains(event.target) && !dropdownMenuCart.contains(event.target)) {
                    dropdownMenuCart.classList.remove('show');
                }
            });

            // Toggle wishlist dropdown
            wishlistIcon.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenuWishlist.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (!wishlistIcon.contains(event.target) && !dropdownMenuWishlist.contains(event.target)) {
                    dropdownMenuWishlist.classList.remove('show');
                }
            });
            // Toggle message dropdown
            messageIcon.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenuMessage.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (!messageIcon.contains(event.target) && !dropdownMenuMessage.contains(event.target)) {
                    dropdownMenuMessage.classList.remove('show');
                }
            });
        });
        //wishlist
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

        function viewWishlist() {
            if (localStorage.getItem('wishlist') != null) {
                var wishlist = JSON.parse(localStorage.getItem('wishlist'));
                const prdWishlist = document.getElementById('wishlist_list');
                if (prdWishlist) {
                    prdWishlist.innerHTML = '';
                    wishlist.forEach((item, index) => {
                        const {
                            name,
                            id,
                            image,
                            price
                        } = item;
                        prdWishlist.innerHTML += `
                            <li class="media d-flex align-items-center" data-index="${index}">
                                <div class="media-left media-middle">
                                    <a href="/product-detail/${id}">
                                        <img src="${image}" alt="Product Image">
                                    </a>
                                </div>
                                <div class="media-body media-middle">
                                    <button class="btn-remove-wishlist" data-index="${index}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <p class="darklinks mt-3"><a href="/product-detail/${id}">${name}</a></p>
                                    <span class="product-quantity">
                                        <span class="price">$${price}</span>
                                    </span>
                                </div>
                            </li>
                        `;

                        // Kiểm tra và thêm class wishlist-added nếu cần
                        var wishlistButton = document.getElementById('wishlist-' + id);
                        if (wishlistButton && wishlist.some(product => product.id === id && product.name === name &&
                                product.price === price)) {
                            wishlistButton.classList.add('wishlist-added');
                        }
                    });
                    removeItemFromWishlist();
                }
            }
            updateWishlistCount();
            updateWishlistButtons();
        }

        function removeItemFromWishlist() {
            const removeButtons = document.querySelectorAll('.btn-remove-wishlist');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const media = this.closest('.media');
                    const index = media.dataset.index;
                    let wishlist = JSON.parse(localStorage.getItem('wishlist'));
                    // Remove item from wishlist
                    wishlist.splice(index, 1);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));

                    viewWishlist();

                    Toastify({
                        text: "Item removed from wishlist!",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                        gravity: "top",
                        position: "center"
                    }).showToast();
                });
            });
            updateWishlistButtons();
        }

        function clearWishlist() {
            localStorage.removeItem('wishlist');
            var wishlistList = document.getElementById('wishlist_list');
            if (wishlistList) {
                wishlistList.innerHTML = '';
            }
            Toastify({
                text: "Wishlist cleared!",
                duration: 3000,
                backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                gravity: "top",
                position: "center"
            }).showToast();
            updateWishlistCount();
            updateWishlistButtons();
        }
        viewWishlist();
        updateWishlistCount();
        //cart
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
        function updateCartCount() {
            var cart = localStorage.getItem('cart');
            var old_data = [];
            if (cart) {
                try {
                    old_data = JSON.parse(cart);
                } catch (e) {
                    console.error("Failed to parse cart JSON:", e);
                }
            }
            if (typeof(old_data) === 'object') {
                var count = old_data.length;
            }
            var countElement = document.querySelector('#count-cart');
            if (countElement) {
                countElement.innerHTML = count;
            }
        }
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
            totalPriceCart();
        }
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
        function removeFromCart(idColor) {
            var cart = localStorage.getItem('cart');
            if (cart) {
                try {
                    var old_data = JSON.parse(cart);
                    old_data = old_data.filter(function(item) {
                        return item.id + '-' + item.color !== idColor;
                    });
                    localStorage.setItem('cart', JSON.stringify(old_data));

                    var cartItem = document.querySelector(`#cart-block [data-index="${idColor}"]`);
                    if (cartItem) {
                        cartItem.remove();
                    }

                    var navbarItem = document.querySelector(`#cart_list [data-index="${idColor}"]`);
                    if (navbarItem) {
                        navbarItem.remove();
                    }

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
            totalPriceCart();
        }
        updateCartCount();
        viewCart();
        function clearCart() {
            localStorage.removeItem('cart');

            var cartList = document.getElementById('cart_list');
            if (cartList) {
                cartList.innerHTML = '';
            }

            var cartBlock = document.getElementById('cart-block');
            if (cartBlock) {
                cartBlock.innerHTML = '';
            }

            Toastify({
                text: "Cart cleared!",
                duration: 3000,
                backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                gravity: "top",
                position: "center"
            }).showToast();

            updateCartCount();
            updateCartButtons();
            totalPrice();
            totalPriceCart();
        }
        // add to cart from wishlist
        document.getElementById('add-to-cart-btn').addEventListener('click', function(event) {
            event.preventDefault();
            let wishlist = localStorage.getItem('wishlist');
            let cart = localStorage.getItem('cart');

            if (wishlist) {
                let wishlistItems = JSON.parse(wishlist);
                let cartItems = cart ? JSON.parse(cart) : [];

                wishlistItems.forEach(wishlistItem => {
                    let item = {
                        ...wishlistItem,
                        color: 'White',
                        quantity: 1
                    };
                    let cartItemIndex = cartItems.findIndex(cartItem =>
                        cartItem.id === item.id &&
                        cartItem.name === item.name &&
                        cartItem.price === item.price
                    );

                    if (cartItemIndex !== -1) {
                        cartItems[cartItemIndex].quantity += item.quantity;
                    } else {
                        cartItems.push(item);
                    }
                });

                localStorage.setItem('cart', JSON.stringify(cartItems));
                localStorage.removeItem('wishlist');
                updateWishlistCount();
                updateWishlistButtons();
                clearWishlist();
                viewWishlist();
                updateCartCount();
                updateCartButtons();
                viewCart();
                viewCartPage();
                totalPrice();
            } else {
                toastr.error('No items in wishlist.');
            }
        });
        // search
        document.querySelector('#search-icon-home').addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('.search-wrapper').classList.toggle('search-appear');
        });
        document.querySelector('.search-close').addEventListener('click', function() {
            document.querySelector('.search-wrapper').classList.remove('search-appear');
        });
    </script>
@endpush
