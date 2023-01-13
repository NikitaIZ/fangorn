<?php

namespace App\Http\Livewire\Security\Personal;

use Livewire\Component;
use App\Models\Security\PersonalModel;
class PersonalDataModal extends Component
{
    public $personal;

    public $readyToLoad = false;


    protected $listeners = [
        "loadPersonal" => "setPersonal"
    ];
    public function render()
    {
        return view('livewire.security.personal.personal-data-modal');
    }

    public function setPersonal($personal){

        $this->personal  = $personal;
        $this->readyToLoad = true;
        
    }

    //Vuelve todas las propiedades a su estado de inicial cuando se cierre el componente.
    public function cleanPropertys(){
        $this->reset('personal');
        $this->readyToLoad = false;
    }
}

