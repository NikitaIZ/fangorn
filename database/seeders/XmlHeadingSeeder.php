<?php

namespace Database\Seeders;

use App\Models\Audit\Xml\XmlHeading;
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
        /*$url   = "http://10.80.22.178:8088/manager.xml";
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

        $heading->save();*/

        $headingNews = array(
            0 => array(
                'name'        => 'OCC_ROOMS_BY_GRP',
                'description' => 'Rooms Occupied by Group'
            ),
            1 => array(
                'name'        => 'OCC_ROOMS_BY_TRN',
                'description' => 'Rooms Occupied by Transient'
            ),
            2 => array(
                'name'        => 'OCC_ROOMS_BY_WHL',
                'description' => 'Rooms Occupied by Wholesale'
            ),
            3 => array(
                'name'        => 'OCC_ROOMS_BY_CON',
                'description' => 'Rooms Occupied by Contract'
            ),
            4 => array(
                'name'        => 'OCC_ROOMS_BY_COMP',
                'description' => 'Rooms Occupied by Complimentary'
            ),
            5 => array(
                'name'        => 'OCC_ROOMS_COM',
                'description' => 'Rooms Occupied Commercial'
            ),
            6 => array(
                'name'        => 'OCC_ROOMS_MEG',
                'description' => 'Rooms Occupied Mega Agency / Consort'
            ),
            7 => array(
                'name'        => 'OCC_ROOMS_NAT',
                'description' => 'Rooms Occupied Corp Pref-National'
            ),
            8 => array(
                'name'        => 'OCC_ROOMS_LOC',
                'description' => 'Rooms Occupied Corp Pref-Local'
            ),
            9 => array(
                'name'        => 'OCC_ROOMS_GOV',
                'description' => 'Rooms Occupied Goverment'
            ),
            10 => array(
                'name'        => 'OCC_ROOMS_PKG',
                'description' => 'Rooms Occupied Package'
            ),
            11 => array(
                'name'        => 'OCC_ROOMS_BPR',
                'description' => 'Rooms Occupied Brand Promotions'
            ),
            12 => array(
                'name'        => 'OCC_ROOMS_INT',
                'description' => 'Rooms Occupied Internet Mktg Progs'
            ),
            13 => array(
                'name'        => 'OCC_ROOMS_IOP',
                'description' => 'Rooms Occupied Opaque Internet'
            ),
            14 => array(
                'name'        => 'OCC_ROOMS_DIS',
                'description' => 'Rooms Occupied Qualified Discounts'
            ),
            15 => array(
                'name'        => 'OCC_ROOMS_WHD',
                'description' => 'Rooms Occupied Wholesale-N Am'
            ),
            16 => array(
                'name'        => 'OCC_ROOMS_WHI',
                'description' => 'Rooms Occupied Wholesale International'
            ),
            17 => array(
                'name'        => 'OCC_ROOMS_WHPI',
                'description' => 'Rooms Occupied Wholesale Property International'
            ),
            18 => array(
                'name'        => 'OCC_ROOMS_WHPN',
                'description' => 'Rooms Occupied Wholesale Property National'
            ),
            19 => array(
                'name'        => 'OCC_ROOMS_WHC',
                'description' => 'Rooms Occupied Wholesale-Cruise'
            ),
            20 => array(
                'name'        => 'OCC_ROOMS_GCP',
                'description' => 'Rooms Occupied Group-Corporate'
            ),
            21 => array(
                'name'        => 'OCC_ROOMS_GCM',
                'description' => 'Rooms Occupied Group-CMP'
            ),
            22 => array(
                'name'        => 'OCC_ROOMS_GDP',
                'description' => 'Rooms Occupied European Plan with a Day Meeting Package'
            ),
            23 => array(
                'name'        => 'OCC_ROOMS_GEP',
                'description' => 'Rooms Occupied Group EP'
            ),
            24 => array(
                'name'        => 'OCC_ROOMS_GTR',
                'description' => 'Rooms Occupied Group-Training'
            ),
            25 => array(
                'name'        => 'OCC_ROOMS_GTT',
                'description' => 'Rooms Occupied Group Tour & Travel'
            ),
            26 => array(
                'name'        => 'OCC_ROOMS_GAS',
                'description' => 'Rooms Occupied Group-Association'
            ),
            27 => array(
                'name'        => 'OCC_ROOMS_GMP',
                'description' => 'Rooms Occupied GMP – Group MMP Modified Meeting Package'
            ),
            28 => array(
                'name'        => 'OCC_ROOMS_GSF',
                'description' => 'Rooms Occupied Group-SMERF'
            ),
            29 => array(
                'name'        => 'OCC_ROOMS_WEDD',
                'description' => 'Rooms Occupied Weeding'
            ),
            30 => array(
                'name'        => 'OCC_ROOMS_GGV',
                'description' => 'Rooms Occupied Group-Government'
            ),
            31 => array(
                'name'        => 'OCC_ROOMS_CNT',
                'description' => 'Rooms Occupied Contract'
            ),
            32 => array(
                'name'        => 'OCC_ROOMS_ATP',
                'description' => 'Rooms Occupied Contract Airline Crew'
            ),
            33 => array(
                'name'        => 'OCC_ROOMS_CMP',
                'description' => 'Rooms Occupied Complimentary'
            ),
            34 => array(
                'name'        => 'OCC_ROOMS_HSU',
                'description' => 'Rooms Occupied House Use'
            ),
            35 => array(
                'name'        => 'OCC_ROOMS_SLB',
                'description' => 'Rooms Occupied Super Liga Baloncesto'
            )
        );

        foreach ($headingNews as $value) {
            $heading = new XmlHeading();
            $heading->name        = $value['name'];
            $heading->description = $value['description'];
            $heading->save();
        }
    }
}
