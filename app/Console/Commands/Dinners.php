<?php

namespace App\Console\Commands;

use App\Models\Reserves\EventBooking;
use Illuminate\Console\Command;

class Dinners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dinner:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar Cenas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function connection(){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $json = json_decode(file_get_contents("http://10.80.22.172:8085/wp-json/wyndham/v1/ReservaFiestas/Reporte", true, stream_context_create($arrContextOptions)), true);
        $data = json_decode($json, true);
        return $data;
    }

    private function update_booking(){
        $data = $this->connection();

        /*foreach ($data["Cena Navideña"] as $value) {
            if ($value['status'] == "wc-completed") {
                $status = "completed";
            }else{
                $status = "on hold";
            }
            if (EventBooking::where('order_id', $value['orderId'])->doesntExist()) {
                $sell = new EventBooking();
                $sell->event_id       = 3;
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
        }*/

        foreach ($data["Cena de Año Nuevo"] as $value) {
            if ($value['status'] == "wc-completed") {
                $status = "completed";
            }elseif($value['status'] == "wc-cancelled"){
                $status = "cancelled";
            }else{
                $status = "on hold";
            }

            switch ($value['name_cupon'] ) {
                case 'cortesia':
                    $coupon = 2;
                    break;

                case 'descuento50':
                    $coupon = 5;
                    break;

                case 'descuento25':
                    $coupon = 6;
                    break;

                case 'descuento20':
                    $coupon = 7;
                    break;

                case '3s9ffqdf':
                    $coupon = 8;
                    break;

                case 'descuento5':
                    $coupon = 9;
                    break;
                
                default:
                    $coupon = 1;
                    break;
            }

            if (EventBooking::where('order_id', $value['orderId'])->doesntExist()) {
                $sell = new EventBooking();
                $sell->event_id       = 4;
                $sell->order_id       = $value['orderId'];
                $sell->client         = $value['cliente'];
                $sell->adults         = $value['adultos'];
                $sell->childrem       = $value['niños'];
                $sell->coupon_id      = $coupon;
            $sell->coupon_description = "";
                $sell->subtotal       = $value['subtotal'];
                $sell->discount       = $value['cupon'];
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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->update_booking();
    }
}
