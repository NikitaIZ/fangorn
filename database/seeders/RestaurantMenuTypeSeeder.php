<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Audit\Restaurants\RestaurantMenuType;

class RestaurantMenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky Standard';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky Bourbons';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky 12 años';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky 15 años';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky 18 años';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Whisky Deluxe';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Vinos Blancos';
        $restaurant->save();

        $restaurant = new RestaurantMenuType();
        $restaurant->name = 'Vinos Tintos';
        $restaurant->save();
    }
}
