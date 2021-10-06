<?php

namespace Database\Seeders;

use App\Models\Tanks\Tank;
use Illuminate\Database\Seeder;

class TankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tank = new Tank();

        $tank->location = "Almacen";
        $tank->capacity = 150;

        $tank->save();
    }
}
