<?php

namespace App\Http\Livewire\Permissions;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    use WithPagination;

    public $permission;

    public $search      = '';
    public $cant        = '25';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'permission.name'        => 'required',
        'permission.description' => 'required'
    ];

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '25'],
        'sort'      => ['except' => 'id'],
        'direction' => ['except' => 'asc']
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad){
            $permissions = Permission::where('name', 'LIKE', '%' . $this->search . '%')
                                    ->orderby($this->sort, $this->direction)
                                    ->paginate($this->cant);
        }else{
            $permissions = [];
        }
        return view('livewire.permissions.permission-index', compact('permissions'));
    }

    public function loadPermissions()
    {
        $this->readyToLoad = true;
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            }else {
                $this->direction = 'asc';
            }
        }else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function update()
    {
        if ($this->permission->name)
        {
            $this->permission->save();

            $this->emit('alert', 'Se Actualizo el Permiso sin problemas');

            $this->emitTo('permissions.permission-index', 'render');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = Permission::findOrFail($id);
            $variable->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('permissions.permission-index', 'render');
    }
}
