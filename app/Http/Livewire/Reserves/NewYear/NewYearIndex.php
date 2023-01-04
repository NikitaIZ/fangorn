<?php

namespace App\Http\Livewire\Reserves\NewYear;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use App\Exports\BookingsExport;
use App\Models\Reserves\EventBooking;
use App\Models\Reserves\EventCoupon;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;

class NewYearIndex extends Component
{
    use WithPagination;

    public $search      = '';
    public $cant        = '10';
    public $sort        = 'order_id';
    public $direction   = 'desc';
    public $status      = 'completed';
    public $event       = 4;
    public $readyToLoad = false;
    public $date_start  = '2022-10-31';
    public $date_end    = '2023-01-01';
    public $coupon      = '';

    public $tables = array();
    public $seats = array();

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '10'],
        'sort'      => ['except' => 'order_id'],
        'direction' => ['except' => 'desc']
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $total = $this->total();
        if ($this->readyToLoad){
            $bookings = EventBooking::where('event_id', $this->event)
                            ->where('status', $this->status)
                            ->where('client', 'LIKE', '%' . $this->search . '%')
                            ->whereBetween('created_at', [$this->date_start, $this->date_end])
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
        }else{
            $bookings = [];
        }

        return view('livewire.reserves.new-year.new-year-index', compact('total', 'bookings'));
    }

    public function getDataTablesAndSeats($id, $i = 0, $tables = array(), $seats = array(),)
    {
        $booking = EventBooking::where('order_id', $id)->get();
        $areas = explode(".", str_replace(",", ".", $booking[0]->seats));
        foreach ($areas as $value) {
            if (empty($tables)) {
                $tables[$i] = $value;
            }else{
                if (is_numeric($value)) {
                    if (empty($seats[$i])) {
                        $seats[$i] = $value;
                    }else{
                        $seats[$i] = $seats[$i] . ", " . $value;
                    }
                }else{
                    if ($tables[$i] != $value) {
                        $i++;
                        $tables[$i] = $value;
                    }
                }
            }
        }
        $this->tables = $tables;
        $this->seats = $seats;
        $this->coupon = EventCoupon::where('id', $booking[0]->coupon_id)->value('name');
    }

    public function loadBookings()
    {
        $this->readyToLoad = true;
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            }else {
                $this->direction = 'asc';
            }
        }else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function status($status){
        $this->status = $status;
    }

    public function delete($id)
    {
        try {
            EventBooking::where('order_id', $id)->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('reserves.new-year.new-year-index', 'render');
    }

    public function total() {
        $data = array(
            'total' => EventBooking::where('event_id', $this->event)->where('status', $this->status)->sum('total'),
            'adults' => EventBooking::where('event_id', $this->event)->where('status', $this->status)->sum('adults'),
            'childrem' => EventBooking::where('event_id', $this->event)->where('status', $this->status)->sum('childrem'),
            'count' => EventBooking::where('event_id', $this->event)->where('status', $this->status)->count(),
        );
        return $data;
    }

    public function excel(){
        $export = new BookingsExport();
        $export->setEvent($this->event);
        $export->setStatus($this->status);
        $export->setSearch($this->search);
        $export->setDateS($this->date_start);
        $export->setDateE($this->date_end);
        $export->setSort($this->sort);
        $export->setDirection($this->direction);

        return Excel::download($export, "Año Nuevo ". date('d-m-Y h_i A') . '.xlsx');
    }
}
