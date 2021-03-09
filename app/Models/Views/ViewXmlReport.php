<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewXmlReport extends Model
{
    use HasFactory;

    protected $table = "xmls_reports_view";

    public static function data($date){
        $data = array();
        $data = DB::table('xmls_reports_view')->where('Fecha', $date)->get();
        return $data;
    }
}
