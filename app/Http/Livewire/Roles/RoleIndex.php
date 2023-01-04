<?php

namespace App\Http\Livewire\Roles;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Log;

use App\Models\Nivel\RoleHasPermission;


class RoleIndex extends Component
{

    use WithPagination;

    public $role;

    public $search      = '';
    public $cant        = '10';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    public $permissions = array();

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'role.name' => 'required',
    ];

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '10'],
        'sort'      => ['except' => 'id'],
        'direction' => ['except' => 'asc']
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad){
            $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
        }else{
            $roles = [];
        }

        return view('livewire.roles.role-index', compact('roles'));
    }

    public function loadRoles()
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

    public function edit(Role $role)
    {
        $this->role = $role;
        $permissions_all = Permission::get()->toarray();

        foreach ($permissions_all as $key => $value) {
            $permissions[$key]['id']          = $value['id'];
            $permissions[$key]['name']        = $value['name'];
            $permissions[$key]['description'] = $value['description'];
            $exist = RoleHasPermission::where('role_id', $role->id)->where('permission_id', $value['id'])->value('permission_id');
            if ($exist != null) {
                $permissions[$key]['bool'] = true;
            }else {
                $permissions[$key]['bool'] = false;
            }
        }
        $this->permissions = $permissions;
    }

    public function update()
    {
        if ($this->role->name)
        {
            $this->role->save();

            $new_permissions = array();
            foreach ($this->permissions as $permission) {
                if ($permission["bool"] == true) {
                    $new_permissions[$permission['name']] = $permission['id'];
                }
            }

            $this->role->syncPermissions($new_permissions);

            $this->emit('alert', 'Se actualizo el Role sin problemas');
            $this->emitTo('roles.role-index', 'render');
        }else {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function changePermission($key){
        if ($this->permissions[$key]['bool'] == true) {
            $this->permissions[$key]['bool'] = false;
        }else {
            $this->permissions[$key]['bool'] = true;
        }
    }

    public function delete($id)
    {
        try {
            $variable = Role::findOrFail($id);
            $variable->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('roles.role-index', 'render');
    }
}
