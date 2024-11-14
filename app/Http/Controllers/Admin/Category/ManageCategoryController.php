<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ManageCategoryController extends Controller
{
    public function index(){
        $user = auth()->user();
        $categories = $this->getAllCategory();
        return view("Admin.manage-category",[
            'user' => $user,
            'categories' => $categories
        ]);
    }
    public function getAllCategory(){
        $categories = Category::paginate(5);
        return $categories;
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category) {
            $check_delete = $category->delete();
            if ($check_delete) {
                return redirect()->route('manage-category')->with('success', 'Delete category successfully!');
            } else {
                return redirect()->route('manage-category')->with('error', 'Delete category failed!');
            }
        } else {
            return redirect()->route('manage-category')->with('error', 'category not found!');
        }
    }
    public function search(Request $request){
        $query = $request->input('search-input');
        $categories = Category::where(function ($q) use ($query) {
            $q->where('categories.name', 'like', '%' . $query . '%')
              ->orWhere('categories.description', 'like', '%' . $query . '%')
              ->orWhere('categories.order_total', 'like', '%' . $query . '%')
              ->orWhere('categories.created_at', 'like', '%' . $query . '%')
              ->orWhere('categories.updated_at', 'like', '%' . $query. '%');
        })
        ->groupBy('categories.id')
        ->orderBy('categories.updated_at', 'DESC')
        ->paginate(5);
        $user = auth()->user();
    return view('Admin.manage-category', [
        'categories' => $categories,
        'user' => $user,
    ]);
    }
}
