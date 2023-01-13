<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketingData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('marketing_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('data', 15, 2);
            $table->foreignId("hotel_id")->references("id")->on("marketing_hotels");
            $table->foreignId("heading_id")->references("id")->on("marketing_headings");
            $table->foreignId("user_id")->references("id")->on("users");
            $table->date("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('marketing_data');
    }
}
