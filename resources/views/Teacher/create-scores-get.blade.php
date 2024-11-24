
@extends('Layouts.master-teacher')
@section('page_title')
    Nhập Điểm Học
@endsection
@section('content')
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
    <div class="dashboard-main-body mt-4 mbt-6">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h1 class="fw-semibold mb-0 body-title">Nhập Điểm Cho Học Sinh</h1>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li><span>-</span></li>
                <li class="fw-medium"><span>User</span></li>
            </ul>
        </div>
        <div class="row justify-content-center align-items-center create-score-block">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('create-scores-post')}}" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="std_id" class="form-label">Họ Và Tên</label>
                                <select name="std_id" id="std_id" class="form-control">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('std_id'))
                                    <span class='text-danger-login'>{{ $errors->first('std_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="semester">Học Kỳ</label>
                                <select name="semester_id" id="semester_id" class="form-control">
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">
                                            {{ $semester->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('semester_id'))
                                    <span class='text-danger-login'>{{ $errors->first('semester_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="exam_type_id">Kỳ Thi</label>
                                <select name="exam_type_id" id="exam_type_id" class="form-control">
                                    @foreach ($examTypes as $examType)
                                        <option value="{{ $examType->id }}">
                                            {{ $examType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('semester_id'))
                                    <span class='text-danger-login'>{{ $errors->first('semester_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="subject_id">Môn Học</label>
                                <select name="subject_id" id="subject_id" class="form-control">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subject_id'))
                                    <span class='text-danger-login'>{{ $errors->first('subject_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="score">Điểm Số</label>
                                <input type="number" class="form-control" name="score" id="score">
                                @if ($errors->has('score'))
                                    <span class='text-danger-login'>{{ $errors->first('score') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3 mt-4">
                                <button type="submit" class="btn btn-create btn-danger text-white">Create Blog</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('custom-scripts')
    
@endpush
