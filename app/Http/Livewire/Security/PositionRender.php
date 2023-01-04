<?php

namespace App\Http\Livewire\Security;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
class PositionRender extends Component
{
    use WithPagination;
    public $search;
    public $tbl_name = "positions";
    protected $limit = 5;
    protected $paginationTheme = 'bootstrap';

    public $sort_order = "asc";
    public $sort_by = "name";

    
    public function render()
    {
        return view('livewire.security.position-render',[
            "data"=>$this->getAllPositions()
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

    private function getAllPositions(){

        
        return DB::table($this->tbl_name)
        ->Where("name","LIKE","%".$this->search."%")
        ->orWhere("description","LIKE","%".$this->search."%")
        ->orderBy($this->sort_by,$this->sort_order)
        ->limit(10)
        ->paginate($this->limit,['*'],'positions');

    }
}
