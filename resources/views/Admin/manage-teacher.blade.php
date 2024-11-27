@extends('layouts.master-admin')
@section('page_title')
Quản Lý Giáo Viên
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
        <h1 class="fw-semibold mb-0 body-title">Quản Lý Giáo Viên</h1>
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
                            <a href="{{route('create-teacher')}}" class="form-control btn-danger text-white" style="background: red;text-decoration: none;">Thêm Giáo Viên</a>
                        </div>
                        <form id="order-listing_filter" class="dataTables_filter" method="GET" action="{{ route('teacher-search') }}">
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
                                                <th class="sorting">Mã Giáo Viên</th>
                                                <th class="sorting">Ảnh</th>
                                                <th class="sorting">Họ Tên</th>
                                                <th class="sorting">Giới Tính</th>
                                                <th class="sorting">Email</th>
                                                <th class="sorting">Giáo Viên Môn</th>
                                                <th class="sorting">Số Điện Thoại</th>
                                                <th class="sorting">Địa Chỉ</th>
                                                <th class="sorting">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-table-body">
                                            @foreach ($teachers as $teacher)
                                            <tr>
                                                <td>{{ $teacher->teacher_code }}</td>
                                                <td>
                                                    @if ($teacher->user->avatar)
                                                    <img src="{{ asset($teacher->user->avatar) }}" alt="Avatar" width="50" height="50">
                                                    @else
                                                    <span>Không có ảnh</span>
                                                    @endif
                                                </td>
                                                <td>{{ $teacher->user->name ?? 'N/A' }}</td>
                                                <td>{{ $teacher->user->gender ?? 'N/A' }}</td>
                                                <td>{{ $teacher->user->email ?? 'N/A' }}</td>
                                                <td>{{ $teacher->subject->name ?? 'N/A' }}</td>
                                                <td>{{ $teacher->user->phone ?? 'N/A' }}</td>
                                                <td>{{ $teacher->user->address ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{route('update-teacher',$teacher->id)}}" class="btn btn-warning btn-sm text-white">Sửa</a>
                                                    <a href="{{ route('delete-teacher', $teacher->id) }}" class="btn btn-danger btn-sm text-white">Xóa</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($teachers)
                                    <div class="d-flex justify-content-end ml-2 paginate">
                                        {{ $teachers->appends(['search-input' => request('search-input')])->links('pagination::bootstrap-5') }}
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