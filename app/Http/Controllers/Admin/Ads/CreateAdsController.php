<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class CreateAdsController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-ads",[
            'user' => $user
        ]);
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'expired_at' =>'nullable|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        // Create ads
        $ads = new Ads();
        $ads->name = $request->input('name');
        $ads->description = $request->input('description');
        $ads->expired_at = $request->input('expired_at');
        if($request->hasFile('image')){
                $fileName = str::random(10);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storedImage = $fileName . '.' . $extension;
                $request->file('image')->storeAs('public/images/Ads', $storedImage);
                $sourcePath = storage_path('app/public/images/Ads/' . $storedImage);
                $destinationPath = public_path('images/Ads/' . $storedImage);
                File::copy($sourcePath, $destinationPath);
                $ads->image = 'images/Ads/' . $storedImage;
        }
        $check_create = $ads->save();
        if($check_create){
            return redirect()->route('manage-ads')->with('success', 'Create ads successfully!');
        }else{
            return redirect()->route('manage-ads')->with('error', 'Create ads failed!');
        }
    }
}
