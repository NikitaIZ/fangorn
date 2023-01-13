<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\PersonalModel;
use App\Models\Security\PersonalIOLog as PersonalIOLogModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PersonalIOLog extends Controller
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */


     public function __construct()
     {
         $this->middleware('can:personal.create_io_log')->only('store_view', 'store');
     }

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
            return view("security/personal_io_log/register",[
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
            "type" => "required",
            "description" => "required|max:256"
        ]);
        try {
            $personal = PersonalModel::where("id",$personal_id)->get()->first();
            
            if($personal){
                $new_log = new PersonalIOLogModel();
                $new_log->type = $request->type;
                $new_log->description = $request->description;
                $new_log->personal_id = $personal->id;
                $new_log->created_by = Auth::user()->id;
                $new_log->save();

                $response["message"] = "Registro creado con exito!";
                $response["status"] = "Successfull";
                
                return redirect()->route("security.personal_io_log.register.get",$personal_id)->with("response",$response);
            }
            
        
        } catch (\Throwable $th) {
            $response["message"] = "Hubo un error creando el registro!";
            $response["status"] = "Unsuccess";
            return redirect()->route("security.personal_io_log.register.get",$personal_id)->with("response",$response);
        }
    }
}
