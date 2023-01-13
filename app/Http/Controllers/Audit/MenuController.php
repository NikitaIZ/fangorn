<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

use App\Models\Audit\Restaurants\Restaurant;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:menu.show')->only('index');
    }

    public function index($lang, $id){
        $restaurant      = Restaurant::where('id', $id)->first();
        $restaurant_list = Restaurant::whereNotIn('id', [$restaurant->id])->get();
        return view('audit.restaurants.menu', compact('lang', 'id', 'restaurant', 'restaurant_list')); 
    }
}
