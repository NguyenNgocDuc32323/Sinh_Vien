<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div>
        <a href="{{ route('admin') }}" class="sidebar-logo">
            <img src="{{ asset('images/Dashboard/logo_admin.png') }}" alt="site logo" class="logo">
        </a>
    </div>
    <div class="sidebar-menu-area open">
        <ul class="sidebar-menu show" id="sidebar-menu">
            <li class="open">
                <a href="{{ route('admin') }}" class="dashboard {{ Route::currentRouteName() == 'admin' ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="open">
                <a href="{{ route('manage-transaction') }}" class="transaction {{ Route::currentRouteName() == 'manage-transaction' || Route::currentRouteName() == 'transaction-search' ? 'active' : '' }}">
                    <i class="fa-solid fa-tent-arrow-left-right"></i>
                    <span>Transaction</span>
                </a>
            </li>
            <li class="open">
                <a href="{{ route('manage-user') }}" class="user {{ Route::currentRouteName() == 'manage-user' || Route::currentRouteName() == 'user-search' || Route::currentRouteName() == 'update-user' ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i>
                    <span>User</span>
                </a>
            </li>
            <li class="open">
                <a href="{{ route('manage-product') }}" class="product-admin {{ Route::currentRouteName() == 'manage-product' || Route::currentRouteName() == 'product-search' || Route::currentRouteName() == 'update-product' || Route::currentRouteName() == 'create-product' ? 'active' : '' }}">
                    <i class="fa-solid fa-bottle-water"></i>
                    <span>Product</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-category')}}" class="category {{ Route::currentRouteName() == 'manage-category' || Route::currentRouteName() == 'category-search' || Route::currentRouteName() == 'update-category' || Route::currentRouteName() == 'create-category' ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i>
                    <span>Category</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-order')}}" class="order {{ Route::currentRouteName() == 'manage-order' || Route::currentRouteName() == 'order-search' || Route::currentRouteName() == 'update-order' ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Order</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-order-detail')}}" class="order-detail {{ Route::currentRouteName() == 'manage-order-detail' || Route::currentRouteName() == 'order-detail-search' || Route::currentRouteName() == 'update-order-detail' ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Order Detail</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-contact')}}" class="contact {{ Route::currentRouteName() == 'manage-contact' || Route::currentRouteName() == 'contact-search' || Route::currentRouteName() == 'contact-reply' ? 'active' : '' }}">
                    <i class="fa-solid fa-message"></i>
                    <span>Contact</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-contact-reply')}}" class="contact-reply {{ Route::currentRouteName() == 'manage-contact-reply' || Route::currentRouteName() == 'contact-reply-search' || Route::currentRouteName() == 'delete-contact-reply' || Route::currentRouteName() == 'update-contact-reply' ? 'active' : '' }}">
                    <i class="fa-solid fa-message"></i>
                    <span>Reply</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-slide')}}" class="slide {{ Route::currentRouteName() == 'manage-slide' || Route::currentRouteName() == 'search-slide' || Route::currentRouteName() == 'create-slide' || Route::currentRouteName() == 'update-slide' ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Slide</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-color')}}" class="color {{ Route::currentRouteName() == 'manage-color' || Route::currentRouteName() == 'color-search' || Route::currentRouteName() == 'create-color' || Route::currentRouteName() == 'update-color' ? 'active' : '' }}">
                    <i class="fa-solid fa-palette"></i>
                    <span>Colors</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-size')}}" class="size {{ Route::currentRouteName() == 'manage-size' || Route::currentRouteName() == 'size-search' || Route::currentRouteName() == 'create-size' || Route::currentRouteName() == 'update-size' ? 'active' : '' }}">
                    <i class="fa-solid fa-expand"></i>
                    <span>Size</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-ads')}}" class="ads {{ Route::currentRouteName() == 'manage-ads' || Route::currentRouteName() == 'ads-search' || Route::currentRouteName() == 'create-ads' || Route::currentRouteName() == 'update-ads' ? 'active' : '' }}">
                    <i class="fa-solid fa-rectangle-ad"></i>
                    <span>Ads</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-label')}}" class="label {{ Route::currentRouteName() == 'manage-label' || Route::currentRouteName() == 'label-search' || Route::currentRouteName() == 'create-label' || Route::currentRouteName() == 'update-label' ? 'active' : '' }}">
                    <i class="fa-solid fa-tag"></i>
                    <span>Label</span>
                </a>
            </li>
            <li class="open">
                <a href="{{route('manage-blog')}}" class="blog {{ Route::currentRouteName() == 'manage-blog' || Route::currentRouteName() == 'blog-search' || Route::currentRouteName() == 'create-blog' || Route::currentRouteName() == 'update-blog' ? 'active' : '' }}">
                    <i class="fa-solid fa-blog"></i>
                    <span>Blog</span>
                </a>
            </li>
        </ul>

    </div>
</aside>
