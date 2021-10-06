<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateRolesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = DB::table('role_has_permissions')
        ->select('roles.id as ID_Role',
                'roles.name as Role',
                'permissions.id as ID_Permiso',
                'permissions.name as Permiso',
                'role_has_permissions.created_at as Subido',
                'role_has_permissions.updated_at as Actualizado')
        ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->leftJoin('roles', 'roles.id', '=', 'role_has_permissions.role_id');

        Schema::createView('roles_view', $roles);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_view');
    }
}
