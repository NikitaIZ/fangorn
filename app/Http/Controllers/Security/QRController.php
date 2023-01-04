<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\Security\Personal as PersonalModel;
use Illuminate\Support\Facades\DB;

class QRController extends Controller
{
    //


    public function scan($encryptedData){
        $response = [
            "message" => "",
            "status" => "",
        ];
        try {
            $data = (array) json_decode(Crypt::decryptString($encryptedData));
            return redirect()->route("security.personal.get",$data['personal_id']);

        } catch (\Throwable $th) {
            $response["message"] = "Invalid QR";
            $response["status"] = "Unsuccess";
            return redirect()->route("security.qrScanner.index")->with("response",$response);
        }
    }


    //Se encarga de crear el Qr y guardarlo en la carpeta public.
    public static function createAndSaveQr($data,$identification){
        $qr_code = QrCode::format("svg")->generate(json_encode($data));
        $file_to_save =  "/qr-code/qrcode-".$identification.".svg";
        Storage::disk('public')->put($file_to_save,$qr_code);
    }

    //Se encarga de asignar un codigo QR.
    public function generatePersonalQr($personal_id){
        $response = [
            "message" => "",
            "status" => "",
        ];
        

        $personal = PersonalModel::where("id",$personal_id)->get()->first();
        if($personal){
            
            $encryptedData = Crypt::encryptString(json_encode([
                "personal_id" => $personal_id
            ]));
            QRController::createAndSaveQr($encryptedData,$personal->identification);
            $response["message"] = "Codigo generado exitosamente!";
            $response["status"] = "Successfully";
            return redirect()->route("security.personal.get",$personal->id);

        }
        $response["message"] = "El usuario no existe!";
        $response["status"] = "Unsuccess";
        return redirect()->route("security.index")->with("response",$response);
    }
}
