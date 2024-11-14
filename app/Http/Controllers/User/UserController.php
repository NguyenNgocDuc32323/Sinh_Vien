<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(){
        $logged_user = $this->logedInUser();
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view('User.user-profile',compact('logged_user', 'user', 'messages'));
    }
    public function logedInUser(){
        $user = auth()->user();
        return $user;
    }
    public function edit($id){
        $user = User::findOrFail($id);
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view('User.user-update',compact('user', 'messages'));
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
            return redirect()->back()->with('error', 'User not found.');
        }
        if (!Hash::check($request->input('current-password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->route('user-profile',compact('id'))->with('success', 'Password updated successfully!');
    }
    public function getMessage($user) {
        $contacts = Contact::where('email', $user->email)->get();
        if ($contacts->isEmpty()) {
            return collect([]);
        }
        $contactIds = $contacts->pluck('id');
        $messages = ContactReply::whereIn('contact_id', $contactIds)->get();
        if ($messages->isEmpty()) {
            return collect([]);
        }

        return $messages;
    }
}
