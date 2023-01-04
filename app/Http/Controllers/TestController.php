<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHeading;
use App\Models\Audit\Xml\XmlHistoryData;
use App\Models\Audit\Xml\XmlHistoryReport;
use App\Models\Audit\Xml\XmlForecastData;
use App\Models\Audit\Xml\XmlForecastDate;
use App\Models\Audit\Xml\XmlForecastReport;
use App\Models\Reserves\EventBooking;

class TestController extends Controller
{
    public function index(){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $json = json_decode(file_get_contents("http://10.80.22.172:8085/wp-json/wyndham/v1/ReservaFiestas/Reporte", true, stream_context_create($arrContextOptions)), true);
        $data = json_decode($json, true);

        foreach ($data["Cena de Año Nuevo"] as $value) {
            if ($value['status'] == "wc-completed") {
                $status = "completed";
            }elseif($value['status'] == "wc-cancelled"){
                $status = "cancelled";
            }else{
                $status = "on hold";
            }
            if (EventBooking::where('order_id', $value['orderId'])->doesntExist()) {
                $sell = new EventBooking();
                $sell->event_id       = 4;
                $sell->order_id       = $value['orderId'];
                $sell->client         = $value['cliente'];
                $sell->adults         = $value['adultos'];
                $sell->childrem       = $value['niños'];
                $sell->subtotal       = $value['subtotal'];
                $sell->coupon         = $value['cupon'];
                $sell->total          = $value['total'];
                $sell->price_adult    = $value['precio'];
                $sell->price_childrem = $value['precio'] / 2;
                $sell->area           = $value['grupo'];
                $sell->seats          = $value['seats'];
                $sell->status         = $status;
                $sell->created_at     = $value['fecha'];
                $sell->save();
            }else{
                $booking = EventBooking::where('order_id', $value['orderId'])->get();
                if ($booking[0]->status != $status) {
                    $booking[0]->status = $status;
                    $booking[0]->save();
                }
            }
        }
    }

    public function store(Request $request){
    }

    public function show($month){
    }
}
