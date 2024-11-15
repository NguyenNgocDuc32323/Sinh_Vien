<?php

namespace App\Http\Controllers;
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
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return redirect('login')
                    ->withErrors($validator)
                    ->withInput();
    }

    $email = $request->input('email');
    $password = $request->input('password');
    $remember = $request->has('remember');
    $user = User::where('email', $email)->first();

    if (!$user || !Hash::check($password, $user->password)) {
        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    User::whereNotNull('remember_token')->update(['remember_token' => null]);

    if ($remember) {
        $token = Str::random(60);
        $user->remember_token = hash('sha256', $token);
        $user->save();
        Cookie::queue('remember_token', $token, 43200);
    } else {
        $user->remember_token = null;
        $user->save();
        Cookie::queue(Cookie::forget('remember_token'));
    }

    Auth::login($user, $remember);

    if ($user->role === 'student') {
        return redirect()->route('student-index', ['id' => $user->id])->with('success', 'Đăng nhập thành công!');
    } elseif ($user->role === 'teacher') {
        return redirect()->route('teacher-index', ['id' => $user->id])->with('success', 'Đăng nhập thành công!');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin')->with('success', 'Đăng nhập thành công!');
    }

    return redirect()->route('student-index', ['id' => $user->id])->with('success', 'Đăng nhập thành công!');
    }
}
