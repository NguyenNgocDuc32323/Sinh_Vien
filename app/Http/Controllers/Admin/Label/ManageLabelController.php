<?php

namespace App\Http\Controllers\Admin\Label;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class ManageLabelController extends Controller
{
    public function index(){
        $user = auth()->user();
        $labels = Label::orderBy('updated_at', 'DESC')->paginate(6);
        return view('Admin.manage-label', [
            'user' => $user,
            'labels' => $labels
        ]);
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $labels = Label::where('name', 'like', '%'. $query. '%')
            ->orWhere('created_at', 'like', '%'. $query. '%')
            ->orWhere('updated_at', 'like', '%'. $query. '%')
            ->orderBy('updated_at', 'DESC')
            ->paginate(6);
        $user = auth()->user();
        return view('Admin.manage-label', [
            'user' => $user,
            'labels' => $labels
        ]);
    }
    public function delete($id){
        $label = Label::findOrFail($id);
        $check_delete = $label->delete();
        if($check_delete){
            return redirect()->route('manage-label')->with('success','Label deleted successfully');
        } else{
            return redirect()->route('manage-label')->with('error','Failed to delete label');
        }
    }
}
