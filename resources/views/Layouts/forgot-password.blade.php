@extends('Layouts.master-auth')
@section('page_title')
    Login
@endsection
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
<div class="top">
    <div class="login tab-box">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-12 form-section">
                    <div class="login-inner-form">
                        <div class="details">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/logo.png') }}" alt="logo">
                            </a>
                            <h3>Kiểm Tra Tài Khoản</h3>
                            <form method="POST" action="{{ route('forgot-password-post') }}" autocomplete="off">
                                @csrf
                                <div class="form-group form-box">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Email" required autocomplete="email">
                                </div>
                                @if ($errors->has('email'))
                                    <span class='text-danger-login'>{{ $errors->first('email') }}</span>
                                @endif
                                <div class="form-group form-box">
                                    <input type="text" name="phone" class="form-control" placeholder="Số Điện Thoại"
                                        required autocomplete="phone">
                                </div>
                                @if ($errors->has('phone'))
                                    <span class='text-danger-login'>{{ $errors->first('phone') }}</span>
                                @endif
                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme w-100">Đặt lại mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 bg-img">
                    <div class="information">
                        <div class="btn-section">
                            <a href="{{ route('login') }}" class="active link-btn">Đăng Nhập</a>
                            <a href="{{ route('home') }}" class="link-btn">Trang Chủ</a>
                        </div>
                        <h1><span>Đại Học Kiến Trúc Đà Nẵng</span></h1>
                        <p>Trường Đại học Kiến trúc Đà Nẵng (DAU) là trường đại học tư thục uy tín, chuyên đào tạo các ngành kiến trúc, xây dựng và thiết kế. Với hơn 15 năm kinh nghiệm, DAU cam kết cung cấp môi trường học tập chất lượng và phát triển nguồn nhân lực đáp ứng nhu cầu xã hội.</p>
                        <div class="social-list">
                            <a href="#" class="facebook-bg">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <a href="#" class="twitter-bg">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="#" class="google-bg">
                                <i class="fa-brands fa-google"></i>
                            </a>
                            <a href="#" class="linkedin-bg">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputs = document.querySelectorAll(
                'input[type="text"], input[type="email"],input[type="password"],input[type="number"], textarea');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
                });
            });
            var togglePassword = document.querySelector('.toggle-password');
            var passwordInput = document.querySelector('input[name="password"]');
            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    togglePassword.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        });
    </script>
@endpush
