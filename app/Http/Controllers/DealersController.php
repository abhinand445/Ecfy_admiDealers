<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealersController extends Controller
{
    //

    public function createDealers() {
        return view('dealers.create');
    }
}
