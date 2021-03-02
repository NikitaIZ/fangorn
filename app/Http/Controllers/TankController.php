<?php

namespace App\Http\Controllers;

use App\Models\Tank;
use App\Models\TankReport;
use App\Models\Views\ViewTankReport;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TankController extends Controller
{
    public function index(){
        $reports = ViewTankReport::paginate();

        foreach ($reports as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s',
                                                $value['Actualizado'],
                                                new DateTimeZone('UTC')
                                               );
            $date->setTimeZone(new DateTimeZone('America/Caracas'));
            $value['Actualizado']=$date->format('Y-m-d H:i:s');
        }

        return view('tanks.index', compact('reports'));
    }

    public function createReport(){
        $tanks = Tank::all();
        return view('tanks.create-report', compact('tanks'));
    }

    public function updateReport(Request $request){
        $reports = new TankReport();

        $reports->user_id     = Auth::user()->currentTeam->id;
        $reports->tank_id     = $request->tanque;
        $reports->liters      = $request->litros;
        $reports->description = $request->descripcion;

        $reports->save();

        return redirect()->route('tanks.index');
    }

    public function createTank(){
        $tanks = Tank::all();
        return view('tanks.create-tank', compact('tanks'));
    }

    public function updateTank(Request $request){
        $tanks = new Tank();

        $tanks->location = $request->ubicacion;
        $tanks->capacity = $request->capacidad;

        $tanks->save();

        return redirect()->route('tanks.index');
    }

    public function show($tank){
        return view('tanks.show', compact('tank'));
    }
}
