
<nav class="dashboard-main-navbar d-flex justify-content-between">
    <div class="d-flex align-items-center">
        <button class="navbar-toggle bars">
            <i class="fa-solid fa-bars bar-icon"></i>
            <i class="fa-solid fa-arrow-right arrow-icon"></i>
        </button>
        <div class="navbar-toggle bars-mobile">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="dropdown-block ms-auto">
        <div class="dropdown">
            <button class="d-flex justify-content-center align-items-center rounded-circle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset($user->avatar)}}" alt="image"
                    class="user-image object-fit-cover rounded-circle">
            </button>
            <div class="dropdown-menu to-top dropdown-menu-sm">
                <div class="drop-header d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="drop-user-name">{{$user->name}}</h6>
                        <span class="drop-user-role">{{$user->role}}</span>
                    </div>
                </div>
                <ul class="to-top-list">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('home')}}">
                            <i class="icon-user-item fa-regular fa-user"></i> <span>Trang Người Dùng</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="icon-user-item fa-solid fa-power-off"></i><span>Đăng Xuất</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var dropdownButton = document.querySelector('[data-bs-toggle="dropdown"]');
    if (dropdownButton) {
        var dropdown = new bootstrap.Dropdown(dropdownButton);
    }
});

    </script>
@endpush
