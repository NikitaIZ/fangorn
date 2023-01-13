<?php

namespace App\Http\Livewire\Marketing\Reports;

use Livewire\Component;

class ReportsIndex extends Component
{   


    public $search = '';
    public $filter = '';
    

    public $readyToLoad = false;

    protected $queryString = [
        "search" => ["except" => "","as" => "date"],
        "filter" => ["except" => "","as" => "by"]
    ];


    public function render()
    {      
        if($this->readyToLoad){
            $data = [];
        }
        else{
            $data = [];
        }

        return view('livewire.marketing.reports.reports-index',compact("data"));
    }


    function getMarketingData(){
        return [];
    }




    public function loadData(){
        $this->readyToLoad = true;
    }
}
