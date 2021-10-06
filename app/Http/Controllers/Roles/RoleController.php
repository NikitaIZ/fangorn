<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.index')  ->only('index');
        $this->middleware('can:roles.create') ->only('create','store');
        $this->middleware('can:roles.show')   ->only('show');
        $this->middleware('can:roles.edit')   ->only('edit','update');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    public function index()
    {
        return view('roles.index');
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        Role::create(['name' => $request->name]);

        return redirect()->route('roles.create')->with('info', 'Role creado');
    }

    public function show($id)
    {
        $role_name = Role::where('id', $id)->value('name');
        return view('roles.show', compact('id', 'role_name'));
    }

    public function edit($id)
    {
        $user  = User::find($id);
        $roles = Role::all();
        return view('roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $name)
    {
        $user  = User::find($name);
        $user->roles()->sync($request->roles);
        return redirect()->route('roles.edit', $user)->with('info', 'Se asignó el Role correctamente');
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return redirect()->route('roles.create')->with('delete', 'Role Eliminado');
    }
}
