<?php

namespace App\Models\Marketing\Hotels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    use HasFactory;

    protected $table = "marketing_hotels_types";

    protected $fillable = ['name', 'description', 'user_id'];
}
