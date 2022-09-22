<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    public function index(){
        return view('audit.restaurants.index'); 
    }
}
