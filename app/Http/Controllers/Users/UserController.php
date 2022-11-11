<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
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
        return view('users.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $name)
    {
    }

    public function destroy($id)
    {
    }
}
