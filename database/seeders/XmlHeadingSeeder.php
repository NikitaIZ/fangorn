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
        $url   = "http://10.80.22.172:8088/xml/020321/manager.xml";
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
    }
}
