<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;

class PlateController extends Controller
{
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
