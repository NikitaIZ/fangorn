<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewRoles extends Model
{
    use HasFactory;

    protected $table = "roles_view";

    public static function check($row1, $dato1, $row2, $dato2){
        if (DB::table('roles_view')->where($row1, $dato1)->where($row2, $dato2)->exists()) {
            return true;
        }else{
            return false;
        }
    }
}
