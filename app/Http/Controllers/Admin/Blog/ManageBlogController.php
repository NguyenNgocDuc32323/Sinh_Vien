<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class ManageBlogController extends Controller
{
    public function index(){
        $user = auth()->user();
        $blogs = Blog::orderBy('updated_at','DESC')->paginate(6);
        return view("Admin.manage-blog",[
            'user' => $user,
            'blogs' => $blogs
        ]);
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $blogs = Blog::where('title', 'like', '%'. $query. '%')
            ->orWhere('name', 'like', '%'. $query. '%')
            ->orWhere('content', 'like', '%' . $query. '%')
            ->orWhere('category_id', 'like', '%' . $query. '%')
            ->orWhere('created_at', 'like', '%' . $query. '%')
            ->orWhere('updated_at', 'like', '%' . $query. '%')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);
        $user = auth()->user();
        return view('Admin.manage-blog', [
            'user' => $user,
            'blogs' => $blogs
        ]);
    }
    public function delete($id){
        $blog = Blog::findOrFail($id);
        $check_delete = $blog->delete();
        if($check_delete){
            return redirect()->route('manage-blog')->with('success','Blog deleted successfully');
        } else{
            return redirect()->route('manage-blog')->with('error','Failed to delete blog');
        }
    }
}
