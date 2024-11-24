<?php
$examTypes = DB::table('exam_types')->orderBy('id')->get();
?>
@extends('Layouts.master-student')
@section('page_title')
Quản Lý Điểm Số
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
<div id="demo_3">
    <section_1 class="m-5">
        <div class="row">
            <div class="col-12">
                <div class="studentDetailContainer frameWork p-4">
                    <div class="semester">
                        <h4 class="header-text showMark">XEM ĐIỂM SỐ
                        </h4>
                        @foreach ($scores as $semesterName => $semesterScores)
                        <h4 class="score-text">{{ $semesterName }}</h4>
                        <table class="table table-bordered text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th>STT</th>
                                    <th>Mã môn</th>
                                    <th>Tên môn học</th>
                                    @foreach ($examTypes as $examType)
                                    <th>{{ $examType->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach ($semesterScores->groupBy('subject_code') as $subjectCode => $subjectScores)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $subjectCode }}</td>
                                    <td>{{ $subjectScores->first()->subject_name }}</td>
                                    @foreach ($examTypes as $examType)
                                    @php
                                    $score = $subjectScores->firstWhere('exam_type_id', $examType->id);
                                    @endphp
                                    <td>{{ $score->score ?? '' }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section_1>

</div>
@endsection