<?php

namespace App\Http\Livewire\Security\Position;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Security\PositionModel;

class PositionRender extends Component
{

    use WithPagination;
    public $search;
    public $limit = 5;
    protected $paginationTheme = 'bootstrap';

    public $sort_order = "asc";
    public $sort_by = "name";

    public $readyToLoad = false;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
    ];

    protected $listeners = [
        'render' => 'render',
    ];
    public function render()
    {
        if ($this->readyToLoad){
            $data = $this->getAllPositions();
        }else{
            $data = [];
        }
        return view('livewire.security.position.position-render',compact("data"));
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

        
        
        return PositionModel::where("name","LIKE","%".$this->search."%")
        ->orderBy($this->sort_by,$this->sort_order)
        ->paginate($this->limit,['*'],'areas');

    }
    public function updatingSearch() {
        $this->resetPage();
    }


    public function loadPositions()
    {
        $this->readyToLoad = true;
    }
}
