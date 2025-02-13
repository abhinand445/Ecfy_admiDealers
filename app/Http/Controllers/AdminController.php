<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

   public function index() {
    return view('index');
    
   }

public function dashboard() {
    return view('dashboard');
}

public function map(){
    return view('NewStores');
    
}

  
  
}

