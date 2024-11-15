<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function index(){
        return view("Layouts.forgot-password");
    }
    public function forgotPassword(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:10'
        ]);

        $user = User::where('email', $validatedData['email'])
                    ->where('phone', $validatedData['phone'])
                    ->first();

        if($user){
            return redirect()->route('reset-password', ['email' => $validatedData['email']])
                             ->with('success','Vui lòng cập nhật mật khẩu của bạn!');
        }

        return redirect()->back()->with('error','Không tìm thấy tài khoản!');
    }


}
