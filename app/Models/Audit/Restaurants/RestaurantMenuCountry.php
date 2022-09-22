<?php

namespace App\Models\Audit\Restaurants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenuCountry extends Model
{
    use HasFactory;

    protected $table = "restaurants_menus_countries";

    protected $fillable = ['name_es', 'name_en', 'name_ru'];

}
