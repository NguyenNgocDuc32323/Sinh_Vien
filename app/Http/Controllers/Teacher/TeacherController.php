<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
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
    public function manage_scores(){
        return view('Teacher.manage-score');
    }
    public function teacher_profile($id){
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User không tồn tại!');
        }
        return view('User.user-profile', compact('user'));
    }
    
}
