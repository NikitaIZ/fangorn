<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketingHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('marketing_hotels', function (Blueprint $table) {
            $table->id();
            $table->string("name",128);
            $table->integer("stars");
            $table->foreignId("type_id")->references("id")->on("marketing_hotels_types");
            $table->foreignId("user_id")->references("id")->on("users");
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
        Schema::dropIfExists('marketing_hotels');
    }
}
