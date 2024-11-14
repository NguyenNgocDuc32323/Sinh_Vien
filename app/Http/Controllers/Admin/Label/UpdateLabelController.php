<?php

namespace App\Http\Controllers\Admin\Label;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class UpdateLabelController extends Controller
{
    public function index($id){
        $user = auth()->user();
        $label = Label::findOrFail($id);
        return view('Admin.update-label', [
            'user' => $user,
            'label' => $label
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $label = Label::findOrFail($id);
        $label->name = $request->name;
        $check_update = $label->save();
        if($check_update){
            return redirect()->route('manage-label')->with('success', 'Label updated successfully');
        } else {
            return redirect()->route('manage-label')->with('error', 'Error updating label');
        }
    }
}
