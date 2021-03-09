<?php

namespace App\Http\Controllers;

use App\Models\Views\ViewXmlReport;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private function dolarToday(){
        $json = file_get_contents('https://s3.amazonaws.com/dolartoday/data.json');
        $data = json_decode($json);
        return $data->USD;
    }

    function index(){
        $data  = ViewXmlReport::data('020321');
        $date  = date('d/m/y');
        $dolar = $this->dolarToday();
        return view('dashboard', compact('data', 'dolar', 'date'));
    }
}
