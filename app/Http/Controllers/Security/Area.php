<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\Area as AreaModel;

use App\Models\Security\Personal as PersonalModel;

class Area extends Controller
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
            AreaModel::create($validated);
            $response["message"] = "Registro completado!";
            $response["status"] = "Successfull";
        } catch (\Throwable $th) {
            $response["message"] = "Hubo un error y no se pude registrar el area.";
            $response["status"] = "Unsuccess";
        }

        return view("security/area/register",["response"=>$response]);

    }


    public function update_show($area_id){

        //Se obtiene el area actual y si existe se muestran los datos.
        $area = AreaModel::where("id",$area_id)->get()->first();

        if($area){
            return view("security/area/update",["area" => $area]);
        }
        $response["message"] = "El registro no existe!";
        $response["status"] = "Unsuccess";
        return redirect()->route("security.area.index")->with("response",$response);
    }

    public function update(Request $request,$area_id){


        //Se valida que en la peticion esten ambos campos.
        $validated = $request->validate([
            "name" => "required",
            "description" => "required",
        ]);

        //Se inicializa una respuesta.
        $response = [
            "message" => "",
            "status" => ""
        ];

        
        $area = AreaModel::where("id",$area_id)->get()->first();
        //Se verifica si existe el area.
        if($area){

            //Se actualizan los campos y se guarda.
            $area->name = $request->name;
            $area->description = $request->description;

            $area->save();


            //Mensaje de eexito.
            $response["message"] = "Actualizacion exitosa!";
            $response['status'] = "Successfull";

            return view("security/area/update",[
                "area" => $area,
                "response" => $response
            ]);
        }

        //Mensaje de error, redireccionado a la pagina de inicio.
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.area.index")->with("response",$response); 
        
    }


    public function delete_show($area_id){

        //Se obtiene el area actual y se muestran los datos.
        $area = AreaModel::where("id",$area_id)->get()->first();

        //Se verifica si existe para mostrar.
        if($area){
            return view("security/area/delete",[
                "area" => $area
            ]);
        }
        //Si no se redirecciona.
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.area.index")->with("response",$response);
        
    }

    public function delete($area_id){


        //Se encarga de eliminar las areas con el ID indicado.

        //Obtiene el area con el id indicado.
        $area = AreaModel::where("id",$area_id)->get()->first();

        //Se verifica si el area existe.
        if($area){
            $validated = PersonalModel::where("area_id",$area->id)->get()->first();
            if($validated){
                $response["message"] = "El registro no puede ser  eliminado.";
                $response['status'] = "Unsuccess";
                return redirect()->route("security.area.index")->with("response",$response);
            }
            //Se elimina de la base de datos y luego se envia un mensaje de exito.
            $area->delete();
            $response["message"] = "Eliminacion exitosa!";
            $response['status'] = "Successfull";
            return redirect()->route("security.area.index")->with("response",$response);
        }
        //Si no existe, se redirecciona a la pagina de inicio de la seccion actual.
        //Con un mensaje de error.
        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.area.index")->with("response",$response);
    }
}
