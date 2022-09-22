<?php

namespace App\Http\Controllers\CCTV;

use DateTime;
use DateTimeZone;

use App\Models\Tanks\Tank;
use App\Models\Tanks\TankReport;
use App\Models\Views\ViewTankReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReportTankController extends Controller
{

    public function create(){
        $tanks = Tank::all();
        return view('tanks.create-report', compact('tanks'));
    }

    public function store(Request $request){
        $reports = new TankReport();

        $reports->user_id     = Auth::user()->currentTeam->id;
        $reports->tank_id     = $request->tanque;
        $reports->liters      = $request->litros;
        $reports->description = $request->descripcion;

        $reports->save();

        return redirect()->route('tanks.index');
    }

    public function show($tank){
        return view('tanks.show', compact('tank'));
    }
}
