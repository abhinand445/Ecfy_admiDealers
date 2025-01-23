<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

      // Show the dashboard page
    public function dashboard()
    {
        return view('dashboard');
    }
    
    public function profile()
    {
        return view('profile');  
    }

    public function changePassword()
    {
        return view('change-password');
    }
}
