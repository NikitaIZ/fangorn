<?php

namespace App\Http\Livewire\Security\Personal;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Security\PersonalModel;

class PersonalRender extends Component
{

    use WithPagination;
    public $search = ''; 

    public $sort_by = "personals.name";
    public $sort_order = "asc";

    public $filter_by = "personals.name";

    public $limit = 5;

    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
    ];

    public function render()
    {

        if($this->readyToLoad){
            $data = $this->getPersonal();
        }
        else{
            $data = [];
        }
        return view('livewire.security.personal.personal-render',compact("data"));
    }

    public function loadPersonal(){
        $this->readyToLoad = true;
    }
  
    public function sort($sort_by){

        
        $this->sort_by = $sort_by;
        if($this->sort_order == "asc"){
            $this->sort_order = "desc";
        }
        else if($this->sort_order == "desc"){
            $this->sort_order = "asc";
        }
    }
    
    

    public function getPersonal(){
        
        $query = PersonalModel::select(
            DB::raw("CONCAT(personals.name,' ',personals.last_name) AS name"),
            'personals.identification as identification',
            'personals.state as state',
            'personals.id as personal_id',
            'areas.id  as area_id',
            'areas.name as area_name',
            'areas.description as area_description',
            'positions.id as position_id',
            'positions.name as position_name',
            'positions.description as position_description'
        )
        ->join('areas','areas.id',"=","personals.area_id")
        ->join('positions','positions.id',"=","personals.position_id")
        ->Where($this->filter_by,"LIKE","%".$this->search."%");
        
        if($this->filter_by == "personals.name"){
            $query->orWhere("personals.last_name","LIKE","%".$this->search."%");
        }

        return $query->orderBy($this->sort_by,$this->sort_order)
        ->paginate($this->limit);
    }

    public function updatingSearch() {
        $this->resetPage();
    }
}
