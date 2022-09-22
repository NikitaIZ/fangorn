<?php

namespace App\Models\Audit\Restaurants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenuPlate extends Model
{
    use HasFactory;

    protected $table = "restaurants_menus_plates";

    protected $fillable = ['menu_id', 'name_es', 'description_es', 'name_en', 'description_en', 'name_ru', 'description_ru', 'price', 'service', 'choice_id', 'country_id', 'status'];

}
