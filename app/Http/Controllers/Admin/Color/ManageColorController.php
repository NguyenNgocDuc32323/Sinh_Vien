<?php

namespace App\Http\Controllers\Admin\Color;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ManageColorController extends Controller
{
    public function index(){
        $user = auth()->user();
        $colors = Color::orderBy('updated_at','DESC')
        ->paginate(10);
        return view("Admin.manage-color",[
            'user' => $user,
            'colors' => $colors
        ]);
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $colors = Color::where('name', 'like', '%'. $query. '%')
        ->orWhere('ratio_price', 'like', '%'. $query. '%')
        ->orWhere('created_at', 'like', '%' . $query. '%')
        ->orWhere('updated_at', 'like', '%' . $query. '%')
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);
        $user = auth()->user();
        return view('Admin.manage-color', [
            'colors' => $colors,
            'user' => $user
        ]);
    }
    public function delete($id){
        $color = Color::findOrFail($id);
        $check_delete = $color->delete();
        if($check_delete){
            return redirect()->route('manage-color')->with('success','Color has been deleted successfully.');
        } else{
            return redirect()->route('manage-color')->with('error','Failed to delete color.');
        }
    }
}
