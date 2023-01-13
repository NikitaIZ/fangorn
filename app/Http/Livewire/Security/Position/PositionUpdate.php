<?php

namespace App\Http\Livewire\Security\Position;

use Livewire\Component;
use App\Models\Security\PositionModel;
class PositionUpdate extends Component
{

    public $cargo;
    public $descripcion;
    public $position_object;
    public $readyToLoad = false;

    protected $rules = [
        "cargo" => "required|max:64",
        "descripcion" => "required|max:256"
    ];

    protected $listeners = [
        "loadPosition" => "setPosition"
    ];
    public function render()
    {
        return view('livewire.security.position.position-update');
    }

    public function setPosition(PositionModel $position){
        $this->position_object = $position;
        $this->cargo = $position->name;
        $this->descripcion = $position->description;
        $this->readyToLoad = true;
    }

    public function update(){

        //Valida que los campos sean correctos.
        $this->validate();

        $this->position_object->name = $this->cargo;
        $this->position_object->description = $this->descripcion;
        
        $this->position_object->save();
        session()->flash('message', 'Cargo actualizado exitosamente!');
        //Emite un evento al componente donde se muestran todas las areas para que se actualice.
        $this->emitTo('security.position.position-render','render');
    }

    public function cleanPropertys(){
        $this->reset('cargo','descripcion','position_object');
        $this->readyToLoad = false;
    }
}
