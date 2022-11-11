<?php

namespace App\Http\Controllers\Reserves;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;
use App\Models\Audit\Xml\XmlForecastData;
use App\Models\Audit\Xml\XmlForecastDate;
use App\Models\Audit\Xml\XmlForecastReport;
use Illuminate\Support\Facades\Artisan;

class RevenueManagerController extends Controller
{
    private function allData($date, $allData = array())
    {
        $allData["yesterday"] = $this->get_yesterday_data($date);
        $allData["today"]     = $this->get_today_data($date);
        //$allData["week"]      = $this->get_week_data($date);
        $allData["month"][0]  = $this->get_month_data($date, 0);
        $allData["month"][1]  = $this->get_month_data($date, 1);
        $allData["month"][2]  = $this->get_month_data($date, 2);
        $allData["year"]      = $this->get_year_data($date);
        $allData["types"]     = $this->get_types_data($date, $date);

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

    private function get_color($id)
    {
        switch ($id) {
            case 0: return "color:white; background-color: rgba(0, 123, 255 "; break;
            case 1: return "color:white; background-color: rgba(40, 167, 69 "; break;
            case 2: return "color:white; background-color: rgba(23, 162, 184 "; break;
            case 3: return "color:black; background-color: rgba(255, 193, 7 "; break;
            case 4: return "color:white; background-color: rgba(220, 53, 69 "; break;
            case 5: return "color:white; background-color: rgba(108, 117, 125 "; break;
            case 6: return "color:white; background-color: rgba(52, 58, 64 "; break;
            case 7: return "color:white; background-color: rgba(232, 5, 255 "; break;
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
                                ->get()->toArray();

        $torr = XmlHistoryData::select('xml_headings.name as HDG', 'day as HAB', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ROOMS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        $toar = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAA', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_ADULTS%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        $tocr = XmlHistoryData::select('xml_headings.name as HDG', 'day as PAC', 'xml_history_reports.date')
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 123)
                                ->where('xml_headings.name', 'like', '%_CHILDREN%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        foreach ($hdgg as $key => $value) {
            $pieces = explode("_", $value['HDG']);
            $types[$key]['head'] = $value['HDG'];
            $types[$key]['name'] = $pieces[0];
            $types[$key]["descrip"] = $this->get_description_name($types[$key]['name']);
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
            $types[$order]['color'] = $this->get_color($order);
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

    private function get_yesterday_data($date)
    {
        $report = XmlHistoryReport::where('date', date("Y-m-d", strtotime($date . " - 1 days")))->value('id');
        $hotel = XmlHistoryData::where('report_id', $report)->where('heading_id', 3)  ->value('day');
        $rooms = XmlHistoryData::where('report_id', $report)->where('heading_id', 119)->value('day');

        $data["PDS"] = $rooms / ($hotel - 42) * 100;
        return $data;
    }

    private function get_today_data($date)
    {
        $date_real  = date("Y-m-d",  strtotime(date($date) . "- 1 days"));
        $date_start = date("Y-m-02", strtotime(date($date_real)));
        $date_end   = date("Y-m-01", strtotime(date($date_real) . "+ 1 month"));

        $year_start = date("Y-01-02", strtotime($date_real));
        $year_end   = date("Y-01-01", strtotime(date($date_real) . "+ 1 year"));

        $report = XmlHistoryReport::where('date', $date) ->value('id');

        $hoteld = XmlHistoryData::where('report_id', $report)->where('heading_id', 3)->value('day');
        $hotelm = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $date_start)->where('xml_history_reports.date', '<=', $date_end)->sum('day');
        $hotely = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $year_start)->where('xml_history_reports.date', '<=', $year_end)->sum('day');

        $habsd = XmlHistoryData::where('report_id', $report)->where('heading_id', 119)->value('day');
        $habsm = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 119)->where('xml_history_reports.date', '>=', $date_start)->where('xml_history_reports.date', '<=', $date_end)->sum('day');
        $habsy = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 119)->where('xml_history_reports.date', '>=', $year_start)->where('xml_history_reports.date', '<=', $year_end)->sum('day');

        $timem = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $date_start)->where('xml_history_reports.date', '<=', $date_end)->count() * 42;
        $timey = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $year_start)->where('xml_history_reports.date', '<=', $year_end)->count() * 42;

        $paxa = XmlHistoryData::join('xml_headings', 'heading_id', '=', 'xml_headings.id')->where('report_id', $report)->where('heading_id', '>', 138)->where('xml_headings.name', 'like', '%_ADULTS_%')->sum('day');
        $paxc = XmlHistoryData::join('xml_headings', 'heading_id', '=', 'xml_headings.id')->where('report_id', $report)->where('heading_id', '>', 138)->where('xml_headings.name', 'like', '%_CHILDREN_%')->sum('day');

        $data["TDD"] = $this->dolar($date);
        $data["IDR"] = $report;
        $data["HAB"] = $habsd;
        $data["PAX"] = $paxa + $paxc;
        $data["PDS"] = $habsd / ($hoteld - 42) * 100;
        $data["PMS"] = $habsm / ($hotelm - $timem) * 100;
        $data["PYS"] = $habsy / ($hotely - $timey) * 100;
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
                                ->get()->toArray();

        $nrsh = XmlHistoryData::select('day as NRS')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 119)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        $adrh = XmlHistoryData::select('day as ADR')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 122)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        $rvph = XmlHistoryData::select('day as RVP')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 123)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->get()->toArray();

        $paxa = XmlHistoryData::select(XmlHistoryData::raw('SUM(day) as PAA'))
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 138)
                                ->where('xml_headings.name', 'like', '%_ADULTS_%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->groupBy('xml_history_reports.date')
                                ->get()->toArray();

        $paxc = XmlHistoryData::select(XmlHistoryData::raw('SUM(day) as PAC'))
                                ->join('xml_headings', 'heading_id', '=', 'xml_headings.id')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', '>', 138)
                                ->where('xml_headings.name', 'like', '%_CHILDREN_%')
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date)
                                ->groupBy('xml_history_reports.date')
                                ->get()->toArray();

        foreach ($habh as $key => $value) {
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['PAA'] = $paxa[$key]['PAA'];
            $ALL[$key]['PAC'] = $paxc[$key]['PAC'];
            $ALL[$key]['PAX'] = $paxa[$key]['PAA'] + $paxc[$key]['PAC'];
            $ALL[$key]['OCC'] = $nrsh[$key]['NRS'] / ($value['HAB'] - 42) * 100;
            $ALL[$key]['ADR'] = $adrh[$key]['ADR'] / $drta[$key]['DOLAR'];
            $ALL[$key]['RVP'] = $rvph[$key]['RVP'] / $drta[$key]['DOLAR'];
            $ALL[$key]['dates'] = $this->get_name_day(strtotime(date($dats[$key]['date'])));
        }

        $week['HAB'] = array_column($ALL, 'HAB');
        $week['PAX'] = array_column($ALL, 'PAX');
        $week['PAA'] = array_column($ALL, 'PAA');
        $week['PAC'] = array_column($ALL, 'PAC');
        $week['OCC'] = array_column($ALL, 'OCC');
        $week['ADR'] = array_column($ALL, 'ADR');
        $week['RVP'] = array_column($ALL, 'RVP');
        $week['TOR'] = $this->get_types_data($date_start, $date);
        $week['dates'] = array_column($ALL, 'dates');

        return $week;
    }

    private function get_month_data($date, $i = 0)
    {
        $date_real  = date("Y-m-d",  strtotime(date($date) . "- 1 days")); //31-08-22
        $date_valid = date("Y-m-15",  strtotime(date($date_real))); //31-08-22
        $date_start = date("Y-m-02", strtotime(date($date_valid) . "+" . $i . "month"));//02-09-22
        $date_end   = date("Y-m-01", strtotime(date($date_valid) . "+". $i+1 ."month"));//01-10-22

        $id_history = XmlHistoryReport::where('date', $date_end)->value('id');

        if ($id_history) {
            $history = $this->get_history($date_start, $date_end);

            $all['name'] = $this->get_name_month(date("m", strtotime($date_start)));

            $all['NRS'] = array_column($history, 'HAB');
            $all['OCC'] = array_column($history, 'OCC');
            $all['OCP'] = array_column($history, 'OCP');
            $all['RVN'] = array_column($history, 'RVN');
            $all['FVN'] = array_column($history, 'FVN');
            $all['OVN'] = array_column($history, 'OVN');
            $all['ADR'] = array_column($history, 'ADR');
            $all['RVP'] = array_column($history, 'RVP');
            $all['BOCC'] = array_column($history, 'BOCC');
            $all['LOCC'] = array_column($history, 'LOCC');
            $all['dates'] = array_column($history, 'dates');

            $all['history']['DYS'] = count(array_column($history, 'HAB'));
            $all['history']['NRS'] = array_sum(array_column($history, 'HAB'));
            $all['history']['OCC'] = array_sum(array_column($history, 'OCC')) / $all['history']['DYS'];
            $all['history']['RVN'] = array_sum(array_column($history, 'RVN'));
            $all['history']['FVN'] = array_sum(array_column($history, 'FVN'));
            $all['history']['OVN'] = array_sum(array_column($history, 'OVN'));
            $all['history']['ADR'] = array_sum(array_column($history, 'ADR')) / $all['history']['DYS'];
            $all['history']['RVP'] = array_sum(array_column($history, 'RVP')) / $all['history']['DYS'];

            $all['forecast']['DYS'] = 0;

            $all['limit'] = count(array_column($history, 'OCC'));
        }else{
            $date_today = date("Y-m-d");
            $date_starf = date("Y-m-01", strtotime($date_start));
            $date_end_f = date("Y-m-t",  strtotime($date_start));

            $id_history = XmlHistoryReport::where('date', $date_start)->value('id');

            if ($id_history) {
                $history = $this->get_history($date_start, $date_end); $avg = end($history);

                $forecast = $this->get_forecast($date_today, $date_end_f, $avg['AVG']);

                $result = array_merge($history, $forecast);

                $all['name'] = $this->get_name_month(date("m", strtotime($date_starf)));

                $all['NRS'] = array_column($result, 'HAB');
                $all['OCC'] = array_column($result, 'OCC');
                $all['OCP'] = array_column($result, 'OCP');
                $all['RVN'] = array_column($result, 'RVN');
                $all['FVN'] = array_column($result, 'FVN');
                $all['OVN'] = array_column($result, 'OVN');
                $all['ADR'] = array_column($result, 'ADR');
                $all['RVP'] = array_column($result, 'RVP');
                $all['BOCC'] = array_column($result, 'BOCC');
                $all['LOCC'] = array_column($result, 'LOCC');
                $all['dates'] = array_column($result, 'dates');

                $all['history']['DYS'] = count(array_column($history, 'HAB'));
                $all['history']['NRS'] = array_sum(array_column($history, 'HAB'));
                $all['history']['OCC'] = array_sum(array_column($history, 'OCC')) / $all['history']['DYS'];
                $all['history']['RVN'] = array_sum(array_column($history, 'RVN'));
                $all['history']['FVN'] = array_sum(array_column($history, 'FVN'));
                $all['history']['OVN'] = array_sum(array_column($history, 'OVN'));
                $all['history']['ADR'] = array_sum(array_column($history, 'ADR')) / $all['history']['DYS'];
                $all['history']['RVP'] = array_sum(array_column($history, 'RVP')) / $all['history']['DYS'];

                $all['forecast']['DYS'] = count(array_column($forecast, 'HAB'));
                $all['forecast']['NRS'] = array_sum(array_column($forecast, 'HAB'));
                $all['forecast']['OCC'] = array_sum(array_column($forecast, 'OCC')) / $all['forecast']['DYS'];
                $all['forecast']['RVN'] = array_sum(array_column($forecast, 'RVN'));
                $all['forecast']['FVN'] = array_sum(array_column($forecast, 'FVN'));
                $all['forecast']['OVN'] = array_sum(array_column($forecast, 'OVN'));
                $all['forecast']['ADR'] = array_sum(array_column($forecast, 'ADR')) / $all['forecast']['DYS'];
                $all['forecast']['RVP'] = array_sum(array_column($forecast, 'RVP')) / $all['forecast']['DYS'];

                $all['total']['DYS'] = $all['history']['DYS'] + $all['forecast']['DYS'];
                $all['total']['NRS'] = $all['history']['NRS'] + $all['forecast']['NRS'];
                $all['total']['OCC'] = $all['history']['OCC'] + $all['forecast']['OCC'];
                $all['total']['RVN'] = $all['history']['RVN'] + $all['forecast']['RVN'];
                $all['total']['FVN'] = $all['history']['FVN'] + $all['forecast']['FVN'];
                $all['total']['OVN'] = $all['history']['OVN'] + $all['forecast']['OVN'];
                $all['total']['ADR'] = $all['history']['ADR'] + $all['forecast']['ADR'];
                $all['total']['RVP'] = $all['history']['RVP'] + $all['forecast']['RVP'];

                if ($all['total']['DYS'] != $all['history']['DYS'] || $all['total']['DYS'] != $all['forecast']['DYS']) {
                    $all['total']['OCC'] = $all['total']['OCC'] / 2;
                    $all['total']['RVP'] = $all['total']['RVP'] / 2;
                    $all['total']['ADR'] = $all['total']['ADR'] / 2;
                }

                $all['limit'] = count(array_column($history, 'OCC'));
            }else{
                $forecast    = $this->get_forecast($date_starf, $date_end_f);

                $all['name'] = $this->get_name_month(date("m", strtotime($date_starf)));

                $all['NRS'] = array_column($forecast, 'HAB');
                $all['OCC'] = array_column($forecast, 'OCC');
                $all['OCP'] = array_column($forecast, 'OCP');
                $all['RVN'] = array_column($forecast, 'RVN');
                $all['FVN'] = array_column($forecast, 'FVN');
                $all['OVN'] = array_column($forecast, 'OVN');
                $all['ADR'] = array_column($forecast, 'ADR');
                $all['RVP'] = array_column($forecast, 'RVP');
                $all['BOCC'] = array_column($forecast, 'BOCC');
                $all['LOCC'] = array_column($forecast, 'LOCC');
                $all['dates'] = array_column($forecast, 'dates');

                $all['forecast']['DYS'] = count(array_column($forecast, 'HAB'));
                $all['forecast']['NRS'] = array_sum(array_column($forecast, 'HAB'));
                $all['forecast']['OCC'] = array_sum(array_column($forecast, 'OCC')) / $all['forecast']['DYS'];
                $all['forecast']['RVN'] = array_sum(array_column($forecast, 'RVN'));
                $all['forecast']['FVN'] = array_sum(array_column($forecast, 'FVN'));
                $all['forecast']['OVN'] = array_sum(array_column($forecast, 'OVN'));
                $all['forecast']['ADR'] = array_sum(array_column($forecast, 'ADR')) / $all['forecast']['DYS'];
                $all['forecast']['RVP'] = array_sum(array_column($forecast, 'RVP')) / $all['forecast']['DYS'];

                $all['limit'] = count(array_column($forecast, 'OCC'));

                $all['history']['DYS'] = 0;
            }
        }

        return $all;
    }

    private function get_history($date_start, $date_today, $avgs = 0)
    {
        $drta = Dolar::select('daily_rate as DOLAR')
                    ->where('date', '>=', date("Y-m-d", strtotime(date($date_start) . "- 1 days")))
                    ->where('date', '<=', $date_today)
                    ->orderBy('date', 'asc')
                    ->get()->toArray();

        $drtr = Dolar::select('daily_rate as DOLAR')
                    ->where('date', '>=', date("Y-m-d", strtotime(date($date_start))))
                    ->where('date', '<=', $date_today)
                    ->orderBy('date', 'asc')
                    ->get()->toArray();


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
                                ->where('heading_id', 119)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $rvnh = XmlHistoryData::select('day as RVN')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 77)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $fvnh = XmlHistoryData::select('day as RVN')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 78)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $ovnh = XmlHistoryData::select('day as RVN')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 79)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $adrh = XmlHistoryData::select('day as ADR')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 122)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $rvph = XmlHistoryData::select('day as RVP', 'xml_history_reports.date')
                                ->join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')
                                ->where('heading_id', 123)
                                ->where('xml_history_reports.date', '>=', $date_start)
                                ->where('xml_history_reports.date', '<=', $date_today)
                                ->orderBy('xml_history_reports.date')
                                ->get()->toArray();

        $days = date("t", strtotime(date($date_start)));

        foreach ($habh as $key => $value) {
            $avgs = $avgs + ($nrsh[$key]['NRS'] / ($value['HAB'] - 42) * 100);
            $ALL[$key]['AVG'] = $avgs;
            $ALL[$key]['OCP'] = $avgs / $days;
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['OCC'] = $nrsh[$key]['NRS'] / ($value['HAB'] - 42) * 100;
            $ALL[$key]['RVN'] = $rvnh[$key]['RVN'] / $drta[$key]['DOLAR'];
            $ALL[$key]['FVN'] = $fvnh[$key]['RVN'] / $drta[$key]['DOLAR'];
            $ALL[$key]['OVN'] = $ovnh[$key]['RVN'] / $drta[$key]['DOLAR'];
            $ALL[$key]['ADR'] = $adrh[$key]['ADR'] / $drtr[$key]['DOLAR'];
            $ALL[$key]['RVP'] = $rvph[$key]['RVP'] / $drtr[$key]['DOLAR'];

            $ALL[$key]["BOCC"] = 'rgba(0, 123, 255, 0.5)';
            $ALL[$key]["LOCC"] = 'rgba(0, 123, 255, 1)';
            $ALL[$key]['dates'] = date("d-M-y", strtotime(date($dats[$key]['date']) . "- 1 days"));
        }

        return $ALL;
    }

    private function get_forecast($date_today, $date_end_f, $avgs = 0)
    {
        $id    = XmlForecastReport::orderBy('date', 'desc')->value('id');
        $dolar = Dolar::orderByDesc('date')->value('daily_rate');

        $dats = XmlForecastDate::select('date')
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
                                ->where('heading_id', 119)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $occh = XmlForecastData::select('dato as OCC')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 121)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $rvnh = XmlForecastData::select('dato as RVN')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 77)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $adrh = XmlForecastData::select('dato as ADR')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 122)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $rvph = XmlForecastData::select('dato as RVP')
                                ->join('xml_forecast_dates', 'date_id', '=', 'xml_forecast_dates.id')
                                ->where('heading_id', 123)
                                ->where('xml_forecast_dates.report_id', $id)
                                ->where('xml_forecast_dates.date', '>=', $date_today)
                                ->where('xml_forecast_dates.date', '<=', $date_end_f)
                                ->orderBy('xml_forecast_dates.date')
                                ->get()->toArray();

        $days = date("t", strtotime(date($date_today)));

        foreach ($habh as $key => $value) {
            $avgs = $avgs + ($nrsh[$key]['NRS'] / ($value['HAB'] - 42) * 100);
            $ALL[$key]['OCP'] = $avgs / $days;
            $ALL[$key]['HAB'] = $nrsh[$key]['NRS'];
            $ALL[$key]['OCC'] = $nrsh[$key]['NRS'] / ($value['HAB'] - 42) * 100;
            $ALL[$key]['RVN'] = $rvnh[$key]['RVN'] / $dolar;
            $ALL[$key]['FVN'] = null;
            $ALL[$key]['OVN'] = null;
            $ALL[$key]['ADR'] = $adrh[$key]['ADR'] / $dolar;
            $ALL[$key]['RVP'] = $rvph[$key]['RVP'] / $dolar;

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
            $month = date("Y-m-01", strtotime($value['date']));
            $year  = date("Y-01-01", strtotime($value['date']));

            $people = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 16) ->value('day');

            $cnt = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 125)->value('day') + XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 126)->value('day');
            $cmp = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 130)->value('day') + XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 131)->value('day');
            $hsu = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 135)->value('day') + XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 136)->value('day');

            $hoteld = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 3)->value('day');
            $hotelm = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $month)->where('xml_history_reports.date', '<=', $value['date'])->sum('day');
            $hotely = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 3)->where('xml_history_reports.date', '>=', $year)->where('xml_history_reports.date', '<=', $value['date'])->sum('day');
            
            $habsd = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 119)->value('day');
            $habsm = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 119)->where('xml_history_reports.date', '>=', $month)->where('xml_history_reports.date', '<=', $value['date'])->sum('day');
            $habsy = XmlHistoryData::join('xml_history_reports', 'report_id', '=', 'xml_history_reports.id')->where('heading_id', 119)->where('xml_history_reports.date', '>=', $year)->where('xml_history_reports.date', '<=', $value['date'])->sum('day');

            $dolar = $this->dolar($value['date']);
            $data["date"][$key] = date("Y",strtotime($value['date'] . "+ 1 days"));
            $data["HAB"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 119)->value('day');
            $data["PAX"][$key]  = $people - $cnt - $cmp - $hsu;
            $data["PDS"][$key]  = $habsd / $hoteld * 100;
            $data["PMS"][$key]  = $habsm / $hotelm * 100;
            $data["PYS"][$key]  = $habsy / $hotely * 100;
            $data["ADR"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 122)->value('day') / $dolar;
            $data["RVP"][$key]  = XmlHistoryData::where('report_id', $value['id'])->where('heading_id', 123)->value('day') / $dolar;
        }
        return $data;
    }

    public function index(){
        $date   = date("Y-m-d");
        $data   = $this->allData($date);
        $agent  = new \Jenssegers\Agent\Agent;
        $number = date("d/m/Y", strtotime($date));
        $start  = XmlHistoryReport::orderBy('date', 'DESC')->value('date');
        $end    = '2022-07-01';
        return view('reserves.manager.index', compact('number', 'date', 'data', 'start', 'end', 'agent'));
    }

    public function store(Request $request){
        $date   = $request->date;
        $data   = $this->allData($date);
        $agent  = new \Jenssegers\Agent\Agent;
        $number = date("d/m/Y", strtotime($date));
        $start  = XmlHistoryReport::orderBy('date', 'DESC')->value('date');
        $end    = '2022-07-01';
        return view('reserves.manager.index', compact('number', 'date', 'data', 'start', 'end', 'agent'));
    }
}
