@extends('layouts.master-admin')
@section('page_title')
Thêm Giáo Viên
@endsection
@section('content')
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.success('{{ session('
            success ') }}');
    });
</script>
@endif
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.error('{{ session('
            error ') }}');
    });
</script>
@endif
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h1 class="fw-semibold mb-0 body-title">Thêm Giáo Viên</h1>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-house"></i>
                    Trang Chủ
                </a>
            </li>
            <li><span>-</span></li>
            <li class="fw-medium"><span>Người Dùng</span></li>
        </ul>
    </div>
    <div class="row justify-content-center align-items-center manage-block">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('create-teacher-post') }}" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="teacher_code">Mã Giáo Viên</label>
                            <input type="text" class="form-control" id="teacher_code" name="teacher_code" required>
                            @if ($errors->has('teacher_code'))
                            <span class='text-danger-login'>{{ $errors->first('teacher_code') }}</span>
                            @endif
                        </div>
                        <div class="form-group form-box position-relative">
                            <label class="form-label" for="password">Mật Khẩu</label>
                            <input type="password" name="password" class="form-control" required autocomplete="password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" style="z-index: 10;top: 65px !important;">
                                <i class="fa fa-eye"></i>
                            </span>
                            @if ($errors->has('password'))
                            <span class='text-danger-login'>{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Họ Và Tên</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @if ($errors->has('name'))
                            <span class='text-danger-login'>{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="gender">Giới Tính</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                            @if ($errors->has('gender'))
                            <span class='text-danger-login'>{{ $errors->first('gender') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            @if ($errors->has('email'))
                            <span class='text-danger-login'>{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="phone_number">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                            @if ($errors->has('phone_number'))
                            <span class='text-danger-login'>{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="address">Địa Chỉ</label>
                            <input type="text" class="form-control" id="address" name="address">
                            @if ($errors->has('address'))
                            <span class='text-danger-login'>{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="avatar">Ảnh Đại Diện</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @if ($errors->has('avatar'))
                            <span class='text-danger-login'>{{ $errors->first('avatar') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="subject_id">Giáo Viên Môn</label>
                            <select class="form-control" id="subject_id" name="subject_id">
                                @if ($subjects)
                                @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('subject_id'))
                            <span class='text-danger-login'>{{ $errors->first('subject_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-update-user badge btn-add-prd">Tạo Giáo Viên</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
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