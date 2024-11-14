<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class CreateBlogController extends Controller
{
    public function index(){
        $user = auth()->user();
        $categories = Category::all();
        return view('Admin.create-blog', [
            'user' => $user,
            'categories' => $categories,
        ]);
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:500',
            'category_id' =>'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        $blog = new Blog();
        $blog->name = $request->input('name');
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->category_id = $request->input('category_id');
        if($request->hasFile('image')){
                $fileName = str::random(10);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storedImage = $fileName . '.' . $extension;
                $request->file('image')->storeAs('public/images/Blog', $storedImage);
                $sourcePath = storage_path('app/public/images/Blog/' . $storedImage);
                $destinationPath = public_path('images/Blog/' . $storedImage);
                File::copy($sourcePath, $destinationPath);
                $blog->image = 'images/Blog/' . $storedImage;
        }
        $check_create = $blog->save();
        if($check_create){
            return redirect()->route('manage-blog')->with('success', 'Create blog successfully!');
        }else{
            return redirect()->route('manage-blog')->with('error', 'Create blog failed!');
        }
    }
}
