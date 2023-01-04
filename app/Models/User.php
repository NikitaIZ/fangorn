<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminlte_image()
    {
        $id = Auth::user()->id;
        $url = DB::table('users')->where('id', $id)->value('profile_photo_path');
        return 'http://190.205.33.228:8088/img/'.$url;
    }

    public function adminlte_desc()
    {
        $id     = Auth::user()->id;
        $idRole = DB::table('model_has_roles')->where('model_id', $id)->value('role_id');

        switch ($idRole) {
            case 2:
                $role = 'Administrador';
                break;
            case 3:
                $role = 'Gerente';
                break;
            case 4:
                $role = 'Coordinador';
                break;
            default:
                $role   = DB::table('roles')->where('id', $idRole)->value('name');
        }

        return $role;
    }

    /*public function adminlte_profile_url()
    {
        return 'profile/username';
    }*/
}
