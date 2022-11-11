<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->index();
            $table->string('client');
            $table->integer('adults');
            $table->integer('childrem');
            $table->decimal('subtotal', 15, 5);
            $table->decimal('coupon', 15, 5);
            $table->decimal('total', 15, 5);
            $table->decimal('price', 15, 5);
            $table->string('group');
            $table->string('seats');
            $table->enum('status', ['completed', 'on hold', 'cancelled']);
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
        Schema::dropIfExists('events_bookings');
    }
}
