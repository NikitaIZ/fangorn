<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\Security\PersonalModel;
use Illuminate\Support\Facades\DB;

class QRController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('can:personal.qr')->only('index','scan','downloadQrAsPng','createAndSaveQr',);
        $this->middleware('can:personal.create')->only('createAndSaveQr');
    }


    public function index(){
        return view("security/qrScanner/index");
    }

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


    public function downloadQrAsPng($encryptedData){
        $qrcode = \QrCode::format("png")->size(150)->generate($encryptedData);
        $filename = (array) json_decode(Crypt::decryptString($encryptedData));
        $filename = 'qr-'.$filename['personal_id'];
        $path = "/qr-code/$filename.png";
        \Storage::disk("public")->put($path,$qrcode); 
        $headers = array(
            'Content-Type: application/png',
            );

        $pb =  public_path('storage/'.$path);
        $filename = "$filename.png";
        return \Response::download($pb,$filename,$headers)->deleteFileAfterSend(true);
    }


    //Se encarga de crear el Qr y guardarlo en la carpeta public.
    public static function createAndSaveQr($data,$identification){
        $qr_code = QrCode::format("svg")->generate(json_encode($data));
        $file_to_save =  "/qr-code/qrcode-".$identification.".svg";
        Storage::disk('public')->put($file_to_save,$qr_code);
    }

}
