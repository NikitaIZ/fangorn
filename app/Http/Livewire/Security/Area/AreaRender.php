<?php

namespace App\Http\Livewire\Security\Area;

use Livewire\Component;
use App\Models\Security\AreaModel;
use Livewire\WithPagination;
class AreaRender extends Component
{

    use WithPagination;
    
    public $search = '';
    public  $limit = 5;
    protected $paginationTheme = 'bootstrap';


    //Propiedades que se muestran en la URL.
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
    ];

    protected $listeners = [
        'render' => 'render',
    ];

    //Campo y orden en el que se ordena las querys.
    public $sort_order = "asc";
    public $sort_by = "name";

    public $readyToLoad = false;
    public function render()
    {
        if ($this->readyToLoad){
            $data = $this->getAllAreas();
        }else{
            $data = [];
        }
        return view('livewire.security.area.area-render',compact("data"));
    }


    //Obtiene todas las areas con los parametros indicados.
    private function getAllAreas(){

        return AreaModel::where("name","LIKE","%".$this->search."%")
        ->orderBy($this->sort_by,$this->sort_order)
        ->paginate($this->limit,['*'],'areas');

    }


    //Setea el orden en el que se traeran el registros
    //y la propiedad por la que se filtrara.
    public function sort($sort_by){

        $this->sort_by = $sort_by;
        if($this->sort_order == "asc"){
            $this->sort_order = "desc";
        }
        else if($this->sort_order == "desc"){
            $this->sort_order = "asc";
        }
    }


    public function updatingSearch() {
        $this->resetPage();
    }


    public function loadAreas()
    {
        $this->readyToLoad = true;
    }
}
