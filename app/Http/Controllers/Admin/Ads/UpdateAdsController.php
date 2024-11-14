<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class UpdateAdsController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $ads = Ads::findOrFail($id);
        return view('Admin.update-ads', [
            'user' => $user,
            'ads' => $ads,
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'expired_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $ads = Ads::findOrFail($id);
        $ads->name = $request->input('name');
        $ads->description = $request->input('description');
        $ads->expired_at = $request->input('expired_at');
        if ($request->hasFile('image')) {
            if ($ads->image && File::exists(public_path($ads->image))) {
                File::delete(public_path($ads->image));
            }
            $fileName = Str::random(10);
            $extension = $request->file('image')->getClientOriginalExtension();
            $storedImage = $fileName . '.' . $extension;
            $request->file('image')->storeAs('public/images/Ads', $storedImage);

            $sourcePath = storage_path('app/public/images/Ads/' . $storedImage);
            $destinationPath = public_path('images/Ads/' . $storedImage);
            File::copy($sourcePath, $destinationPath);

            $ads->image = 'images/Ads/' . $storedImage;
        }
        $check_update = $ads->save();
        if ($check_update) {
            return redirect()->route('manage-ads')->with('success', 'Ads updated successfully!');
        } else {
            return redirect()->route('manage-ads')->with('error', 'Failed to update ads!');
        }
    }
}
