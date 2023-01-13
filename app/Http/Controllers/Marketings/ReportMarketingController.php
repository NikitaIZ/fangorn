<?php

namespace App\Http\Controllers\Marketings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportMarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mk_reports.show')->only('index');
    }

    public function index(){
        return view('marketing.reports.index');
    }
}
