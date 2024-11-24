@extends('Layouts.master-teacher')
@section('page_title')
Cập Nhật Điểm Của Học Sinh
@endsection
@section('content')
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.success('{{ session('
            success ') }}');
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        toastr.error('{{ session('
            error ') }}');
    });
</script>
@endif
<div id="manage-std-scores">
    <section_1 class="m-5">
        <div class="row">
            <div class="col-12">
                <div class="studentDetailContainer frameWork p-4">
                    <div class="students-scores semester">
                        <h4 class="text-white">Cập Nhật Điểm Số</h4>
                        <hr>
                        <div style="overflow-x: auto; max-height: 500px;">
                        <form method="POST" action="{{ isset($selectedScore) ? route('update-scores.update', ['studentId' => $studentId, 'semesterId' => $semesterId]) : route('update-scores.submit', ['studentId' => $studentId, 'semesterId' => $semesterId]) }}">
                            @csrf
                            <div class="form-group mb-3 mt-3">
                                <label for="subject" class="form-label text-white fw-bold">Chọn môn học:</label>
                                <select name="subject" id="subject" class="form-control">
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ isset($selectedScore) && $selectedScore->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3 mt-3">
                                <label for="exam_type" class="form-label text-white fw-bold">Chọn kỳ thi:</label>
                                <select name="exam_type" id="exam_type" class="form-control">
                                    @foreach($examTypes as $examType)
                                    <option value="{{ $examType->id }}" {{ isset($selectedScore) && $selectedScore->exam_type_id == $examType->id ? 'selected' : '' }}>
                                        {{ $examType->exam_symbol }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            @if(isset($selectedScore))
                            <div class="form-group mb-3 mt-3">
                                <label for="score" class="form-label text-white fw-bold">Điểm hiện tại:</label>
                                <input type="number" name="score" id="score" class="form-control" value="{{ old('score', $selectedScore->score) }}" step="0.01">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning text-white mt-4">Cập nhật điểm</button>
                            </div>
                            @else
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning text-white mt-4">Hiển thị điểm</button>
                            </div>
                            @endif
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section_1>

</div>
@endsection