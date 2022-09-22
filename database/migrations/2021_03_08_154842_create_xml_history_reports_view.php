<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateXmlHistoryReportsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $xml_history_reports = DB::table('xml_history_reports')
        ->select('xml_history_reports.id as id',
                'xml_history_reports.folder as folder',
                'xml_history_reports.date as date',
                'xml_headings.id as headings_id',
                'xml_headings.description as description',
                'xml_history_data.day as day',
                'xml_history_data.month as month',
                'xml_history_data.year as year',
                'dolars.daily_rate as daily_rate',
                'xml_history_reports.created_at as created_at',
                'xml_history_reports.updated_at as updated_at')
        ->leftJoin('dolars', 'dolars.id', '=', 'xml_history_reports.dolar_id')
        ->leftJoin('xml_history_data', 'xml_history_data.report_id', '=', 'xml_history_reports.id')
        ->leftJoin('xml_headings', 'xml_headings.id', '=', 'xml_history_data.heading_id');

        Schema::createView('xml_history_reports_view', $xml_history_reports);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xml_history_reports_view');
    }
}
