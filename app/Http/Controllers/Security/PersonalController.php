<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Security\PersonalModel;
use App\Models\User as UserModel;
use App\Models\Security\AreaModel;
use App\Models\Security\PositionModel;
use Illuminate\Http\Response;


use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Image;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Security\QRController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Security\PersonalIOLog as PersonalIOLogModel;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Crypt;

class PersonalController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('can:personal.show')->only('index','show');
        $this->middleware('can:personal.create')->only('store_view', 'store');
        $this->middleware('can:personal.edit')->only('update_view', 'update');
    }




    public function index(){
        return view("security/personal/index");
    }

    //Toma un timestamp y lo convierte a la hora zona horario especificada.
    private function setTMZ($timestamp){
        $date = new DateTime($timestamp);
        $date->setTimezone(new DateTimeZone("America/Caracas"));
        return $date->format('Y-m-d H:i:sP');
    }



    private function storePhoto($photo,$filename){

        //se encarga de guardar la foto en la carpeta especificada.
        $path = "/personal_photos/$filename";
        \Storage::disk('public')->put($path,$photo);
    }

    

    public function store_view(){
            
        //Obtiene todas las areas y posiciones disponibles y las muestra.
        $positions = PositionModel::all();
        $areas = AreaModel::all();

        return view("security/personal/register",[
            "positions" => $positions,
            "areas" => $areas
        ]);
    }


    //Registra un nuevo personal.
    public function store(Request $request){
        

        //falta agregar validacion. en el cliente.
        
        $validated = $request->validate([
            "Nombre" => "required|max:64",
            "Apellido" => "required|max:64",
            "Cargo" => "required",
            "Area" => "required",
            "Identificacion" => "required|integer",
            "Foto" => "required|image|mimes:png,jpg,jpeg|max:2048"
        ]);



        
        
        $photo = $request->Foto;

        //convierte la foto enviada en png.
        $convertedPhoto = Image::make($photo)->resize(128,128)->stream("png");

        //Guarda un mensaje para ser mostrado segun el estado de la consulta.
        //y el estado de la consulta como tal.

        $response = [
            "message" => "",
            "status" => "",
        ];

        
        
        //inicializa el modelo de personal para se guardado en la base de datosw.
        $new_personal = new PersonalModel();

        $new_personal->name = $request->Nombre;
        $new_personal->last_name = $request->Apellido;
        $new_personal->position_id = $request->Cargo;
        $new_personal->area_id = $request->Area;
        $new_personal->state = 1;
        $new_personal->warn_count = 0;
        $new_personal->identification = $request->Identificacion;

        //Obtiene el ID del usuario que esta logeado actualmente y lo guarda.
        $new_personal->created_by_id = Auth::user()->id;


        //Si ya existe enviara un mensaje de error, de otra forma guarda el personal.
        $validation = PersonalModel::where("identification",$new_personal->identification)->get()->first();
        $validate_area = AreaModel::where("id",$request->Area)->get()->first();
        $validate_position = PositionModel::where("id",$request->Cargo)->get()->first();
        $validate_created_by = UserModel::where("id",Auth::user()->id)->get()->first();

        //Valida que el area enviada exista.
        if(!$validate_area){
            $response["message"] = "Ingrese un area existente!";
            $response["status"] = "Unsuccess";
        }
        //Valida que el cargo o position exiata.
        else if(!$validate_position){
            $response["message"] = "Ingrese un cargo existente!";
            $response["status"] = "Unsuccess";
        }
        //Valida que el usuario que esta creando el personal este registrado.
        else if(!$validate_created_by){
            $response["message"] = "Debe estar registrado en el sistema para ingresar un personal!";
            $response["status"] = "Unsuccess";
        }
        //Verifica que el usuario no se encuentre ya registrado.
        else if($validation){
            $response["message"] = "Ya existe un registro con esa identificacion!";
            $response["status"] = "Unsuccess";
        }
        else{
            //Se guarda la foto y el registro y se genera el QR.
            $new_personal->save();
            

            //Datos para guardar en el QR.
            $encryptedData = Crypt::encryptString(json_encode([
                "personal_id" => $new_personal->id
            ]));
            $this->storePhoto(
                $convertedPhoto,
                "photo-$new_personal->identification.png"
            );

            $response["message"] = "Registro completado!";
            $response["status"] = "Successfull";
            return redirect()->route("security.personal.get",$new_personal->id);
        }
        
        return redirect()->route("security.personal.register.get")->with("response",$response);
        return view("security/personal/register",[
            "response" => $response,
            "areas" => [],
            "positions" => []
        ]);
    }

    //Vista para modificar los datos de un persona.

    public function update_show($personal_id){

        
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
            'positions.id as position_id',
            'positions.name as position_name',
        )
        ->get()->first();

        $areas = AreaModel::select("id","name")->get();
        $positions = PositionModel::select("id","name")->get();

        if($personal){
            return view("security/personal/update",[
                "personal" => $personal,
                "areas" => $areas,
                "positions" => $positions
            ]);
        }

        $response["message"] = "El registro no existe!";
        $response["status"] = "Unsuccess";
        return redirect()->route("security.index")->with("response",$response);

        
    }

    //Modifica el personal con los datos enviados.

    public function update(Request $request,$personal_id){

        $response = [
            "message" => "",
            "status"=>""
        ];
        $validated = $request->validate([
            "Nombre" => "required|max:64",
            "Apellido" => "required|max:64",
            "Cargo" => "required",
            "Area" => "required",
            "Identificacion" => "required|integer",
            "Foto" => "image|mimes:png,jpg,jpeg|max:2048"
        ]);

        $photo = $request->Foto;
        
        
        $personal = PersonalModel::where("id",$personal_id)->get()->first();
        $validate_ced = PersonalModel::where("identification",$request->Identificacion)->get()->first();

        if(!$personal){
            $response['message'] = "El usuario no se encuentra registrado.";
            $response['status'] = "Unsuccess";
            return redirect()->route("security.index")->with("response",$response);
        }
        else if($validate_ced && (int)$request->Identificacion !== $personal->identification){
            $response['message'] = "La cedula ya se encuentra registrada.";
            $response['status'] = "Unsuccess";
        }
        else{

            if($photo){
                $convertedPhoto = Image::make($photo)->resize(128,128)->stream("png");
                $this->storePhoto(
                    $convertedPhoto,
                    "photo-$personal->identification.png"
                );
            }
            $personal->name = $request->Nombre;
            $personal->last_name = $request->Apellido;
            $personal->position_id = $request->Cargo;
            $personal->area_id = $request->Area;
            $personal->identification = $request->Identificacion;
            $personal->save();

            $response["message"] = "Actualizacion exitosa!";
            $response['status'] = "Successfull";
        }


        return redirect()->route("security.personal.update.get",$personal->id)->with("response",$response);

    }

    

    
    public function show($personal_id){
        $personal = DB::table("personals")->where("personals.id",$personal_id)
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
            return view("security/personal/show",["personal" => $personal]);
        }

        $response["message"] = "El registro no existe!";
        $response['status'] = "Unsuccess";
        return redirect()->route("security.index")->with("response",$response);
    }
}
