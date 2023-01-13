<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:restaurant.show')->only('index');
    }

    public function index(){
        return view('audit.restaurants.index'); 
    }
}
