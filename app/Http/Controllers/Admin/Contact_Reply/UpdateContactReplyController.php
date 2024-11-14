<?php

namespace App\Http\Controllers\Admin\Contact_Reply;

use App\Http\Controllers\Controller;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class UpdateContactReplyController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $contact_reply = ContactReply::join('contacts', 'contact_replies.contact_id', '=', 'contacts.id')
            ->select('contact_replies.*', 'contacts.name as name', 'contacts.email as email','contacts.content as content')
            ->where('contact_replies.id', $id)
            ->firstOrFail();
        return view("Admin.update-contact-reply", [
            'contact_reply' => $contact_reply,
            'user' => $user,
        ]);
    }
    public function updatePost($id, Request $request){
        $request->validate([
            'email' => 'required|email',
            'content' => 'required|string',
            'message' => 'required|string',
        ]);
        $contactReply = ContactReply::findOrFail($id);
        $contactReply->message = $request->input('message');
        $contactReply->save();
        return redirect()->route('manage-contact-reply')->with('success', 'Update contact reply successfully!');
    }
}
