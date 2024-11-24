<?php

use App\Models\Subject;

$subject = Subject::find($user->teacher->subject_id);
?>
@extends('Layouts.master-teacher')
@section('page_title')
Hồ Sơ Giáo Viên
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
<div id="demo_2">
  <section_1 class="m-5">
    <div class="row">
      <div class="col-8">
        <div class="studentDetailContainer frameWork p-4">
          <div class="row">
            <div class="col-12">
              <div
                class="titleContainer d-flex align-items-center justify-content-between">
                <div class="titleMark p-2">Thông Tin Giáo Viên</div>
                <div class="moreDetails p-2"><a>Xem chi
                    tiết</a></div>
              </div>
            </div>
            <div class="col-3 p-3">
              <div class="avatarContainer">
                <img
                  src="{{asset('images/Dashboard/teacher.webp')}}"
                  class="avatar" alt>
              </div>

            </div>
            <div class="col-8 p-3">
              <div class="d-flex flex-column">
                <div class="mt-2">
                  <span class="info-label">Mã Giáo Viên:</span>
                  <span
                    class="info-value">{{$user->teacher->teacher_code}}</span>
                </div>
                <div class="mt-2">
                  <span class="info-label">Họ Và Tên:</span>
                  <span class="info-value">{{$user->name}}</span>
                </div>
                <div class="mt-2">
                  <span class="info-label">Giáo Viên Môn:</span>
                  @if($subject)
                  <span
                    class="info-value">{{$subject->name}}</span>
                  @endif


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="listMarkContainer h-100 frameWork p-4">
          <div class="row">
            <div class="col-12">
              <div
                class="titleContainer d-flex align-items-center justify-content-between">
                <div class="titleMark p-2">QUẢN LÝ</div>
              </div>
            </div>
            <div class="col-12 mt-4">
              <a href="{{route('create-scores-get')}}" class="btn btn-danger form-control ">NHẬP ĐIỂM</a>
            </div>
            <div class="col-12 mt-4">
              <a href="{{route('manage-student-scores')}}" class="btn btn-danger form-control">XEM DANH SÁCH SINH VIÊN</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section_1>
  <section_2 class="m-5">
    <div class="section_2 frameWork p-4">
      <div class="row">
        <div class="col-12">
          <div class="titleSC">TIN TỨC</div>
        </div>
      </div>

      <div class="row m-4">
        <!-- First Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Về việc nộp hồ sơ xét giảm học phí học kỳ 1 năm học 2024 - 2025</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 2" class="img-fluid mb-3">
          <p class="news-text">Danh sách sinh viên tốt nghiệp học kỳ 2 năm học 2023 - 2024</p>
        </div>
      </div>
    </div>

  </section_2>
  <section_3 class="m-5">
    <div class="section_2 frameWork p-4">
      <div class="row">
        <div class="col-12">
          <div class="titleSC">HƯỚNG DẪN</div>
        </div>
      </div>

      <div class="row m-4">
        <!-- First Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Hướng dẫn thủ tục thanh toán ra trường và nhận bằng tốt nghiệp của sinh viên được công nhận tốt nghiệp năm 2024.</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 2" class="img-fluid mb-3">
          <p class="news-text"> VIDEO - HƯỚNG DẪN SINH VIÊN TRA CỨU, ĐỀ XUẤT BIỂU MẪU TRỰC TUYẾN.</p>
        </div>
      </div>
    </div>

  </section_3>
  <section_4 class="m-5">
    <div class="section_2 frameWork p-4">
      <div class="row">
        <div class="col-12">
          <div class="titleSC">QUY ĐỊNH</div>
        </div>
      </div>

      <div class="row m-4">
        <!-- First Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Ban hành Quy định về việc quy đổi chứng chỉ Ngoại ngữ và Tin học tương đương theo yêu cầu chuẩn đầu ra của Trường Đại học Kiến trúc Đà Nẵng.</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center teacher-ads-img">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 2" class="img-fluid mb-3">
          <p class="news-text">Quy định đánh giá kết quả học tập sinh viên.</p>
        </div>
      </div>
    </div>

  </section_4>


</div>
@endsection