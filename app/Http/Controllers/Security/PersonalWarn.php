<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Security\PersonalWarn as PersonalWarnModel;
use App\Models\Security\Personal as PersonalModel;
class PersonalWarn extends Controller
{
    //



    public function store_view($personal_id){
        
        $personal = DB::table("personals")
        ->where("personals.id",$personal_id)
        ->leftJoin("areas","areas.id","=","personals.area_id")
        ->leftJoin("positions","positions.id","=","personals.position_id")
        ->select(
            'personals.name as name',
            'personals.last_name as last_name',
            'personals.identification as identification',
            'personals.state as state',
            'personals.id as personal_id',
            'areas.id  as area_id',
            'areas.name as area_name',
            'areas.description as area_description',
            'positions.id as position_id',
            'positions.name as position_name',
            'positions.description as position_description'
        )
        ->get()->first();
        if($personal){
            return view("security/personal_warn/register",[
                "personal" => $personal
            ]);
        }

        return redirect()->route("security.index");
    }

    public function store(Request $request,$personal_id){

        
        $response = [
            "message" => "",
            "status" => ""
        ];
        $validated = $request->validate([
            "razon" => "required",
            "descripcion" => "required|max:256"
        ]);
        try {
            $personal = PersonalModel::where("id",$personal_id)->get()->first();
            
            if($personal){
                $personal->warn_count++;
            
                if($personal->warn_count == 1){
                    $personal->state = 2;
                }
                else if($personal->warn_count == 2){
                    $personal->state = 3;
                }
                else if($personal->warn_count == 3){
                    $personal->state = 4;
                }
                else if($personal->warn_count >= 4){
                    $personal->state = 5;
                }
               

                $new_log = new PersonalWarnModel();
                $new_log->title = $request->razon;
                $new_log->description = $request->descripcion;
                $new_log->personal_id = $personal->id;
                $new_log->created_by = Auth::user()->id;
                $new_log->save();
                $personal->save();

                $response["message"] = "Registro creado con exito!";
                $response["status"] = "Successfull";
                
                return redirect()->route("security.personal_warn.register.get",$personal_id)->with("response",$response);
            }


            
        
        } catch (\Throwable $th) {
            $response["message"] = "Hubo un error creando el registro!";
            $response["status"] = "Unsuccess";
            return redirect()->route("security.personal_warn.register.get",$personal_id)->with("response",$response);
        }
    }
}
