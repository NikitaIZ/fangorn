<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.permissions.edit')->only('edit','update');
    }

    public function update(Request $request, $id)
    {
        $role = Role::where('id', $id)->first();
        $role->syncPermissions($request->except(['_method', '_token']));

        return redirect()->route('roles.show', $id);
    }

}
