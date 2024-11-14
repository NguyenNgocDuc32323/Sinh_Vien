<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class UpdateBlogController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        return view('Admin.update-blog', [
            'user' => $user,
            'blog' => $blog,
            'categories' => $categories,
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $blog = Blog::findOrFail($id);
        $blog->name = $request->input('name');
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->category_id = $request->input('category_id');
        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            $fileName = Str::random(10);
            $extension = $request->file('image')->getClientOriginalExtension();
            $storedImage = $fileName . '.' . $extension;
            $request->file('image')->storeAs('public/images/Blog', $storedImage);

            $sourcePath = storage_path('app/public/images/Blog/' . $storedImage);
            $destinationPath = public_path('images/Blog/' . $storedImage);
            File::copy($sourcePath, $destinationPath);

            $blog->image = 'images/Blog/' . $storedImage;
        }
        $check_update = $blog->save();
        if ($check_update) {
            return redirect()->route('manage-blog')->with('success', 'Blog updated successfully!');
        } else {
            return redirect()->route('manage-blog')->with('error', 'Failed to update blog!');
        }
    }
}
