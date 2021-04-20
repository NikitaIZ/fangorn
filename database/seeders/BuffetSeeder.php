<?php

namespace Database\Seeders;

use App\Models\Buffet;
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
        $buffet->service  = 'breakfast';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'lunch';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'dinner';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'brunch';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'pool day';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();

        $buffet = new Buffet();

        $buffet->user_id  = 1;
        $buffet->service  = 'additional pax';
        $buffet->adults   = 0;
        $buffet->children = 0;

        $buffet->save();
    }
}