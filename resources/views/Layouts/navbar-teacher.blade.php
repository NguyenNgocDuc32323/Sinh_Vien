<header id="header">
    <div class="row headerContainer">
        <div class="col-3">
            <div class="wrapper-container">
                <div class="wrapper-item">
                    <div
                        class="d-flex align-items-center justify-content-center">
                        <div class="logoContainer">
                            <a href="{{route('home')}}">
                                <img
                                    src="{{asset('images/logo.png')}}"
                                    alt="Logo" class="img-fluid" style="width: 80px;">
                            </a>
                        </div>
                        <div class="SchoolName m-3"><a href="{{route('home')}}">TRƯỜNG ĐẠI HỌC KIẾN TRÚC ĐÀ NẴNG</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-2">
            <div class="wrapper-container">
                <div class="wrapper-item">
                    <div class="searchContainer">
                        <input type="text" class="form-control search"
                            placeholder="Search">
                        <i class="bi bi-search searchIcon"></i>

                    </div>
                </div>
            </div>

        </div>
        <div class="col navbar-student-list">
            <div class="navbar-student-item">
                <a href="{{route('home')}}"
                    class="homeIconContainer d-flex justify-content-center align-items-center h-100 w-100 size">
                    <i class="bi bi-house-door-fill m-2"></i>
                    Trang chủ
                </a>
            </div>
        </div>
        <div class="col navbar-student-list">
            <div class="navbar-student-item">
                <a href="{{route('home')}}"
                    class="homeIconContainer d-flex justify-content-center align-items-center h-100 w-100 size">
                    <i class="fa-solid fa-bell"></i>
                    <span class="infor-span">Tin tức</span>
                    <div class="numberNews">
                        <div class="wrapper-container">
                            <div class="wrapper-item">
                                0
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col">
            <div
                class="studentProfileContaienr w-100 h-100 d-flex align-items-center justify-content-end">
                <div class="avatarContainer">
                    <div>
                        <img src="{{asset('images/Dashboard/student.webp')}}" class="avatar" alt>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn borderNone" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="studentName">
                            Nguyễn Ngọc Đức
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-student">
                        <li><a class="dropdown-item" href="{{ route('student-profile', ['id' => 2]) }}">Chỉnh Sửa Thông Tin</a></li>
                        <li><a class="dropdown-item" href="{{route('logout')}}">Đăng
                                xuất</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</header>