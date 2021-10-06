<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Xml\XmlData;
use App\Models\Xml\XmlReport;
use App\Models\Xml\XmlHeading;
use App\Models\Views\ViewXmlReport;


class XmlTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:task';

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

    private function orderDate($name){
        $chara = str_split($name);
        $date = $chara[0] . $chara[1] . "/" . 
                $chara[2] . $chara[3] . "/" . 
                $chara[4] . $chara[5] ;
        return $date;
    } 

    private function dirScan($disk, $option) {
        $ignored = array('.', '..', 'Thumbs.db', '111014', '010715', '310715', '010815', '010915');
        $directories = array();    
        foreach (scandir($disk) as $directory) {
            if (in_array($directory, $ignored)) continue;
            if (ViewXmlReport::check('Fecha', $this->orderDate($directory)) == false){
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

    private function heading($name){
        $table = XmlHeading::select('*')->where('name', $name)->get();
        foreach ($table as $dato){
            return $dato->id;
        }
    }

    private function updateXmlReport($date, $array){
        $XmlReport = new XmlReport();
        $XmlReport->date = $date;
        $XmlReport->save();
        foreach ($array as $key => $dato){
            $XmlData = new XmlData();
            $XmlData->report_id  = $XmlReport->id;
            $XmlData->heading_id = $this->heading($key);
            $XmlData->day        = $dato['DAY'];
            $XmlData->month      = $dato['MONTH'];
            $XmlData->year       = $dato['YEAR'];
            $XmlData->save();
        }

    }

    private function orderXml($urlManager, $urlBuc, $name, $i=0, $all_data = array()){

        $date = $this->orderDate($name);

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

        $xml   = simplexml_load_file($urlBuc);
        $json  = json_encode($xml);
        $array = json_decode($json, TRUE);

        foreach ($array['LIST_G_ROOM']['G_ROOM'] as $value){
            if (
                $value['MARKET_CODE'] == 'CNT'
            ){
                $i++;
            }
        }

        $all_data['OCC_ROOMS_TIME_SHARE']['DAY']   = $i;
        $all_data['OCC_MINUS_COMP_HU_TS']['DAY']   = $all_data['OCC_MINUS_COMP_HU']['DAY'] - $all_data['OCC_ROOMS_TIME_SHARE']['DAY'];
        $all_data['OCC_PERC_TS']['DAY']            = $all_data['OCC_ROOMS_TIME_SHARE']['DAY'] / $all_data['PHYSICAL_ROOMS']['DAY'] * 100;
        $all_data['OCC_PERC_WO_CHTS']['DAY']       = $all_data['OCC_MINUS_COMP_HU_TS']['DAY'] / $all_data['PHYSICAL_ROOMS']['DAY'] * 100;
        if ($all_data['OCC_MINUS_COMP_HU_TS']['DAY'] != 0){
            $all_data['ADR_ROOM_WO_CHTS']['DAY']   = $all_data['ROOM_REVENUE']['DAY'] / $all_data['OCC_MINUS_COMP_HU_TS']['DAY'];
        }else{
            $all_data['ADR_ROOM_WO_CHTS']['DAY']   = 0;
        }
        $all_data['REV_PAR']['DAY']                = $all_data['ADR_ROOM_WO_CHTS']['DAY'] * $all_data['OCC_PERC_WO_O']['DAY'] / 100;

        $all_data['OCC_ROOMS_TIME_SHARE']['MONTH'] = "";
        $all_data['OCC_MINUS_COMP_HU_TS']['MONTH'] = "";
        $all_data['OCC_PERC_TS']['MONTH']          = "";
        $all_data['OCC_PERC_WO_CHTS']['MONTH']     = "";
        $all_data['ADR_ROOM_WO_CHTS']['MONTH']     = "";
        $all_data['REV_PAR']['MONTH']              = "";

        $all_data['OCC_ROOMS_TIME_SHARE']['YEAR']  = "";
        $all_data['OCC_MINUS_COMP_HU_TS']['YEAR']  = "";
        $all_data['OCC_PERC_TS']['YEAR']           = "";
        $all_data['OCC_PERC_WO_CHTS']['YEAR']      = "";
        $all_data['ADR_ROOM_WO_CHTS']['YEAR']      = "";
        $all_data['REV_PAR']['YEAR']               = "";

        $this->updateXmlReport($date, $all_data);
    }

    public function handle()
    {
        $directories = $this->dirScan('Z:\\', 'first');
        if ($directories != false){
            foreach ($directories as $directory) {
                $fileBuc = "Z:\\" . $directory . "\buc_chk_exc.xml";
                $fileManager = "Z:\\" . $directory . "\manager.xml";
                if (
                    file_exists($fileBuc) AND file_exists($fileManager) == true
                ) {
                    $this->orderXml($fileManager, $fileBuc, $directory);
                }
            }
        }
    }
}
