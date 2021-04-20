<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xml\XmlHeading;
use App\Models\Xml\XmlData;
use App\Models\Xml\XmlReport;
use App\Models\Views\ViewXmlReport;

class XmlController extends Controller
{
    public function index(){
        $reports = XmlReport::orderby('id', 'desc')->paginate();
        return view('xmls.index', compact('reports')); 
    }

    public function createXml(){

    }

    public function show($xml){
        $data = ViewXmlReport::select('*')->where('ID', $xml)->get();
        return view('xmls.show', compact('xml', 'data'));
    }
}
