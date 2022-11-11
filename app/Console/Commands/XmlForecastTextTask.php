<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use DateTime;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;
use App\Models\Audit\Xml\XmlForecastData;
use App\Models\Audit\Xml\XmlForecastDate;
use App\Models\Audit\Xml\XmlForecastReport;

class XmlForecastTextTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecastext:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subir Pronostico a la base de datos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    private function orderDateFiles($name){
        $chara = str_split($name);
        $date = $chara[0] . $chara[1] . "/" . 
                $chara[2] . $chara[3] . "/" . 
                $chara[4] . $chara[5] ;
        return $date;
    }

    private function date($folder){
        $chara = explode("/", $folder);
            $order = $chara[0] . "-" . 
                    $chara[1] . "-20" . 
                    $chara[2];
            $date = date("Y-m-d",strtotime($order."+ 1 days"));
        return $date;
    }

    private function dirScan($disk, $option) {
        $ignored = array('.', '..', 'Thumbs.db', 'Historico', '150309', '140319', '160320', '140321', '060319', '070322');
        $directories = array();
        foreach (scandir($disk) as $directory) {
            if (in_array($directory, $ignored)) continue;
            if (XmlForecastReport::check('folder', $this->orderDateFiles($directory)) == false){
                $directories[$directory] = filectime($disk . '/' . $directory);
            }
        }
        if ($option == "first"){
            asort($directories);
        }elseif($option == "last"){
            arsort($directories);
        }
        $directories = array_keys($directories);
        return ($directories) ? $directories : false;
    }

    private function updateXmlHistoryReport($folder, $dates){
        $date = $this->date($folder);
        $XmlHistoryReport = new XmlForecastReport();
        $XmlHistoryReport->folder = $folder;
        $XmlHistoryReport->date   = $date;
        $XmlHistoryReport->save();

        foreach ($dates as $date){
            $XmlDate = new XmlForecastDate();
            $XmlDate->date      = $date["date"];
            $XmlDate->report_id = $XmlHistoryReport->id;
            $XmlDate->dolar_id  = $date["dolar"];
            $XmlDate->save();

            foreach ($date["data"] as $dato){
                $XmlHistoryData = new XmlForecastData();
                $XmlHistoryData->date_id    = $XmlDate->id;
                $XmlHistoryData->heading_id = $dato["heading"];
                $XmlHistoryData->dato       = $dato['dato'];
                $XmlHistoryData->save();
            }
        }
    }

    private function formatDate($date){
        $formatDate = DateTime::createFromFormat('d-M-y', $date);
        $newDate    = $formatDate->format('Y-m-d');
        return $newDate;
    }

    private function dolarOrden($date){
        $dolar = Dolar::where('date', $date)->value('id');
        if ($dolar == null){
            $dolar = Dolar::orderByDesc('date')->value('id');
        }
        return $dolar;
    }


    private function orderXml($urlForecast, $name, $on = false, $i = 0, $j = 2, $all_data = array()){

        $comp = 0; $hsu = 0; $cnt = 0; $people = 0;

        $month      = date("m", strtotime(date("d-m-Y")."+ 2 months"));
        $year       = date("Y", strtotime(date("d-m-Y")."+ 2 months"));
        $date_end   = date("d-m-y", (mktime(0,0,0,$month+1,1,$year)));
        $date_start = date("d-m-y");

        $date   = $this->orderDateFiles($name); //12/07/22
        $report = XmlHistoryReport::where('folder', $date)->value('id');
        $occup  = XmlHistoryData::where('report_id', $report)->where('heading_id', 2)->value('day');
        $revfb  = XmlHistoryData::where('report_id', $report)->where('heading_id', 2)->value('month');

        $file = file($urlForecast);

        foreach ($file as $value) {
            $pieces = explode("	", $value);

            if ($pieces[2] == $date_start){
                $on = true;
            }elseif ($pieces[2] == $date_end){
                $on = false;
            }

            if ($on == true) {
                if ($pieces[3] == "ATP") {
                    $all_data[$i]["date"]  = date("Y-m-d",strtotime($pieces[1]));
                    //$all_data[$i]["date"]  = date("Y-m-d",strtotime($pieces[1]));
                    $all_data[$i]["dolar"] = $this->dolarOrden($all_data[$i]["date"]);

                    $all_data[$i]["data"][0]["heading"] = 1;
                    $all_data[$i]["data"][1]["heading"] = 2;

                    $all_data[$i]["data"][0]["dato"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 1)->value('day');
                    $all_data[$i]["data"][1]["dato"] = $pieces[6];
                }

                switch ($pieces[3]) {
                    case 'CNT':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 124;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 125;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                        }
                        $cnt = $pieces[27];
                    break;

                    case 'CMP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 129;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 130;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                        }
                        $comp = $pieces[27];
                    break;

                    case 'HSU':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 134;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 135;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                        }
                        $hsu = $pieces[27];
                    break;

                    case 'COM':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 139;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 140;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'PKG':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 144;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 145;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'SLB':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 149;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 150;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WHD':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 154;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 155;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WHI':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 159;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 160;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'MEG':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 164;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 165;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'NAT':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 169;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 170;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'LOC':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 174;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 175;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GOV':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 179;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 180;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'BPR':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 184;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 185;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'INT':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 189;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 190;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'IOP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 194;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 195;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'DIS':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 199;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 200;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WHPI':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 204;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 205;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WHPN':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 209;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 210;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WHC':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 214;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 215;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GCP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 219;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 220;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GCM':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 224;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 225;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GDP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 229;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 230;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GEP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 234;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 235;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GTR':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 239;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 240;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GTT':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 244;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 245;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GAS':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 249;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 250;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GMP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 254;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 255;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GSF':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 259;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 260;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'WEDD':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 264;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 265;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'GGV':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 269;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 270;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;

                    case 'ATP':
                        if ($pieces[27] != 0) {
                            $all_data[$i]["data"][$j]["heading"] = 274;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[27];
                            $j++;
                            $all_data[$i]["data"][$j]["heading"] = 275;
                            $all_data[$i]["data"][$j]["dato"]    = $pieces[29];
                            $j++;
                            $people = $people + $pieces[29];
                        }
                    break;
                }

                if($pieces[3] == "WHPN"){
                    $rooms = $all_data[$i]["data"][1]["dato"] - $comp - $hsu - $cnt;
                    $perc  = $pieces[6] / ($all_data[$i]["data"][0]["dato"] - $pieces[33]) * 100;

                    $all_data[$i]["data"][$j]["heading"] = 3;
                    $all_data[$i]["data"][$j]["dato"]    = $all_data[$i]["data"][0]["dato"] - $pieces[33];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 12;
                    $all_data[$i]["data"][$j]["dato"]    = $pieces[33];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 14;
                    $all_data[$i]["data"][$j]["dato"]    = $people;
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 16;
                    $all_data[$i]["data"][$j]["dato"]    = $pieces[15];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 35;
                    $all_data[$i]["data"][$j]["dato"]    = $pieces[23];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 36;
                    $all_data[$i]["data"][$j]["dato"]    = $perc;
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 37;
                    $all_data[$i]["data"][$j]["dato"]    = $pieces[13];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 45;
                    $all_data[$i]["data"][$j]["dato"]    = $occup + $pieces[13] - $pieces[6];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 77;
                    $all_data[$i]["data"][$j]["dato"]    = $pieces[8];
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 119;
                    $all_data[$i]["data"][$j]["dato"]    = $rooms;
                    $j++;

                    $all_data[$i]["data"][$j]["heading"] = 121;
                    $all_data[$i]["data"][$j]["dato"]    = $rooms / ($all_data[$i]["data"][0]["dato"] - $pieces[33] - 42) * 100;
                    $j++;

                    if ($pieces[8] == 0){
                        $all_data[$i]["data"][$j]["heading"] = 122;
                        $all_data[$i]["data"][$j]["dato"] = 0;
                        $j++;

                        $all_data[$i]["data"][$j]["heading"] = 123;
                        $all_data[$i]["data"][$j]["dato"] = 0;
                    }else{
                        $adr = $pieces[8] / $rooms;

                        $all_data[$i]["data"][$j]["heading"] = 122;
                        $all_data[$i]["data"][$j]["dato"] = $adr;
                        $j++;

                        $all_data[$i]["data"][$j]["heading"] = 123;
                        $all_data[$i]["data"][$j]["dato"] = $adr * $perc / 100;
                    }

                    $i++; $j = 2; $people = 0; $occup = $pieces[6];
                }
            }
        }

        $this->updateXmlHistoryReport($date, $all_data);
    }

    private function validation1($folder){
        $date = $this->orderDateFiles($folder);
        $validation = XmlForecastReport::where('folder', $date)->value('id');
        if ($validation == null){
            return true;
        }else{
            return false;
        }
    }

    private function validation2($folder){
        $date = $this->orderDateFiles($folder);
        $validation = XmlHistoryReport::where('folder', $date)->value('id');
        if ($validation == null){
            return false;
        }else{
            return true;
        }
    }

    public function handle()
    {
        $date = date("dmy",strtotime(date("d-m-Y")."- 1 days"));
        $validation1 = $this->validation1($date);
        $validation2 = $this->validation2($date);
        $fileFores = 'M:\\'. $date .'\forecast.txt';
        if (file_exists($fileFores) == true AND $validation1 == true AND $validation2 == true) {
            $this->orderXml($fileFores, $date);
        }
        /*$directories = $this->dirScan('M:\\', 'first');
        if ($directories != false){
            foreach ($directories as $directory) {
                $validation  = $this->validation($directory);
                $fileFores = "M:\\". $directory ."\history_forecast.xml";
                $fileForesTS = "M:\\". $directory ."\history_forecast_ts.xml";
                if (
                    file_exists($fileFores) == true AND file_exists($fileForesTS) == true AND $validation == true
                ) {
                    $this->orderXml($fileFores, $fileForesTS, $directory);
                }
            }
        }*/
    }
}
