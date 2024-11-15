<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
{
    $slides = Slider::all();
    $user = auth()->user();

    return view("layouts.home", [
        "slides" => $slides,
        'user' => $user,
    ]);
    }
    public function uploadImage(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('images/Contact'), $fileName);

        $relativePath = 'images/Contact/' . $fileName;

        return response()->json([
            'fileName' => $fileName,
            'uploaded' => 1,
            'url' => $relativePath
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => ['message' => 'Không có tệp nào được tải lên hoặc kích thước tệp quá lớn.']
    ]);
    }
}
