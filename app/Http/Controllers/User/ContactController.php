<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ContactController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view('User.contact',[
            'user' => $user,
            'messages' => $messages
        ]);
    }
    public function sentForm(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'title' =>['required', 'string','max:255'],
            'content' => ['required', 'string', 'max:500']
        ]);
        $contact = new Contact();
        $contact->name = $request->username;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->title = $request->title;
        $contact->content = $request->content;
        $newContact = $contact->save();
        if($newContact){
            return redirect()->route('contact')->with('success', 'Thank you for Feedback Information!');
        }
        return redirect()->route('contact')->with('error', 'Failed to send your message. Please try again later.');
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
}
