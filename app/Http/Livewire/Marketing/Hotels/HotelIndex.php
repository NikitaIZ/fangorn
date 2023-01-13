<?php

namespace App\Http\Livewire\Marketing\Hotels;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\Marketing\Hotels\Hotel;
use App\Models\Marketing\Hotels\HotelType;

class HotelIndex extends Component
{
    use WithPagination;

    public $hotel, $stars, $input_id;

    public $search      = '';
    public $cant        = '25';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'hotel.name'    => 'required',
        'hotel.color'   => 'required',
        'hotel.type_id' => 'required'
    ];

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '25'],
        'sort'      => ['except' => 'id'],
        'direction' => ['except' => 'asc']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $types_list = HotelType::get();
        if ($this->readyToLoad){
            $hotels = Hotel::where('name', 'LIKE', '%' . $this->search . '%')
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
        }else{
            $hotels = [];
        }
        return view('livewire.marketing.hotels.hotel-index', compact('hotels', 'types_list'));
    }

    public function loadHotels()
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

    public function edit(Hotel $hotel)
    {
        $this->hotel = $hotel;
        $this->stars = $hotel->stars;
        $this->input_id = 'input_' . $hotel->id;
    }

    public function update()
    {
        if ($this->hotel->name)
        {
            $this->hotel->save();

            $this->emit('alert', 'Se Actualizo el Permiso sin problemas');

            $this->emitTo('marketing.hotels.hotel-index', 'render');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = Hotel::findOrFail($id);
            $variable->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('marketing.hotels.hotel-index', 'render');
    }

    public function stars($number)
    {
        $this->stars = $number;
    }
}
