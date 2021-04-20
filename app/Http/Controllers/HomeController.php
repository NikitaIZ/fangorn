<?php

namespace App\Http\Controllers;

use App\Models\Buffet;
use App\Models\Views\ViewXmlReport;
use App\Models\Xml\XmlReport;

class HomeController extends Controller
{
    private function dolarToday(){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $json = file_get_contents("https://s3.amazonaws.com/dolartoday/data.json", false, stream_context_create($arrContextOptions));
        $data = json_decode(utf8_encode($json));
        return $data->USD;
    }

    function index(){
        /*$date_past = strtotime('-1 day', strtotime(date('d-m-Y')));
        $date_past = date('d/m/y', $date_past);*/
        $date   = date('d/m/y');
        $dolar  = $this->dolarToday();
        $buffet = Buffet::select('*')->get();
        $id     = XmlReport::all()->last()->id;
        $xml    = ViewXmlReport::select('*')->where('ID', $id)->get();
        return view('dashboard', compact('xml', 'dolar', 'date', 'buffet'));
    }
}
