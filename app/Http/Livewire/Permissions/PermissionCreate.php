<?php

namespace App\Http\Livewire\Permissions;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

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

            $this->reset('name');

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
