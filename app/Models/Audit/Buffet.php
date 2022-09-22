<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buffet extends Model
{
    use HasFactory;

    protected $table = "buffets";

    protected $fillable = ['service', 'adults', 'children'];
}
