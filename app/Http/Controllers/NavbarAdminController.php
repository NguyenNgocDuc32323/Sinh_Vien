<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavbarAdminController extends Controller
{
    public function index(){
        $login_user = Auth::user();
        return view("Layouts.navbar-admin",[
            "login_user"=> $login_user
        ]);
    }
}
