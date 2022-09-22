<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Throwable;

use Livewire\Component;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;

class ChoiceCreate extends Component
{
    public $lang, $name, $menu, $choice;

    public $name_es, $name_en, $name_ru;

    public $create = true;

    protected $rules = [
        'name_es' => 'required',
        'name_en' => 'required',
        'name_ru' => 'required',
    ];

    public function save()
    {
        if ($this->name_es && $this->name_en)
        {
            $exist = RestaurantMenuChoice::where('name_es', $this->name_es)->where('menu_id', $this->menu->id)->value('id');
            if ($exist == null)
            {
                RestaurantMenuChoice::create([
                    'menu_id'  => $this->menu->id,
                    'name_es'  => $this->name_es,
                    'name_en'  => $this->name_en,
                    'name_ru'  => $this->name_ru,
                ]);
                $this->reset('name_es', 'name_en');
                $this->emitTo('audit.restaurants.plates.plate-create', 'render');
                $this->emit('alert', 'Se creo una Nueva Opción para este Menu');
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

    public function mount(RestaurantMenu $menu) {
        $this->menu = $menu;
    }

    public function render()
    {
        $choices_list = RestaurantMenuChoice::where('menu_id', $this->menu->id)->get();
        return view('livewire.audit.restaurants.plates.choice-create', compact('choices_list'));
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
        if ($this->choice != null) {
            try {
                $variable = RestaurantMenuChoice::findOrFail($this->choice);
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
