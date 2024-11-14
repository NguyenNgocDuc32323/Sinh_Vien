<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class NavbarAdminController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('Layouts.master-admin',[
            'user'=> $user
        ]);
    }
}
