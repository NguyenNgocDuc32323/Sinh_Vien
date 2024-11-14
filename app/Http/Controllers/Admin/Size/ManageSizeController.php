<?php

namespace App\Http\Controllers\Admin\Size;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class ManageSizeController extends Controller
{
    public function index(){
        $user = auth()->user();
        $sizes = Size::orderBy('updated_at', 'desc')->paginate(6);
        return view("Admin.manage-size",[
            'user' => $user,
            'sizes' => $sizes
        ]);
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $sizes = Size::where('name', 'like', '%'. $query. '%')
        ->orWhere('ratio_price', 'like', '%' . $query. '%')
        ->orWhere('created_at', 'like', '%' . $query. '%')
        ->orWhere('updated_at', 'like', '%' . $query. '%')
        ->orderBy('updated_at', 'desc')
        ->paginate(6);
        $user = auth()->user();
        return view('Admin.manage-size', [
           'sizes' => $sizes,
            'user' => $user
        ]);
    }
    public function delete($id){
        $size = Size::findOrFail($id);
        $check_delete = $size->delete();
        if($check_delete){
            return redirect()->route('manage-size')->with('success', 'Size deleted successfully');
        }else{
            return redirect()->route('manage-size')->with('error', 'Failed to delete size');
        }
    }
}
