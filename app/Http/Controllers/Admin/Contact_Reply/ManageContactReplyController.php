<?php

namespace App\Http\Controllers\Admin\Contact_Reply;

use App\Http\Controllers\Controller;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class ManageContactReplyController extends Controller
{
    public function index(){
        $user = auth()->user();
        $contact_replies = $this->getReply();
        return view("Admin.manage-contact-reply",[
            'user' => $user,
            'contact_replies' => $contact_replies
        ]);
    }
    public function getReply(){
        $contact_replies = ContactReply::join('contacts','contacts.id','=','contact_replies.contact_id')
                            ->select('contact_replies.*','contacts.name','contacts.email','contacts.title','contacts.content')
                            ->orderBy('contact_replies.updated_at','DESC')
                            ->paginate(5);
        return $contact_replies;
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $contact_replies = ContactReply::join('contacts','contacts.id','=','contact_replies.contact_id')
                            ->select('contact_replies.*','contacts.name','contacts.email','contacts.title','contacts.content')
                            ->where(function ($q) use ($query) {
                                $q->where('contacts.name', 'like', '%'. $query. '%')
                                  ->orWhere('contacts.email', 'like', '%'. $query. '%')
                                  ->orWhere('contacts.title', 'like', '%'. $query. '%')
                                  ->orWhere('contacts.content', 'like', '%'. $query. '%')
                                  ->orWhere('contact_replies.message', 'like', '%'. $query. '%')
                                  ->orWhere('contact_replies.created_at', 'like', '%'. $query. '%')
                                  ->orWhere('contact_replies.updated_at', 'like', '%'. $query. '%');
                            })
                            ->orderBy('contact_replies.updated_at','DESC')
                            ->paginate(5);
                            $user = auth()->user();
                            return view('Admin.manage-contact-reply', [
                                'contact_replies' => $contact_replies,
                                'user' => $user
                            ]);
    }
    public function delete($id){
        $contact_reply = ContactReply::findOrFail($id);
        if($contact_reply){
            $contact_reply->delete();
        }
        return redirect()->route('manage-contact-reply')->with('success','Delete Contact Reply successfully');
    }
}
