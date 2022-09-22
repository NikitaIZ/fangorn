<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateXmlForecastReportsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $xml_forecast = DB::table('xml_forecast_dates')
        ->select('xml_forecast_reports.id as ID',
                'xml_forecast_reports.date as Reporte',
                'xml_forecast_dates.date as Fecha',
                'xml_headings.description as Descripción',
                'xml_forecast_data.dato as Dato',
                'dolars.daily_rate as Tasa_del_Día',
                'xml_forecast_reports.created_at as Subido',
                'xml_forecast_reports.updated_at as Actualizado')
        ->leftJoin('dolars', 'dolars.id', '=', 'xml_forecast_dates.dolar_id')
        ->leftJoin('xml_forecast_reports', 'xml_forecast_reports.id', '=', 'xml_forecast_dates.report_id')
        ->leftJoin('xml_forecast_data', 'xml_forecast_dates.id', '=', 'xml_forecast_data.date_id')
        ->leftJoin('xml_headings', 'xml_headings.id', '=', 'xml_forecast_data.heading_id');

        Schema::createView('xml_forecast_reports_view', $xml_forecast);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xml_forecast_reports_view');
    }
}
