<?php

namespace App\Http\Controllers\Admin\Slide;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class CreateSlideController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-slide",[
            'user' => $user
        ]);
    }
    public function createSlide(Request $request){
        $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);
        // Create slide
        $slide = new Slider();
        $slide->name = $request->input('name');
        $slide->description = $request->input('description');
        if($request->hasFile('images')){
                $fileName = str::random(10);
                $extension = $request->file('images')->getClientOriginalExtension();
                $storedImage = $fileName . '.' . $extension;
                $request->file('images')->storeAs('public/images/Slide', $storedImage);
                $sourcePath = storage_path('app/public/images/Slide/' . $storedImage);
                $destinationPath = public_path('images/Slide/' . $storedImage);
                File::copy($sourcePath, $destinationPath);
                $slide->images = 'images/Slide/' . $storedImage;
        }
        $check_create = $slide->save();
        if($check_create){
            return redirect()->route('manage-slide')->with('success', 'Create slide successfully!');
        }else{
            return redirect()->route('manage-slide')->with('error', 'Create slide failed!');
        }
    }
}
