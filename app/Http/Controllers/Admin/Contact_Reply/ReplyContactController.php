<?php

namespace App\Http\Controllers\Admin\Contact_Reply;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class ReplyContactController extends Controller
{
    public function index($id){
        $contact = Contact::findOrFail($id);
        $user = auth()->user();
        return view('Admin.reply-contact', [
            'contact' => $contact,
            'user' => $user,
        ]);
    }
    public function reply($id, Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        $contact = Contact::findOrFail($id);
        if (!$contact) {
            return redirect()->route('manage-contact')->with('error', 'Contact not found');
        }
        $contact_reply = new ContactReply();
        $contact_reply->contact_id = $id;
        $contact_reply->message = $request->content;
        $contact_reply->save();
        $contact->update(['status' => 'Read']);
        return redirect()->route('manage-contact')->with('success', 'Contact Reply Successfully');
    }
    public function uploadImageAdmin(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/Contact_Reply'), $fileName);

        $relativePath = 'images/Contact_Reply/' . $fileName;

        return response()->json([
            'uploaded' => 1,
            'url' => asset($relativePath)
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => ['message' => 'No file uploaded or file size too large.']
    ]);
    }
}
