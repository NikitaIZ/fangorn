<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateUsersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = DB::table('users')
        ->select('users.id as ID',
                'users.name as Nombre',
                'users.email as Correo_Electronico',
                'users.profile_photo_path as Foto_de_Perfil',
                'roles.name as Nivel',
                'users.created_at as Subido',
                'users.updated_at as Actualizado')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id');

        Schema::createView('users_view', $users);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_view');
    }
}
