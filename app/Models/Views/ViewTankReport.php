<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewTankReport extends Model
{
    use HasFactory;

    protected $table = "tanks_reports_view";

    public static function data(){
        $data = array();
        $data['average'] = DB::table('tanks_reports_view')->avg('Litros');
        $data['max']     = DB::table('tanks_reports_view')->max('Litros');
        $data['min']     = DB::table('tanks_reports_view')->min('Litros');
        return $data;
    }
}
