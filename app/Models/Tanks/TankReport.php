<?php

namespace App\Models\Tanks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TankReport extends Model
{
    use HasFactory;

    protected $table = "tanks_reports";

    public static function average(){
        $average = DB::table('tanks_reports')
                        ->avg('liters');
        return $average;
    }
}
