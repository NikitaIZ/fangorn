<?php

namespace App\Http\Livewire\Security;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Security\Personal as PersonalModel;

use Livewire\WithPagination;
class PersonalRender extends Component
{   
    use WithPagination;
    public $search; 

    public $sort_by = "personals.id";
    public $sort_order = "asc";

    public $filter_by = "personals.name";

    private $limit = 5;
    private $tbl_name = "personals";

    protected $paginationTheme = 'bootstrap';

    public function render()
    {   
        return view('livewire.security.personal-render',[
            'data' => $this->getPersonal()
        ]);
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

    public function filter($filter_by){

        $this->filter_by = $filter_by;
    }

    public function getPersonal(){
        return DB::table("$this->tbl_name")
            ->leftJoin("areas","areas.id","=","personals.area_id")
            ->leftJoin("positions","positions.id","=","personals.position_id")
            ->select(
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
            ->Where($this->filter_by,"LIKE","%".$this->search."%")
            ->orderBy($this->sort_by,$this->sort_order)
            ->paginate($this->limit);
    }

    public function updatingSearch() {
        $this->resetPage();
    }
    
}
