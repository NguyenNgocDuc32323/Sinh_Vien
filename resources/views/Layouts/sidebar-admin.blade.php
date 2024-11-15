<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div>
        <a href="{{ route('admin') }}" class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="site logo" class="logo">
        </a>
    </div>
    <div class="sidebar-menu-area open">
        <ul class="sidebar-menu show" id="sidebar-menu">
            <li class="open">
                <a href="{{ route('admin') }}" class="dashboard {{ Route::currentRouteName() == 'admin' ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Học Sinh</span>
                </a>
            </li>
        </ul>

    </div>
</aside>
