<?php

namespace App\Http\Controllers\Reserves;

use App\Http\Controllers\Controller;

use App\Models\Reserves\Event;
use App\Models\Reserves\EventArea;
use App\Models\Reserves\EventBooking;


class dinnersController extends Controller
{
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

        foreach ($data["Cena Navideña"] as $value) {
            if ($value['status'] == "wc-completed") {
                $status = 1;
            }else{
                $status = 2;
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
                $booking->status = $status;
                $booking->save();
            }
        }

        foreach ($data["Cena de Año Nuevo"] as $value) {
            if ($value['status'] == "wc-completed") {
                $status = 1;
            }else{
                $status = 2;
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
                $booking->status = $status;
                $booking->save();
            }
        }
    }

    private function orden($date = 1, $status = 'completed'){

        $sales = array(); $dates = array(); $adults = array(); $childrem = array(); $groups = array(); $prices = array();

        $groups = EventBooking::select('area')->where('event_id', $date)->where('status', $status)->orderBy('area', 'asc')->groupBy('area')->get()->toArray();
        $prices_a = EventBooking::select('price_adult AS price')->where('event_id', $date)->where('status', $status)->orderBy('price_adult', 'desc')->groupBy('price_adult')->get()->toArray();
        $prices_c = EventBooking::select('price_childrem AS price')->where('event_id', $date)->where('status', $status)->orderBy('price_childrem', 'desc')->groupBy('price_childrem')->get()->toArray();

        foreach ($groups as $key => $value) {
            $groups[$key]['volume'] = EventArea::where('event_id', $date)->where('name', $value['area'])->value('volume');
            $groups[$key]['count']  = EventBooking::where('event_id', $date)->where('status', $status)->where('area', $value['area'])->count();
        }

        foreach ($prices_a as $key => $value) {
            $prices_a[$key]['count'] = EventBooking::where('event_id', $date)->where('status', $status)->where('price_adult', $value['price'])->count();
        }

        foreach ($prices_c as $key => $value) {
            $prices_c[$key]['count'] = EventBooking::where('event_id', $date)->where('status', $status)->where('price_childrem', $value['price'])->count();
        }

        $prices = array_merge($prices_a, $prices_c);

        $array = EventBooking::where('event_id', $date)->where('status', $status)->get()->toArray();

        foreach ($array as $key => $value) {
            $adults[$key] = $value["adults"];
            $childrem[$key] = $value["childrem"];
            $sales[$key] = $value["total"];
            $dates[$key] = date("d/m/y", strtotime($value["created_at"]));
        }

        $data = array(
            "balance" => Event::where('id', $date)->value('balance_point'),
            "sales"   => array(
                "data"     => $sales,
                "labels"   => $dates,
                "adults"   => $adults,
                "childrem" => $childrem
            ),
            "groups"   => $groups,
            "prices"   => $prices,
            "total"    => EventBooking::where('event_id', $date)->where('status', $status)->sum('total'),
            "adults"   => EventBooking::where('event_id', $date)->where('status', $status)->sum('adults'),
            "childrem" => EventBooking::where('event_id', $date)->where('status', $status)->sum('childrem'),
            "quantity" => EventBooking::where('event_id', $date)->where('status', $status)->count(),
        );

        return $data;
    }

    private function balancePoint($array = array(), $i = 0){
        $point = array(
            "initial" => $array['balance'],
            "current" => -$array['balance']
        );

        $date = array_unique($array["sales"]["labels"]);

        foreach ($date as $value) {
            $point["date"][$i] = $value;
            $point["data"][$i] = 0;
            $i++;
        }

        if ($date != null) {
            foreach ($point["date"] as $key1 => $value1) {
                foreach ($array["sales"]["labels"] as $key2 => $value2) {
                    if ($value2 == $value1) {
                        $point["data"][$key1] += $array["sales"]["data"][$key2];
                    }
                }
            }

            foreach ($point["data"] as $key => $value) {
                $point["meta"][$key] = $point["current"] + $value;
                $point["perc"][$key] = $point["meta"][$key] / $point["initial"] * 100;
                $point["current"] = $point["current"] + $value;
            }
        }

        return $point;
    }


    function index(){

        //$this->update_booking();
        //$date = date("Y-24-31", strtotime($date));

        $data["christmas"] = $this->orden(Event::where('date', date("2021-12-24"))->value('id'));
        $data["new_year"]  = $this->orden(Event::where('date', date("2021-12-31"))->value('id'));

        $total = array(
            0 => $data["christmas"]["total"] + $data["new_year"]["total"],
            1 => $data["christmas"]["total"] ,
            2 => $data["new_year"]["total"]
        );

        $point["christmas"] = $this->balancePoint($data["christmas"]);
        $point["new_year"]  = $this->balancePoint($data["new_year"]);

        return view('reserves.index', compact('data', 'total', 'point'));
    }

    private function total($date = 1, $status = "completed") {
        $data = array(
            0 => EventBooking::where('event_id', $date)->where('status', $status)->sum('total'),
            1 => EventBooking::where('event_id', $date)->where('status', $status)->sum('adults'),
            2 => EventBooking::where('event_id', $date)->where('status', $status)->sum('childrem'),
            3 => EventBooking::where('event_id', $date)->where('status', $status)->count(),
        );
        return $data;
    }

    function christmas(){
        $data = EventBooking::where('event_id', 1)->get()->toArray();
        $total["completed"] = $this->total(1, "completed");
        $total["hold"]      = $this->total(1, "on hold");

        return view('reserves.christmas', compact('data', 'total'));
    }

    function newYear(){
        $data = $this->connection();
        $data = $data["Cena de Año Nuevo"];
        $total["completed"] = $this->total($data, "wc-completed");
        $total["hold"]      = $this->total($data, "wc-on-hold");

        return view('reserves.new-year', compact('data', 'total'));
    }
}
