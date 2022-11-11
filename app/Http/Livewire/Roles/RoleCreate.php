<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

use Livewire\WithPagination;

class RoleCreate extends Component
{
    use WithPagination;

    public $name;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required',
    ];

    public function save()
    {
        if ($this->name)
        {
            Role::create(['name' => $this->name]);

            $this->reset('name');

            $this->emitTo('roles.role-index', 'render');

            $this->emit('alert', 'Se añadio la nueva tasa de cambio, sin problemas');

        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }
    
    public function render()
    {
        return view('livewire.roles.role-create');
    }
}
