<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonalIOLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_io_logs', function (Blueprint $table) {
            $table->id();
            $table->string("type",16);
            $table->string("description",256);
            $table->foreignId("personal_id")->references("id")->on("personals");
            $table->foreignId("created_by")->references("id")->on("users");
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
        Schema::dropIfExists('personal_io_logs');
    }
}
