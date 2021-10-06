<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use App\Models\Views\ViewUser;

use Livewire\WithPagination;

class RolesIndex extends Component
{

    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $users = ViewUser::where('Nombre', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('Correo_Electronico', 'LIKE', '%' . $this->search . '%')
                    ->paginate();

        return view('livewire.roles.roles-index', compact('users'));
    }
}
