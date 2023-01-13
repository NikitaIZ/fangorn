<?php

namespace App\Http\Controllers\Marketings;

use App\Http\Controllers\Controller;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:marketing')->only('index');
    }

    public function index(){
        return view('marketing.index');
    }
}
