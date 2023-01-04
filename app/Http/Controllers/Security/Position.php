<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\Position as PositionModel;
use App\Models\Security\Personal as PersonalModel;
class Position extends Controller
{
    //




    public function store(Request $request){

        //valida que esten todos los campos.
        $validated = $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        $response = [
            "message" => "",
            "status" => ""
        ];



        try {
            PositionModel::create($validated);
            $response["message"] = "Registro completado!";
            $response["status"] = "Successfull";
        } catch (\Throwable $th) {
            $response["message"] = "Hubo un error y no se pude registrar el cargo.";
            $response["status"] = "Unsuccess";
        }

        return view("security/position/register",["response"=>$response]);

    }

    public function update_show($position_id){
        $position = PositionModel::where("id",$position_id)->get()->first();

        if($position){
            return view("security/position/update",["position" => $position]);
        }
        $response["message"] = "El registro no existe!";
        $response["status"] = "Unsuccess";
        return redirect()->route("security.position.index")->with("response",$response);
    }

    public function update(Request $request,$position_id){

        $validated = $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        $response = [
            "message" => "",
            "status" => ""
        ];

        $position = PositionModel::where("id",$position_id)->get()->first();

        if($position){
            
            $position->name = $request->name;
            $position->description = $request->description;

            $position->save();

            $response["message"] = "Actualizacion exitosa!";
            $response['status'] = "Successfull";

            return view("security/position/update",[
                "position" => $position,
                "response" => $response
            ]);
        }
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.position.index")->with("response",$response); 
        
    }

    public function delete_show($position_id){
        $position = PositionModel::where("id",$position_id)->get()->first();

        if($position){
            return view("security/position/delete",[
                "position" => $position
            ]);
        }
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.position.index")->with("response",$response);
        
    }

    public function delete($position_id){

        $position = PositionModel::where("id",$position_id)->get()->first();

        if($position){
            $validated = PersonalModel::where("position_id",$position->id)->get()->first();
            if($validated){
                $response["message"] = "El registro no puede ser  eliminado.";
                $response['status'] = "Unsuccess";
                return redirect()->route("security.position.index")->with("response",$response);
            }

            $position->delete();
            $response["message"] = "Eliminacion exitosa!";
            $response['status'] = "Successfull";
            return redirect()->route("security.position.index")->with("response",$response);
        }
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.position.index")->with("response",$response);
    }
}
