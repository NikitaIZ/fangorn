<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xml\XmlHeading;
use App\Models\Xml\XmlData;
use App\Models\Xml\XmlReport;


class XMLController extends Controller
{
    private function date($url){
        $link = str_replace('xml/', '', $url);
        $groups = explode('/', $link);
        $date = $groups[count($groups) - 2];
        return $date;
    }

    private function heading($name){
        $table = XmlHeading::select('*')->where('name', $name)->get();

        foreach ($table as $dato){
            return $dato->id;
        }
        
    }

    private function upXml($id, $date, $array){
       /* $XmlReport = new XmlReport();
        $XmlReport->date     = $date;
        $XmlReport->document = $id;
        $XmlReport->save();
       foreach ($array as $key => $dato){
            $XmlData = new XmlData();
            $XmlData->report_id  = $XmlReport->id;
            $XmlData->heading_id = $this->heading($key);
            $XmlData->day        = $dato['DAY'];
            $XmlData->month      = $dato['MONTH'];
            $XmlData->year       = $dato['YEAR'];
            $XmlData->save();
        }*/
    }

    public function index(){

        $all_data = array();

        $url = "xml/020321/manager.xml";
        $xml = simplexml_load_file($url);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        $id   = $array['LIST_G_MASTER_VALUE_ORDER']['G_MASTER_VALUE_ORDER']['RESORT'];
        $data = $array['LIST_G_MASTER_VALUE_ORDER']['G_MASTER_VALUE_ORDER']['LIST_G_LAST_YEAR_01']['G_LAST_YEAR_01']['LIST_G_CROSS']['G_CROSS']['LIST_G_MASTER_VALUE']['G_MASTER_VALUE'];
                
        foreach ($data as $value) {
            $title= $value['SUB_GRP_1'];
            $time = $value['LIST_G_HEADING_1_ORDER']['G_HEADING_1_ORDER'];

            foreach ($time as $value) {
                if ($value['LIST_G_SUM_AMOUNT']['G_SUM_AMOUNT']['SUM_AMOUNT'] != null){
                    $all_data[$title][$value['HEADING_2']] = $value['LIST_G_SUM_AMOUNT']['G_SUM_AMOUNT']['SUM_AMOUNT'];
                }
                else{
                    $all_data[$title][$value['HEADING_2']] = '';
                }
            }
        }

        $date = $this->date($url);

        $this->upXml($id, $date, $all_data);
    }
}
