<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Audit\Restaurants\RestaurantMenu;

class RestaurantMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new RestaurantMenu();
        $restaurant->restaurant_id = 1;
        $restaurant->language      = 'español';
        $restaurant->type          = 'comida';
        $restaurant->name          = 'Entradas';
        $restaurant->choice        = false;
        $restaurant->country       = false;
        $restaurant->save();

        $restaurant = new RestaurantMenu();
        $restaurant->restaurant_id = 1;
        $restaurant->language      = 'español';
        $restaurant->type          = 'bebida';
        $restaurant->name          = 'Whisky';
        $restaurant->choice        = true;
        $restaurant->country       = false;
        $restaurant->save();

        $restaurant = new RestaurantMenu();
        $restaurant->restaurant_id = 1;
        $restaurant->language      = 'español';
        $restaurant->type          = 'bebida';
        $restaurant->name          = 'Brandies';
        $restaurant->choice        = false;
        $restaurant->country       = false;
        $restaurant->save();

        $restaurant = new RestaurantMenu();
        $restaurant->restaurant_id = 1;
        $restaurant->language      = 'español';
        $restaurant->type          = 'bebida';
        $restaurant->name          = 'Vinos';
        $restaurant->choice        = true;
        $restaurant->country       = true;
        $restaurant->save();

        $restaurant = new RestaurantMenu();
        $restaurant->restaurant_id = 1;
        $restaurant->language      = 'español';
        $restaurant->type          = 'bebida';
        $restaurant->name          = 'Espumantes';
        $restaurant->choice        = false;
        $restaurant->country       = true;
        $restaurant->save();
    }
}
