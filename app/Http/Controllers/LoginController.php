<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        return view("Layouts.login");
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'code' => 'required|string',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return redirect('login')
                    ->withErrors($validator)
                    ->withInput();
    }

    $code = $request->input('code');
    $password = $request->input('password');
    $remember = $request->has('remember');

    // Tìm kiếm user dựa trên code
    $user = User::whereHas('teacher', function ($query) use ($code) {
        $query->where('teacher_code', $code);
    })->orWhereHas('student', function ($query) use ($code) {
        $query->where('student_code', $code);
    })->orWhereHas('admin', function ($query) use ($code) { // Thêm điều kiện tìm kiếm admin_code
        $query->where('admin_code', $code);
    })->first();

    if (!$user || !Hash::check($password, $user->password)) {
        return back()->with('error', 'Code hoặc mật khẩu không đúng!');
    }

    // Xóa token cũ cho tất cả người dùng
    User::whereNotNull('remember_token')->update(['remember_token' => null]);

    if ($remember) {
        $token = Str::random(60);
        $user->remember_token = hash('sha256', $token);
        $user->save();
        Cookie::queue('remember_token', $token, 43200); // Lưu token vào cookie
    } else {
        $user->remember_token = null;
        $user->save();
        Cookie::queue(Cookie::forget('remember_token'));
    }

    Auth::login($user, $remember);

    if ($user->role === 'student') {
        $student = $user->student()->with(['course', 'class', 'scores.subject'])->first();
        if ($student) {
            $user->student = $student;
            return redirect()->route('student-index', [
                'id' => $user->id, 'user' => $user
            ])->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh!');
    } 

    if ($user->role === 'teacher') {
        $teacher = $user->teacher()->with('subject')->first();
        if ($teacher) {
            $user->teacher = $teacher;
            return redirect()->route('teacher-index', [
                'id' => $user->id, 'teacher_subject' => $teacher->subject
            ])->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->route('login')->with('error', 'Không tìm thấy thông tin giáo viên!');
    }

    if ($user->role === 'admin') {
        $admin = $user->admin()->first(); // Lấy thông tin admin
        if ($admin) {
            $user->admin = $admin;
            return redirect()->route('admin', ['user' => $user])->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->route('login')->with('error', 'Không tìm thấy thông tin admin!');
    }

    return redirect()->route('login')->with('error', 'Vai trò không hợp lệ!');
}





}
