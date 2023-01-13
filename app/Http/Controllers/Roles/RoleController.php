<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.show')->only('index');
    }

    public function index()
    {
        return view('roles.index');
    }
}
