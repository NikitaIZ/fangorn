<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\Position as PositionModel;
use App\Models\Security\PersonalModel;


class PositionController extends Controller
{
    //



    public function index(){
        return view("security/position/index");
    }

}
