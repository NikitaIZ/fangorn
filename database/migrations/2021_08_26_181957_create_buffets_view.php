<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateBuffetsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $buffets = DB::table('buffets')
        ->select('buffets.id as ID',
                'users.name as Usuario',
                'buffets.service as Servicio',
                'buffets.adults as Adultos',
                'buffets.children as Niños',
                'buffets.created_at as Subido',
                'buffets.updated_at as Actualizado')
        ->leftJoin('users', 'users.id', '=', 'buffets.user_id');

        Schema::createView('buffets_view', $buffets);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buffets_view');
    }
}
