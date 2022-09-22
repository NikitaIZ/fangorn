<?php

namespace App\Http\Livewire\Audit\Restaurants\Menus;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class MenuIndex extends Component
{
    use WithPagination;

    public $rest, $lang, $type, $menu, $name;

    public $search      = '';
    public $cant        = '25';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'menu.type'        => 'required',
        'menu.name_es'     => 'required',
        'menu.name_en'     => 'required',
        'menu.name_ru'     => 'required',
        'menu.description' => 'required',
        'menu.service'     => 'required',
        'menu.choice'      => 'required',
        'menu.country'     => 'required',
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

    public function mount(Restaurant $rest) {
        $this->rest = $rest;
        $this->name = 'name_' . $this->lang;
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad){
            $menu_list = RestaurantMenu::where($this->name, 'LIKE', '%' . $this->search . '%')
                                    ->where('restaurant_id', $this->rest->id)
                                    ->where('type', $this->type)
                                    ->orderby($this->sort, $this->direction)
                                    ->paginate($this->cant);
        }else{
            $menu_list = [];
        }

        return view('livewire.audit.restaurants.menus.menu-index', compact('menu_list'));
    }

    public function loadMenus()
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

    public function edit(RestaurantMenu $menu)
    {
        $this->menu = $menu;
    }

    public function update()
    {
        if ($this->menu->name_es && $this->menu->name_en)
        {
            $this->menu->save();
            $this->emit('alert', 'Se Actualizo el Menu sin problemas');
            $this->emitTo('audit.restaurants.menus.menu-index', 'render');
            try {
                $this->createArray($this->rest->id);
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
            $variable = RestaurantMenu::findOrFail($id);
            $variable->delete();
            $this->createArray($this->rest->id);
        } catch(Throwable $e) {
            Log::error($e);
        }
    }

    private function updateDataJson($data, $name){
        $dataJson = json_encode($data, true);
        file_put_contents("D:\\ftps_sync\wp.wyndhamconcorde.com\wp-content\uploads\menu-". $name .".json", $dataJson);

        $ftp_server="ftp.wyndhamconcorde.com";
        $ftp_user_name="pupjhhbnaibb";
        $ftp_user_pass="wyndCCE.2022#%!";
        $file = "D:\\ftps_sync\wp.wyndhamconcorde.com\wp-content\uploads\menu-". $name .".json";//tobe uploaded
        $remote_file = "public_html/wp/wp-content/uploads/menu-". $name .".json";

        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        if($conn_id){
            // login with username and password
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            ftp_put($conn_id, $remote_file, $file, FTP_ASCII);
            ftp_close($conn_id);
        }
    }

    private function createArray($id){
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
