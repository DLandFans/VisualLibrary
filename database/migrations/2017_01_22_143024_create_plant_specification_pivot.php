<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantSpecificationPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_specification', function (Blueprint $table) {
            $table->increments('plant_specification_id');
            $table->integer('plant_id')->unsigned();
            $table->integer('specification_id')->unsigned();
            $table->string('specification_note',255)->nullable();
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
        Schema::dropIfExists('plant_specification');
    }
}
