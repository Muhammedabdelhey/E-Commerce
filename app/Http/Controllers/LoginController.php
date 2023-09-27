<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /// go to RouteServiceProvider and change Home to new route
    public function login()
    {
        if (Auth::user()->user_type == 0) {
            return redirect()->route('home');
            // return view('User.home.index');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
