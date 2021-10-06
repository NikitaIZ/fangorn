<?php

namespace App\Http\Controllers;

use App\Models\Buffet;
use App\Models\Dolar;
use App\Models\Xml\XmlData;
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

    private function orderDate($date, $option){
        switch ($option) {
            case 0:
                $chara = str_split($date);
                $newDate = $chara[0] . $chara[1] . "/" . 
                        $chara[2] . $chara[3] . "/" . 
                        $chara[4] . $chara[5] ;
                break;
            case 1: 
                $chara = explode("/", $date);
                $order = $chara[1] . "/" . 
                        $chara[0] . "/" . 
                        $chara[2];
                $newDate= date("d/m/y",strtotime($order."+ 1 days"));
                break;
            case 2: 
                $chara = explode("/", $date);
                $order = $chara[0] . "-" . 
                        $chara[1] . "-20" . 
                        $chara[2];
                $newDate= date("l",strtotime($order."+ 1 days"));
                switch ($newDate) {
                    case 'Monday':
                        $newDate = 'Lunes';
                        break;
                    case 'Tuesday':
                        $newDate = 'Martes';
                        break;
                    case 'Wednesday':
                        $newDate = 'Miercoles';
                        break;
                    case 'Thursday':
                        $newDate = 'Jueves';
                        break;
                    case 'Friday':
                        $newDate = 'Viernes';
                        break;
                    case 'Saturday':
                        $newDate = 'Sabado';
                        break;
                    case 'Sunday':
                        $newDate = 'Domingo';
                        break;
                }
                break;
            default:
                break;
        }
        return $newDate;
    }

    public function index($i = 6, $dataYear = array(), $dataWeek = array()){
        $dateToday     = date("d/m/y",strtotime("- 1 days"));
        $dateYesterday = date("d/m/y",strtotime("- 2 days"));
        
        $reportToday     = XmlReport::where('date', $dateToday)->value('id');
        $reportYesterday = XmlReport::where('date', $dateYesterday)->value('id');

        $dolar = Dolar::where('report_id', $reportToday)->value('daily_rate');

        if ($dolar == null){
            $dolar = Dolar::orderByDesc('date')->value('daily_rate');
        }

        $buffet = Buffet::select('*')->get();

        $week = XmlReport::latest()->take(7)->get();
        
        while ($i >= 0) {
            $dolarRate = Dolar::where('report_id', $week[$i]->id)->value('daily_rate');
            $dataWeek['date'][$i]   = $this->orderDate($week[$i]->date, 2);

            if ($dolarRate != null){
                $dataWeek['ADR'][$i]    = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 122)->value('day') / $dolarRate;
                $dataWeek['RevPAR'][$i] = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 123)->value('day') / $dolarRate;
            }else{
                $dataWeek['ADR'][$i]    = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 122)->value('day') / $dolar;
                $dataWeek['RevPAR'][$i] = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 123)->value('day') / $dolar;
            }

            $dataWeek['Hab'][$i]        = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 2) ->value('day');
            $dataWeek['Pax'][$i]        = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 16)->value('day');
            $dataWeek['DEP'][$i]        = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 95)->value('day');
            $dataWeek['ARR'][$i]        = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 93)->value('day');
            $dataWeek['Per'][$i]        = XmlData::where('report_id', $week[$i]->id)->where('heading_id', 36)->value('day');

            $i--; 
        }

        $dateYear = date("d/m",strtotime("- 1 days"));
        $xmlYear  = XmlReport::select('*')->where('date', 'LIKE', '%' . $dateYear . '%')->orderByDesc('date')->get();
        $date     = date('d/m/Y');

        foreach ($xmlYear as $key => $value) {
            $dataYear['id'][$key]         = $value['id'];
            $dataYear['date'][$key]       = $this->orderDate($value['date'], 1);
            $dolarRate = Dolar::where('report_id', $value['id'])->value('daily_rate');

            if ($dolarRate != null){
                $dataYear['ADR'][$key]    = XmlData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolarRate;
                $dataYear['RevPAR'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolarRate;
            }else{
                $dataYear['ADR'][$key]    = XmlData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolar;
                $dataYear['RevPAR'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolar;
            }

            $dataYear['Hab'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 2)  ->value('day');
            $dataYear['Pax'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 16) ->value('day');
            $dataYear['DEP'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 95) ->value('day');
            $dataYear['ARR'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 93) ->value('day');
            $dataYear['Per']['Dia'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('day');
            $dataYear['Per']['Mes'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('month');
            $dataYear['Per']['Año'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('year');
        }

        $percentage = array(
                            'ayer' => XmlData::where('report_id', $reportYesterday)->where('heading_id', 36)->value('day'),
                            'dia'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('day'),
                            'mes'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('month'),
                            'año'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('year')
                            );

        if ($percentage['dia']>= 50){
            $colors = array(
                            0 => "small-box bg-warning",
                            1 => "small-box bg-danger"
                            );
        }else{
            $colors = array(
                            0 => "small-box bg-warning-off",
                            1 => "small-box bg-danger-off"
                            );
        }

        return view('dashboard', compact('dataYear','dataWeek', 'dolar', 'date', 'buffet', 'percentage', 'colors'));
    }

    public function store($i = 0, $j = 1, $dataYear = array(), $dataWeek = array(), Request $request){
        $dateToday     = date("d/m/y",strtotime($request->date."- 1 days"));
        $dateYesterday = date("d/m/y",strtotime($request->date."- 2 days"));

        $reportToday     = XmlReport::where('date', $dateToday)->value('id');
        $reportYesterday = XmlReport::where('date', $dateYesterday)->value('id');

        $dolar = Dolar::where('report_id', $reportToday)->value('daily_rate');

        if ($dolar == null){
            $dolar = Dolar::orderByDesc('date')->value('daily_rate');
        }

        $buffet = Buffet::select('*')->get();

        while ($i <= 6) {
            $dolarDate = date("d/m/y",strtotime($request->date."- ". $j. "days"));
            $id        = XmlReport::where('date', $dolarDate)->value('id');
            $dolarRate = Dolar::where('report_id', $id)->value('daily_rate');
            $dataWeek['date'][$i]   = $this->orderDate($dolarDate, 2);

            if ($dolarRate != null){
                $dataWeek['ADR'][$i]    = XmlData::where('report_id', $id)->where('heading_id', 122)->value('day') / $dolarRate;
                $dataWeek['RevPAR'][$i] = XmlData::where('report_id', $id)->where('heading_id', 123)->value('day') / $dolarRate;
            }else{
                $dataWeek['ADR'][$i]    = XmlData::where('report_id', $id)->where('heading_id', 122)->value('day') / $dolar;
                $dataWeek['RevPAR'][$i] = XmlData::where('report_id', $id)->where('heading_id', 123)->value('day') / $dolar;
            }

            $dataWeek['Hab'][$i]        = XmlData::where('report_id', $id)->where('heading_id', 2) ->value('day');
            $dataWeek['Pax'][$i]        = XmlData::where('report_id', $id)->where('heading_id', 16)->value('day');
            $dataWeek['DEP'][$i]        = XmlData::where('report_id', $id)->where('heading_id', 95)->value('day');
            $dataWeek['ARR'][$i]        = XmlData::where('report_id', $id)->where('heading_id', 93)->value('day');
            $dataWeek['Per'][$i] = XmlData::where('report_id', $id)->where('heading_id', 36)->value('day');

            $j++;
            $i++; 
        }

        $date = date("d/m/y",strtotime($request->date));

        $newDate  = date("d/m", strtotime($request->date ."- 1 days"));
        $xmlYear = XmlReport::select('*')->where('date', 'LIKE', '%' . $newDate . '%')->orderByDesc('date')->get();

        foreach ($xmlYear as $key => $value) {
            $dataYear['id'][$key]         = $value['id'];
            $dataYear['date'][$key]       = $this->orderDate($value['date'], 1);
            $dolarRate = Dolar::where('report_id', $value['id'])->value('daily_rate');

            if ($dolarRate != null){
                $dataYear['ADR'][$key]    = XmlData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolarRate;
                $dataYear['RevPAR'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolarRate;
            }else{
                $dataYear['ADR'][$key]    = XmlData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolar;
                $dataYear['RevPAR'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolar;
            }

            $dataYear['Hab'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 2)  ->value('day');
            $dataYear['Pax'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 16) ->value('day');
            $dataYear['DEP'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 95) ->value('day');
            $dataYear['ARR'][$key]        = XmlData::where('report_id', $value['id'])->where('heading_id', 93) ->value('day');
            $dataYear['Per']['Dia'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('day');
            $dataYear['Per']['Mes'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('month');
            $dataYear['Per']['Año'][$key] = XmlData::where('report_id', $value['id'])->where('heading_id', 36) ->value('year');
        }

        $percentage = array(
                            'ayer' => XmlData::where('report_id', $reportYesterday)->where('heading_id', 36)->value('day'),
                            'dia'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('day'),
                            'mes'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('month'),
                            'año'  => XmlData::where('report_id', $reportToday)    ->where('heading_id', 36)->value('year')
                            );

        if ($percentage['dia']>= 50){
            $colors = array(
                            0 => "small-box bg-warning",
                            1 => "small-box bg-danger"
                            );
        }else{
            $colors = array(
                            0 => "small-box bg-warning-off",
                            1 => "small-box bg-danger-off"
                            );
        }

        return view('dashboard', compact('dataYear','dataWeek', 'dolar', 'date', 'buffet', 'percentage', 'colors'));
    }
}
