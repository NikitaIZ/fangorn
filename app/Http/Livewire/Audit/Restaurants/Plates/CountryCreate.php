<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Throwable;

use Livewire\Component;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class CountryCreate extends Component
{
    public $lang, $name, $country;

    public $name_es, $name_en, $name_ru;

    public $create = true;

    protected $rules = [
        'name_es' => 'required',
        'name_en' => 'required',
        'name_ru' => 'required',
    ];

    public function save()
    {
        if ($this->name_es)
        {
            $exist = RestaurantMenuCountry::where('name_' . $this->lang , $this->name_es)->value('id');
            if ($exist == null)
            {
                RestaurantMenuCountry::create([
                    'name_es'  => $this->name_es,
                    'name_en'  => $this->name_en,
                    'name_ru'  => $this->name_ru,
                ]);
                $this->reset('name_es','name_en', 'name_ru');
                $this->emitTo('audit.restaurants.plates.plate-create', 'render');

                $this->emit('alert', 'Se Agrego un Nuevo País a la Lista');
            }else
            {
                $this->emit('error', 'Ese Pais ya esta registrado');
            }
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        $country_list = RestaurantMenuCountry::get();
        return view('livewire.audit.restaurants.plates.country-create', compact('country_list'));
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
        if ($this->country != null) {
            try {
                $variable = RestaurantMenuCountry::findOrFail($this->country);
                $variable->delete();
            } catch(Throwable $e) {
                Log::error($e);
            }
            $this->emitTo('audit.restaurants.plates.plate-all', 'render');
            $this->emitTo('audit.restaurants.plates.plate-choice', 'render');
            $this->emitTo('audit.restaurants.plates.plate-country', 'render');
        }
    }
}
