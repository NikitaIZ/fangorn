<?php

namespace Database\Seeders;

use App\Models\Xml\XmlHeading;
use Illuminate\Database\Seeder;

class XmlHeadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url   = "";
        $xml   = simplexml_load_file($url);
        $json  = json_encode($xml);
        $array = json_decode($json,TRUE);

        $data = $array['LIST_G_MASTER_VALUE_ORDER']['G_MASTER_VALUE_ORDER']['LIST_G_LAST_YEAR_01']['G_LAST_YEAR_01']['LIST_G_CROSS']['G_CROSS']['LIST_G_MASTER_VALUE']['G_MASTER_VALUE'];
                
        foreach ($data as $key => $value) {
            $heading = new XmlHeading();

            $heading->name        = $value['SUB_GRP_1'];
            $heading->description = $value['DESCRIPTION'];

            $heading->save();
        }

        $heading = new XmlHeading();

        $heading->name        = 'OCC_ROOMS_TIME_SHARE';
        $heading->description = 'Rooms Occupied Time Share';

        $heading->save();

        $heading = new XmlHeading();

        $heading->name        = 'OCC_MINUS_COMP_HU_TS';
        $heading->description = 'Rooms Occupied minus Comp, House Use and TS';

        $heading->save();

        $heading = new XmlHeading();

        $heading->name        = 'OCC_PERC_TS';
        $heading->description = '% Rooms Occupied TimeShare';

        $heading->save();

        $heading = new XmlHeading();

        $heading->name        = 'OCC_PERC_WO_CHTS';
        $heading->description = '% Rooms Occupied minus Comp, House and TS';

        $heading->save();

        $heading = new XmlHeading();

        $heading->name        = 'ADR_ROOM_WO_CHTS';
        $heading->description = 'ADR minus Comp and House Use and TimeShare';

        $heading->save();

        $heading = new XmlHeading();

        $heading->name        = 'REV_PAR';
        $heading->description = 'Revenue Per Available Room Day';

        $heading->save();

    }
}
