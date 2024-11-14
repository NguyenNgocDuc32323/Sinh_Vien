<?php

namespace App\Http\Controllers\Admin\Slide;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateSlideController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $slide = Slider::findOrFail($id);
        return view("Admin.update-slide",[
            'user' => $user,
            'slide' => $slide
        ]);
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'images' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ]);

    $slide = Slider::findOrFail($id);
    $slide->name = $request->input('name');
    $slide->description = $request->input('description');

    if ($request->hasFile('images')) {
        $fileName = Str::random(10);
        $extension = $request->file('images')->getClientOriginalExtension();
        $storedImage = $fileName . '.' . $extension;
        $request->file('images')->storeAs('public/images/Slide', $storedImage);
        $sourcePath = storage_path('app/public/images/Slide/' . $storedImage);
        $destinationPath = public_path('images/Slide/' . $storedImage);
        File::copy($sourcePath, $destinationPath);

        if ($slide->images && Storage::exists('public/' . $slide->images)) {
            Storage::delete('public/' . $slide->images);
        }

        $slide->images = 'images/Slide/' . $storedImage;
    }

    $check_update = $slide->save();

    if ($check_update) {
        return redirect()->route('manage-slide')->with('success', 'Slide updated successfully!');
    } else {
        return redirect()->route('manage-slide')->with('error', 'Slide update failed!');
    }
    }
}
