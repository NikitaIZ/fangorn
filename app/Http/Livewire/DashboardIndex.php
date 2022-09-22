<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Audit\Dolar;
use App\Models\Audit\Buffet;
use App\Models\Audit\Xml\XmlHeading;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;
use App\Models\Audit\Xml\XmlForecastData;
use App\Models\Audit\Xml\XmlForecastDate;
use App\Models\Audit\Xml\XmlForecastReport;

class DashboardIndex extends Component
{
    public $report, $number, $dolar, $date, $start, $end;

    public $orden = 0;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'render' => 'render',
    ];
    
    protected $queryString = [
        'date'
    ];

    public function mount()
    {
        $this->number = date("d/m/Y", strtotime($this->date));
        $this->report = XmlHistoryReport::where('date', $this->date)->value('id');
        $this->dolar  = $this->dolar($this->date);
        if ($this->report == null){
            $this->date   = date("Y-m-d",strtotime($this->date . "- 1 days"));
            $this->dolar  = $this->dolar($this->date);
            $this->report = XmlHistoryReport::where('date', $this->date)->value('id');
        }
        $this->start = XmlHistoryReport::orderBy('date', 'DESC')->value('date');
        $this->end   = XmlHistoryReport::orderBy('date', 'ASC') ->value('date');
    }

    public function update()
    {
        $this->number = date("d/m/Y", strtotime($this->date));
        $this->report = XmlHistoryReport::where('date', $this->date)->value('id');
        $this->dolar  = $this->dolar($this->date);
        $data = $this->allData();
        $this->emit("update", $data);
    }

    public function render()
    {
        $data = $this->allData();
        return view('livewire.dashboard-index', compact('data'));
    }

    private function allData($allData = array())
    {
        $date   = date("Y-m-d", strtotime($this->date . " - 1 days"));
        $report = XmlHistoryReport::where('date', $date)->value('id');
        $allData["yesterday"]["PDS"] = XmlHistoryData::where('report_id', $report)->where('heading_id', 36)->value('day');

        $allData["today"]    = $this->get_today_data();
        $allData["week"]     = $this->get_week_data();
        $allData["month"][0] = $this->get_month_data(0,0);
        $allData["month"][1] = $this->get_month_data(0,1);
        $allData["month"][2] = $this->get_month_data(0,2);
        $allData["year"]     = $this->get_year_data();
        $allData["types"]    = $this->get_types_data();
        $allData["buffet"]   = Buffet::get();

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

    private function get_name_type($id)
    {
        $name = XmlHeading::where('id', $id)->value('name');
        $pieces = explode("_", $name);
        return $pieces[0];
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

    private function get_today_data()
    {
        $data["HAB"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 2)  ->value('day');
        $data["PAX"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 16) ->value('day');
        $data["PDS"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 36) ->value('day');
        $data["PMS"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 36) ->value('month');
        $data["PYS"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 36) ->value('year');
        $data["DEP"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 95) ->value('day');
        $data["ARR"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 93) ->value('day');
        $data["PDR"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 121)->value('day');
        $data["ADB"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 122)->value('day');
        $data["RVB"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 123)->value('day');
        $data["ADR"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 122)->value('day') / $this->dolar;
        $data["RVP"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 123)->value('day') / $this->dolar;
        $data["HAR"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 2)->value('day') - XmlHistoryData::where('report_id', $this->report)->where('heading_id', 6)->value('day') - XmlHistoryData::where('report_id', $this->report)->where('heading_id', 7)->value('day') - XmlHistoryData::where('report_id', $this->report)->where('heading_id', 124)->value('day');

        return $data;
    }

    private function get_week_data($i = 0, $j = 1)
    {
        $week = date("Y-m-d", strtotime($this->date . " - 7 days"));
        while ($i <= 6) {
            $date   = date("Y-m-d",strtotime($week . " + " . $j . "days"));
            $dolar  = $this->dolar($date);
            $report = XmlHistoryReport::where('date', $date)->value('id');
            $data["date"][$i] = $this->get_name_day(strtotime($date));
            $data["HAB"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 2)  ->value('day');
            $data["PAX"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 16) ->value('day');
            $data["PER"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 36) ->value('day');
            $data["DEP"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 95) ->value('day');
            $data["ARR"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 93) ->value('day');
            $data["ADR"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 122)->value('day') / $dolar;
            $data["RVP"][$i]  = XmlHistoryData::where('report_id', $report)->where('heading_id', 123)->value('day') / $dolar;

            $x = 0; $y = 124;

            while ($y <= 278) {
                $data["TOR"][$x]["order"] = $x;
                $data["TOR"][$x]["name"]  = $this->get_name_type($y);
                switch ($data["TOR"][$x]["name"]) {
                    case 'CMP':
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', 6)  ->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', 125)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', 126)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;

                    case 'HSU':
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', 7)  ->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', 135)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', 136)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;

                    case 'GCP':
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', 22) ->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', 220)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', 221)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;

                    case 'WHD':
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', 25) ->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', 155)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', 156)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;

                    case 'CNT':
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', 118)->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', 125)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', 126)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;

                    default:
                        $data["TOR"][$x]["rooms"][$i]    = XmlHistoryData::where('report_id', $report)->where('heading_id', $y)  ->value('day');
                        $data["TOR"][$x]["adults"][$i]   = XmlHistoryData::where('report_id', $report)->where('heading_id', $y+1)->value('day');
                        $data["TOR"][$x]["childrem"][$i] = XmlHistoryData::where('report_id', $report)->where('heading_id', $y+2)->value('day');
                        $data["TOR"][$x]["people"][$i]   = strval($data["TOR"][$x]["adults"][$i] + $data["TOR"][$x]["childrem"][$i]);
                        if ($data["TOR"][$x]["people"][$i] == 0) {
                            $data["TOR"][$x]["people"][$i] = null;
                            $data["TOR"][$x]["rat"][$i]    = null;
                        }else{
                            $data["TOR"][$x]["rat"][$i] = strval(round($data["TOR"][$x]["people"][$i] / $data["TOR"][$x]["rooms"][$i], 2));
                        }
                        if ($data["TOR"][$x]["adults"][$i] == 0) {
                            $data["TOR"][$x]["adults"][$i] = null;
                        }
                        if ($data["TOR"][$x]["childrem"][$i] == 0) {
                            $data["TOR"][$x]["childrem"][$i] = null;
                        }
                    break;
                }
                $y = $y + 5; $x++;
            }
            $i++; $j++;
        }

        foreach ($data["TOR"] as $key => $value) {
            $i = 0;  $j = 0;
            while ($i <= 6) {
                if ($value["rooms"][$i] == null || $value["rooms"][$i] == 0) {
                    $j++;
                }
                $i++;
            }
            if ($j == 7) {
                unset($data["TOR"][$key]);
                $j = 0;
            }
        }

        sort($data["TOR"]);

        return $data;
    }

    private function get_month_data($i = 0, $j = 0)
    {
        $data = array(
            "name"    => $this->get_name_month(date("m", strtotime(date($this->date)."+" . $j . "month"))),
            "history" => array(
                "OCC" => 0, "ARR" => 0, "DEP" => 0, "NRS" => 0, "NPS" => 0, "COM" => 0,
                "HOU" => 0, "NSR" => 0, "RVN" => 0, "RVP" => 0, "ADR" => 0, "DYS" => 0, 
                "ALR" => 0
            ),
            "forecast" => array(
                "OCC" => 0, "ARR" => 0, "DEP" => 0, "NRS" => 0, "NPS" => 0, "COM" => 0,
                "HOU" => 0, "NSR" => 0, "RVN" => 0, "RVP" => 0, "ADR" => 0, "DYS" => 0, 
                "ALR" => 0
            ),
        );

        $days  = date("t", strtotime(date($this->date)."+" . $j . "month"))-1;
        $month = date("Y-m", strtotime(date($this->date)."+" . $j . "month"));

        while ($i <= $days) {
            $date = date("Y-m-d",strtotime(date($month . '-01')."+". $i  ."days"));
            $data["date"][$i] = date("d-M-y", strtotime($date));

            $history = XmlHistoryReport::where('date', $date)->value('id');
            $dolar   = $this->dolar($date);

            if ($history != null){
                $data["ALR"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 1)  ->value('day');
                $data["NRS"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 2)  ->value('day');
                $data["COM"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 6)  ->value('day');
                $data["HOU"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 7)  ->value('day');
                $data["NSR"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 12) ->value('day');
                $data["NPS"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 16) ->value('day');
                $data["OCC"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 36) ->value('day');
                $data["ARR"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 37) ->value('day');
                $data["DEP"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 45) ->value('day');
                $data["RVN"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 77) ->value('day') / $dolar;
                $data["ADR"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 122)->value('day') / $dolar;
                $data["RVP"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 123)->value('day') / $dolar;

                $x = 0; $y = 124;

                while ($y <= 278) {
                    $data["TOR"][$x]["order"]   = $x;
                    $data["TOR"][$x]["name"]    = $this->get_name_type($y);
                    $data["TOR"][$x]["descrip"] = $this->get_description_name($data["TOR"][$x]["name"]);
                    $data["TOR"][$x]["total"]   = 0;
                    $data["TOR"][$x]["history"] = 0;
                    switch ($data["TOR"][$x]["name"]) {
                        case 'CMP':
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 6)  ->value('day');
                        break;

                        case 'HSU':
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 7)  ->value('day');
                        break;

                        case 'GCP':
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 22) ->value('day');
                        break;

                        case 'WHD':
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 25) ->value('day');
                        break;

                        case 'CNT':
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', 118)->value('day');
                        break;

                        default:
                            $data["TOR"][$x]["rooms"][$i] = XmlHistoryData::where('report_id', $history)->where('heading_id', $y)  ->value('day');
                        break;
                    }
                    $y = $y + 5; $x++;
                }

                $data["history"]["ARR"] += $data["ARR"][$i];
                $data["history"]["DEP"] += $data["DEP"][$i];
                $data["history"]["NRS"] += $data["NRS"][$i];
                $data["history"]["NPS"] += $data["NPS"][$i];
                $data["history"]["COM"] += $data["COM"][$i];
                $data["history"]["HOU"] += $data["HOU"][$i];
                $data["history"]["NSR"] += $data["NSR"][$i];
                $data["history"]["ADR"] += $data["ADR"][$i];
                $data["history"]["RVN"] += $data["RVN"][$i];
                $data["history"]["RVP"] += $data["RVP"][$i];
                $data["history"]["ALR"] += $data["ALR"][$i];
                $data["history"]["DYS"]++;

                $data["BOCC"][$i] = 'rgb(0, 123, 255, 0.5)';
                $data["BARR"][$i] = 'rgb(27, 188, 155, 0.5)';
                $data["BDEP"][$i] = 'rgb(45, 62, 80, 0.5)';
                $data["LOCC"][$i] = 'rgba(0, 123, 255, 1)';
                $data["LARR"][$i] = 'rgb(27, 188, 155, 1)';
                $data["LDEP"][$i] = 'rgb(45, 62, 80, 1)';
            }else{
                $forecast = XmlForecastReport::orderBy('date', 'desc')->value('id');
                $id = XmlForecastDate::where('date', date("Y-m-d", strtotime($date)))->where('report_id', $forecast)->value('id');
                if ($id != null){
                    $data["ROS"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 1)  ->value('dato');
                    $data["NRS"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 2)  ->value('dato');
                    $data["COM"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 6)  ->value('dato');
                    $data["HOU"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 7)  ->value('dato');
                    $data["NSR"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 12) ->value('dato');
                    $data["NPS"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 16) ->value('dato');
                    $data["ARR"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 37) ->value('dato');
                    $data["DEP"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 45) ->value('dato');
                    $data["RVN"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 77) ->value('dato') / $dolar;
                    $data["ADR"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 122)->value('dato') / $dolar;
                    $data["RVP"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', 123)->value('dato') / $dolar;
                    $data["OCC"][$i] = $data["NRS"][$i] / ($data["ROS"][$i] - $data["NSR"][$i]) * 100;

                    $x = 0; $y = 124;

                    while ($y <= 278) {
                        $data["TOR"][$x]["order"]     = $x;
                        $data["TOR"][$x]["name"]      = $this->get_name_type($y);
                        $data["TOR"][$x]["descrip"]   = $this->get_description_name($data["TOR"][$x]["name"]);
                        $data["TOR"][$x]["total"]     = 0;
                        $data["TOR"][$x]["forecast"]  = 0;
                        $data["TOR"][$x]["rooms"][$i] = XmlForecastData::where('date_id', $id)->where('heading_id', $y)->value('dato');
                        $y = $y + 5; $x++;
                    }
                }else{
                    $data["OCC"][$i] = null;
                    $data["ARR"][$i] = null;
                    $data["DEP"][$i] = null;
                    $data["NRS"][$i] = null;
                    $data["NPS"][$i] = null;
                    $data["COM"][$i] = null;
                    $data["HOU"][$i] = null;
                    $data["NSR"][$i] = null;
                    $data["RVN"][$i] = null;
                    $data["ADR"][$i] = null;
                    $data["RVP"][$i] = null;
                }
                $data["ALR"][$i] = XmlHistoryData::where('heading_id', 1)->value('day');

                $data["forecast"]["ARR"] += $data["ARR"][$i];
                $data["forecast"]["DEP"] += $data["DEP"][$i];
                $data["forecast"]["NRS"] += $data["NRS"][$i];
                $data["forecast"]["NPS"] += $data["NPS"][$i];
                $data["forecast"]["COM"] += $data["COM"][$i];
                $data["forecast"]["HOU"] += $data["HOU"][$i];
                $data["forecast"]["NSR"] += $data["NSR"][$i];
                $data["forecast"]["ADR"] += $data["ADR"][$i];
                $data["forecast"]["RVN"] += $data["RVN"][$i];
                $data["forecast"]["RVP"] += $data["RVP"][$i];
                $data["forecast"]["ALR"] += $data["ALR"][$i];

                $data["forecast"]["DYS"]++;

                $data["BOCC"][$i] = 'rgb(0, 123, 255, 0.4)';
                $data["BARR"][$i] = 'rgb(27, 188, 155, 0.4)';
                $data["BDEP"][$i] = 'rgb(45, 62, 80, 0.4)';
                $data["LOCC"][$i] = 'rgb(0, 123, 255, 0.5)';
                $data["LARR"][$i] = 'rgb(27, 188, 155, 0.5)';
                $data["LDEP"][$i] = 'rgb(45, 62, 80, 0.5)';
            }
            $i++;
        }

        if ($data["history"]["DYS"] != 0){
            //$data["history"]["RVN"] = $data["history"]["RVN"] / $data["history"]["DYS"];
            $data["history"]["ADR"] = $data["history"]["ADR"] / $data["history"]["DYS"];
            $data["history"]["RVP"] = $data["history"]["RVP"] / $data["history"]["DYS"];
            $data["history"]["OCC"] = $data["history"]["NRS"] / ($data["history"]["ALR"] - $data["history"]["NSR"]) * 100;
        }

        if ($data["forecast"]["DYS"] != 0){
            //$data["forecast"]["RVN"] = $data["forecast"]["RVN"] / $data["forecast"]["DYS"];
            $data["forecast"]["ADR"] = $data["forecast"]["ADR"] / $data["forecast"]["DYS"];
            $data["forecast"]["RVP"] = $data["forecast"]["RVP"] / $data["forecast"]["DYS"];
            $data["forecast"]["OCC"] = $data["forecast"]["NRS"] / ($data["forecast"]["ALR"] - $data["forecast"]["NSR"]) * 100;
        }

        $data["total"]["ARR"] = $data["history"]["ARR"] + $data["forecast"]["ARR"];
        $data["total"]["DEP"] = $data["history"]["DEP"] + $data["forecast"]["DEP"];
        $data["total"]["NRS"] = $data["history"]["NRS"] + $data["forecast"]["NRS"];
        $data["total"]["NPS"] = $data["history"]["NPS"] + $data["forecast"]["NPS"];
        $data["total"]["COM"] = $data["history"]["COM"] + $data["forecast"]["COM"];
        $data["total"]["HOU"] = $data["history"]["HOU"] + $data["forecast"]["HOU"];
        $data["total"]["NSR"] = $data["history"]["NSR"] + $data["forecast"]["NSR"];
        $data["total"]["ALR"] = $data["history"]["ALR"] + $data["forecast"]["ALR"];
        $data["total"]["RVN"] = $data["history"]["RVN"] + $data["forecast"]["RVN"];
        $data["total"]["RVP"] = $data["history"]["RVP"] + $data["forecast"]["RVP"];
        $data["total"]["ADR"] = $data["history"]["ADR"] + $data["forecast"]["ADR"];
        $data["total"]["OCC"] = $data["total"]["NRS"] / ($data["total"]["ALR"] - $data["total"]["NSR"]) * 100;

        if ($data["forecast"]["RVP"] != 0) {
            //$data["total"]["RVN"] = $data["total"]["RVN"] / 2;
            $data["total"]["RVP"] = $data["total"]["RVP"] / 2;
            $data["total"]["ADR"] = $data["total"]["ADR"] / 2;
        }

        foreach ($data["TOR"] as $key => $value) {
            $i = 0;  $j = 0;
            while ($i <= $days) {
                if ($value["rooms"][$i] == null || $value["rooms"][$i] == 0) {
                    $j++;
                }
                $i++;
            }
            if ($j == $days+1) {
                unset($data["TOR"][$key]);
                $j = 0;
            }
        }

        sort($data["TOR"]);

        foreach ($data["TOR"] as $key => $value) {
            $i = 0; $history = 0; $forecast = 0;
            while ($i <= $data["history"]["DYS"]-1) {
                $history = $history + $value["rooms"][$i];
                $i++;
            }
            while ($i <= $data["history"]["DYS"] + $data["forecast"]["DYS"]-1) {
                $forecast = $forecast + $value["rooms"][$i];
                $i++;
            }
            $data["TOR"][$key]["history"]  = $history;
            $data["TOR"][$key]["forecast"] = $forecast;
            $data["TOR"][$key]["total"]    = $history + $forecast;
            $data["TOR"][$key]["color"]    = $this->get_color($key);
        }

        return $data;
    }

    private function get_year_data()
    {
        $date  = date("m-d", strtotime($this->date));
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

    private function get_types_data($i = 0, $j = 124)
    {
        $colors = array(
            0 => "bg-primary",
            1 => "bg-success",
            2 => "bg-info",
            3 => "bg-warning",
            4 => "bg-danger",
            5 => "bg-secondary",
            6 => "bg-dark",
        );

        while ($j <= 278) {
            $validation = XmlHistoryData::where('report_id', $this->report)->where('heading_id', $j)->value('day');
            if ($validation) {
                $data[$i]["name"]     = $this->get_name_type($j);
                $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', $j++)->value('day');
                $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', $j++)->value('day');
                $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', $j++)->value('day');
                $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', $j++)->value('day');
                $i++;$j++;
            }else{
                $name = $this->get_name_type($j);
                switch ($name) {
                    case 'CMP':
                        if (XmlHistoryData::where('report_id', $this->report)->where('heading_id', 6)->value('day')) {
                            $data[$i]["name"]     = $name;
                            $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 6)  ->value('day');
                            $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 125)->value('day');
                            $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 126)->value('day');
                            $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 127)->value('day');
                            $i++;
                        }
                    break;
                    
                    case 'HSU':
                        if (XmlHistoryData::where('report_id', $this->report)->where('heading_id', 7)->value('day')) {
                            $data[$i]["name"]     = $name;
                            $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 7)  ->value('day');
                            $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 135)->value('day');
                            $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 136)->value('day');
                            $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 137)->value('day');
                            $i++;
                        }
                    break;

                    case 'GCP':
                        if (XmlHistoryData::where('report_id', $this->report)->where('heading_id', 22)->value('day')) {
                            $data[$i]["name"]     = $name;
                            $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 22) ->value('day');
                            $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 220)->value('day');
                            $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 221)->value('day');
                            $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 222)->value('day');
                            $i++;
                        }
                    break;

                    case 'WHD':
                        if (XmlHistoryData::where('report_id', $this->report)->where('heading_id', 25)->value('day')) {
                            $data[$i]["name"]     = $name;
                            $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 25) ->value('day');
                            $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 155)->value('day');
                            $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 156)->value('day');
                            $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 109)->value('day');
                            $i++;
                        }
                    break;

                    case 'CNT':
                        if (XmlHistoryData::where('report_id', $this->report)->where('heading_id', 118)->value('day')) {
                            $data[$i]["name"]     = $name;
                            $data[$i]["rooms"]    = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 118)->value('day');
                            $data[$i]["adults"]   = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 125)->value('day');
                            $data[$i]["childrem"] = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 126)->value('day');
                            $data[$i]["revenue"]  = XmlHistoryData::where('report_id', $this->report)->where('heading_id', 127)->value('day');
                            $i++;
                        }
                    break;
                }
                $j = $j + 5;
            }
        }

        foreach ($data as $key => $value) {
            $data[$key]["per"]     = $value["rooms"] / XmlHistoryData::where('report_id', $this->report)->where('heading_id', 3)->value('day') * 100;
            $data[$key]["color"]   = $colors[$key];
            $data[$key]["descrip"] = $this->get_description_name($value["name"]);
        }

        return $data;
    }
}
