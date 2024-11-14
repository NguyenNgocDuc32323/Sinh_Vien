<?php

namespace App\Http\Controllers\Admin\Label;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class CreateLabelController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-label",[
            'user' => $user
        ]);
    }
    public function create(Request $request){
        $request->validate([
            'name' =>'required|string|max:255'
        ]);
        $label = new Label();
        $label->name = $request->name;
        $check_create = $label->save();
        if($check_create){
            return redirect()->route('manage-label')->with('success', 'Label created successfully');
        }else {
            return redirect()->route('manage-label')->with('error', 'Error creating label');
        }
    }
}
