<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;

class PlateController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:plate.show')->only('index');
    }

    public function index($lang, $rest, $id){
        $restaurant  = Restaurant::where('id', $rest)->first();
        $restaurants = Restaurant::whereNotIn('id', [$restaurant->id])->get();
        $menu        = RestaurantMenu::where('id', $id)->first();
        $menus       = RestaurantMenu::where('restaurant_id', $rest)->whereNotIn('id', [$menu->id])->get();
        $allData = array(
            'restaurants' => $restaurants,
            'restaurant'  => $restaurant,
            'menus'       => $menus,
            'menu'        => $menu,
            'rest'        => $rest,
            'lang'        => $lang,
        );
        return view('audit.restaurants.plate', compact('allData')); 
    }
}
