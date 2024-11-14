<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    public function index(){
        return view("layouts.register");
    }
    public function register(Request $request){
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone' => 'required|max:10|unique:users,phone',
            'address' => 'required|string',
            'agree' => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->with('error', 'Account already exists!');
        }
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->avatar = 'images/Admin/user.png';
        $user->save();
        return redirect('login')->with('success', 'Registration successful!');
    }


}
