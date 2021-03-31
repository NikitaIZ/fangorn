<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewXmlReport extends Model
{
    use HasFactory;

    protected $table = "xml_reports_view";

    public static function data($row, $dato, $data = array()){
        $data = DB::table('xml_reports_view')->where($row, $dato)->get();
        return $data;
    }

    public static function check($row, $dato){
        if (DB::table('xml_reports_view')->where($row, $dato)->exists()) {
            return true;
        }else{
            return false;
        }
    }

    public static function doubleCheck($row1, $row2, $dato1, $dato2){
        if (DB::table('xml_reports_view')->where($row1, $dato1)->where($row2, $dato2)->exists()) {
            return true;
        }else{
            return false;
        }
    }
}
