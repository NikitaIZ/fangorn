<?php

namespace App\Http\Controllers;

use App\Models\Views\ViewXmlReport;
use App\Models\Xml\XmlReport;

use Illuminate\Http\Request;

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
        $date_past = strtotime('-1 day', strtotime(date('d-m-Y')));
        $date_past = date('d/m/y', $date_past);
        $data      = ViewXmlReport::data('Fecha', $date_past);
        if (empty($data[0]) == true){
            return redirect()->route('reports.create');
        }else{
            $date      = date('d/m/y');
            $dolar     = $this->dolarToday();
            return view('dashboard', compact('data', 'dolar', 'date'));
        }
    }

    function test(){

    }
}
