<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CreateCategoryController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view("Admin.create-category",[
            'user' => $user
        ]);
    }
    public function create(Request $request){
        $validated = $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|max:255'
        ]);
        // Create category
        $category = new Category();
        $category->name = $validated['name'];
        $category->description = $validated['description'];
        $category->save();
        return redirect()->route('manage-category')->with('success', 'Category created successfully');
    }
}
