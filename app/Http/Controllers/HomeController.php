<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;

use Goutte\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Audit\Dolar;
use App\Models\Audit\Buffet;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;
use App\Models\Audit\Xml\XmlForecastData;
use App\Models\Audit\Xml\XmlForecastDate;
use App\Models\Audit\Xml\XmlForecastReport;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dashboard')->only('index', 'store');
    }

    private function dolarCentral($date)
    {
        $check = Dolar::where('date', $date)->value('id');
        if ($check == null){
            $client = new Client();
            $url   = 'https://www.bcv.org.ve/';
            $page  = $client->request('GET', $url);
            $texto = $page->filter(selector:'#dolar')->text();
            $valor = substr($texto, 4);
            $dolar = str_replace(",", ".", $valor);
            $dolar = round($dolar, 2);
            $XmlHistoryReport = new Dolar();
            $XmlHistoryReport->user_id    = Auth::user()->currentTeam->user_id;
            $XmlHistoryReport->daily_rate = $dolar;
            $XmlHistoryReport->date       = $date;
            $XmlHistoryReport->save();
            $this->updateDataJson($dolar);
        }
    }

    private function updateDataJson($dayli)
    {
        $data['dolar'] = $dayli;
        $dataJson = json_encode($data, true);
        file_put_contents(config('app.ftp.local') . "\datos.json", $dataJson);

        $ftp_server = config('app.ftp.server');
        $ftp_user_name = config('app.ftp.name');
        $ftp_user_pass = config('app.ftp.pass');
        $file = config('app.ftp.local') . "\datos.json";
        $remote_file = config('app.ftp.remote') . "datos.json";

        $conn_id = ftp_connect($ftp_server);
        if($conn_id){
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            ftp_put($conn_id, $remote_file, $file, FTP_ASCII);
            ftp_close($conn_id);
        }
    }

    private function allData($date, $allData = array(), $validate = false)
    {
        $allData["yesterday"] = $this->get_yesterday_data($date);
        $allData["today"]     = $this->get_today_data($date);
        $allData["week"]      = $this->get_week_data($date);
        $allData["month"][0]  = $this->get_month_data($date);
        $allData["month"][1]  = $this->get_month_data($date, 1);
        $allData["month"][2]  = $this->get_month_data($date, 2);
        $allData["year"]      = $this->get_year_data($date);
        $allData["types"]     = $this->get_types_data($date, $date);
        $allData["buffet"]    = Buffet::get();
        if ($allData["today"]["PDS"] >= 50){
            $allData["box"]["color"][0] = "small-box bg-warning";
            $allData["box"]["color"][1] = "small-box bg-danger";
        }else{
            $allData["box"]["color"][0] = "small-box bg-warning-off";
            $allData["box"]["color"][1] = "small-box bg-danger-off";
        }
        return $allData;
    }

    private function dolar($var)
    {
        $dolar  = Dolar::where('date', $var)->value('daily_rate');
        if ($dolar == null){
            $dolar = Dolar::orderByDesc('date')->value('daily_rate');
        }
        return $dolar;
    }

    private function get_color_type($name)
    {
        switch ($name) {
            case "CNT": return "color:white; background-color: rgba(206, 32, 41"; break;
            case "CMP": return "color:white; background-color: rgba(255, 104, 29"; break;
            case "HSU": return "color:black; background-color: rgba(255, 221, 38"; break;
            case "COM": return "color:white; background-color: rgba(0, 163, 254"; break;
            case "PKG": return "color:white; background-color: rgba(0, 35, 111"; break;
            case "SLB": return "color:white; background-color: rgba(45, 1, 109"; break;
            case "WHD": return "color:white; background-color: rgba(13, 109, 1"; break;
            case "WHI": return "color:black; background-color: rgba(146, 229, 75"; break;
            case "MEG": return "color:white; background-color: rgba(75, 229, 112"; break;
            case "NAT": return "color:white; background-color: rgba(40, 229, 129"; break;
            case "LOC": return "color:white; background-color: rgba(7, 155, 123"; break;
            case "GOV": return "color:white; background-color: rgba(10, 196, 215"; break;
            case "BPR": return "color:white; background-color: rgba(8, 138, 222"; break;
            case "INT": return "color:white; background-color: rgba(7, 113, 232"; break;
            case "IOP": return "color:white; background-color: rgba(13, 70, 192"; break;
            case "DIS": return "color:white; background-color: rgba(29, 32, 231"; break;
            case "WHPI": return "color:white; background-color: rgba(128, 88, 242"; break;
            case "WHPN": return "color:white; background-color: rgba(77, 40, 181"; break;
            case "WHC": return "color:white; background-color: rgba(132, 56, 229"; break;
            case "GCP": return "color:white; background-color: rgba(114, 24, 229"; break;
            case "GCM": return "color:white; background-color: rgba(172, 48, 243"; break;
            case "GDP": return "color:white; background-color: rgba(207, 13, 255"; break;
            case "GEP": return "color:white; background-color: rgba(245, 79, 240"; break;
            case "GTR": return "color:white; background-color: rgba(234, 24, 227"; break;
            case "GTT": return "color:white; background-color: rgba(185, 26, 132"; break;
            case "GAS": return "color:white; background-color: rgba(249, 15, 171"; break;
            case "GMP": return "color:white; background-color: rgba(200, 3, 93"; break;
            case "GSF": return "color:white; background-color: rgba(217, 5, 75"; break;
            case "WEDD": return "color:white; background-color: rgba(0, 0, 0"; break;
            case "GGV": return "color:white; background-color: rgba(179, 218, 3"; break;
            case "ATP": return "color:white; background-color: rgba(227, 220, 7"; break;
        }
    }

    private function get_color_type_line($name)
    {
        switch ($name) {
            case "CNT": return "rgba(206, 32, 41, 0.5)"; break;
            case "CMP": return "rgba(255, 104, 29, 0.5)"; break;
            case "HSU": return "rgba(255, 221, 38, 0.5)"; break;
            case "COM": return "rgba(0, 163, 254, 0.5)"; break;
            case "PKG": return "rgba(0, 35, 111, 0.5)"; break;
            case "SLB": return "rgba(45, 1, 109, 0.5)"; break;
            case "WHD": return "rgba(13, 109, 1, 0.5)"; break;
            case "WHI": return "rgba(146, 229, 75, 0.5)"; break;
            case "MEG": return "rgba(75, 229, 112, 0.5)"; break;
            case "NAT": return "rgba(40, 229, 129, 0.5)"; break;
            case "LOC": return "rgba(7, 155, 123, 0.5)"; break;
            case "GOV": return "rgba(10, 196, 215, 0.5)"; break;
            case "BPR": return "rgba(8, 138, 222, 0.5)"; break;
            case "INT": return "rgba(7, 113, 232, 0.5)"; break;
            case "IOP": return "rgba(13, 70, 192, 0.5)"; break;
            case "DIS": return "rgba(29, 32, 231, 0.5)"; break;
            case "WHPI": return "rgba(128, 88, 242, 0.5)"; break;
            case "WHPN": return "rgba(77, 40, 181, 0.5)"; break;
            case "WHC": return "rgba(132, 56, 229, 0.5)"; break;
            case "GCP": return "rgba(114, 24, 229, 0.5)"; break;
            case "GCM": return "rgba(172, 48, 243, 0.5)"; break;
            case "GDP": return "rgba(207, 13, 255, 0.5)"; break;
            case "GEP": return "rgba(245, 79, 240, 0.5)"; break;
            case "GTR": return "rgba(234, 24, 227, 0.5)"; break;
            case "GTT": return "rgba(185, 26, 132, 0.5)"; break;
            case "GAS": return "rgba(249, 15, 171, 0.5)"; break;
            case "GMP": return "rgba(200, 3, 93, 0.5)"; break;
            case "GSF": return "rgba(217, 5, 75, 0.5)"; break;
            case "WEDD": return "rgba(0, 0, 0, 0.5)"; break;
            case "GGV": return "rgba(179, 218, 3, 0.5)"; break;
            case "ATP": return "rgba(227, 220, 7, 0.5)"; break;
        }
    }

    private function get_name_day($date)
    {
        switch (date('w', $date)){
            case 0: return "Domingo"; break;
            case 1: return "Lunes"; break;
            case 2: return "Martes"; break;
            case 3: return "Miercoles"; break;
            case 4: return "Jueves"; break;
            case 5: return "Viernes"; break;
            case 6: return "Sabado"; break;
        }
    }

    private function get_name_month($date)
    {
        switch ($date){
            case 1:  return "Ene"; break;
            case 2:  return "Feb"; break;
            case 3:  return "Mar"; break;
            case 4:  return "Abr"; break;
            case 5:  return "May"; break;
            case 6:  return "Jun"; break;
            case 7:  return "Jul"; break;
            case 8:  return "Ago"; break;
            case 9:  return "Sep"; break;
            case 10: return "Oct"; break;
            case 11: return "Nov"; break;
            case 12: return "Dic"; break;
        }
    }

    private function get_description_name($name)
    {
        switch ($name) {
            case "COM": return "Commercial"; break;
            case "MEG": return "Mega Agency"; break;
            case "NAT": return "Corp Pref-National"; break;
            case "LOC": return "Corp Pref-Local"; break;
            case "GOV": return "Government"; break;
            case "PKG": return "Package"; break;
            case "BPR": return "Brand Promotions"; break;
            case "INT": return "Internet Mktg"; break;
            case "IOP": return "Opaque Internet"; break;
            case "DIS": return "Qualified Discounts"; break;
            case "WHD": return "Travel Agent"; break;
            case "WHI": return "Wholesale International"; break;
            case "WHC": return "Wholesale-Cruise"; break;
            case "GCP": return "Group-Corporate"; break;
            case "GCM": return "Group-CMP"; break;
            case "GDP": return "European Plan"; break;
            case "GEP": return "Group EP"; break;
            case "GTR": return "Group-Training"; break;
            case "GTT": return "Group Tour & Travel"; break;
            case "GAS": return "Group-Association"; break;
            case "GMP": return "Group MMP"; break;
            case "GSF": return "Group-SMERF"; break;
            case "GGV": return "Group-Government"; break;
            case "CNT": return "Time Share"; break;
            case "ATP": return "Contract Airline Crew"; break;
            case "HSU": return "House Use"; break;
            case "SLB": return "SuperLiga"; break;
            case "CMP": return "Complimentary"; break;
            case "WHPI": return "Wholesale Property International"; break;
            case "WHPN": return "Wholesale Property National"; break;
            case "WEDD": return "Weeding"; break;
        }
    }

    private function get_types_data($date_start, $date)
    {
        $ROOMS_OOO = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                    ->where('xml_history_reports.date', $date_start)
                                    ->where('heading_id', 3)
                                    ->value('day');

        $dats = XmlHistoryReport::select('date')
                                ->where('date', '>=', $date_start)
                                ->where('date', '<=', $date)
                                ->get()->toArray();

        $hdgg = XmlHistoryData::select('xml_headings.name as HDG')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->groupBy('xml_headings.id')
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $torr = XmlHistoryData::select('xml_headings.name as HDG', 'day as HAB', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $toar = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAA', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ADULTS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $tocr = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAC', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_CHILDREN%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        foreach ($hdgg as $key => $value) {
            $pieces = explode("_", $value['HDG']);
            $types[$key]['head'] = $value['HDG'];
            $types[$key]['name'] = $pieces[0];
            $types[$key]["descrip"] = $this->get_description_name($pieces[0]);
        }

        foreach ($types as $order => $type) {
            foreach ($dats as $key => $date) {
                foreach ($torr as $value) {
                    if ($type['head'] == $value['HDG'] && $date['date'] == $value['date']) {
                        $types[$order]['rooms'][$key] = $value['HAB'];
                        $types[$order]['adults'][$key] = null;
                        $types[$order]['childrem'][$key] = null;
                    }
                }
                foreach ($toar as $value) {
                    $pieces = explode("_", $value['HDG']);
                    if ($type['name'] == $pieces[0] && $date['date'] == $value['date']) {
                        $types[$order]['adults'][$key] = $value['PAA'];
                    }
                }
                foreach ($tocr as $value) {
                    $pieces = explode("_", $value['HDG']);
                    if ($type['name'] == $pieces[0] && $date['date'] == $value['date']) {
                        $types[$order]['childrem'][$key] = $value['PAC'];
                    }
                }
            }
        }

        foreach ($types as $order => $type) {
            $types[$order]['color'] = $this->get_color_type($type['name']);
            $types[$order]['lines'] = $this->get_color_type_line($type['name']);
            foreach ($dats as $key => $date) {
                if (array_key_exists($key, $type['rooms']) == false) {
                    $types[$order]['rooms'][$key] = null;
                    $types[$order]['adults'][$key] = null;
                    $types[$order]['childrem'][$key] = null;
                    $types[$order]['people'][$key] = null;
                    $types[$order]['rat'][$key] = null;
                    $types[$order]['per'][$key] = null;
                }else{
                    if ($type['adults'][$key] != null) {
                        $types[$order]['people'][$key] = $type['adults'][$key] + $type['childrem'][$key];
                        $types[$order]['rat'][$key]    = strval(round($types[$order]['people'][$key] / $type['rooms'][$key], 2));
                        $types[$order]["per"][$key]    = $type['rooms'][$key] / $ROOMS_OOO * 100;
                    }else{
                        $types[$order]['people'][$key] = null;
                        $types[$order]['rat'][$key] = null;
                        $types[$order]['per'][$key] = null;
                    }
                }
            }
            ksort($types[$order]['rooms']);
            ksort($types[$order]['adults']);
            ksort($types[$order]['childrem']);
            ksort($types[$order]['people']);
            ksort($types[$order]['rat']);
            ksort($types[$order]['per']);
        }

        return $types;
    }

    private function get_types_data_history($date_start, $date)
    {
        $ROOMS_OOO = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                    ->where('xml_history_reports.date', $date_start)
                                    ->where('heading_id', 3)
                                    ->value('day');

        $dats = XmlHistoryReport::select('date')
                                ->where('date', '>=', $date_start)
                                ->where('date', '<=', $date)
                                ->get()->toArray();

        $hdgg = XmlHistoryData::select('xml_headings.name as HDG')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->groupBy('xml_headings.id')
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $torr = XmlHistoryData::select('xml_headings.name as HDG', 'day as HAB' , 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $toar = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAA', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ADULTS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $tocr = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAC', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_CHILDREN%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        foreach ($hdgg as $key => $value) {
            $pieces = explode("_", $value['HDG']);
            $types[$key]['head'] = $value['HDG'];
            $types[$key]['name'] = $pieces[0];
            $types[$key]["descrip"] = $this->get_description_name($pieces[0]);
        }

        foreach ($types as $order => $type) {
            foreach ($dats as $key => $date) {
                foreach ($torr as $value) {
                    if ($type['head'] == $value['HDG'] && $date['date'] == $value['date']) {
                        $types[$order]['rooms'][$key] = $value['HAB'];
                        $types[$order]['adults'][$key] = null;
                        $types[$order]['childrem'][$key] = null;
                    }
                }
                foreach ($toar as $value) {
                    $pieces = explode("_", $value['HDG']);
                    if ($type['name'] == $pieces[0] && $date['date'] == $value['date']) {
                        $types[$order]['adults'][$key] = $value['PAA'];
                    }
                }
                foreach ($tocr as $value) {
                    $pieces = explode("_", $value['HDG']);
                    if ($type['name'] == $pieces[0] && $date['date'] == $value['date']) {
                        $types[$order]['childrem'][$key] = $value['PAC'];
                    }
                }
            }
        }

        foreach ($types as $order => $type) {
            $types[$order]['color'] = $this->get_color_type($type['name']);
            $types[$order]['lines'] = $this->get_color_type_line($type['name']);
            foreach ($dats as $key => $date) {
                if (array_key_exists($key, $type['rooms']) == false) {
                    $types[$order]['rooms'][$key] = null;
                    $types[$order]['adults'][$key] = null;
                    $types[$order]['childrem'][$key] = null;
                    $types[$order]['people'][$key] = null;
                    $types[$order]['rat'][$key] = null;
                    $types[$order]['per'][$key] = null;
                }else{
                    if ($type['adults'][$key] != null) {
                        $types[$order]['people'][$key] = $type['adults'][$key] + $type['childrem'][$key];
                        $types[$order]['rat'][$key]    = strval(round($types[$order]['people'][$key] / $type['rooms'][$key], 2));
                        $types[$order]["per"][$key]    = $type['rooms'][$key] / $ROOMS_OOO * 100;
                    }else{
                        $types[$order]['people'][$key] = null;
                        $types[$order]['rat'][$key] = null;
                        $types[$order]['per'][$key] = null;
                    }
                }
            }
            ksort($types[$order]['rooms']);
            ksort($types[$order]['adults']);
            ksort($types[$order]['childrem']);
            ksort($types[$order]['people']);
            ksort($types[$order]['rat']);
            ksort($types[$order]['per']);
        }

        return $types;
    }

    private function get_types_data_forecast($date_start, $date)
    {
        $id    = XmlForecastReport::orderBy('date', 'desc')->value('id');

        $dats = XmlForecastDate::select('date')
                                ->where('report_id', $id)
                                ->where('date', '>=', $date_start)
                                ->where('date', '<=', $date)
                                ->get()->toArray();

        $ROOMS_OOO = XmlForecastData::join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                    ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                    ->where('heading_id', 3)
                                    ->where('xml_forecast_dates.report_id', $id)
                                    ->where('xml_forecast_dates.date', '>=', $date_start)
                                    ->where('xml_forecast_dates.date', '<=', $date)
                                    ->orderBy('xml_headings.id')
                                    ->value('dato');

        $hdgg = XmlForecastData::select('xml_headings.name as HDG')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_forecast_dates.date', '>=', $date_start)
                                ->where('xml_forecast_dates.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->groupBy('xml_headings.id')
                                ->get()->toArray();

        $torr = XmlForecastData::select('xml_headings.name as HDG', 'dato as HAB' , 'xml_forecast_dates.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_forecast_dates.date', '>=', $date_start)
                                ->where('xml_forecast_dates.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        $toar = XmlForecastData::select('dato as PAA')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_headings.name', 'like', '%_ADULTS%')
                                ->where('xml_forecast_dates.date', '>=', $date_start)
                                ->where('xml_forecast_dates.date', '<=', $date)
                                ->orderBy('xml_headings.id')
                                ->get()->toArray();

        foreach ($hdgg as $key => $value) {
            $pieces = explode("_", $value['HDG']);
            $types[$key]['head'] = $value['HDG'];
            $types[$key]['name'] = $pieces[0];
            $types[$key]["descrip"] = $this->get_description_name($pieces[0]);
        }

        foreach ($types as $order => $type) {
            foreach ($dats as $key => $date) {
                foreach ($torr as $raw => $value) {
                    if ($type['head'] == $value['HDG'] && $date['date'] == $value['date']) {
                        $types[$order]['rooms'][$key]    = $value['HAB'];
                        $types[$order]['people'][$key]   = $toar[$raw]['PAA'];
                        $types[$order]['rat'][$key]      = strval(round($types[$order]['people'][$key] / $value['HAB'], 2));
                        $types[$order]["per"][$key]      = $value['HAB'] / $ROOMS_OOO * 100;
                    }
                }
            }
        }

        foreach ($types as $order => $type) {
            $types[$order]['color'] = $this->get_color_type($type['name']);
            $types[$order]['lines'] = $this->get_color_type_line($type['name']);
            foreach ($dats as $key => $date) {
                if (array_key_exists($key, $type['rooms']) == false) {
                    $types[$order]['rooms'][$key] = null;
                    $types[$order]['people'][$key] = null;
                    $types[$order]['rat'][$key] = null;
                    $types[$order]['per'][$key] = null;
                }
            }
            ksort($types[$order]['rooms']);
            ksort($types[$order]['people']);
            ksort($types[$order]['rat']);
            ksort($types[$order]['per']);
        }
        return $types;
    }

    private function get_yesterday_data($date)
    {
        $report      = XmlHistoryReport::where('date', date("Y-m-d", strtotime($date . " - 1 days")))->value('id');
        $data["PDS"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 36)->value('day');
        return $data;
    }

    private function get_today_data($date)
    {
        $report = XmlHistoryReport::where('date', $date)->value('id');

        $data["TDD"] = $this->dolar($date);
        $data["IDR"] = XmlHistoryReport::where('date', $date)->value('id');
        $data["HAB"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 2)  ->value('day');
        $data["PAX"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 16) ->value('day');
        $data["PDS"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 36) ->value('day');
        $data["PMS"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 36) ->value('month');
        $data["PYS"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 36) ->value('year');
        $data["ARR"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 93) ->value('day');
        $data["DEP"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 95) ->value('day');
        $data["HAR"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 119)->value('day');
        $data["PDR"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 121)->value('day');
        $data["ADB"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 122)->value('day');
        $data["RVB"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 123)->value('day');
        $data["ADR"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 122)->value('day') / $this->dolar($date);
        $data["RVP"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 123)->value('day') / $this->dolar($date);

        return $data;
    }

    private function get_week_data($date)
    {
        $date_start = date("Y-m-d", strtotime($date . " - 6 days"));

        $drta = Dolar::select('daily_rate as DOLAR')
                        ->where('date', '>=', date("Y-m-d", strtotime(date($date_start))))
                        ->where('date', '<=', $date)
                        ->orderBy('date', 'asc')
                        ->get()->toArray();

        $dats = XmlHistoryReport::select('date')
                                ->where('date', '>=', $date_start)
                                ->where('date', '<=', $date)
                                ->get()->toArray();

        $habh = XmlHistoryData::select('day as HAB')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 3)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $nrsh = XmlHistoryData::select('day as NRS')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 2)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $arrh = XmlHistoryData::select('day as ARR')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 37)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $deph = XmlHistoryData::select('day as DEP')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 45)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $paxa = XmlHistoryData::select('day as PAA')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 14)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $paxc = XmlHistoryData::select('day as PAC')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 15)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $ocuc = XmlHistoryData::select('day as OCC')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 36)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        foreach ($habh as $key => $value) {
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['PAA'] = $paxa[$key]['PAA'];
            $ALL[$key]['PAC'] = $paxc[$key]['PAC'];
            $ALL[$key]['PAX'] = $paxa[$key]['PAA'] + $paxc[$key]['PAC'];
            $ALL[$key]['OCC'] = $ocuc[$key]['OCC'];
            $ALL[$key]['ARR'] = $arrh[$key]['ARR'];
            $ALL[$key]['DEP'] = $deph[$key]['DEP'];
            $ALL[$key]['dates'] = $this->get_name_day(strtotime(date($dats[$key]['date'])));
        }

        $week['HAB'] = array_column($ALL, 'HAB');
        $week['PAX'] = array_column($ALL, 'PAX');
        $week['PAA'] = array_column($ALL, 'PAA');
        $week['PAC'] = array_column($ALL, 'PAC');
        $week['OCC'] = array_column($ALL, 'OCC');
        $week['ARR'] = array_column($ALL, 'ARR');
        $week['DEP'] = array_column($ALL, 'DEP');
        $week['TOR'] = $this->get_types_data($date_start, $date);
        $week['dates'] = array_column($ALL, 'dates');

        return $week;
    }

    private function get_month_data($date_today, $i = 0)
    {
        $date_real  = date("Y-m-d",  strtotime(date($date_today) . "- 1 days")); //31-08-22
        $date_valid = date("Y-m-15",  strtotime(date($date_real))); //31-08-22
        $date_start = date("Y-m-02", strtotime(date($date_valid) . "+" . $i . "month"));//02-09-22
        $date_end   = date("Y-m-01", strtotime(date($date_valid) . "+". $i+1 ."month"));//01-10-22

        $id_history = XmlHistoryReport::where('date', $date_end)->value('id');

        if ($id_history) {

            $history = $this->get_history($date_start, $date_end);

            $all['name'] = $this->get_name_month(date("m", strtotime($date_start)));

            $all['NRS'] = array_column($history, 'HAB');
            $all['NPS'] = array_column($history, 'NPS');
            $all['OCC'] = array_column($history, 'OCC');
            $all['OCP'] = array_column($history, 'OCP');
            $all['ARR'] = array_column($history, 'ARR');
            $all['DEP'] = array_column($history, 'DEP');
            $all['BARR'] = array_column($history, 'BARR');
            $all['LARR'] = array_column($history, 'LARR');
            $all['BDEP'] = array_column($history, 'BDEP');
            $all['LDEP'] = array_column($history, 'LDEP');
            $all['BOCC'] = array_column($history, 'BOCC');
            $all['LOCC'] = array_column($history, 'LOCC');
            $all['dates'] = array_column($history, 'dates');

            $all['history']['DYS'] = count(array_column($history, 'HAB'));
            $all['history']['NRS'] = array_sum(array_column($history, 'HAB'));
            $all['history']['NPS'] = array_sum(array_column($history, 'NPS'));
            $all['history']['OCC'] = array_sum(array_column($history, 'OCC')) / $all['history']['DYS'];
            $all['history']['ARR'] = array_sum(array_column($history, 'ARR'));
            $all['history']['DEP'] = array_sum(array_column($history, 'DEP'));

            $torh = $this->get_types_data_history($date_start, $date_end);

            foreach ($torh as $key => $value) {
                $all['TOR'][$key]['name']    = $value['name'];
                $all['TOR'][$key]['descrip'] = $value['descrip'];
                $all['TOR'][$key]['color']   = $value['color'];
                $all['TOR'][$key]['lines']   = $value['lines'];
                $all['TOR'][$key]['rooms']   = $value['rooms'];
                $all['TOR'][$key]['people']  = $value['people'];
                $all['TOR'][$key]['rat']     = $value['rat'];
                $all['TOR'][$key]['per']     = $value['per'];

                $all['history']['TOR'][$key]['color']  = $value['color'];
                $all['history']['TOR'][$key]['lines']  = $value['lines'];
                $all['history']['TOR'][$key]['rooms']  = array_sum($torh[$key]['rooms']);
                $all['history']['TOR'][$key]['people'] = array_sum($torh[$key]['people']);
                $all['history']['TOR'][$key]['rat']    = array_sum($torh[$key]['rat']);
                $all['history']['TOR'][$key]['per']    = array_sum($torh[$key]['per']) / $all['history']['DYS'];
            }

            $all['forecast']['DYS'] = 0;

            $all['limit'] = count(array_column($history, 'OCC'));
        }else{
            $date_starf = date("Y-m-01", strtotime($date_start));
            $date_end_f = date("Y-m-t",  strtotime($date_start));

            $id_history = XmlHistoryReport::where('date', $date_start)->value('id');

            if ($id_history) {
                $history = $this->get_history($date_start, $date_end);

                $forecast = $this->get_forecast($date_today, $date_end_f);

                $result = array_merge($history, $forecast);

                $all['name'] = $this->get_name_month(date("m", strtotime($date_start)));

                $all['NRS'] = array_column($result, 'HAB');
                $all['NPS'] = array_column($result, 'NPS');
                $all['OCC'] = array_column($result, 'OCC');
                $all['ARR'] = array_column($result, 'ARR');
                $all['DEP'] = array_column($result, 'DEP');
                $all['BARR'] = array_column($result, 'BARR');
                $all['LARR'] = array_column($result, 'LARR');
                $all['BDEP'] = array_column($result, 'BDEP');
                $all['LDEP'] = array_column($result, 'LDEP');
                $all['BOCC'] = array_column($result, 'BOCC');
                $all['LOCC'] = array_column($result, 'LOCC');
                $all['dates'] = array_column($result, 'dates');

                $all['history']['DYS'] = count(array_column($history, 'HAB'));
                $all['history']['NRS'] = array_sum(array_column($history, 'HAB'));
                $all['history']['NPS'] = array_sum(array_column($history, 'NPS'));
                $all['history']['OCC'] = array_sum(array_column($history, 'OCC')) / $all['history']['DYS'];
                $all['history']['ARR'] = array_sum(array_column($history, 'ARR'));
                $all['history']['DEP'] = array_sum(array_column($history, 'DEP'));

                $all['forecast']['DYS'] = count(array_column($forecast, 'HAB'));
                $all['forecast']['NRS'] = array_sum(array_column($forecast, 'HAB'));
                $all['forecast']['NPS'] = array_sum(array_column($forecast, 'NPS'));
                $all['forecast']['OCC'] = array_sum(array_column($forecast, 'OCC')) / $all['forecast']['DYS'];
                $all['forecast']['ARR'] = array_sum(array_column($forecast, 'ARR'));
                $all['forecast']['DEP'] = array_sum(array_column($forecast, 'DEP'));

                $all['total']['DYS'] = $all['history']['DYS'] + $all['forecast']['DYS'];
                $all['total']['NRS'] = $all['history']['NRS'] + $all['forecast']['NRS'];
                $all['total']['NPS'] = $all['history']['NPS'] + $all['forecast']['NPS'];
                $all['total']['OCC'] = ($all['history']['OCC'] + $all['forecast']['OCC']) / 2;
                $all['total']['ARR'] = $all['history']['ARR'] + $all['forecast']['ARR'];
                $all['total']['DEP'] = $all['history']['DEP'] + $all['forecast']['DEP'];

                $torh = $this->get_types_data_history($date_start, $date_end);
                $torf = $this->get_types_data_forecast($date_starf, $date_end_f);

                foreach ($torf as $key => $value) {
                    if (array_key_exists($key, $torh) == false) {
                        $torh[$key]['name']    = $value['name'];
                        $torh[$key]['descrip'] = $value['descrip'];
                        $torh[$key]['color']   = $value['color'];
                        $torh[$key]['lines']   = $value['lines'];
                        foreach ($torh[0]['rooms'] as $key2 => $value2) {
                            $torh[$key]['rooms'][$key2]   = null;
                            $torh[$key]['people'][$key2]  = null;
                            $torh[$key]['rat'][$key2]     = null;
                            $torh[$key]['per'][$key2]     = null;
                        }
                    }
                }

                foreach ($torh as $key => $value) {
                    if (array_key_exists($key, $torf) == false) {
                        $torf[$key]['name']    = $value['name'];
                        $torf[$key]['descrip'] = $value['descrip'];
                        $torf[$key]['color']   = $value['color'];
                        $torh[$key]['lines']   = $value['lines'];
                        foreach ($torf[0]['rooms'] as $key2 => $value2) {
                            $torf[$key]['rooms'][$key2]   = null;
                            $torf[$key]['people'][$key2]  = null;
                            $torf[$key]['rat'][$key2]     = null;
                            $torf[$key]['per'][$key2]     = null;
                        }
                    }
                }

                foreach ($torh as $key => $value) {
                    $all['TOR'][$key]['name']    = $value['name'];
                    $all['TOR'][$key]['descrip'] = $value['descrip'];
                    $all['TOR'][$key]['color']   = $value['color'];
                    $all['TOR'][$key]['lines']   = $value['lines'];
                    $all['TOR'][$key]['rooms']   = array_merge($value['rooms'], $torf[$key]['rooms']);
                    $all['TOR'][$key]['people']  = array_merge($value['people'], $torf[$key]['people']);
                    $all['TOR'][$key]['rat']     = array_merge($value['rat'], $torf[$key]['rat']);
                    $all['TOR'][$key]['per']     = array_merge($value['per'], $torf[$key]['per']);

                    $all['history']['TOR'][$key]['color']  = $value['color'];
                    $all['history']['TOR'][$key]['lines']  = $value['lines'];
                    $all['history']['TOR'][$key]['rooms']  = array_sum($torh[$key]['rooms']);
                    $all['history']['TOR'][$key]['people'] = array_sum($torh[$key]['people']);
                    $all['history']['TOR'][$key]['rat']    = array_sum($torh[$key]['rat']);
                    $all['history']['TOR'][$key]['per']    = array_sum($torh[$key]['per']) / $all['history']['DYS'];

                    $all['forecast']['TOR'][$key]['color']  = $value['color'];
                    $all['forecast']['TOR'][$key]['lines']  = $value['lines'];
                    $all['forecast']['TOR'][$key]['rooms']  = array_sum($torf[$key]['rooms']);
                    $all['forecast']['TOR'][$key]['people'] = array_sum($torf[$key]['people']);
                    $all['forecast']['TOR'][$key]['rat']    = array_sum($torf[$key]['rat']);
                    $all['forecast']['TOR'][$key]['per']    = array_sum($torf[$key]['per']) / $all['forecast']['DYS'];

                    $all['total']['TOR'][$key]['color']  = $value['color'];
                    $all['total']['TOR'][$key]['lines']  = $value['lines'];
                    $all['total']['TOR'][$key]['rooms']  = $all['history']['TOR'][$key]['rooms']  + $all['forecast']['TOR'][$key]['rooms'];
                    $all['total']['TOR'][$key]['people'] = $all['history']['TOR'][$key]['people'] + $all['forecast']['TOR'][$key]['people'];
                    $all['total']['TOR'][$key]['rat']    = $all['history']['TOR'][$key]['rat']    + $all['forecast']['TOR'][$key]['rat'];
                    $all['total']['TOR'][$key]['per']    = ($all['history']['TOR'][$key]['per']   + $all['forecast']['TOR'][$key]['per']) / 2;
                }

                $all['limit'] = count(array_column($history, 'OCC'));
            }else{
                $forecast    = $this->get_forecast($date_starf, $date_end_f);

                $all['name'] = $this->get_name_month(date("m", strtotime($date_starf)));

                $all['NRS'] = array_column($forecast, 'HAB');
                $all['NPS'] = array_column($forecast, 'NPS');
                $all['OCC'] = array_column($forecast, 'OCC');
                $all['ARR'] = array_column($forecast, 'ARR');
                $all['DEP'] = array_column($forecast, 'DEP');
                $all['BARR'] = array_column($forecast, 'BARR');
                $all['LARR'] = array_column($forecast, 'LARR');
                $all['BDEP'] = array_column($forecast, 'BDEP');
                $all['LDEP'] = array_column($forecast, 'LDEP');
                $all['BOCC'] = array_column($forecast, 'BOCC');
                $all['LOCC'] = array_column($forecast, 'LOCC');
                $all['dates'] = array_column($forecast, 'dates');

                $all['forecast']['DYS'] = count(array_column($forecast, 'HAB'));
                $all['forecast']['NRS'] = array_sum(array_column($forecast, 'HAB'));
                $all['forecast']['NPS'] = array_sum(array_column($forecast, 'NPS'));
                $all['forecast']['OCC'] = array_sum(array_column($forecast, 'OCC')) / $all['forecast']['DYS'];
                $all['forecast']['ARR'] = array_sum(array_column($forecast, 'ARR'));
                $all['forecast']['DEP'] = array_sum(array_column($forecast, 'DEP'));

                $torf = $this->get_types_data_forecast($date_starf, $date_end_f);

                foreach ($torf as $key => $value) {
                    $all['TOR'][$key]['name']    = $value['name'];
                    $all['TOR'][$key]['descrip'] = $value['descrip'];
                    $all['TOR'][$key]['color']   = $value['color'];
                    $all['TOR'][$key]['lines']   = $value['lines'];
                    $all['TOR'][$key]['rooms']   = $value['rooms'];
                    $all['TOR'][$key]['people']  = $value['people'];
                    $all['TOR'][$key]['rat']     = $value['rat'];
                    $all['TOR'][$key]['per']     = $value['per'];

                    $all['forecast']['TOR'][$key]['color']  = $value['color'];
                    $all['forecast']['TOR'][$key]['lines']  = $value['lines'];
                    $all['forecast']['TOR'][$key]['rooms']  = array_sum($torf[$key]['rooms']);
                    $all['forecast']['TOR'][$key]['people'] = array_sum($torf[$key]['people']);
                    $all['forecast']['TOR'][$key]['rat']    = array_sum($torf[$key]['rat']);
                    $all['forecast']['TOR'][$key]['per']    = array_sum($torf[$key]['per']) / $all['forecast']['DYS'];
                }

                $all['limit'] = count(array_column($forecast, 'OCC'));

                $all['history']['DYS'] = 0;
            }
        }
        return $all;
    }

    private function get_history($date_start, $date_today)
    {
        $dats = XmlHistoryReport::select('date')
                                ->where('date', '>=', $date_start)
                                ->where('date', '<=', $date_today)
                                ->get()->toArray();

        $habh = XmlHistoryData::select('day as HAB')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 3)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $nrsh = XmlHistoryData::select('day as NRS')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 2)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $paxh = XmlHistoryData::select('day as NPS')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 16)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $occh = XmlHistoryData::select('day as OCC')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 36)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $arrh = XmlHistoryData::select('day as ARR')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 37)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $deph = XmlHistoryData::select('day as DEP')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 45)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        foreach ($habh as $key => $value) {
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['NPS'] = $paxh[$key]['NPS'];
            $ALL[$key]['OCC'] = $occh[$key]['OCC'];
            $ALL[$key]['ARR'] = $arrh[$key]['ARR'];
            $ALL[$key]['DEP'] = $deph[$key]['DEP'];

            $ALL[$key]["BARR"] = 'rgba(27, 188, 155, 0.5)';
            $ALL[$key]["LARR"] = 'rgba(27, 188, 155, 1)';
            $ALL[$key]["BDEP"] = 'rgba(45, 62, 80, 0.5)';
            $ALL[$key]["LDEP"] = 'rgba(45, 62, 80, 1)';
            $ALL[$key]["BOCC"] = 'rgba(0, 123, 255, 0.5)';
            $ALL[$key]["LOCC"] = 'rgba(0, 123, 255, 1)';

            $ALL[$key]['dates'] = date("d-M-y", strtotime(date($dats[$key]['date']) . "- 1 days"));
        }

        return $ALL;
    }

    private function get_forecast($date_today, $date_end_f)
    {
        $id   = XmlForecastReport::orderBy('date', 'desc')->value('id');

        $dats = XmlForecastDate::select('date')
                                ->where('report_id', $id)
                                ->where('date', '>=', $date_today)
                                ->where('date', '<=', $date_end_f)
                                ->get()->toArray();

        $habh = XmlForecastData::select('dato as HAB')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 3)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $nrsh = XmlForecastData::select('dato as NRS')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 2)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $paxh = XmlForecastData::select('dato as NPS')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 16)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $occh = XmlForecastData::select('dato as OCC')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 36)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $arrh = XmlForecastData::select('dato as ARR')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 37)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $deph = XmlForecastData::select('dato as DEP')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 45)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        foreach ($habh as $key => $value) {
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['NPS'] = $paxh[$key]['NPS'];
            $ALL[$key]['OCC'] = $occh[$key]['OCC'];
            $ALL[$key]['ARR'] = $arrh[$key]['ARR'];
            $ALL[$key]['DEP'] = $deph[$key]['DEP'];

            $ALL[$key]["BARR"] = 'rgba(27, 188, 155, 0.4)';
            $ALL[$key]["LARR"] = 'rgba(27, 188, 155, 0.5)';
            $ALL[$key]["BDEP"] = 'rgba(45, 62, 80, 0.4)';
            $ALL[$key]["LDEP"] = 'rgba(45, 62, 80, 0.5)';
            $ALL[$key]["BOCC"] = 'rgba(0, 123, 255, 0.4)';
            $ALL[$key]["LOCC"] = 'rgba(0, 123, 255, 0.5)';

            $ALL[$key]['dates'] = date("d-M-y", strtotime(date($dats[$key]['date'])));
        }

        return $ALL;
    }

    private function get_year_data($date)
    {
        $date  = date("m-d", strtotime($date));
        $dates = XmlHistoryReport::where('date', 'LIKE', '%' . $date . '%')->orderBy('date', 'asc')->get();

        foreach ($dates as $key => $value) {
            $dolar = $this->dolar($value['date']);
            $data["date"][$key] = date("Y",strtotime($value['date'] . "+ 1 days"));
            $data["HAB"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 2)  ->value('day');
            $data["PAX"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 16) ->value('day');
            $data["DEP"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 95) ->value('day');
            $data["ARR"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 93) ->value('day');
            $data["PDS"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 36) ->value('day');
            $data["PMS"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 36) ->value('month');
            $data["PYS"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 36) ->value('year');
            $data["ADR"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolar;
            $data["RVP"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolar;
        }
        return $data;
    }

    public function index($validate = false)
    {
        $day = DateTime::createFromFormat('Y-m-d G:i:s', date('Y-m-d G:i:s'), new DateTimeZone('UTC'));
        $day->setTimeZone(new DateTimeZone('America/Caracas'));
        $today = $day->format('Y-m-d');
        while ($validate == false) {
            if (XmlHistoryReport::where('date', $today)->doesntExist()) {
                $today = date("Y-m-d", strtotime($today . " - 1 days"));
            }else{
                $validate = true;
            }
        }
        $this->dolarCentral($today);
        $data   = $this->allData($today);
        $number = date("d/m/Y", strtotime($today));
        $start  = XmlHistoryReport::orderBy('date', 'DESC')->value('date');
        $end    = XmlHistoryReport::orderBy('date', 'ASC') ->value('date');
        $date   = date("dmy",strtotime($today."- 1 days"));

        return view('dashboard', compact('number', 'start', 'end','date','data'));
    }

    public function store(Request $request)
    {
        $date = $request->date;
        $data = $this->allData($date);
        $number = date("d/m/Y", strtotime($date));
        $start = XmlHistoryReport::orderBy('date', 'DESC')->value('date');
        $end   = XmlHistoryReport::orderBy('date', 'ASC') ->value('date');
        return view('dashboard', compact('number', 'start', 'end','date','data'));
    }
}
