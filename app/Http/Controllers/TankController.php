<?php

namespace App\Http\Controllers;

use App\Models\Tank;
use Illuminate\Http\Request;

class TankController extends Controller
{
    public function index(){
        $tank = Tank::all();
        return view('tanks.index');
    }

    public function create(){
        return view('tanks.create');
    }

    public function show($tank){
        return view('tanks.show', compact('tank'));
    }
}
