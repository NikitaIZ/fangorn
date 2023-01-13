<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\AreaModel;


class AreaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:personal.area.show')->only('index');
    }
    public function index(){
        return view("security/area/index");
    }

}
