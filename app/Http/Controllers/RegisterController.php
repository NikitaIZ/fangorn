<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Nivel\ModelHasRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function index(){
        return view('auth.register'); 
    }

    function create(Request $request){
        $User = new User();
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = Hash::make($request->password);

        $User->save();

        $ModelHasRole = new ModelHasRole();
        $ModelHasRole->role_id    = $request->nivel;
        $ModelHasRole->model_type = 'App\Models\User';
        $ModelHasRole->model_id   = $User->id;

        $ModelHasRole->save();

        $Team = new Team();
        $Team->user_id       = $User->id;
        $Team->name          = explode(' ', $request->name, 2)[0]."'s Team";
        $Team->personal_team = true;

        $Team->save();

        return redirect()->route('dashboard');
    }
}
