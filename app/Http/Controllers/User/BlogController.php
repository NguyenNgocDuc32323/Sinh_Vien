<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        $blogs = Blog::orderBy('updated_at','DESC')->paginate(6);
        return view("User.blog",[
            'user' => $user,
            'messages' => $messages,
            'blogs' => $blogs
        ]);
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
    public function detail($id){
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        $blog= Blog::findOrFail($id);
        return view("User.blog-detail",[
            'user' => $user,
            'blog' => $blog,
            'messages' => $messages
        ]);
    }
}
