<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('firstname', 255);
            $table->string('street', 255);
            $table->string('location', 255);
            $table->string('phone_business', 255)->nullable();
            $table->string('phone_private', 255);
            $table->string('email', 255);
            $table->string('event_title', 255)->nullable();
            $table->string('event_date', 255)->nullable();
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
        Schema::dropIfExists('event_subscribers');
    }
}
