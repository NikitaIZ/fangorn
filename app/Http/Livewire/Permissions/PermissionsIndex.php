<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use App\Models\Views\ViewUser;
use Spatie\Permission\Models\Permission;

use Livewire\WithPagination;

class PermissionsIndex extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $permissions = Permission::where('name', 'LIKE', '%' . $this->search . '%')->paginate();

        return view('livewire.permissions.permissions-index', compact('permissions'));
    }
}
