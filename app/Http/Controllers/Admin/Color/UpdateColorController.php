<?php

namespace App\Http\Controllers\Admin\Color;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class UpdateColorController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $color = Color::findOrFail($id);
        return view('Admin.update-color', [
            'user' => $user,
            'color' => $color
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string',
            'ratio_price' => 'required|numeric'
        ]);
        $color = Color::findOrFail($id);
        $color->name = $request->name;
        $color->ratio_price = $request->ratio_price;
        $check_update = $color->save();
        if($check_update){
            return redirect()->route('manage-color')->with('success', 'Color updated successfully');
        } else {
            return redirect()->route('manage-color')->with('error', 'Error updating color');
        }
    }
}
