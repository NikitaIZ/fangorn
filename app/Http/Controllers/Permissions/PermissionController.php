<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:permissions.show')   ->only('index');
    }

    public function index()
    {
        return view('permissions.index');
    }
}
