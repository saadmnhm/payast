<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeiceController extends Controller
{
    public function index()
    {
        return view('front.list.piece');
    }
}
