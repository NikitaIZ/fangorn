<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use App\Models\Views\ViewRoles;

use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesShow extends Component
{
    use WithPagination;

    public $search;

    public $permision;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $newPermission = Permission::all()->pluck('name','id');
        $role_id = Role::where('id', $this->permision)->value('id');
        $role_name = Role::where('id', $this->permision)->value('name');
        $permissions = ViewRoles::where('ID_Role', $this->permision)
                                ->Where('Permiso', 'LIKE', '%' . $this->search . '%')->paginate();

        return view('livewire.roles.roles-show', compact('role_id', 'role_name', 'permissions', 'newPermission'));
    }
}
