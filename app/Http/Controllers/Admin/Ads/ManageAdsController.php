<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class ManageAdsController extends Controller
{
    public function index(){
        $user = auth()->user();
        $adses = Ads::orderBy('updated_at', 'DESC')->paginate(6);
        return view('Admin.manage-ads', [
            'user' => $user,
            'adses' => $adses
        ]);
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $adses = Ads::orwhere('name', 'like', '%'. $query. '%')
            ->orWhere('description', 'like', '%'. $query. '%')
            ->orWhere('expired_at', 'like', '%' . $query . '%')
            ->orWhere('created_at', 'like', '%' . $query. '%')
            ->orWhere('updated_at', 'like', '%' . $query. '%')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);
        $user = auth()->user();
        return view('Admin.manage-ads', [
            'adses' => $adses,
            'user' => $user
        ]);
    }
    public function delete($id){
        $ads = Ads::findOrFail($id);
        $checked_delete = $ads->delete();
        if($checked_delete){
            return redirect()->route('manage-ads')->with('success','Ads deleted successfully');
        } else {
            return redirect()->route('manage-ads')->with('error','Failed to delete Ads');
        }
    }
}
