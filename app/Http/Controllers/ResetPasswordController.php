<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index(Request $request){
        $email = $request->query("email");
        return view("Layouts.reset-password",[
            "email"=> $email
        ]);
    }
    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        if ($user) {
            $user->password = Hash::make($validatedData['password']);
            $user->save();
            return redirect()->route('login')->with('success', 'Đã cập nhật mật khẩu thành công!');
        }
        return redirect()->back()->with('error', 'Cập nhật mật khẩu không thành công!');
    }

}
