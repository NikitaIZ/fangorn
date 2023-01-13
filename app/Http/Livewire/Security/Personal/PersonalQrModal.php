<?php

namespace App\Http\Livewire\Security\Personal;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
class PersonalQrModal extends Component
{

    public $readyToLoad = false;
    public $personal_id;
    public $encryptedData;

    protected $listeners = [
        "loadPersonalId" => "setPersonalId",
        "render" => "render"
    ];

    public function render()
    {
        return view('livewire.security.personal.personal-qr-modal');
    }

    public function setPersonalId($personal_id){

        $this->personal_id = $personal_id;
        $this->encryptedData = json_encode(Crypt::encryptString(json_encode(["personal_id"=>$personal_id])));
        $this->readyToLoad = true;
        $this->emitSelf("loadButton");
    }

    //Vuelve todas las propiedades a su estado de inicial cuando se cierre el componente.
    public function cleanPropertys(){
        $this->reset('personal_id',"encryptedData");
        $this->readyToLoad = false;
    }
}
