<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:permissions.index')  ->only('index');
        $this->middleware('can:permissions.create') ->only('create','store');
        $this->middleware('can:permissions.show')   ->only('show');
        $this->middleware('can:permissions.edit')   ->only('edit','update');
        $this->middleware('can:permissions.destroy')->only('destroy');
    }

    public function index()
    {
        return view('permissions.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Permission::create(['name' => $request->name]);
        /*Permission::create(['name' => $request->name . '.index']);
        Permission::create(['name' => $request->name . '.create']);
        Permission::create(['name' => $request->name . '.store']);
        Permission::create(['name' => $request->name . '.destroy']);
        Permission::create(['name' => $request->name . '.update']);
        Permission::create(['name' => $request->name . '.edit']);
        Permission::create(['name' => $request->name . '.show']);*/

        return redirect()->route('permissions.index')->with('info', 'Role creado');
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
        //
    }

    public function destroy($id)
    {
        Permission::destroy($id);

        return redirect()->route('permissions.index')->with('delete', 'Role Eliminado');
    }
}
