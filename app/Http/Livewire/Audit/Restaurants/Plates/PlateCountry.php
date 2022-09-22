<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Livewire\Component;

use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class PlateCountry extends Component
{
    public $readyToLoad = false;

    public $rest, $lang, $menu, $name;

    protected $listeners = [
        'render' => 'render',
    ];

    public function mount(RestaurantMenu $menu) {
        $this->menu = $menu;
        $this->name = 'name_'. $this->lang;
    }

    public function render()
    {
        if ($this->readyToLoad){
            $plates = RestaurantMenuPlate::where('menu_id', $this->menu->id)->get();
            if (count($plates)) {
                foreach ($plates as $key => $plate) {
                    $countries[$key]['id']   = RestaurantMenuCountry::where('id', $plate->country_id)->value('id');
                    $countries[$key]['name'] = RestaurantMenuCountry::where('id', $plate->country_id)->value($this->name);
                    $countries[$key]['coll'] = preg_replace('/\s+/', '_', $countries[$key]['name']);
                }
                $countries = array_map("unserialize", array_unique(array_map("serialize", $countries)));
            }else {
                $countries = [];
            }
        }else{
            $countries = [];
        }
        return view('livewire.audit.restaurants.plates.plate-country', compact('countries'));
    }

    public function loadCountries()
    {
        $this->readyToLoad = true;
    }
}
