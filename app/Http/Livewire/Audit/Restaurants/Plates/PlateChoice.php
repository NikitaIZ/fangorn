<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Livewire\Component;

use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;

class PlateChoice extends Component
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
            $plates = RestaurantMenuPlate::where('menu_id', $this->menu->id)->get();
            if (count($plates)) {
                foreach ($plates as $key => $plate) {
                    $choices[$key]['id']   = RestaurantMenuChoice::where('id', $plate->choice_id)->value('id');
                    $choices[$key]['name'] = RestaurantMenuChoice::where('id', $plate->choice_id)->value($this->name);
                    $choices[$key]['coll'] = preg_replace('/\s+/', '_', $choices[$key]['name']);
                }
                $choices = array_map("unserialize", array_unique(array_map("serialize", $choices)));
            }else {
                $choices = [];
            }
        }else{
            $choices = [];
        }
        return view('livewire.audit.restaurants.plates.plate-choice', compact('choices'));
    }

    public function loadChoices()
    {
        $this->readyToLoad = true;
    }
}
