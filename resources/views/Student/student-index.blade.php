@extends('Layouts.master-student')
@section('page_title')
Hồ Sơ Học Sinh
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
<div id="demo_4" class="container">
  <div class="ProfileContainer mt-4">
    <div class="row">
      <div class="col-7">
        <div class="row frame p-4 m-1">
          <div class="col-12">
            <div class="titleSV">Thông tin sinh viên</div>
          </div>
          <div class="col p-4">
            <div class="avatarContainer">
              <img
                src="{{asset($user->avatar)}}"
                class="avatar" alt>
            </div>
          </div>
          <div class="col-4">
            <div class="d-flex flex-column">
              <div class="mt-2">
                <span class="info-label">MSSV:</span>
                <span
                  class="info-value">{{ $user->student->student_code }}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Họ
                  tên:</span>
                <span class="info-value">{{$user->name}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Giới tính
                  :</span>
                <span class="info-value">{{$user->gender}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Ngày sinh
                  :</span>
                <span
                  class="info-value">{{$user->student->birth_day}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Nơi sinh
                  :</span>
                <span
                  class="info-value">{{$user->address}}</span>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="d-flex flex-column">
              <div class="mt-2">
                <span class="info-label">Lớp học
                  :</span>
                <span
                  class="info-value">{{$user->student->class->class_name}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Khoá
                  học:</span>
                <span class="info-value">{{$user->student->course->course_name}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Bậc đào
                  tạo:</span>
                <span
                  class="info-value">{{$user->student->course->training_level}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Loại hình đào
                  tạo : </span>
                <span
                  class="info-value">{{$user->student->course->type}}</span>
              </div>
              <div class="mt-2">
                <span class="info-label">Nghành :</span>
                <span
                  class="info-value">{{$user->student->course->major}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-5 ">
        <div class="row">
          <div class="col-12">
            <div
              class="border rounded p-3 d-flex align-items-center"
              style="background-color: #f8f9fa;">
              <!-- Số thứ tự -->
              <div class="">
                <span
                  class="display-4 fw-bold text-primary m-3">5</span>
              </div>
              <!-- Nội dung thông báo -->
              <div>
                <p class="text-muted">Nhắc nhở mới,
                  chưa xem</p>
                <p class="">
                  Trường Đại Học Kiến Trúc Đà Nẵng •
                  Thông báo Lịch học bù • Phát triển
                  Ứng dụng IoT •
                  Ngày 08/12/2024, Tiết 1 — 5, Phòng
                  401.
                </p>
                <!-- Liên kết chi tiết -->
                <a href="#" class="text-primary">xem chi
                  tiết</a>
              </div>
              <!-- Icon tải về -->
              <div class="bellContainer wrapper-container">
                <div class="wrapper-item">
                  <a href="">
                    <i class="bi bi-bell"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 mt-3 ">
            <div class="border rounded p-3 d-flex align-items-center schedule" style="background-color: #e0f7fa;">
              <!-- Số lượng lịch học -->
              <div class="me-3">
                <span class="display-4 fw-bold text-primary">7</span>
              </div>
              <!-- Nội dung lịch học -->
              <div>
                <p class="mb-1 text-muted">Lịch học trong tuần</p>
                <a href="#" class="text-primary">Xem chi tiết</a>
              </div>
              <!-- Icon lịch -->
              <div class="ms-auto">
                <i class="bi bi-calendar-event" style="font-size: 1.5rem; color: #90caf9;"></i>
              </div>
            </div>
          </div>
          <div class="col-6 mt-3">
            <div class="border rounded p-3 d-flex align-items-center schedule" style="background-color: #fff3e0;">
              <!-- Số lượng lịch thi -->
              <div class="me-3">
                <span class="display-4 fw-bold text-warning">0</span>
              </div>
              <!-- Nội dung lịch thi -->
              <div>
                <p class="mb-1 text-muted">Lịch thi trong tuần</p>
                <a href="#" class="text-warning">Xem chi tiết</a>
              </div>
              <!-- Icon lịch -->
              <div class="ms-auto">
                <i class="bi bi-calendar-event" style="font-size: 1.5rem; color: #ffcc80;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row h-100 w-100 listfunction">
        <a href="{{route('student-scores')}}" class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-chart-bar" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Kết quả học tập</p>
          </div>
        </a>
        <!-- Ô 2 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-calendar-week" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Lịch theo tuần</p>
          </div>
        </div>

        <!-- Ô 3 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-file-alt" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Lịch theo biên độ</p>
          </div>
        </div>

        <!-- Ô 4 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-file-upload" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Đề xuất biểu mẫu</p>
          </div>
        </div>

        <!-- Ô 5 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-search-dollar" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Tra cứu công nợ</p>
          </div>
        </div>

        <!-- Ô 6 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded h-100 p-4" style="background-color: #f8f9fa;">
            <i class="fas fa-credit-card" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Thanh toán trực tuyến</p>
          </div>
        </div>

        <!-- Ô 7 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-file-invoice" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Phiếu thu tổng hợp</p>
          </div>
        </div>

        <!-- Ô 8 -->
        <div class="col text-center pt-3 optionContainer">
          <div class="border rounded p-4 h-100" style="background-color: #f8f9fa;">
            <i class="fas fa-receipt" style="font-size: 2rem; color: #90caf9;"></i>
            <p class="mt-2">Phiếu thu trực tuyến</p>
          </div>
        </div>
      </div>


    </div>
  </div>
  <section_2 class="m-5">
    <div class="section_2 frameWork p-4">
      <div class="row">
        <div class="col-12">
          <div class="titleSC">TIN TỨC</div>
        </div>
      </div>

      <div class="row m-4">
        <!-- First Column -->
        <div class="col-md-6 d-flex flex-column align-items-center">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Về việc nộp hồ sơ xét giảm học phí học kỳ 1 năm học 2024 - 2025</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center">
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
        <div class="col-md-6 d-flex flex-column align-items-center">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Hướng dẫn thủ tục thanh toán ra trường và nhận bằng tốt nghiệp của sinh viên được công nhận tốt nghiệp năm 2024.</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center">
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
        <div class="col-md-6 d-flex flex-column align-items-center">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 1" class="img-fluid mb-3">
          <p class="news-text">Ban hành Quy định về việc quy đổi chứng chỉ Ngoại ngữ và Tin học tương đương theo yêu cầu chuẩn đầu ra của Trường Đại học Kiến trúc Đà Nẵng.</p>
        </div>

        <!-- Second Column -->
        <div class="col-md-6 d-flex flex-column align-items-center">
          <img src="{{asset('images/Sinh_Vien/hoc_tap.png')}}" alt="Image 2" class="img-fluid mb-3">
          <p class="news-text">Quy định đánh giá kết quả học tập sinh viên.</p>
        </div>
      </div>
    </div>

  </section_4>

</div>
@endsection