<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;


class CreateXmlReportsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $xml_reports = DB::table('xml_data')
        ->select('xml_reports.id as ID',
                 'xml_reports.date as Fecha',
                 'xml_reports.document as Documento',
                 'xml_headings.description as Descripción',
                 'xml_data.day as Dia',
                 'xml_data.month as Mes',
                 'xml_data.year as Año',
                 'xml_reports.created_at as Subido',
                 'xml_reports.updated_at as Actualizado')
        ->leftJoin('xml_reports', 'xml_reports.id', '=', 'xml_data.report_id')
        ->leftJoin('xml_headings', 'xml_headings.id', '=', 'xml_data.heading_id');

        Schema::createView('xmls_reports_view', $xml_reports);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xmls_reports_view');
    }
}
