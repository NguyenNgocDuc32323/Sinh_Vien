<?php

namespace App\Http\Controllers\Admin\Color;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class CreateColorController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-color",[
            'user' => $user
        ]);
    }
    public function create(Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'ratio_price' =>'required|numeric'
        ]);
        $color = new Color();
        $color->name = $request->name;
        $color->ratio_price = $request->ratio_price;
        $check_crete = $color->save();
        if($check_crete){
            return redirect()->route('manage-color')->with('success', 'Color created successfully');
        }else {
            return redirect()->route('create-color')->with('error', 'Failed to create color');
        }
    }
}
