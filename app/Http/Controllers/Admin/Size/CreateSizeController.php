<?php

namespace App\Http\Controllers\Admin\Size;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class CreateSizeController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-size",[
            'user' => $user
        ]);
    }
    public function create(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'ratio_price' =>'required|numeric'
        ]);
        $size = new Size();
        $size->name = $request->name;
        $size->ratio_price = $request->ratio_price;
        $check_create = $size->save();
        if($check_create){
            return redirect()->route('manage-size')->with('success', 'Size created successfully!');
        }else {
            return redirect()->route('manage-size')->with('error', 'Failed to create size!');
        }
    }
}
