@extends('Layouts.master_user')
@section('page_title')
    User Profile
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
<section class="pb-4 mt-5">
    <div class="border rounded-5">
        <section class="custom-section">
          <div class="row d-flex justify-content-center">
            <div class="col col-lg-7 mb-4 mb-lg-0">
              <div class="card custom-card">
                <div class="row g-0">
                  <div class="col-md-4 gradient-custom text-center text-white custom-gradient-column">
                    <img src="{{asset($user->avatar)}}" alt="avatar" class="img-fluid my-5" style="width: 80px;">
                    <h5>{{$user->name}}</h5>
                    <a href="{{route('user-profile-edit',$user->id)}}">
                        <i class="far fa-edit mb-5"></i>
                    </a>
                  </div>
                  <div class="col-md-8">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center infor-block">
                            <h6>Thông Tin</h6>
                            <a href="{{route('user-profile-edit',$user->id)}}" class="ms-auto">
                              <i class="far fa-edit mb-5"></i>
                            </a>
                          </div>
                      <hr class="mt-0 mb-4">
                      <div class="row pt-1">
                        @if ($user->role == 'student')
                          <div class="col-6 mb-3">
                            <h6>Mã Học Viên</h6>
                            <p class="text-muted">{{$user->student->student_code}}</p>
                          </div>
                        @elseif($user->role == 'teacher')
                          <div class="col-6 mb-3">
                            <h6>Mã Giáo Viên</h6>
                            <p class="text-muted">{{$user->teacher->teacher_code}}</p>
                          </div>
                        @endif
                        <div class="col-6 mb-3">
                          <h6>Email</h6>
                          <p class="text-muted">{{$user->email}}</p>
                        </div>
                        <div class="col-6 mb-3">
                          <h6>Số Điện Thoại</h6>
                          <p class="text-muted">{{$user->phone}}</p>
                        </div>
                      </div>
                      <div class="col-6 mb-3">
                        <h6>Địa Chỉ</h6>
                        <p class="text-muted">{{$user->address}}</p>
                      </div>
                      <hr class="mt-0 mb-4">
                      <div class="d-flex justify-content-start media-block">
                        <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                        <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                        <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
  </section>
@endsection
