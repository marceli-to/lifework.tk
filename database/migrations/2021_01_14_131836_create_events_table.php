<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('category', 255)->nullable();
            $table->string('title', 255);
            $table->text('description');
            $table->string('target_group', 255)->nullable();
            $table->string('date', 255)->nullable();
            $table->string('time', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('host', 255)->nullable();
            $table->string('host_title', 255)->nullable();
            $table->string('cost', 255)->nullable();
            $table->date('dateDeadline')->nullable();
            $table->tinyInteger('hasForm')->default(1);
            $table->string('email', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->date('dateShowUntil')->nullable();
            $table->tinyInteger('isBildungskrippe')->nullable();
            $table->tinyInteger('isKita')->nullable();
            $table->tinyInteger('isLeadership')->nullable();
            $table->tinyInteger('isCompany')->nullable();
            $table->tinyInteger('isOther')->nullable();
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
        Schema::dropIfExists('events');
    }
}
