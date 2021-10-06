<?php

namespace Database\Seeders;

use App\Models\Tanks\TankReport;
use Illuminate\Database\Seeder;

class TankReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tankReport = new TankReport();

        $tankReport->user_id = 2;
        $tankReport->tank_id = 1;
        $tankReport->liters  = 75;
        $tankReport->description = "";

        $tankReport->save();
    }
}
