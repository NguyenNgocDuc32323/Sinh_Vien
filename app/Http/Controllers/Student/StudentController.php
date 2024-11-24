<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class StudentController extends Controller
{
    public function index(){
        $logged_user = $this->logedInUser();
        $user = auth()->user();
        return view('Student.student-index',compact('logged_user', 'user'));
    }
    public function logedInUser(){
        $user = auth()->user();
        return $user;
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
    public function student_profile($id){
        $user = User::find($id); // Sử dụng find() để lấy một bản ghi theo id
        if (!$user) {
            return redirect()->back()->with('error', 'User không tồn tại!');
        }
        return view('User.user-profile', compact('user')); // Đưa tên biến vào compact
    }
    public function edit($student_id){
        $user = User::find($student_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User không tồn tại!');
        }
        return view('User.user-update', compact('user'));
    }
    public function manage_scores()
    {
        $user = auth()->user();
        $student = $user->student;
        $scores = DB::table('scores')
            ->leftJoin('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->leftJoin('exam_types', 'scores.exam_type_id', '=', 'exam_types.id')
            ->leftJoin('semesters', 'scores.semester_id', '=', 'semesters.id')
            ->where('scores.student_id', $student->id)
            ->select(
                'subjects.name as subject_name',
                'subjects.subject_code as subject_code',
                'exam_types.id as exam_type_id',
                'exam_types.name as exam_type_name',
                'semesters.name as semester_name',
                'scores.score'
            )
            ->orderBy('semesters.name')
            ->orderBy('exam_types.id')
            ->get()
            ->groupBy('semester_name');

    
        return view('Student.manage-score', compact('scores'));
    }
    

    
}
