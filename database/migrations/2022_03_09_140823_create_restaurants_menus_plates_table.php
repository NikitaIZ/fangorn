<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsMenusPlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants_menus_plates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->index();
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 15, 5);
            $table->decimal('service', 15, 5);
            $table->foreignId('choice_id')->index();
            $table->foreignId('country_id')->index();
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
        Schema::dropIfExists('restaurants_menus_plates');
    }
}
