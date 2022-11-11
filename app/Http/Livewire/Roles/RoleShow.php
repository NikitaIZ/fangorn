<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Nivel\RoleHasPermission;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleShow extends Component
{
    use WithPagination;

    public $search;

    public $role;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $role_id = Role::where('id', $this->role)->value('id');
        $role_name = Role::where('id', $this->role)->value('name');
        $permissions_all = Permission::get()->toarray();

        foreach ($permissions_all as $key => $value) {
            $permissions[$key]['id']          = $value['id'];
            $permissions[$key]['name']        = $value['name'];
            $permissions[$key]['description'] = $value['description'];
            $exist = RoleHasPermission::where('role_id', $this->role)->where('permission_id', $value['id'])->value('permission_id');
            if ($exist != null) {
                $permissions[$key]['bool'] = true;
            }else {
                $permissions[$key]['bool'] = false;
            }
        }

        return view('livewire.roles.role-show', compact('permissions', 'role_id', 'role_name'));
    }
}
