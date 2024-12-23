@extends('layouts.master-admin')
@section('page_title')
Trang Quản Lý
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
        <h1 class="fw-semibold mb-0 body-title">Quản Lý Học Sinh</h1>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{route('home')}}" class="d-flex align-items-center gap-1 hover-text-primary">
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
                    <div class="d-flex justify-content-between align-items-center mb-3 card-body-item">
                        <div>
                            <a href="{{route('create-student')}}" class="form-control btn-danger text-white" style="background: red;text-decoration: none;">Thêm Sinh Viên</a>
                        </div>
                        <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('student-search') }}">
                            @csrf
                            <input type="text" id="search-input" name="search-input" class="form-control" placeholder="Search">
                            <button type="submit" class="btn-search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="order-listing" class="table dataTable no-footer">
                                        <thead>
                                            <tr class="bg-primary text-white">
                                                <th class="sorting">Mã Học Sinh</th>
                                                <th class="sorting">Ảnh</th>
                                                <th class="sorting">Họ Tên</th>
                                                <th class="sorting">Email</th>
                                                <th class="sorting">Ngày Sinh</th>
                                                <th class="sorting">Lớp Học</th>
                                                <th class="sorting">Khóa Học</th>
                                                <th class="sorting">Số Điện Thoại</th>
                                                <th class="sorting">Địa Chỉ</th>
                                                <th class="sorting">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-table-body">
                                            @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $student->student_code }}</td>
                                                <td>
                                                    <img src="{{ asset( $student->user->avatar) }}" alt="Ảnh đại diện" style="width: 50px; height: 50px; border-radius: 50%;">
                                                </td>
                                                <td>{{ $student->user->name }}</td>
                                                <td>{{ $student->user->email }}</td>
                                                <td>{{ \Carbon\Carbon::parse($student->birth_day)->format('d/m/Y') }}</td>
                                                <td>{{ $student->class->class_name ?? 'Không có lớp' }}</td> <!-- Hiển thị tên lớp -->
                                                <td>{{ $student->course->course_name ?? 'Không có khóa học' }}</td> <!-- Hiển thị tên khóa học -->
                                                <td>{{ $student->user->phone ?? 'Không có' }}</td>
                                                <td>{{ $student->user->address ?? 'Không có' }}</td>
                                                <td>
                                                    <a href="{{route('update-student',$student->id)}}" class="btn btn-warning btn-sm text-white">Sửa</a>
                                                    <a href="{{ route('delete-student', $student->id) }}" class="btn btn-danger btn-sm text-white">Xóa</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if ($students)
                                            <div class="d-flex justify-content-end ml-2 paginate">
                                                {{ $students->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
                                            </div>
                                    @endif
                                </div>
                            </div>
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
    
</script>
@endpush