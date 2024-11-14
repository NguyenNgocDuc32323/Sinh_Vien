@extends('Layouts.master-auth')
@section('page_title')
    Login
@endsection
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.success('{{ session('success') }}');
        });
    </script>
    @endif
@if(session('error'))
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
                            <a href="{{route('home')}}">
                                <img src="{{asset('images/Login/logo_login.png')}}" alt="logo">
                            </a>
                            <h3>Sign Into Your Account</h3>
                            <form method="POST" action="{{ route('login-post') }}" >
                                @csrf
                                <div class="form-group form-box">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required autocomplete="email">
                                </div>
                                @if ($errors->has('email'))
                                    <span class='text-danger-login'>{{ $errors->first('email') }}</span>
                                @endif
                                <div class="form-group form-box position-relative">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="password">
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" style="z-index: 10;">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class='text-danger-login'>{{ $errors->first('password') }}</span>
                                @endif
                                <div class="form-group form-box checkbox clearfix">
                                    <div class="form-check checkbox-theme">
                                        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="{{ route('forgot-password') }}">Forgot Password</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme w-100">Login</button>
                                </div>
                                <p>Don't have an account?<a href="{{ route('register') }}" class="text-route"> Register here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 bg-img">
                    <div class="information">
                        <div class="btn-section">
                            <a href="{{route('login')}}" class="active link-btn">Login</a>
                            <a href="{{route('register')}}" class="link-btn">Register</a>
                        </div>
                        <h1>Welcome To <span>Polysite</span></h1>
                        <p>Polysite is a leading producer of plastic bottles and packaging, serving the food, pharmaceutical, and cosmetic industries. With over 20 years of experience, Polysite is committed to innovation and delivering high-quality packaging solutions to meet customer needs.</p>
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
    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('input[type="text"], input[type="email"],input[type="password"],input[type="number"], textarea');
        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
            });
        });

        var togglePassword = document.querySelector('.toggle-password');
        var passwordInput = document.querySelector('input[name="password"]');
        togglePassword.addEventListener('click', function () {
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