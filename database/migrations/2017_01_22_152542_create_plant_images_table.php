<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_images', function (Blueprint $table) {
            $table->increments('image_id');
            $table->integer('plant_id')->unsigned();
            $table->string('file_name', 100);
            $table->string('file_type', 4);
            $table->string('image_desc', 255)->nullable();
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
        Schema::dropIfExists('plant_images');
    }
}
