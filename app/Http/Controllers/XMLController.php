<?php

namespace App\Http\Controllers;

class XmlController extends Controller
{
    public function index(){
        return view('xmls.index'); 
    }

    public function show($xml){
        return view('xmls.show', compact('xml'));
    }
}
