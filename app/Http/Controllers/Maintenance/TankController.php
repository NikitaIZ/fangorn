<?php

namespace App\Http\Controllers\Maintenance;

use DateTime;
use DateTimeZone;

use App\Models\Tanks\Tank;
use App\Models\Views\ViewTankReport;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TankController extends Controller
{
    public function index(){
        $data = ViewTankReport::data();
        $reports = ViewTankReport::paginate(10);
        foreach ($reports as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s',
                                                $value['Actualizado'],
                                                new DateTimeZone('UTC'));
            $date->setTimeZone(new DateTimeZone('America/Caracas'));
            $value['Actualizado'] = $date->format('Y-m-d g:i A');
        }
        return view('tanks.index', compact('reports', 'data'));
    }

    public function create(){
        $tanks = Tank::all();
        return view('tanks.create-tank', compact('tanks'));
    }

    public function store(Request $request){
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
