<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dolar extends Model
{
    use HasFactory;

    protected $table = "dolars";

    protected $fillable = ['user_id', 'daily_rate', 'date'];
}
