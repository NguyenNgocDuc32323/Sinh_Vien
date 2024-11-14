<?php

namespace App\Http\Controllers\Admin\Size;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class UpdateSizeController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $size = Size::findOrFail($id);
        return view('Admin.update-size', [
            'user' => $user,
            'size' => $size
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string',
            'ratio_price' => 'required|numeric'
        ]);
        $size = Size::findOrFail($id);
        $size->name = $request->name;
        $size->ratio_price = $request->ratio_price;
        $check_update = $size->save();
        if($check_update){
            return redirect()->route('manage-size')->with('success', 'size updated successfully');
        } else {
            return redirect()->route('manage-size')->with('error', 'Error updating size');
        }
    }
}
