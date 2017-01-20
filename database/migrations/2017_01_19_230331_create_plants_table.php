<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
//            $table->increments('plant_id');
            $table->increments('plant_id');
            $table->string('genus_name', 40)->nullable();
            $table->string('specific_epithet', 40)->nullable();
            $table->string('variety_name', 40)->nullable();
            $table->string('cultivar_name', 40)->nullable();
            $table->string('hybrid_genus', 40)->nullable();
            $table->string('hybrid_epithet', 40)->nullable();
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
        Schema::dropIfExists('plants');
    }
}
