<?php

namespace App\Http\Controllers\Marketings;

use App\Http\Controllers\Controller;

class HotelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:hotels.show')->only('index');
    }

    public function index(){
        return view('marketing.hotels.index');
    }
}
