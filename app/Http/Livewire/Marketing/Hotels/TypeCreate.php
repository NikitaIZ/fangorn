<?php

namespace App\Http\Livewire\Marketing\Hotels;

use Throwable;

use Livewire\Component;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Marketing\Hotels\Hotel;
use App\Models\Marketing\Hotels\HotelType;

class TypeCreate extends Component
{
    public $type, $name, $description;

    public $create = true;

    protected $rules = [
        'name'        => 'required',
        'description' => 'required',
    ];

    protected $listeners = [
        'delete' => 'delete'
    ];

    public function save()
    {
        if ($this->name && $this->description)
        {
            $exist = HotelType::where('name', $this->name)->doesntExist();
            if ($exist)
            {
                HotelType::create([
                    'name'        => $this->name,
                    'description' => $this->description,
                    'user_id'     => Auth::user()->currentTeam->user_id,
                ]);
                $this->reset('name', 'description');
                $this->emitTo('marketing.hotels.hotel-create', 'render');
                $this->emit('alert', 'Se creo un nuevo tipo de Hotel');
            }else
            {
                $this->emit('error', 'El nombre ya existe');
            }
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        $types_list = HotelType::get();
        return view('livewire.marketing.hotels.type-create', compact('types_list'));
    }

    public function change()
    {
        if ($this->create == true) {
            $this->create = false;
        }else{
            $this->create = true;
        }
    }

    public function delete()
    {
        if ($this->type != null) {
            try {
                Hotel::where('type_id', $this->type)->delete();
                $variable = HotelType::findOrFail($this->type);
                $variable->delete();
            } catch(Throwable $e) {
                Log::error($e);
            }
            $this->create = true;
            $this->emitTo('marketing.hotels.hotel-index', 'render');
        }
    }
}
