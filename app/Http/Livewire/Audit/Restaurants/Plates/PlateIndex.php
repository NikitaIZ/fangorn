<?php

namespace App\Http\Livewire\Audit\Restaurants\Plates;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class PlateIndex extends Component
{
    use WithPagination;

    public $rest, $lang, $service, $menu, $plate, $name, $description;

    public $country, $choice;

    public $countries = false, $choices = false;

    public $search      = '';
    public $cant        = '25';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $rules = [
        'plate.name_es'        => 'required',
        'plate.description_es' => 'required',
        'plate.name_en'        => 'required',
        'plate.description_en' => 'required',
        'plate.name_ru'        => 'required',
        'plate.description_ru' => 'required',
        'plate.price'          => 'required',
        'plate.service'        => 'required',
        'plate.choice_id'      => 'required',
        'plate.country_id'     => 'required',
        'plate.status'         => 'required',
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

    protected $paginationTheme = 'bootstrap';

    public function mount(RestaurantMenu $menu) {
        $this->menu        = $menu;
        $this->plate       = new RestaurantMenuPlate();
        $this->name        = 'name_' . $this->lang;
        $this->description = 'description_' . $this->lang;
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $choice_list  = RestaurantMenuChoice::where('menu_id', $this->menu->id)->get();
        $country_list = RestaurantMenuCountry::get();

        if ($this->readyToLoad){
            if($this->countries && $this->choices){
                $plates_list = RestaurantMenuPlate::where('menu_id', $this->menu->id)->where('choice_id', $this->choice)->where('country_id', $this->country)
                        ->where($this->name, 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);
            }elseif($this->choices) {
                $plates_list = RestaurantMenuPlate::where('menu_id', $this->menu->id)->where('choice_id', $this->choice)
                        ->where($this->name, 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);
            }elseif($this->countries) {
                $plates_list = RestaurantMenuPlate::where('menu_id', $this->menu->id)->where('country_id', $this->country)
                        ->where($this->name, 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);
            }else{
                $plates_list = RestaurantMenuPlate::where('menu_id', $this->menu->id)
                        ->where($this->name, 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);
            }
        }else{
            $plates_list = [];
        }
        return view('livewire.audit.restaurants.plates.plate-index', compact('plates_list', 'choice_list', 'country_list'));
    }

    public function loadPlates()
    {
        $this->readyToLoad = true;
    }

    public function enabled($id)
    {
        $status = RestaurantMenuPlate::where('id', $id)->value('status');
        if ($status) {
            RestaurantMenuPlate::where('id', $id)->update(['status' => false]);
        } else {
            RestaurantMenuPlate::where('id', $id)->update(['status' => true]);
        }
        $this->createArray($this->rest);
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

    public function edit(RestaurantMenuPlate $plate)
    {
        $this->plate = $plate;
    }

    public function update()
    {
        if ($this->plate->name_es && $this->plate->name_en)
        {
            if ($this->plate->price == null){
                $this->plate->price = 0;
            }
            if ($this->plate->service == null){
                $this->plate->service = 0;
            }
            $this->plate->save();
            $this->emit('alert', 'Se Actualizo el Articulo sin problemas');
            $this->emitTo('audit.restaurants.plates.plate-index', 'render');
            try {
                $this->createArray($this->rest);
            } catch(Throwable $e) {
                Log::error($e);
            }
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = RestaurantMenuPlate::findOrFail($id);
            $variable->delete();
            $this->createArray($this->rest);
        } catch(Throwable $e) {
            Log::error($e);
        }
        if($this->countries && $this->choices){
            $this->emitTo('audit.restaurants.plates.plate-all', 'render');
        }elseif($this->choices) {
            $this->emitTo('audit.restaurants.plates.plate-choice', 'render');
        }elseif($this->countries) {
            $this->emitTo('audit.restaurants.plates.plate-country', 'render');
        }
    }

    private function updateDataJson($data, $name)
    {
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
