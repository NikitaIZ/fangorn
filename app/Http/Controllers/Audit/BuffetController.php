<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class BuffetController extends Controller
{
    function index(){
        return view('audit.buffet');
    }
}
