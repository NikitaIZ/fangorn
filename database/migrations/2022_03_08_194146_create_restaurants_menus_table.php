<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->index();
            $table->string('language');
            $table->string('type');
            $table->string('name');
            $table->boolean('description');
            $table->boolean('service');
            $table->boolean('choice');
            $table->boolean('country');
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
        Schema::dropIfExists('restaurants_menus');
    }
}
