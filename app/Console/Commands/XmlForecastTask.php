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
use App\Models\Views\ViewXmlForecastReport;

class XmlForecastTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:task';

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


    private function orderXml($urlForecast, $urlForecastTS, $name, $all_data = array()){

        $date = $this->orderDateFiles($name); //2022-06-14

        $xml   = simplexml_load_file($urlForecast);
        $json  = json_encode($xml);
        $array = json_decode($json, TRUE);

        $xmlTS   = simplexml_load_file($urlForecastTS);
        $jsonTS  = json_encode($xmlTS);
        $arrayTS = json_decode($jsonTS, TRUE);

        if (array_key_exists('0', $array["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"])){
            if (array_key_exists(1, $array["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"])) {
                $forecast = $array["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"][1]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];
            }else{
                $forecast = $array["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];
            }
            if (array_key_exists(1, $arrayTS["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"])) {
                $forecastTS = $arrayTS["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"][1]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];
            } else {
                $forecastTS = $arrayTS["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];
            }

            //$forecast   = $array["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"][1]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];
            //$forecastTS = $arrayTS["LIST_G_GPAGEID"]["G_GPAGEID"]["LIST_G_REC_TYPE"]["G_REC_TYPE"][1]["LIST_G_CONSIDERED_DATE"]["G_CONSIDERED_DATE"];

            foreach ($forecast as $key => $value) {
                $all_data[$key]["date"]  = $this->formatDate($value["CONSIDERED_DATE"]);
                $all_data[$key]["dolar"] = $this->dolarOrden($all_data[$key]["date"]);

                $report = XmlHistoryReport::where('folder', $date)->value('id');
                $totalR = XmlHistoryData::where('report_id', $report)->where('heading_id', 1)->value('day');
                $rooms  = $value["NO_ROOMS"] - $value["COMPLIMENTARY_ROOMS"] - $value["HOUSE_USE_ROOMS"] - $forecastTS[$key]["NO_ROOMS"] + $forecastTS[$key]["HOUSE_USE_ROOMS"];
                $perc   = $value["NO_ROOMS"] / ($totalR - $value["CF_OOO_ROOMS"]) * 100;

                if ($value["REVENUE"] == 0){
                    $ADR    = 0;
                    $RevPAR = 0;
                }else{
                    $ADR    = $value["REVENUE"] / $rooms;
                    $RevPAR = $ADR * $perc / 100;
                }

                $all_data[$key]["data"][0]["heading"]  = 1;
                $all_data[$key]["data"][1]["heading"]  = 2;
                $all_data[$key]["data"][2]["heading"]  = 6;
                $all_data[$key]["data"][3]["heading"]  = 7;
                $all_data[$key]["data"][4]["heading"]  = 11;
                $all_data[$key]["data"][5]["heading"]  = 12;
                $all_data[$key]["data"][6]["heading"]  = 16;
                $all_data[$key]["data"][7]["heading"]  = 35;
                $all_data[$key]["data"][8]["heading"]  = 37;
                $all_data[$key]["data"][9]["heading"]  = 45;
                $all_data[$key]["data"][10]["heading"] = 57;
                $all_data[$key]["data"][11]["heading"] = 71;
                $all_data[$key]["data"][12]["heading"] = 77;
                $all_data[$key]["data"][13]["heading"] = 122;
                $all_data[$key]["data"][14]["heading"] = 123;

                $all_data[$key]["data"][0]["dato"] = $totalR;
                $all_data[$key]["data"][1]["dato"] = $value["NO_ROOMS"];
                $all_data[$key]["data"][2]["dato"] = $value["COMPLIMENTARY_ROOMS"];
                $all_data[$key]["data"][3]["dato"] = $value["HOUSE_USE_ROOMS"];
                $all_data[$key]["data"][4]["dato"] = $value["DAY_USE_ROOMS"];
                $all_data[$key]["data"][5]["dato"] = $value["CF_OOO_ROOMS"];
                $all_data[$key]["data"][6]["dato"] = $value["NO_PERSONS"];
                $all_data[$key]["data"][7]["dato"] = $value["CF_OCCUPANCY"];
                $all_data[$key]["data"][8]["dato"] = $value["ARRIVAL_ROOMS"];
                $all_data[$key]["data"][9]["dato"] = $value["DEPARTURE_ROOMS"];
                if ($value["NO_SHOW_ROOMS"] != null){
                    $all_data[$key]["data"][10]["dato"] = $value["NO_SHOW_ROOMS"];
                }else{
                    $all_data[$key]["data"][10]["dato"] = 0;
                }
                $all_data[$key]["data"][11]["dato"] = $value["CF_AVERAGE_ROOM_RATE"];
                $all_data[$key]["data"][12]["dato"] = $value["REVENUE"];
                $all_data[$key]["data"][13]["dato"] = $ADR;
                $all_data[$key]["data"][14]["dato"] = $RevPAR;
            }
        }
        $this->updateXmlHistoryReport($date, $all_data);
    }

    private function validation($folder){
        $date = $this->orderDateFiles($folder);
        $validation = XmlForecastReport::where('folder', $date)->value('id');
        if ($validation == null){
            return true;
        }else{
            return false;
        }
    }

    public function handle()
    {
        $date = date("dmy",strtotime(date("d-m-Y")."- 1 days"));
        $validation  = $this->validation($date);
        $fileFores = "M:\\". $date ."\history_forecast.xml";
        $fileForesTS = "M:\\". $date ."\history_forecast_ts.xml";
        if (
            file_exists($fileFores) == true AND file_exists($fileForesTS) == true AND $validation == true
        ) {
            $this->orderXml($fileFores, $fileForesTS, $date);
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
