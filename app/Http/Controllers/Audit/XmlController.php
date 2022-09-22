<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

use App\Models\Audit\Xml\XmlHistoryReport;

class XmlController extends Controller
{
    public function index(){
        return view('audit.reports.index'); 
    }

    public function show($xml){
        $date = XmlHistoryReport::where('id', $xml)->value('date');
        return view('audit.reports.show', compact('xml', 'date'));
    }

    public function update_date(){
        $reports = XmlHistoryReport::get();

        foreach ($reports as $report) {
            $chara = explode("/", $report->folder);
            $order = $chara[0] . "-" . 
                    $chara[1] . "-20" . 
                    $chara[2];
            $newDate = date("Y-m-d",strtotime($order."+ 1 days"));
            XmlHistoryReport::select('*')
                ->where('id', $report->id)
                ->update(['date' => $newDate]);
        }
    }
}
