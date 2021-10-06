<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

use Livewire\WithPagination;

class RolesCreate extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }
    
    public function render()
    {
        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')->paginate();
        return view('livewire.roles.roles-create', compact('roles'));
    }
}
