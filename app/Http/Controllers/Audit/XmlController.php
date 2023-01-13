<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;

use App\Models\Audit\Xml\XmlHistoryReport;

class XmlController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:au_reports.show')->only('index', 'show');
    }

    public function index(){
        return view('audit.reports.index'); 
    }

    public function show($xml){
        $date = XmlHistoryReport::where('id', $xml)->value('date');
        return view('audit.reports.show', compact('xml', 'date'));
    }
}
