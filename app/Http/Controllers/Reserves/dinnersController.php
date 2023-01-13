<?php

namespace App\Http\Controllers\Reserves;

use App\Http\Controllers\Controller;

use App\Models\Reserves\Event;
use App\Models\Reserves\EventArea;
use App\Models\Reserves\EventBooking;

class DinnersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dinners')       ->only('index');
        $this->middleware('can:christmas.show')->only('christmas');
        $this->middleware('can:new_year.show') ->only('newYear');
    }

    private function orden($event, $year, $status = 'completed'){

        $day = date("d-m-Y");

        $date = date("Y-m-d", strtotime($day ." - ". $year ." year"));
        $today = date("Y-m-d", strtotime($date . "+ 1 days"));

        $sales = array(); $dates = array(); $adults = array(); $childrem = array(); $groups = array(); $prices = array(); $labels = array();

        $colors = array(
            0 => "bg-primary",
            1 => "bg-success",
            2 => "bg-warning",
            3 => "bg-danger",
            4 => "bg-info",
            5 => "bg-dark",
        );

        $groups   = EventArea::where('event_id', $event)->get()->toArray();
        $prices_a = EventBooking::select('price_adult AS price')->where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->where('status', $status)->orderBy('price_adult', 'desc')->groupBy('price_adult')->get()->toArray();
        $prices_c = EventBooking::select('price_childrem AS price')->where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->orderBy('price_childrem', 'desc')->groupBy('price_childrem')->get()->toArray();

        foreach ($groups as $key => $value) {
            $groups[$key]['color'] = $colors[$key];
            $groups[$key]['count'] = EventBooking::where('event_id', $event)->where('status', $status)->where('area', $value['name'])->where('created_at', '<=', $today)->sum('adults') + EventBooking::where('event_id', $event)->where('status', $status)->where('area', $value['name'])->where('created_at', '<=', $today)->sum('childrem');
            if ($groups[$key]['count'] > 0) {
                $groups[$key]['per'] = number_format($groups[$key]['count']/$value["volume"]*100, 0);
            }else{
                $groups[$key]['per'] = 0;
            }
        }

        foreach ($prices_a as $key => $value) {
            $prices_a[$key]['count'] = EventBooking::where('event_id', $event)->where('status', $status)->where('price_adult', $value['price'])->where('created_at', '<=', $today)->sum('adults');
        }

        foreach ($prices_c as $key => $value) {
            $prices_c[$key]['count'] = EventBooking::where('event_id', $event)->where('status', $status)->where('price_childrem', $value['price'])->where('created_at', '<=', $today)->sum('childrem');
        }

        $prices_all = array_merge($prices_a, $prices_c);

        foreach ($prices_all as $key => $value) {
            $prices['price'][$key] = $value['price'];
            $prices['count'][$key] = $value['count'];
        }

        $array = EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->orderBy('created_at', 'asc')->get()->toArray();

        foreach ($array as $key => $value) {
            $dates[$key] = date("Y-m-d", strtotime($value["created_at"]));
            $sales[$key] = $value["total"];
            $adults[$key] = $value["adults"];
            $childrem[$key] = $value["childrem"];
            $labels[$key] = date("d/m/y", strtotime($value["created_at"]));
        }

        $tikets   = round(EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->sum('adults') + EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->sum('childrem') / 2);
        $courtesy = round(EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 2)->where('created_at', '<=', $today)->sum('adults') + EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 2)->where('created_at', '<=', $today)->sum('childrem') / 2);
        $officers = round(EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 4)->where('created_at', '<=', $today)->sum('adults') + EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 4)->where('created_at', '<=', $today)->sum('childrem') / 2);
        $exchange = round(EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 3)->where('created_at', '<=', $today)->sum('adults') + EventBooking::where('event_id', $event)->where('status', $status)->where('coupon_id', 3)->where('created_at', '<=', $today)->sum('childrem') / 2);

        $variable = Event::where('id', $event)->value('factor') * $tikets;

        Event::where('id', $event)->update(['variable_cost' => $variable]);

        $balace_point = Event::where('id', $event)->value('variable_cost') + Event::where('id', $event)->value('fixed_cost');

        Event::where('id', $event)->update(['balance_point' => $balace_point]);

        $data = array(
            "balance" => Event::where('id', $event)->value('balance_point'),
            "sales"   => array(
                "data"     => $sales,
                "dates"    => $dates,
                "labels"   => $labels,
                "adults"   => $adults,
                "childrem" => $childrem
            ),
            "groups"   => $groups,
            "prices"   => $prices,
            "tickets"  => $tikets,
            "courtesy" => $courtesy,
            "officers" => $officers,
            "exchange" => $exchange,
            "coupons"  => $tikets - $courtesy - $officers - $exchange,
            "total"    => EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->sum('total'),
            "adults"   => EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->sum('adults'),
            "childrem" => EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->sum('childrem'),
            "quantity" => EventBooking::where('event_id', $event)->where('status', $status)->where('created_at', '<=', $today)->count(),
        );

        return $data;
    }

    private function balancePoint($array, $year, $i = 0){

        $day = date("d-m-Y");
        $today = date("Y-m-d", strtotime($day ." - ". $year ." year"));
        $dates = array_unique($array["sales"]["dates"]);

        $point = array(
            "total"   => $array['total'],
            "initial" => $array['balance'],
            "current" => -$array['balance'],
        );

        foreach ($dates as $value){
            if ($value <= $today) {
                $point["dato"][$i] = date("-m-d", strtotime($value));
                $point["date"][$i] = date("d/m/y", strtotime($value));
                $point["data"][$i] = 0;
                $i++;
            }
        }

        if ($dates != null) {
            foreach ($point["date"] as $key1 => $value1) {
                foreach ($array["sales"]["labels"] as $key2 => $value2) {
                    if ($value2 == $value1) {
                        $point["data"][$key1] += $array["sales"]["data"][$key2];
                    }
                }
            }

            foreach ($point["data"] as $key => $value) {
                $point["meta"][$key] = $point["current"] + $value;
                $point["perc"][$key] = $point["meta"][$key] / $point["total"] * 100;
                $point["current"] = $point["current"] + $value;
            }

        }else{
            $point["dato"][0] = date("-m-d", strtotime($today));
            $point["data"][0] = 0;
            $point["meta"][0] = $point["current"];
            $point["perc"][0] = 100;
            $point["current"] = $point["current"];
        }
        return $point;
    }

    private function unir($one_year, $two_year, $event, $data = array()){

        if ($event == "new_year") {
            $ids = array(0 => 2, 1 => 4);
        }else{
            $ids = array(0 => 1, 1 => 3);
        }

        $array = array_unique(array_merge($one_year, $two_year));
        sort($array, SORT_STRING);

        foreach ($array as $key => $value) {
            $data["dates"][$key] = date("d/m", strtotime('2021' . $value));
            $data["2021"][$key] = EventBooking::where('event_id', $ids[0])->where('status', 'completed')->where('created_at', 'LIKE', '%' . '2021' . $value. '%')->sum('total');
            $data["2022"][$key] = EventBooking::where('event_id', $ids[1])->where('status', 'completed')->where('created_at', 'LIKE', '%' . '2022' . $value. '%')->sum('total');

            if ($data["2021"][$key] == 0) {
                $data["2021"][$key] = null;
            }

            if ($data["2022"][$key] == 0) {
                $data["2022"][$key] = null;
            }
        }

        return $data;
    }

    public function index(){
        $data["christmas"]["2022"] = $this->orden(Event::where('date', date("2022-12-24"))->value('id'), 0);
        $data["christmas"]["2021"] = $this->orden(Event::where('date', date("2021-12-24"))->value('id'), 1);

        $data["new_year"]["2022"] = $this->orden(Event::where('date', date("2022-12-31"))->value('id'), 0);
        $data["new_year"]["2021"] = $this->orden(Event::where('date', date("2021-12-31"))->value('id'), 1);

        $point["christmas"]["2022"] = $this->balancePoint($data["christmas"]["2022"], 0);
        $point["christmas"]["2021"] = $this->balancePoint($data["christmas"]["2021"], 1);

        $point["new_year"]["2022"] = $this->balancePoint($data["new_year"]["2022"], 0);
        $point["new_year"]["2021"] = $this->balancePoint($data["new_year"]["2021"], 1);

        $years["christmas"] = $this->unir($point["christmas"]["2022"]["dato"], $point["christmas"]["2021"]["dato"], "christmas");
        $years["new_year"]  = $this->unir($point["new_year"]["2022"]["dato"], $point["new_year"]["2021"]["dato"], "new_year");

        return view('reserves.index', compact('data', 'point', 'years'));
    }

    public function christmas(){
        return view('reserves.christmas');
    }

    public function newYear(){
        return view('reserves.new-year');
    }
}
