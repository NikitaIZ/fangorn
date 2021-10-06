<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Nivel\RoleHasPermission;
use Illuminate\Http\Request;
use App\Models\Views\ViewRoles;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.permissions.index')  ->only('index');
        $this->middleware('can:roles.permissions.create') ->only('create','store');
        $this->middleware('can:roles.permissions.show')   ->only('show');
        $this->middleware('can:roles.permissions.edit')   ->only('edit','update');
        $this->middleware('can:roles.permissions.destroy')->only('destroy');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $verification = ViewRoles::check('ID_Role', $id, 'ID_Permiso', $request->id);

        if ($verification) {
            return redirect()->route('roles.show', $id)->with('warning', 'El Role ya tiene ese permiso');
        }else{
            $RolePermission = new RoleHasPermission();
            $RolePermission->permission_id = $request->id;
            $RolePermission->role_id = $id;
            $RolePermission->save();
            return redirect()->route('roles.show', $id)->with('info', 'Nuevo permiso agregado');
        }
    }

    public function destroy(Request $request, $id)
    {
        RoleHasPermission::where('role_id', $id)->where('permission_id', $request->permiso)->delete();
        return redirect()->route('roles.show', $id)->with('danger', 'El permiso se elimino');
    }
}
