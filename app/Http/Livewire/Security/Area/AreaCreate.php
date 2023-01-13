<?php

namespace App\Http\Livewire\Security\Area;

use Livewire\Component;
use App\Models\Security\AreaModel;

class AreaCreate extends Component
{


    public $area;
    public $descripcion;

    //Reglas que deben cumplir las propiedades.
    protected $rules = [
        "area" => "required|max:64",
        "descripcion" => "required|max:256"
    ];

    public function render()
    {
        return view('livewire.security.area.area-create');
    }

    public function save(){
        //Valida que los campos tengan el formato correcto.
        //y luego crea la nueva area.

        $this->validate();

        $new_area = new Areamodel();
        $new_area->name = $this->area;
        $new_area->description = $this->descripcion;
        $new_area->save();

        $this->reset("area","descripcion");
        session()->flash('message', 'Area creada exitosamente!');
        $this->emitTo('security.area.area-render','render');
    }
}
