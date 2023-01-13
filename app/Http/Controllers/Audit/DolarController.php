<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class DolarController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dolar.show')->only('index');
    }

    public function index(){
        return view('audit.dolars.index');
    }
}
