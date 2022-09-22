<?php

namespace Database\Seeders;

use App\Models\Audit\Buffet;
use Illuminate\Database\Seeder;

class BuffetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Breakfast Plus';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Breakfast';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Lunch';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Dinner';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Brunch';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Pool Day';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'Additional Pax';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();
    }
}