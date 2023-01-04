<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Throwable;

use Livewire\Component;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class PlateCreate extends Component
{
    public $lang, $rest, $menu, $name, $list = false, $countries = false, $choices = false, $create = '';

    public $name_es, $description_es, $name_en, $description_en, $name_ru, $description_ru, $price = 1, $service = 0, $choice_id, $country_id;

    protected $rules = [
        'name_es'    => 'required',
        'name_en'    => 'required',
        'name_ru'    => 'required',
        'price'      => 'required',
        'choice_id'  => 'required',
        'country_id' => 'required',
    ];

    protected $listeners = [
        'render' => 'render',
    ];

    public function mount() {
        $this->name = 'name_'. $this->lang;
    }

    public function save()
    {
        if ($this->name_es && $this->name_en)
        {
            if ($this->choices)
            {
                if ($this->choice_id == null)
                {
                    $this->emit('error', 'Ocurrio un error revise bien el formulario');
                    $this->validate();
                }
            }
            if ($this->countries)
            {
                if ($this->country_id == null)
                {
                    $this->emit('error', 'Ocurrio un error revise bien el formulario');
                    $this->validate();
                }
            }

            RestaurantMenuPlate::create([
                'menu_id'        => $this->menu->id,
                'name_es'        => $this->name_es,
                'description_es' => $this->description_es,
                'name_en'        => $this->name_en,
                'description_en' => $this->description_en,
                'name_ru'        => $this->name_ru,
                'description_ru' => $this->description_ru,
                'price'          => $this->price,
                'service'        => $this->service,
                'choice_id'      => $this->choice_id,
                'country_id'     => $this->country_id,
                'status'         => true,
            ]);

            $this->reset('name_es', 'description_es','name_en', 'description_en', 'name_ru', 'description_ru', 'price', 'service');

            $this->emitTo('audit.restaurants.plates.plate-index', 'render');

            if($this->countries && $this->choices){
                $this->emitTo('audit.restaurants.plates.plate-all', 'render');
            }elseif($this->choices) {
                $this->emitTo('audit.restaurants.plates.plate-choice', 'render');
            }elseif($this->countries) {
                $this->emitTo('audit.restaurants.plates.plate-country', 'render');
            }

            if ($this->choices)
            {
                $this->reset('choice_id');
            }
            if ($this->countries)
            {
                $this->reset('country_id');
            }

            try {
                $this->createArray($this->rest);
            } catch(Throwable $e) {
                Log::error($e);
            }

            $this->emit('alert', 'Se Agrego un Nuevo Articulo al Menu');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        $choice_list  = RestaurantMenuChoice::where('menu_id', $this->menu->id)->get();
        $country_list = RestaurantMenuCountry::get();

        $choice  = RestaurantMenuChoice::where('id', $this->choice_id)->value($this->name);
        $country = RestaurantMenuCountry::where('id', $this->country_id)->value($this->name);
        return view('livewire.audit.restaurants.plates.plate-create', compact('choice_list', 'country_list', 'country', 'choice'));
    }

    private function updateDataJson($data, $name){
        $dataJson = json_encode($data, true);
        file_put_contents(config('app.ftp.local') . "\menu-" . $name . ".json", $dataJson);

        $ftp_server = config('app.ftp.server');
        $ftp_user_name = config('app.ftp.name');
        $ftp_user_pass = config('app.ftp.pass');
        $file = config('app.ftp.local') . "\menu-" . $name . ".json";//tobe uploaded
        $remote_file = config('app.ftp.remote') . "menu-". $name . ".json";

        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        if($conn_id){
            // login with username and password
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            ftp_put($conn_id, $remote_file, $file, FTP_ASCII);
            ftp_close($conn_id);
        }
    }

    private function createArray($id)
    {
        $name  = preg_replace('/\s+/', '-',  strtolower(Restaurant::where('id', $id)->value('name')));
        $menus = RestaurantMenu::where('restaurant_id', $id)->get();
        $languagues = array(
            0 => 'es',
            1 => 'en',
            2 => 'ru'
        );
        foreach ($languagues as $value) {
            foreach ($menus as $menu) {
                switch ($value) {
                    case 'es':
                        $list[$value][$menu->type][$menu->id]['coll'] = 'es_' . preg_replace('/\s+/', '_', strtolower($menu->name_es)) . '_' . $menu->id * rand(1,100);
                        $list[$value][$menu->type][$menu->id]['name'] = $menu->name_es;
                    break;
                    case 'en':
                        $list[$value][$menu->type][$menu->id]['coll'] = 'en_' . preg_replace('/\s+/', '_', strtolower($menu->name_en)) . '_' . $menu->id * rand(1,100);
                        $list[$value][$menu->type][$menu->id]['name'] = $menu->name_en;
                    break;
                    case 'ru':
                        $list[$value][$menu->type][$menu->id]['coll'] = 'ru_' . preg_replace('/\s+/', '_', strtolower($menu->name_ru)) . '_' . $menu->id * rand(1,100);
                        $list[$value][$menu->type][$menu->id]['name'] = $menu->name_ru;
                    break;
                }
                $list[$value][$menu->type][$menu->id]['description'] = $menu->description;
                $list[$value][$menu->type][$menu->id]['service']     = $menu->service;
                $list[$value][$menu->type][$menu->id]['choice']      = $menu->choice;
                $list[$value][$menu->type][$menu->id]['country']     = $menu->country;
                if ($menu->choice && $menu->country) {
                    $choices = RestaurantMenuChoice::where('menu_id', $menu->id)->get();
                    if (count($choices)) {
                        foreach ($choices as $key1 => $choice) {
                            switch ($value) {
                                case 'es':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['name'] = $choice->name_es;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['coll'] = 'es_' . preg_replace('/\s+/', '_', strtolower($choice->name_es));
                                break;
                                case 'en':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['name'] = $choice->name_en;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['coll'] = 'en_' . preg_replace('/\s+/', '_', strtolower($choice->name_en));
                                break;
                                case 'ru':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['name'] = $choice->name_ru;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['coll'] = 'ru_' . preg_replace('/\s+/', '_', strtolower($choice->name_ru));
                                break;
                            }
                            $plates = RestaurantMenuPlate::where('menu_id', $menu->id)->where('choice_id', $choice->id)->get();
                            if (count($plates)) {
                                foreach ($plates as $key2 => $plate) {
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'][$key2]['name']   = RestaurantMenuCountry::where('id', $plate->country_id)->value('name_' . $value);
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'][$key2]['coll']   = $value . '_' . preg_replace('/\s+/', '_', strtolower($list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'][$key2]['name']));
                                    $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'][$key2]['plates'] = RestaurantMenuPlate::select('name_' . $value, 'description_' . $value, 'price', 'service')->where('menu_id', $menu->id)->where('choice_id', $choice->id)->where('country_id', $plate->country_id)->where('status', true)->get()->toArray();
                                }
                                $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'] = array_map("unserialize", array_unique(array_map("serialize", $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'])));
                                $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'] = array_values($list[$value][$menu->type][$menu->id]['choices'][$key1]['countries']);
                            }else {
                                $list[$value][$menu->type][$menu->id]['choices'][$key1]['countries'] = [];
                            }
                        }
                    }else {
                        $list[$value][$menu->type][$menu->id]['choices'] = [];
                    }
                }elseif ($menu->choice) {
                    $choices = RestaurantMenuChoice::where('menu_id', $menu->id,)->get();
                    if (count($choices)) {
                        foreach ($choices as $key => $choice) {
                            switch ($value) {
                                case 'es':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['name'] = $choice->name_es;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['coll'] = 'es_' . preg_replace('/\s+/', '_', strtolower($choice->name_es));
                                break;
                                case 'en':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['name'] = $choice->name_en;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['coll'] = 'en_' . preg_replace('/\s+/', '_', strtolower($choice->name_en));
                                break;
                                case 'ru':
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['name'] = $choice->name_ru;
                                    $list[$value][$menu->type][$menu->id]['choices'][$key]['coll'] = 'ru_' . preg_replace('/\s+/', '_', strtolower($choice->name_ru));
                                break;
                            }
                            $list[$value][$menu->type][$menu->id]['choices'][$key]['plates'] = RestaurantMenuPlate::select('name_' . $value, 'description_' . $value, 'price', 'service')->where('menu_id', $menu->id)->where('choice_id', $choice->id)->where('status', true)->get()->toArray();
                        }
                    }else {
                        $list[$value][$menu->type][$menu->id]['choices'] = [];
                    }
                } elseif ($menu->country) {
                    $countries = RestaurantMenuCountry::get();
                    if (count($countries)) {
                        foreach ($countries as $key => $country) {
                            $validation = RestaurantMenuPlate::where('menu_id', $menu->id)->where('country_id', $country->id)->value('id');
                            if ($validation) {
                                switch ($value) {
                                    case 'es':
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['name'] = $country->name_es;
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['coll'] = 'es_' . preg_replace('/\s+/', '_', strtolower($country->name_es));
                                    break;
                                    case 'en':
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['name'] = $country->name_en;
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['coll'] = 'es_' . preg_replace('/\s+/', '_', strtolower($country->name_en));
                                    break;
                                    case 'ru':
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['name'] = $country->name_ru;
                                        $list[$value][$menu->type][$menu->id]['countries'][$key]['coll'] = 'ru_' . preg_replace('/\s+/', '_', strtolower($country->name_ru));
                                    break;
                                }
                                $list[$value][$menu->type][$menu->id]['countries'][$key]['plates'] = RestaurantMenuPlate::select('name_' . $value, 'description_' . $value, 'price', 'service')->where('menu_id', $menu->id)->where('country_id', $country->id)->where('status', true)->get()->toArray();
                            }
                        }
                        $list[$value][$menu->type][$menu->id]['countries'] = array_values($list[$value][$menu->type][$menu->id]['countries']);
                    }else {
                        $list[$value][$menu->type][$menu->id]['countries'] = [];
                    }
                }else {
                    $plates = RestaurantMenuPlate::where('menu_id', $menu->id)->get();
                    if (count($plates)) {
                        $list[$value][$menu->type][$menu->id]['plates'] = RestaurantMenuPlate::select('name_' . $value, 'description_' . $value, 'price', 'service')->where('menu_id', $menu->id)->where('status', true)->get()->toArray();
                    }else {
                        $list[$value][$menu->type][$menu->id]['plates'] = [];
                    }
                }
                $list[$value][$menu->type] = array_values($list[$value][$menu->type]);
            }
        }
        $this->updateDataJson($list, $name);
    }
}
