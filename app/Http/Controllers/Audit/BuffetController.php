<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class BuffetController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:buffet.show')->only('index');
    }

    function index(){
        return view('audit.buffet');
    }
}
