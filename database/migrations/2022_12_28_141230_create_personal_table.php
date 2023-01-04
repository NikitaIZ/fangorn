<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string("name",64);
            $table->string("last_name",64);
            $table->integer("identification")->unique();
            $table->integer("state");
            $table->integer("warn_count");
            $table->foreignId("area_id")->references("id")->on("areas");
            $table->foreignId("position_id")->references("id")->on("positions");
            $table->foreignId('created_by_id')->references("id")->on("users");
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
        Schema::dropIfExists('personals');
    }
}
