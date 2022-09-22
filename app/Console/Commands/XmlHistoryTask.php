<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHeading;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;

class XmlHistoryTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subir Xml a la base de datos';

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

    private function validation($folder){
        $date = $this->orderDateFiles($folder);
        $validation = XmlHistoryReport::where('folder', $date)->value('id');
        if ($validation == null){
            return true;
        }else{
            return false;
        }
    }

    private function dirScan($disk, $option) {
        $ignored = array('.', '..', 'Thumbs.db', 'Historico', '150309', '140319', '160320', '140321', '060319');
        $directories = array();
        foreach (scandir($disk) as $directory) {
            if (in_array($directory, $ignored)) continue;
            $data = XmlHistoryReport::where('folder', $this->orderDateFiles($directory))->value('id');
            if ($data == null){
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

    private function updateXmlHistoryReport($folder, $array){
        $dolar = Dolar::orderByDesc('date')->value('id');
        $date  = $this->date($folder);
        $XmlHistoryReport = new XmlHistoryReport();
        $XmlHistoryReport->folder   = $folder;
        $XmlHistoryReport->date     = $date;
        $XmlHistoryReport->dolar_id = $dolar;
        $XmlHistoryReport->save();
        foreach ($array as $key => $dato){
            $XmlHistoryData = new XmlHistoryData();
            $XmlHistoryData->report_id  = $XmlHistoryReport->id;
            $XmlHistoryData->heading_id = XmlHeading::where('name', $key)->value('id');
            $XmlHistoryData->day        = $dato['DAY'];
            if (array_key_exists('MONTH', $dato)) {
                $XmlHistoryData->month  = $dato['MONTH'];
            }
            if (array_key_exists('YEAR', $dato)) {
                $XmlHistoryData->year  = $dato['YEAR'];
            }
            $XmlHistoryData->save();
        }
    }

    private function orderXml($urlManager, $urlBuc, $urlJournal, $name, $all_data = array()){

        $folder = $this->orderDateFiles($name);

        $xml   = simplexml_load_file($urlManager);
        $json  = json_encode($xml);
        $array = json_decode($json, TRUE);

        $data = $array['LIST_G_MASTER_VALUE_ORDER']['G_MASTER_VALUE_ORDER']['LIST_G_LAST_YEAR_01']['G_LAST_YEAR_01']['LIST_G_CROSS']['G_CROSS']['LIST_G_MASTER_VALUE']['G_MASTER_VALUE'];

        foreach ($data as $value) {
            $title = $value['SUB_GRP_1'];
            $time  = $value['LIST_G_HEADING_1_ORDER']['G_HEADING_1_ORDER'];

            foreach ($time as $value) {
                if ($value['LIST_G_SUM_AMOUNT']['G_SUM_AMOUNT']['SUM_AMOUNT'] != null){
                    $all_data[$title][$value['HEADING_2']] = $value['LIST_G_SUM_AMOUNT']['G_SUM_AMOUNT']['SUM_AMOUNT'];
                }
                else{
                    $all_data[$title][$value['HEADING_2']] = '';
                }
            }
        }

        $types = array(
            "COM"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "MEG"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "NAT"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "LOC"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GOV"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "PKG"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "BPR"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "INT"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "IOP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "DIS"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WHD"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WHI"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WHPI" => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WHPN" => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WHC"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GCP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GCM"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GDP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GEP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GTR"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GTT"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GAS"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GMP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GSF"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "WEDD" => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "GGV"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "CNT"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "ATP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "CMP"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "HSU"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
            "SLB"  => array("Rooms" => 0, "Adults" => 0, "Childrem" => 0, "Revenue" => 0),
        );

        $xml   = simplexml_load_file($urlBuc);
        $json  = json_encode($xml);
        $array = json_decode($json, TRUE);

        foreach ($array['LIST_G_ROOM']['G_ROOM'] as $value){
            switch ($value['MARKET_CODE']) {
                case 'COM':
                    $types['COM']['Rooms']++;
                    $types['COM']['Adults']   = $types['COM']['Adults']   + $value['RM_ADULTS'];
                    $types['COM']['Childrem'] = $types['COM']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'MEG':
                    $types['MEG']['Rooms']++;
                    $types['MEG']['Adults']   = $types['MEG']['Adults']   + $value['RM_ADULTS'];
                    $types['MEG']['Childrem'] = $types['MEG']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'NAT':
                    $types['NAT']['Rooms']++;
                    $types['NAT']['Adults']   = $types['NAT']['Adults']   + $value['RM_ADULTS'];
                    $types['NAT']['Childrem'] = $types['NAT']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'LOC':
                    $types['LOC']['Rooms']++;
                    $types['LOC']['Adults']   = $types['LOC']['Adults']   + $value['RM_ADULTS'];
                    $types['LOC']['Childrem'] = $types['LOC']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GOV':
                    $types['GOV']['Rooms']++;
                    $types['GOV']['Adults']   = $types['GOV']['Adults']   + $value['RM_ADULTS'];
                    $types['GOV']['Childrem'] = $types['GOV']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'PKG':
                    $types['PKG']['Rooms']++;
                    $types['PKG']['Adults']   = $types['PKG']['Adults']   + $value['RM_ADULTS'];
                    $types['PKG']['Childrem'] = $types['PKG']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'BPR':
                    $types['BPR']['Rooms']++;
                    $types['BPR']['Adults']   = $types['BPR']['Adults']   + $value['RM_ADULTS'];
                    $types['BPR']['Childrem'] = $types['BPR']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'INT':
                    $types['INT']['Rooms']++;
                    $types['INT']['Adults']   = $types['INT']['Adults']   + $value['RM_ADULTS'];
                    $types['INT']['Childrem'] = $types['INT']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'IOP':
                    $types['IOP']['Rooms']++;
                    $types['IOP']['Adults']   = $types['IOP']['Adults']   + $value['RM_ADULTS'];
                    $types['IOP']['Childrem'] = $types['IOP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'DIS':
                    $types['DIS']['Rooms']++;
                    $types['DIS']['Adults']   = $types['DIS']['Adults']   + $value['RM_ADULTS'];
                    $types['DIS']['Childrem'] = $types['DIS']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WHD':
                    $types['WHD']['Rooms']++;
                    $types['WHD']['Adults']   = $types['WHD']['Adults']   + $value['RM_ADULTS'];
                    $types['WHD']['Childrem'] = $types['WHD']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WHI':
                    $types['WHI']['Rooms']++;
                    $types['WHI']['Adults']   = $types['WHI']['Adults']   + $value['RM_ADULTS'];
                    $types['WHI']['Childrem'] = $types['WHI']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WHPI':
                    $types['WHPI']['Rooms']++;
                    $types['WHPI']['Adults']   = $types['WHPI']['Adults']   + $value['RM_ADULTS'];
                    $types['WHPI']['Childrem'] = $types['WHPI']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WHPN':
                    $types['WHPN']['Rooms']++;
                    $types['WHPN']['Adults']   = $types['WHPN']['Adults']   + $value['RM_ADULTS'];
                    $types['WHPN']['Childrem'] = $types['WHPN']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WHC':
                    $types['WHC']['Rooms']++;
                    $types['WHC']['Adults']   = $types['WHC']['Adults']   + $value['RM_ADULTS'];
                    $types['WHC']['Childrem'] = $types['WHC']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GCP':
                    $types['GCP']['Rooms']++;
                    $types['GCP']['Adults']   = $types['GCP']['Adults']   + $value['RM_ADULTS'];
                    $types['GCP']['Childrem'] = $types['GCP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GCM':
                    $types['GCM']['Rooms']++;
                    $types['GCM']['Adults']   = $types['GCM']['Adults']   + $value['RM_ADULTS'];
                    $types['GCM']['Childrem'] = $types['GCM']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GDP':
                    $types['GDP']['Rooms']++;
                    $types['GDP']['Adults']   = $types['GDP']['Adults']   + $value['RM_ADULTS'];
                    $types['GDP']['Childrem'] = $types['GDP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GEP':
                    $types['GEP']['Rooms']++;
                    $types['GEP']['Adults']   = $types['GEP']['Adults']   + $value['RM_ADULTS'];
                    $types['GEP']['Childrem'] = $types['GEP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GTR':
                    $types['GTR']['Rooms']++;
                    $types['GTR']['Adults']   = $types['GTR']['Adults']   + $value['RM_ADULTS'];
                    $types['GTR']['Childrem'] = $types['GTR']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GTT':
                    $types['GTT']['Rooms']++;
                    $types['GTT']['Adults']   = $types['GTT']['Adults']   + $value['RM_ADULTS'];
                    $types['GTT']['Childrem'] = $types['GTT']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GAS':
                    $types['GAS']['Rooms']++;
                    $types['GAS']['Adults']   = $types['GAS']['Adults']   + $value['RM_ADULTS'];
                    $types['GAS']['Childrem'] = $types['GAS']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GMP':
                    $types['GMP']['Rooms']++;
                    $types['GMP']['Adults']   = $types['GMP']['Adults']   + $value['RM_ADULTS'];
                    $types['GMP']['Childrem'] = $types['GMP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GSF':
                    $types['GSF']['Rooms']++;
                    $types['GSF']['Adults']   = $types['GSF']['Adults']   + $value['RM_ADULTS'];
                    $types['GSF']['Childrem'] = $types['GSF']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'WEDD':
                    $types['WEDD']['Rooms']++;
                    $types['WEDD']['Adults']   = $types['WEDD']['Adults']   + $value['RM_ADULTS'];
                    $types['WEDD']['Childrem'] = $types['WEDD']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'GGV':
                    $types['GGV']['Rooms']++;
                    $types['GGV']['Adults']   = $types['GGV']['Adults']   + $value['RM_ADULTS'];
                    $types['GGV']['Childrem'] = $types['GGV']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'CNT':
                    $types['CNT']['Rooms']++;
                    $types['CNT']['Adults']   = $types['CNT']['Adults']   + $value['RM_ADULTS'];
                    $types['CNT']['Childrem'] = $types['CNT']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'ATP':
                    $types['ATP']['Rooms']++;
                    $types['ATP']['Adults']   = $types['ATP']['Adults']   + $value['RM_ADULTS'];
                    $types['ATP']['Childrem'] = $types['ATP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'CMP':
                    $types['CMP']['Rooms']++;
                    $types['CMP']['Adults']   = $types['CMP']['Adults']   + $value['RM_ADULTS'];
                    $types['CMP']['Childrem'] = $types['CMP']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'HSU':
                    $types['HSU']['Rooms']++;
                    $types['HSU']['Adults']   = $types['HSU']['Adults']   + $value['RM_ADULTS'];
                    $types['HSU']['Childrem'] = $types['HSU']['Childrem'] + $value['RM_CHILDREN'];
                break;
                case 'SLB':
                    $types['SLB']['Rooms']++;
                    $types['SLB']['Adults']   = $types['SLB']['Adults']   + $value['RM_ADULTS'];
                    $types['SLB']['Childrem'] = $types['SLB']['Childrem'] + $value['RM_CHILDREN'];
                break;
            }
        }

        $charges = array(
            0 => 'Room Charge',
            1 => 'Room Charge Rebate',
            2 => 'Room Charge Manually',
            3 => 'Late Check Out',
            4 => 'Otros Ingresos Ama de Llaves',
            5 => 'Otros Ingresos de Reserva'
        );

        $xml   = simplexml_load_file($urlJournal);
        $json  = json_encode($xml);
        $array = json_decode($json, TRUE);

        foreach ($array['LIST_FIRST']['FIRST'] as $lists){
            $list = $lists['LIST_SECOND']['SECOND']['LIST_THIRD']['THIRD']['LIST_G_TRX_CHAR_DATE']['G_TRX_CHAR_DATE'];
            if (array_key_exists(0, $list)) {
                foreach ($list as $value){
                    switch ($value['MARKET_CODE']) {
                        case 'COM':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['COM']['Revenue'] = $types['COM']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'MEG':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['MEG']['Revenue'] = $types['MEG']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'NAT':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['NAT']['Revenue'] = $types['NAT']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'LOC':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['LOC']['Revenue'] = $types['LOC']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GOV':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GOV']['Revenue'] = $types['GOV']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'PKG':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['PKG']['Revenue'] = $types['PKG']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'BPR':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['BPR']['Revenue'] = $types['BPR']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'INT':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['INT']['Revenue'] = $types['INT']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'IOP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['IOP']['Revenue'] = $types['IOP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'DIS':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['DIS']['Revenue'] = $types['DIS']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WHD':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WHD']['Revenue'] = $types['WHD']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WHI':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WHI']['Revenue'] = $types['WHI']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WHPI':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WHPI']['Revenue'] = $types['WHPI']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WHPN':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WHPN']['Revenue'] = $types['WHPN']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WHC':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WHC']['Revenue'] = $types['WHC']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GCP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GCP']['Revenue'] = $types['GCP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GCM':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GCM']['Revenue'] = $types['GCM']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GDP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GDP']['Revenue'] = $types['GDP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GEP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GEP']['Revenue'] = $types['GEP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GTR':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GTR']['Revenue'] = $types['GTR']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GTT':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GTT']['Revenue'] = $types['GTT']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GAS':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GAS']['Revenue'] = $types['GAS']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GMP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GMP']['Revenue'] = $types['GMP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GSF':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GSF']['Revenue'] = $types['GSF']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'WEDD':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['WEDD']['Revenue'] = $types['WEDD']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'GGV':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['GGV']['Revenue'] = $types['GGV']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'CNT':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['CNT']['Revenue'] = $types['CNT']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'ATP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['ATP']['Revenue'] = $types['ATP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'CMP':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['CMP']['Revenue'] = $types['CMP']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'HSU':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['HSU']['Revenue'] = $types['HSU']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                        case 'SLB':
                            foreach ($charges as $charge){
                                if ($charge == $value['TRX_DESC']){
                                    $types['SLB']['Revenue'] = $types['SLB']['Revenue'] + $value['DEBIT'];
                                }
                            }
                        break;
                    }
                }
            }else{
                switch ($list['MARKET_CODE']) {
                    case 'COM':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['COM']['Revenue'] = $types['COM']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'MEG':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['MEG']['Revenue'] = $types['MEG']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'NAT':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['NAT']['Revenue'] = $types['NAT']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'LOC':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['LOC']['Revenue'] = $types['LOC']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GOV':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GOV']['Revenue'] = $types['GOV']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'PKG':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['PKG']['Revenue'] = $types['PKG']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'BPR':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['BPR']['Revenue'] = $types['BPR']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'INT':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['INT']['Revenue'] = $types['INT']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'IOP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['IOP']['Revenue'] = $types['IOP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'DIS':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['DIS']['Revenue'] = $types['DIS']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WHD':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WHD']['Revenue'] = $types['WHD']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WHI':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WHI']['Revenue'] = $types['WHI']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WHPI':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WHPI']['Revenue'] = $types['WHPI']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WHPN':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WHPN']['Revenue'] = $types['WHPN']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WHC':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WHC']['Revenue'] = $types['WHC']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GCP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GCP']['Revenue'] = $types['GCP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GCM':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GCM']['Revenue'] = $types['GCM']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GDP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GDP']['Revenue'] = $types['GDP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GEP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GEP']['Revenue'] = $types['GEP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GTR':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GTR']['Revenue'] = $types['GTR']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GTT':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GTT']['Revenue'] = $types['GTT']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GAS':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GAS']['Revenue'] = $types['GAS']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GMP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GMP']['Revenue'] = $types['GMP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GSF':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GSF']['Revenue'] = $types['GSF']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'WEDD':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['WEDD']['Revenue'] = $types['WEDD']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'GGV':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['GGV']['Revenue'] = $types['GGV']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'CNT':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['CNT']['Revenue'] = $types['CNT']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'ATP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['ATP']['Revenue'] = $types['ATP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'CMP':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['CMP']['Revenue'] = $types['CMP']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'HSU':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['HSU']['Revenue'] = $types['HSU']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                    case 'SLB':
                        foreach ($charges as $charge){
                            if ($charge == $list['TRX_DESC']){
                                $types['SLB']['Revenue'] = $types['SLB']['Revenue'] + $list['DEBIT'];
                            }
                        }
                    break;
                }
            }
        }

        $all_data['TIME_SHARE_ROOMS']['DAY']       = $types['CNT']['Rooms'];
        $all_data['OCC_MINUS_COMP_HU_TS']['DAY']   = $all_data['OCC_MINUS_COMP_HU']['DAY'] - $all_data['TIME_SHARE_ROOMS']['DAY'];
        $all_data['OCC_PERC_TS']['DAY']            = $all_data['TIME_SHARE_ROOMS']['DAY'] / $all_data['PHYSICAL_ROOMS']['DAY'] * 100;
        $all_data['OCC_PERC_WO_CHTS']['DAY']       = $all_data['OCC_MINUS_COMP_HU_TS']['DAY'] / $all_data['PHYSICAL_ROOMS']['DAY'] * 100;
        if ($all_data['OCC_MINUS_COMP_HU_TS']['DAY'] != 0){
            $all_data['ADR_ROOM_WO_CHTS']['DAY']   = $all_data['ROOM_REVENUE']['DAY'] / $all_data['OCC_MINUS_COMP_HU_TS']['DAY'];
        }
        $all_data['REV_PAR_WO_CHTS']['DAY']        = $all_data['ADR_ROOM_WO_CHTS']['DAY'] * $all_data['OCC_PERC_WO_O']['DAY'] / 100;

        foreach ($types as $key => $value) {
            if ($value['Rooms'] > 0) {
                $all_data[$key . '_ROOMS']['DAY']             = $value['Rooms'];
                $all_data[$key . '_ADULTS_IN_HOUSE']['DAY']   = $value['Adults'];
                $all_data[$key . '_CHILDREN_IN_HOUSE']['DAY'] = $value['Childrem'];
                $all_data[$key . '_REVENUE']['DAY']           = $value['Revenue'];
                $all_data['OCC_PERC_' . $key]['DAY']          = $value['Rooms'] / $all_data['PHYSICAL_ROOMS']['DAY'] * 100;
            }
        }

        $this->updateXmlHistoryReport($folder, $all_data);
    }

    public function handle()
    {
        //$directory = date("dmy",strtotime(date("d-m-Y")."- 1 days"));
        
        $directories = $this->dirScan('M:\\', 'first');
        if ($directories != false){
            foreach ($directories as $directory) {
                $validation  = $this->validation($directory);
                $fileBucChk  = "M:\\" . $directory . "\buc_chk_exc.xml";
                $fileManager = "M:\\" . $directory . "\manager.xml";
                $fileJournal = "M:\\" . $directory . "\journal.xml";
                if (file_exists($fileBucChk) == true AND file_exists($fileManager) == true AND file_exists($fileJournal) == true AND $validation == true) {
                    $this->orderXml($fileManager, $fileBucChk, $fileJournal, $directory);
                }
            }
        }
    }
}
