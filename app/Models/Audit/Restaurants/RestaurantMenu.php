<?php

namespace App\Models\Audit\Restaurants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    use HasFactory;

    protected $table = "restaurants_menus";

    protected $fillable = ['restaurant_id', 'type', 'name_es', 'name_en','name_ru', 'description', 'service', 'choice', 'country'];

}
