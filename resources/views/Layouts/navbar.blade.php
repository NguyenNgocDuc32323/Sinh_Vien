<div class="navbar">
    <div class="page_header_wrapper w-100">
        <div class="page_header">
            <div class="container-fluid mobile-container">
                <div class="container">
                    <div class="row position-relative">
                        <div class="col-sm-12 d-flex align-items-center justify-content-between">
                            <div class="col-md-6 col-sm-12">
                                <div class="header_left_logo order-1">
                                    <a href="{{ route('home') }}">
                                        <h1>TRƯỜNG ĐẠI HỌC KIẾN TRÚC ĐÀ NẴNG</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                                <div id="menu-button" class="d-lg-none">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="overlay"></div>
                                <div class="header_right_buttons order-3">
                                    @guest
                                    <a href="{{ route('login') }}" class="btn btn-index">ĐĂNG NHẬP</a>
                                    @else
                                    <div class="user-infor">
                                        <a href="{{ route('logout') }}" class="btn btn-index ms-2">Đăng Xuất</a>
                                        @if($user->role == 'admin')
                                        <a href="{{ route('admin') }}" class="btn btn-index bd-logout ms-2">Trang Quản Trị</a>
                                        @endif
                                    </div>
                                    @endguest
                                </div>

                            </div>
                            <div class="logo">
                                <a href="{{route('home')}}">
                                    <img src="{{asset('images/logo.png')}}" class="logo2" id="logo2">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="navbar-bottom d-flex align-items-center">
    <div class="col-md-6 col-sm-12 navbar-bottom-list">
        <ul>
            <li>
                <a href="#">Giới Thiệu</a>
            </li>
        </ul>
    </div>
</div>
@push('custom-scripts')
@endpush