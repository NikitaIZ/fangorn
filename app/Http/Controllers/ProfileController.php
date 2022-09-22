<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\StatefulGuard;

use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

use Livewire\WithFileUploads;

use Spatie\Permission\Models\Role;


class ProfileController extends Controller
{
    use WithFileUploads;

    public $photo;

    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    function index(Request $request){
        $role_name = Role::where('id', $request->user()->id)->value('name');
        return view('profile', [
            'role' => $role_name,
            'request' => $request,
            'user' => $request->user(),
        ]); 
    }

    function update(Request $request, UpdateUserProfileInformation $updater){
        $state = array('name' => $request->username, 'email' => $request->email);
        $updater->update(
            Auth::user(), $request->photo
            ? array_merge($state, ['photo' => $request->photo])
            : $state
        );
        if (isset($request->photo)) {
            return redirect()->route('profile.index');
        }
        return back(303)->with('status', 'guardado');
    }

    public function deleteProfilePhoto(){
        Auth::user()->deleteProfilePhoto();
        return back(303)->with('status', 'profile-photo-deleted');
    }

    public function updatePassword(Request $request, UpdateUserPassword $updater){
        $state = array('current_password' => $request->current_password, 'password' => $request->new_password, 'password_confirmation' => $request->confirm_password);
        $updater->update(Auth::user(), $state);
        $state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
        return back(303)->with('status', 'guardado');
    }

    public function updateAuthenticator(Request $request, EnableTwoFactorAuthentication $enable){
        $confirmed = app(ConfirmPassword::class)(
            $this->guard, $request->user(), $request->password
        );
        if ($confirmed == true){
            $enable($request->user());

            return $request->wantsJson()
                        ? new JsonResponse('', 200)
                        : back()->with('status', 'two-factor-authentication-enabled');
        }else{
            echo "incorrecto";
        }
    }
}
