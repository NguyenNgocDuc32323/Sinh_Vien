<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ManageContactController extends Controller
{
    public function index(){
        $user = auth()->user();
        $contacts = $this->getAllContact();
        return view("Admin.manage-contact",[
            'user' => $user,
            'contacts' => $contacts
        ]);
    }
    public function getAllContact(){
        $contacts = Contact::orderBy('updated_at','DESC')
                    ->paginate(5);
        return $contacts;
    }
    public function search(Request $request){
        $query = $request->input('search-input');

        $contacts = Contact::where(function ($q) use ($query) {
            $q->where('name', 'like', '%'. $query. '%')
                ->orWhere('email', 'like', '%'. $query. '%')
                ->orWhere('phone', 'like', '%'. $query. '%')
                ->orWhere('title', 'like', '%'. $query. '%')
                ->orWhere('content', 'like', '%'. $query. '%')
                ->orWhere('status', 'like', '%'. $query. '%')
                ->orWhere('created_at', 'like', '%'. $query. '%')
                ->orWhere('updated_at', 'like', '%'. $query. '%');
        })
        ->orderBy('updated_at','DESC')
        ->paginate(5);
        $user = auth()->user();
        return view('Admin.manage-contact', [
            'contacts' => $contacts,
            'user' => $user
        ]);
    }
    public function delete($id){
        $contact = Contact::findOrFail($id);
        $check_delete = $contact->delete();
        if($check_delete){
            return redirect()->route('manage-contact')->with('success','Contact deleted successfully');
        }else{
            return redirect()->route('manage-contact')->with('error','Failed to delete contact');
        }
    }
}
