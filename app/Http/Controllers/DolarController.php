<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Dolar;
use App\Models\Xml\XmlReport;

class DolarController extends Controller
{
    public function index(){
        return view('dolar.index');
    }

    public function update(Request $request){
        $validate = Dolar::where('date', $request->date)->value('daily_rate');
        if ($validate) {
            Dolar::select('*')
                    ->where('date', $request->date)
                    ->update(['daily_rate' => $request->daily_rate,
                                'user_id' => Auth::user()->currentTeam->id]);
        }else{
            $date = date("d/m/y",strtotime($request->date."- 1 days"));
            $id = XmlReport::where('date', $date)->value('id');

            $dolars = new Dolar();

            $dolars->user_id    = Auth::user()->currentTeam->id;
            $dolars->report_id  = $id;
            $dolars->daily_rate = $request->daily_rate;
            $dolars->date       = $request->date;

            $dolars->save();
            
        }

        return redirect()->route('dolar.index')->with('info', 'Tasa añadida');
    }

    public function destroy($id){
        Dolar::destroy($id);
        return redirect()->route('dolar.index')->with('delete', 'Tasa eleiminada Eliminado');
    }
}
