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
            $table->string('firstname', 255);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('organisation', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('participant_firstname', 255)->nullable();
            $table->string('participant_name', 255)->nullable();
            $table->string('participant_email', 255)->nullable();
            $table->string('participant_phone', 255)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('is_member')->default(0);
            $table->string('event_title', 255)->nullable();
            $table->string('event_date', 255)->nullable();
            $table->string('event_time', 255)->nullable();
            $table->string('event_location', 255)->nullable();
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
