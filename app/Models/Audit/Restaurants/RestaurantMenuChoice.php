<?php

namespace App\Models\Audit\Restaurants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantMenuChoice extends Model
{
    use HasFactory;

    protected $table = "restaurants_menus_choices";

    protected $fillable = ['menu_id', 'name_es', 'name_en', 'name_ru'];
}
