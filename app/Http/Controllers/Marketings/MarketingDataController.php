<?php

namespace App\Http\Controllers\Marketings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingDataController extends Controller
{
    //



    public function index(){
        return view("marketing.data.index");
    }
}
