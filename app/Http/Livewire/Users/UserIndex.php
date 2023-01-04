<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination;

    public $user;

    public $search      = '';
    public $cant        = '10';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;
    public $password = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'user.name'  => 'required',
        'user.email' => 'required',
        'user.role'  => 'required',
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
        $roles = Role::get();
        if ($this->readyToLoad){
            $users = User::select('users.id', 'users.name', 'email', 'roles.name as role')
                            ->join('model_has_roles', 'id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->where('users.name', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('users.email', 'LIKE', '%' . $this->search . '%')
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
        }else{
            $users = [];
        }
        return view('livewire.users.user-index', compact('users', 'roles'));
    }

    public function loadUsers()
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

    public function edit($id)
    {
        $user = User::select('users.id', 'users.name', 'email', 'model_has_roles.role_id as role')
                            ->join('model_has_roles', 'id', '=', 'model_has_roles.model_id')
                            ->where('users.id', $id)->first();
        $this->user = $user;
    }

    public function update()
    {
        if ($this->user->name && $this->user->email)
        {
            if (empty($this->password) == false) {
                $this->user->password = Hash::make($this->password);
                User::where('id', $this->user->id)->update([
                                                            'name' => $this->user->name,
                                                            'email' => $this->user->email,
                                                            'password' => $this->user->password,
                                                        ]);
            }else{
                User::where('id', $this->user->id)->update([
                                                            'name' => $this->user->name,
                                                            'email' => $this->user->email,
                ]);
            }
            $user = User::where('id', $this->user->id)->first();
            $role = Role::where('id', $this->user->role)->value('name');
            $user->assignRole($role);

            $this->emit('alert', 'Se actualizo el Role sin problemas');
            $this->emitTo('roles.role-index', 'render');
        }else {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

}
