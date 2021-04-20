<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buffet;

class BuffetController extends Controller
{
    function index(){
        $buffet = Buffet::select('*')->get();
        return view('buffet', compact('buffet'));
    }

    function update(Request $request){
        return $request;
    }
}
