<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index(){
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        $ads = Ads::orderBy('updated_at','desc')->paginate(9);
        $ads_bottoms = $this->getAdsBottom();
        return view("User.ads",[
            'user' => $user,
            'messages' => $messages,
            'ads' => $ads,
            'ads_bottoms' => $ads_bottoms,
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
    public function getAdsBottom(){
        $ads_bottom = Ads::orderBy('updated_at','asc')->paginate(4);
        return $ads_bottom;
    }
}
