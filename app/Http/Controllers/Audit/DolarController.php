<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class DolarController extends Controller
{
    public function index(){
        return view('audit.dolars.index');
    }
}
