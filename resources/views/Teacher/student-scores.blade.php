@extends('Layouts.master-teacher')
@section('page_title')
Hồ Sơ Giáo Viên
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
                        <h4 class="text-white">XEM ĐIỂM SỐ</h4>
                        @foreach ($semesters as $semester)
                        <h4 class="text-center text-white mt-5 mb-3 fw-semibold">{{ $semester->name }}</h4>
                        <div style="overflow-x: auto; max-height: 500px;">
                            <table class="table table-bordered table-striped text-center"
                                style="overflow-x: auto; display: block; white-space: nowrap;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th rowspan="2" class="align-middle">Học sinh</th>
                                        @foreach ($subjects as $subject)
                                        <th colspan="{{ count($exam_types) }}" class="bg-danger text-white">
                                            {{ $subject->name }}
                                        </th>
                                        @endforeach
                                        <th class="bg-danger text-white">Action</th>
                                    </tr>
                                    <tr>
                                        @foreach ($subjects as $subject)
                                        @foreach ($exam_types as $exam_type)
                                        <th style="width: 50px; min-width: 50px;" class="bg-warning">
                                            {{ $exam_type->exam_symbol }}
                                        </th>
                                        @endforeach
                                        @endforeach
                                        <th style="width: 50px; min-width: 50px;" class="bg-warning"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentScores[$semester->id] as $studentId => $student)
                                    <tr>
                                        <td class="font-weight-bold">{{ $student['name'] }}</td>
                                        @foreach ($subjects as $subject)
                                        @if (isset($student['scores'][$subject->name]))
                                        @foreach ($exam_types as $exam_type)
                                        <td style="text-align: center; vertical-align: middle;">
                                            {{ $student['scores'][$subject->name][$exam_type->exam_symbol] ?? '-' }}
                                        </td>
                                        @endforeach
                                        @else
                                        @foreach ($exam_types as $exam_type)
                                        <td style="text-align: center; vertical-align: middle;">-</td>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        <td>
                                            <a href="{{route('update-scores',['studentId' => $studentId, 'semesterId' => $semester->id])}}" class="btn btn-warning text-white">update</a>
                                            @php
                                            $hasScores = false;
                                            foreach ($subjects as $subject) {
                                            if (isset($student['scores'][$subject->name])) {
                                            $hasScores = true;
                                            break;
                                            }
                                            }
                                            @endphp
                                            @if ($hasScores)
                                            <a href="{{ route('delete-scores', ['studentId' => $studentId, 'semesterId' => $semester->id]) }}"
                                                class="btn btn-danger text-white">delete</a>
                                            @else
                                            <button class="btn btn-secondary text-white" disabled>deleted</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section_1>

</div>
@endsection