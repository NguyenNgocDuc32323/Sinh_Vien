<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Course;
use App\Models\ExamType;
use App\Models\Score;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class TeacherController extends Controller
{
    public function index(){
        $logged_user = $this->logedInUser();
        $user = auth()->user();
        return view('Teacher.teacher-index',compact('logged_user', 'user'));
    }
    public function logedInUser(){
        $user = auth()->user();
        return $user;
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('User.user-update',compact('user', ));
    }
    public function updateInforPost($id, Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'phone' => 'required|string|max:10|unique:users,phone,' . $id,
        'address' => 'nullable|string|max:255',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $user = User::findOrFail($id);
    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }
    $user->username = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->address = $request->input('address');
    if ($request->hasFile('avatar')) {
        $fileName = str::random(10);
        $extension = $request->file('avatar')->getClientOriginalExtension();
        $storedImage = $fileName . '.' . $extension;
        $request->file('avatar')->storeAs('public/images/Admin/Manage-User', $storedImage);
        $sourcePath = storage_path('app/public/images/Admin/Manage-User/' . $storedImage);
        $destinationPath = public_path('images/Admin/Manage-User/' . $storedImage);
        File::copy($sourcePath, $destinationPath);
        $user->avatar = 'images/Admin/Manage-User/' . $storedImage;
    }
    $check_update = $user->save();
    if ($check_update) {
        return redirect()->route('user-profile',compact('id'))->with('success', 'Update information successfully!');
    } else {
        return redirect()->back()->with('error', 'Update user information failed!');
    }
    }
    public function updatePasswordPost($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
        }
        if (!Hash::check($request->input('current-password'), $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->route('user-profile',compact('id'))->with('success', 'Đã cập nhật mật khẩu thành công!');
    }
    
    public function teacher_profile($id){
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User không tồn tại!');
        }
        return view('User.user-profile', compact('user'));
    }
    public function student_scores()
{
    $semesters = Semester::all();
    $subjects = Subject::all();
    $exam_types = ExamType::all();
    $students = Student::with('user')->get();

    $studentScores = [];

    foreach ($semesters as $semester) {
        $scores = Score::where('semester_id', $semester->id)
            ->with(['subject', 'exam_type', 'semester'])
            ->get();

        $studentScores[$semester->id] = []; // Điểm cho từng học kỳ

        foreach ($students as $student) {
            $studentScores[$semester->id][$student->id] = [
                'name' => $student->user->name,
                'scores' => []
            ];

            foreach ($scores as $score) {
                if ($score->student_id == $student->id) {
                    $subjectName = $score->subject->name;
                    $examSymbol = $score->exam_type->exam_symbol;

                    $studentScores[$semester->id][$student->id]['scores'][$subjectName][$examSymbol] = $score->score;
                }
            }
        }
    }

    return view('Teacher.student-scores', [
        'semesters' => $semesters,
        'subjects' => $subjects,
        'exam_types' => $exam_types,
        'studentScores' => $studentScores
    ]);
    }
    public function delete_scores_get($studentId, $semesterId)
{
    Score::where('student_id', $studentId)
        ->where('semester_id', $semesterId)
        ->delete();
    session()->flash('success', 'Xóa điểm thành công.');
    return redirect()->route('manage-student-scores');
    }
    public function update_scores($studentId, $semesterId)
{
    $scores = Score::where('student_id', $studentId)
        ->where('semester_id', $semesterId)
        ->with(['subject', 'exam_type'])
        ->get();
    $subjects = Subject::all();
    $examTypes = ExamType::all();
    return view('Teacher.update-scores', compact('scores', 'studentId', 'semesterId', 'subjects', 'examTypes'));
}
    public function show_selected_score(Request $request, $studentId, $semesterId)
    {
        $subjects = Subject::all();
        $examTypes = ExamType::all();
        $subjectId = $request->input('subject');
        $examTypeId = $request->input('exam_type');

        $selectedScore = Score::where('student_id', $studentId)
            ->where('semester_id', $semesterId)
            ->where('subject_id', $subjectId)
            ->where('exam_type_id', $examTypeId)
            ->first();
        if (!$selectedScore) {
            $selectedScore = null;
        }
        return view('Teacher.update-scores', compact('selectedScore', 'studentId', 'semesterId', 'subjects', 'examTypes'));
    }
    public function update_score(Request $request, $studentId, $semesterId)
    {
        $subjectId = $request->input('subject');
        $examTypeId = $request->input('exam_type');
        $newScore = $request->input('score');
        $score = Score::where('student_id', $studentId)
                      ->where('semester_id', $semesterId)
                      ->where('subject_id', $subjectId)
                      ->where('exam_type_id', $examTypeId)
                      ->first();
        if ($score) {
            $score->score = $newScore;
            $score->save();
            return redirect()->route('manage-student-scores', ['studentId' => $studentId, 'semesterId' => $semesterId])
                             ->with('success', 'Điểm đã được cập nhật thành công!');
        } else {
            return redirect()->route('manage-student-scores', ['studentId' => $studentId, 'semesterId' => $semesterId])
                             ->with('error', 'Không tìm thấy điểm cho môn học và kỳ thi này');
        }
    }
    public function create_scores_get()
{
    $subjects = Subject::all();
    $examTypes = ExamType::all();
    $students = Student::with('user')->get();
    $semesters = Semester::all();

    return view('Teacher.create-scores-get', [
        'subjects' => $subjects,
        'examTypes' => $examTypes,
        'students' => $students,
        'semesters' => $semesters
    ]);
    
    }
    public function create_scores_post(Request $request)
{
    $validator = Validator::make($request->all(), [
        'std_id' => 'required|integer',
        'semester_id' => 'required|integer',
        'subject_id' => 'required|integer',
        'exam_type_id' => 'required|integer',
        'score' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $data = [
        'student_id' => $request->input('std_id'),
        'semester_id' => $request->input('semester_id'),
        'subject_id' => $request->input('subject_id'),
        'exam_type_id' => $request->input('exam_type_id'),
    ];
    $existingScore = Score::where($data)->first();

    if ($existingScore) {
        $existingScore->update(['score' => $request->input('score')]);
        $message = 'Điểm đã được cập nhật thành công!';
    } else {
        $data['score'] = $request->input('score');
        Score::create($data);
        $message = 'Điểm đã được thêm thành công!';
    }
    return redirect()->route('manage-student-scores')->with('success', $message);
}


    









}
