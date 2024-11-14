<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    public function updateInfor($id){
        $user = User::findOrFail($id);
        return view('Admin.update-user',[
            'user' => $user
        ]);
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

        // Store the file in the desired directory within storage
        $request->file('avatar')->storeAs('public/images/Admin/Manage-User', $storedImage);
        $sourcePath = storage_path('app/public/images/Admin/Manage-User/' . $storedImage);
        $destinationPath = public_path('images/Admin/Manage-User/' . $storedImage);
        File::copy($sourcePath, $destinationPath);
        $user->avatar = 'images/Admin/Manage-User/' . $storedImage;
    }
    $check_update = $user->save();
    if ($check_update) {
        return redirect()->route('manage-user')->with('success', 'Update user information successfully!');
    } else {
        return redirect()->back()->with('error', 'Update user information failed!');
    }
    }
    public function updatePassword($id, Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check if current password matches
        if (!Hash::check($request->input('current-password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update the password
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->route('manage-user')->with('success', 'Password updated successfully!');
    }
}
