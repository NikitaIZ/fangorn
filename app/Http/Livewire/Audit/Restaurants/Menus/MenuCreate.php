<?php

namespace App\Http\Livewire\Audit\Restaurants\Menus;

use Livewire\Component;

use App\Models\Audit\Restaurants\Restaurant;
use App\Models\Audit\Restaurants\RestaurantMenu;
use App\Models\Audit\Restaurants\RestaurantMenuPlate;
use App\Models\Audit\Restaurants\RestaurantMenuChoice;
use App\Models\Audit\Restaurants\RestaurantMenuCountry;

class MenuCreate extends Component
{
    public $rest, $lang, $type;

    public $name_es, $name_en, $name_ru, $description = 0, $service = 0, $choice = 0, $country = 0;

    protected $rules = [
        'name_es' => 'required',
        'name_en' => 'required',
        'name_ru' => 'required',
    ];

    public function save()
    {
        if ($this->name_es && $this->name_en)
        {
            RestaurantMenu::create([
                'restaurant_id' => $this->rest->id,
                'type'          => $this->type,
                'name_es'       => $this->name_es,
                'name_en'       => $this->name_en,
                'name_ru'       => $this->name_ru,
                'description'   => $this->description,
                'service'       => $this->service,
                'choice'        => $this->choice,
                'country'       => $this->country,
            ]);

            $this->reset('name_es', 'name_en', 'name_ru', 'description', 'service', 'choice', 'country');

            $this->emitTo('audit.restaurants.menus.menu-index', 'render');

            $this->createArray($this->rest->id);

            $this->emit('alert', 'Se creo un Nuevo Menu sin Problemas');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.audit.restaurants.menus.menu-create');
    }

    public function enabled($option)
    {
        switch ($option) {
            case 'choice':
                if ($this->choice == 0){
                    $this->choice = 1;
                }else{
                    $this->choice = 0;
                }
            break;
            case 'service':
                if ($this->service == 0){
                    $this->service = 1;
                }else{
                    $this->service = 0;
                }
            break;
            case 'country':
                if ($this->country == 0){
                    $this->country = 1;
                }else{
                    $this->country = 0;
                }
            break;
            case 'description':
                if ($this->description == 0){
                    $this->description = 1;
                }else{
                    $this->description = 0;
                }
            break;
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
