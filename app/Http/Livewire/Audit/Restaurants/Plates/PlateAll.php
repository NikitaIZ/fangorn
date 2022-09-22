<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Livewire\Component;

use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class PlateAll extends Component
{
    public $readyToLoad = true;

    public $rest, $lang, $service, $menu, $name;

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
            $choices = RestaurantMenuChoice::where('menu_id', $this->menu->id)->get();
            if (count($choices)) {
                foreach ($choices as $key => $choice) {
                    $list[$key]['id']   = $choice->id;
                    switch ($this->lang) {
                        case 'es':
                            $list[$key]['name'] = $choice->name_es;
                            $list[$key]['coll'] = preg_replace('/\s+/', '_', strtolower($choice->name_es));
                        break;
                        case 'en':
                            $list[$key]['name'] = $choice->name_en;
                            $list[$key]['coll'] = preg_replace('/\s+/', '_', strtolower($choice->name_en));
                        break;
                        case 'ru':
                            $list[$key]['name'] = $choice->name_ru;
                            $list[$key]['coll'] = preg_replace('/\s+/', '_', strtolower($choice->name_ru));
                        break;
                    }
                }
                $list = array_map("unserialize", array_unique(array_map("serialize", $list)));
                foreach ($list as $key1 => $option) {
                    $plates = RestaurantMenuPlate::where('menu_id', $this->menu->id)->where('choice_id', $option['id'])->get();
                    if (count($plates)) {
                        foreach ($plates as $key2 => $plate) {
                            $list[$key1]['option'][$key2]['id']   = $plate->country_id;
                            $list[$key1]['option'][$key2]['name'] = RestaurantMenuCountry::where('id', $plate->country_id)->value($this->name);
                            $list[$key1]['option'][$key2]['coll'] = preg_replace('/\s+/', '_', strtolower($list[$key1]['option'][$key2]['name']));
                        }
                        $list[$key1]['option'] = array_map("unserialize", array_unique(array_map("serialize", $list[$key1]['option'])));
                    }else {
                        $list[$key1]['option'] = [];
                    }
                }
            }else {
                $list = [];
            }
        }else{
            $list = [];
        }
        return view('livewire.audit.restaurants.plates.plate-all', compact('list'));
    }

    public function loadAll()
    {
        $this->readyToLoad = true;
    }
}
