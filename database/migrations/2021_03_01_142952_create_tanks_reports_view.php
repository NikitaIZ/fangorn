<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateTanksReportsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tanks_reports = DB::table('tanks_reports')
                        ->select('tanks_reports.id as ID',
                                 'users.name as Usuario',
                                 'tanks_reports.tank_id as Tanque',
                                 'tanks.location as Ubicación',
                                 'tanks_reports.liters as Litros',
                                 'tanks_reports.created_at as Subido',
                                 'tanks_reports.updated_at as Actualizado')
                        ->leftJoin('users', 'users.id', '=', 'tanks_reports.user_id')
                        ->leftJoin('tanks', 'tanks.id', '=', 'tanks_reports.tank_id');
        Schema::createView('tanks_reports_view', $tanks_reports);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('tanks_reports_view');
    }
}
