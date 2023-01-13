<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;

use Spatie\Permission\Models\Permission;

class PermissionCreate extends Component
{
    public $name, $description;

    protected $rules = [
        'name' => 'required',
    ];

    public function save()
    {
        if ($this->name)
        {
            Permission::create([
                'name'        => $this->name,
                'description' => $this->description,
            ]);

            $this->reset('name', 'description');

            $this->emitTo('audit.permissions.permission-index', 'render');

            $this->emit('alert', 'Se creo un Nuevo Permiso sin problemas');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.permissions.permission-create');
    }
}
