<?php

namespace App\Http\Livewire\Marketing\Hotels;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Marketing\Hotels\Hotel;
use App\Models\Marketing\Hotels\HotelType;

class HotelCreate extends Component
{
    public $name, $stars = 0, $color, $type_id;

    protected $rules = [
        'name'  => 'required',
        'color' => 'required',
        'type_id' => 'required',
    ];

    public function save()
    {
        if ($this->name && $this->color)
        {
            Hotel::create([
                'name'    => $this->name,
                'stars'   => $this->stars,
                'color'   => $this->color,
                'type_id' => $this->type_id,
                'user_id' => Auth::user()->currentTeam->user_id,
            ]);

            $this->reset('name', 'stars', 'color', 'type_id');

            $this->emitTo('marketing.hotels.hotel-index', 'render');

            $this->emit('alert', 'Se creo un Nuevo Permiso sin problemas');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        $types_list = HotelType::get();
        return view('livewire.marketing.hotels.hotel-create', compact('types_list'));
    }

    public function stars($number)
    {
        $this->stars = $number;
    }
}
