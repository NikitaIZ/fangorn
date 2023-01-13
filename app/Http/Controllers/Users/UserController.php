<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.show')->only('index');
    }

    public function index()
    {
        return view('users.index');
    }
}
