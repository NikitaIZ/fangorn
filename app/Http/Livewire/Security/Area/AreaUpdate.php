<?php

namespace App\Http\Livewire\Security\Area;

use Livewire\Component;
use App\Models\Security\AreaModel;
class AreaUpdate extends Component
{

    public $area_object;
    public $area;
    public $descripcion;


    //Reglas que deben cumplir las propiedades.
    protected $rules = [
        "area" => "required|max:64",
        "descripcion" => "required|max:256"
    ];

    protected $listeners = [
        "loadArea" => "setArea"
    ];

    public $readyToLoad = false;
    public function render()
    {
        return view('livewire.security.area.area-update');
    }

    //Se encarga de setear las propiedades para modifcar el area.
    public function setArea(AreaModel $area){
        $this->area_object = $area;
        $this->area = $area->name;
        $this->descripcion = $area->description;
        $this->readyToLoad = true;
    }

    //Actualiza el modelo.
    public function update(){

        //Valida que los campos sean correctos.
        $this->validate();

        $this->area_object->name = $this->area;
        $this->area_object->description = $this->descripcion;
        
        $this->area_object->save();
        session()->flash('message', 'Area actualizada exitosamente!');
        //Emite un evento al componente donde se muestran todas las areas para que se actualice.
        $this->emitTo('security.area.area-render','render');
    }

    //Vuelve todas las propiedades a su estado de inicial cuando se cierre el componente.
    public function cleanPropertys(){
        $this->reset('area','descripcion','area_object');
        $this->readyToLoad = false;
    }
}
