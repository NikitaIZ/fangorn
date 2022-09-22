<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Audit\Restaurants\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new Restaurant();
        $restaurant->name  = 'Restaurante Marea';
        $restaurant->save();

        $restaurant = new Restaurant();
        $restaurant->name  = 'Espuma Bar';
        $restaurant->save();

        $restaurant = new Restaurant();
        $restaurant->name  = 'Bar las Rocas';
        $restaurant->save();
    }
}
