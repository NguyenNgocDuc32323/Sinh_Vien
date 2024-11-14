<?php

namespace App\Http\Controllers\Admin\Slide;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class ManageSlideController extends Controller
{
    public function index(){
        $user = auth()->user();
        $slides = Slider::orderBy('updated_at', 'DESC')
        ->paginate(10);
        return view("Admin.manage-slide",[
            'user' => $user,
            'slides' => $slides
        ]);
    }
    public function search(Request $request)
{
    $user = auth()->user();
    $query = $request->input('search-input');
    $slides = Slider::where('name', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->orWhere('created_at', 'like', '%' . $query . '%')
        ->orWhere('updated_at', 'like', '%' . $query. '%')
        ->orderBy('updated_at', 'DESC')
        ->paginate(10);

    return view('Admin.manage-slide', [
        'user' => $user,
        'slides' => $slides
    ]);
    }
    public function delete($id){
        $slide = Slider::findOrFail($id);
        $check_delete = $slide->delete();
        if($check_delete){
            return redirect()->route('manage-slide')->with('success','Slide deleted successfully');
        } else{
            return redirect()->route('manage-slide')->with('error','Failed to delete slide');
        }
    }
}
