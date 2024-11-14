<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class UpdateCategoryController extends Controller
{
    public function update($id){
        $category = Category::findOrFail($id);
        $user = auth()->user();
        return view('Admin.update-category',[
            'category' => $category,
            'user' => $user,
        ]);
    }
    public function updatePost($id,Request $request){
        $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string',
            'order_total' =>'required|numeric'
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->order_total = $request->order_total;
        $category->save();
        return redirect()->route('manage-category')->with('success', 'Category updated successfully');
    }
}
