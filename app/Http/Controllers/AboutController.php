<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view("User.about",[
            'user' => $user,
            'messages' => $messages
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
}
