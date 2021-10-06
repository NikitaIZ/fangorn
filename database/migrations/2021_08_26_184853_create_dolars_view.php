<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateDolarsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dolars = DB::table('dolars')
        ->select('dolars.id as ID',
                'users.name as Usuario',
                'dolars.daily_rate as Tasa_del_día',
                'dolars.date as Fecha',
                'dolars.created_at as Subido',
                'dolars.updated_at as Actualizado')
        ->leftJoin('users', 'users.id', '=', 'dolars.user_id');

        Schema::createView('dolars_view', $dolars);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dolars_view');
    }
}
