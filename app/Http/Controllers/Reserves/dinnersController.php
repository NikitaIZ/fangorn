<?php

namespace App\Http\Controllers\Reserves;

use App\Http\Controllers\Controller;

class dinnersController extends Controller
{
    private function connection(){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $json = json_decode(file_get_contents("http://10.80.22.172:8085/wp-json/wyndham/v1/ReservaFiestas/Reporte", true, stream_context_create($arrContextOptions)), true);
        $data = json_decode($json, true);
        return $data;
    }

    private function orden($array = array()){
        $groups = array(
            "A" => 0,
            "B" => 0,
            "C" => 0,
            "D" => 0,
            "E" => 0
        );

        $prices = array(
            "180" => 0,
            "80"  => 0,
            "250" => 0,
            "200" => 0,
            "100" => 0,
            "150" => 0,
            "75"  => 0,
            "130" => 0,
            "65"  => 0,
            "50"  => 0,
            "60"  => 2,
            "40"  => 0
        );

        $i = 0; $childrem = 0; $adults = 0; $total = 0;

        foreach ($array as $value){
            if ($value["status"] == "wc-completed") {
                $total     = $total     + $value["total"];
                $childrem  = $childrem  + $value["niños"];
                $adults    = $adults    + $value["adultos"];

                $nadul[$i] = $value["adultos"];
                $nchil[$i] = $value["niños"];
                $sales[$i] = $value["total"];
                $dates[$i] = date("d/m/y", strtotime($value["fecha"]));

                $i++;

                switch ($value["grupo"]) {
                    case 'A':
                        $groups["A"] = $groups["A"] + $value["cantidad"];
                        break;
                    case 'B':
                        $groups["B"] = $groups["B"] + $value["cantidad"];
                        break;
                    case 'C':
                        $groups["C"] = $groups["C"] + $value["cantidad"];
                        break;
                    case 'D':
                        $groups["D"] = $groups["D"] + $value["cantidad"];
                        break;
                    case 'E':
                        $groups["E"] = $groups["E"] + $value["cantidad"];
                        break;
                }

                switch ($value["precio"]) {
                    case '250':
                        $prices["250"] = $prices["250"] + $value["adultos"];
                        $prices["100"] = $prices["100"] + $value["niños"];
                        break;
                    case '200':
                        $prices["200"] = $prices["200"] + $value["adultos"];
                        $prices["100"] = $prices["100"] + $value["niños"];
                        break;
                    case '150':
                        $prices["150"] = $prices["150"] + $value["adultos"];
                        $prices["75"]  = $prices["75"]  + $value["niños"];
                        break;
                    case '180':
                        $prices["180"] = $prices["180"] + $value["adultos"];
                        $prices["80"]  = $prices["80"]  + $value["niños"];
                        break;
                    case '130':
                        $prices["130"] = $prices["130"] + $value["adultos"];
                        $prices["65"]  = $prices["65"]  + $value["niños"];
                        break;
                    case '100':
                        $prices["100"] = $prices["100"] + $value["adultos"];
                        $prices["50"]  = $prices["50"]  + $value["niños"];
                        break;
                    case '60':
                        $prices["60"] = $prices["60"] + $value["adultos"];
                        $prices["40"]  = $prices["40"]  + $value["niños"];
                        break;
                }
            }
        }

        $data = array(
            "sales" => array(
                "data"     => $sales,
                "labels"   => $dates,
                "adults"   => $nadul,
                "childrem" => $nchil
            ),
            "groups"   => $groups,
            "prices"   => $prices,
            "total"    => $total,
            "adults"   => $adults,
            "childrem" => $childrem,
            "quantity" => $i
        );

        return $data;
    }

    private function balancePoint($array = array(), $CF = 0, $i=0){
        $point = array(
            "initial" => $CF,
            "current" => -$CF
        );

        $date = array_unique($array["sales"]["labels"]);

        foreach ($date as $value) {
            $point["date"][$i] = $value;
            $point["data"][$i] = 0;
            $i++;
        }

        foreach ($point["date"] as $key1 => $value1) {
            foreach ($array["sales"]["labels"] as $key2 => $value2) {
                if ($value2 == $value1) {
                    $point["data"][$key1] += $array["sales"]["data"][$key2];
                }
            }
        }

        foreach ($point["data"] as $key => $value) {
            $point["meta"][$key] = $point["current"] + $value;
            $point["perc"][$key] = $point["meta"][$key] / $point["initial"] * 100;

            $point["current"] = $point["current"] + $value;
        }
        return $point;
    }


    function index($sales = array()){

        $data = $this->connection();

        $sales["christmas"] = $this->orden($data["Cena Navideña"]);
        $sales["christmas"]["adults"] = $sales["christmas"]["adults"];

        $sales["NewYear"] = $this->orden($data["Cena de Año Nuevo"]);

        $total = array(
            0 => $sales["christmas"]["total"] + $sales["NewYear"]["total"],
            1 => $sales["christmas"]["total"] ,
            2 => $sales["NewYear"]["total"]
        );

        $point["christmas"] = $this->balancePoint($sales["christmas"], 13137.15);
        $point["NewYear"] = $this->balancePoint($sales["NewYear"], 50340.87);

        return view('reserves.index', compact('data', 'total', 'sales', 'point'));
    }

    private function total($array = array(), $status="", $total = 0, $amount = 0, $childrem = 0, $adults = 0){
        foreach ($array as $value){
            if ($value["status"] == $status) {
                $total     = $total     + $value["total"];
                $childrem  = $childrem  + $value["niños"];
                $adults    = $adults    + $value["adultos"];
                $amount++;
            }
        }
        $data = array($total, $amount, $adults, $childrem);
        return $data;
    }

    function christmas(){
        $data = $this->connection();
        $data = $data["Cena Navideña"];
        $total["completed"] = $this->total($data, "wc-completed");
        $total["hold"]      = $this->total($data, "wc-on-hold");

        return view('reserves.christmas', compact('data', 'total'));
    }

    function newYear(){
        $data = $this->connection();
        $data = $data["Cena de Año Nuevo"];
        $total["completed"] = $this->total($data, "wc-completed");
        $total["hold"]      = $this->total($data, "wc-on-hold");

        return view('reserves.new-year', compact('data', 'total'));
    }
}
