<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class RestaurantMenuCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'España';
        $restaurant->save();

        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'Argentina';
        $restaurant->save();

        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'Chile';
        $restaurant->save();

        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'Francia';
        $restaurant->save();

        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'Italia';
        $restaurant->save();

        $restaurant = new RestaurantMenuCountry();
        $restaurant->name = 'Portugal';
        $restaurant->save();
    }
}
