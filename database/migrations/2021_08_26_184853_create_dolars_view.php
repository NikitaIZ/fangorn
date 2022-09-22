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
        ->select('dolars.id as id',
                'users.id as user_id',
                'users.name as user',
                'dolars.daily_rate as daily_rate',
                'dolars.date as date',
                'dolars.created_at as created_at',
                'dolars.updated_at as updated_at')
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
