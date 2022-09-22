<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuPlateType;
use App\Models\Audit\Restaurants\RestaurantMenuPlateCountry;

class RestaurantMenuPlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Ceviche de pescado en jugo de Mandarina";
        $plate->description = "";
        $plate->price       = 10;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Cóctel de Mariscos";
        $plate->description = "";
        $plate->price       = 11;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Ensalada César con Camarones";
        $plate->description = "Lechuga romana, croutones, camarones, aderezado con salsa césar y queso parmesano";
        $plate->price       = 12;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Ensalada César con Pollo";
        $plate->description = "Lechuga romana, croutones, pollo, aderezad con salsa césar y queso parmesano";
        $plate->price       = 9;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Ensalada de Tomate Margariteño";
        $plate->description = "Con queso de búfala y albahaca fresca";
        $plate->price       = 4;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 1;
        $plate->name        = "Camarones Gratinados";
        $plate->description = "";
        $plate->price       = 12;
        $plate->service     = 0;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "Red Label";
        $plate->description = "";
        $plate->price       = 5;
        $plate->service     = 35;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 1;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "Something Special";
        $plate->description = "";
        $plate->price       = 5;
        $plate->service     = 35;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 1;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "The Famous Grouse";
        $plate->description = "";
        $plate->price       = 5;
        $plate->service     = 35;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 1;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "Black & White";
        $plate->description = "";
        $plate->price       = 5;
        $plate->service     = 35;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 1;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "White Label";
        $plate->description = "";
        $plate->price       = 5;
        $plate->service     = 35;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 1;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 2;
        $plate->name        = "Jack Daniels";
        $plate->description = "";
        $plate->price       = 10;
        $plate->service     = 95;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 2;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 3;
        $plate->name        = "Chemineaud";
        $plate->description = "";
        $plate->price       = 2;
        $plate->service     = 15;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 3;
        $plate->name        = "Chemineaud";
        $plate->description = "";
        $plate->price       = 2;
        $plate->service     = 15;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 3;
        $plate->name        = "Gran Duque de Alba";
        $plate->description = "";
        $plate->price       = 15;
        $plate->service     = 135;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 3;
        $plate->name        = "Hennessys";
        $plate->description = "";
        $plate->price       = 15;
        $plate->service     = 135;
        $plate->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 4;
        $plate->name        = "Astica Torrontes Blanc";
        $plate->description = "";
        $plate->price       = 20;
        $plate->service     = 0;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 7;
        $plateType->save();

        $plateType = new RestaurantMenuPlateCountry();
        $plateType->plate_id   = $plate->id;
        $plateType->country_id = 2;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 4;
        $plate->name        = "Misiones de Rengo Chardonnay";
        $plate->description = "";
        $plate->price       = 20;
        $plate->service     = 0;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 7;
        $plateType->save();

        $plateType = new RestaurantMenuPlateCountry();
        $plateType->plate_id   = $plate->id;
        $plateType->country_id = 3;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 4;
        $plate->name        = "Casal Mendes Blanco";
        $plate->description = "";
        $plate->price       = 14;
        $plate->service     = 0;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 7;
        $plateType->save();

        $plateType = new RestaurantMenuPlateCountry();
        $plateType->plate_id   = $plate->id;
        $plateType->country_id = 6;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 4;
        $plate->name        = "Astica Merlot";
        $plate->description = "";
        $plate->price       = 20;
        $plate->service     = 0;
        $plate->save();

        $plateType = new RestaurantMenuPlateType();
        $plateType->plate_id = $plate->id;
        $plateType->type_id  = 8;
        $plateType->save();

        $plateType = new RestaurantMenuPlateCountry();
        $plateType->plate_id   = $plate->id;
        $plateType->country_id = 2;
        $plateType->save();

        $plate = new RestaurantMenuPlate();
        $plate->menu_id     = 5;
        $plate->name        = "Maria Codorniu";
        $plate->description = "";
        $plate->price       = 30;
        $plate->service     = 0;
        $plate->save();

        $plateType = new RestaurantMenuPlateCountry();
        $plateType->plate_id   = $plate->id;
        $plateType->country_id = 1;
        $plateType->save();
    }
}
