@extends('layouts.master-admin')
@section('page_title')
Cập Nhật Giáo Viên
@endsection
@section('content')
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
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h1 class="fw-semibold mb-0 body-title">Cập Nhật Giáo Viên</h1>
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
    <div class="row justify-content-center align-items-center user-manage-block">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                role="tab" aria-controls="profile" aria-selected="true">Thông Tin Cá Nhân</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                                aria-controls="password" aria-selected="false">Đổi Mật Khẩu</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="{{route('update-teacher-post',[$teacher->id])}}" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="teacher_code">Mã Giáo Viên</label>
                                    <input type="text" class="form-control" id="teacher_code" name="teacher_code" value="{{$teacher->teacher_code}}">
                                    @if ($errors->has('teacher_code'))
                                    <span class="text-danger">{{ $errors->first('teacher_code') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Họ Tên</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$teacher->user->name}}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <label for="class_id">Giáo Viên Môn</label>
                                    <select class="form-control" id="class_id" name="class_id">
                                        @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ $teacher->subject->id == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class_id'))
                                    <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-success">Cập Nhật Giáo Viên</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form action="{{route('update-teacher-password',$teacher->id)}}" method="POST" class="w-50 mx-auto">
                                @csrf
                                <div class="form-group mb-3 position-relative">
                                    <label for="current_password">Mật Khẩu Hiện Tại</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                    <span class="show-pass-word">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    @if ($errors->has('current_password'))
                                    <span class="text-danger-login">{{ $errors->first('current_password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <label for="new_password">Mật Khẩu Mới</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                    <span class="show-pass-word">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    @if ($errors->has('new_password'))
                                    <span class="text-danger-login">{{ $errors->first('new_password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <label for="confirm_password">Xác Nhận Mật Khẩu</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    <span class="show-pass-word">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    @if ($errors->has('confirm_password'))
                                    <span class="text-danger-login">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-update-user">Thay Đổi Mật Khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea');
        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/<script[^>]*>.*<\/script>/gi, '');
            });
        });
        var togglePasswordIcons = document.querySelectorAll('.show-pass-word');
        togglePasswordIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                var passwordInput = this.previousElementSibling;
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        });
    });
</script>
@endpush