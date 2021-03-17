<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('caption')->nullable();
            $table->double('coords_w', 16, 12)->nullable();
            $table->double('coords_h', 16, 12)->nullable();
            $table->double('coords_x', 16, 12)->nullable();
            $table->double('coords_y', 16, 12)->nullable();
            $table->string('orientation', 10)->nullable();
            $table->tinyInteger('order')->default(-1);
            $table->tinyInteger('publish')->default(0);
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('post_images');
    }
}
