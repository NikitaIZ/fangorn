<?php

namespace App\Models\Marketing\Hotels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = "marketing_hotels";

    protected $fillable = ['id', 'name', 'stars', 'color', 'type_id', 'user_id'];

}
