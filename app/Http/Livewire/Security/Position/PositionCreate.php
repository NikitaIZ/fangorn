<?php

namespace App\Http\Livewire\Security\Position;

use Livewire\Component;
use App\Models\Security\PositionModel;
class PositionCreate extends Component
{

    public $cargo;
    public $descripcion;

    protected $rules = [
        "cargo" => "required|max:64",
        "descripcion" => "required|max:256"
    ];
    public function render()
    {
        return view('livewire.security.position.position-create');
    }
    public function save(){
        //Valida que los campos tengan el formato correcto.
        //y luego crea la nueva area.

        $this->validate();

        $new_position = new PositionModel();
        $new_position->name = $this->cargo;
        $new_position->description = $this->descripcion;
        $new_position->save();

        $this->reset("cargo","descripcion");
        session()->flash('message', 'Area creada exitosamente!');
        $this->emitTo('security.position.position-render','render');
    }
}
