<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstablishMMPlantFlowercolor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plant_flower_color', function (Blueprint $table) {
            $table->foreign('plant_id')->references('plant_id')->on('plants');
            $table->foreign('flower_color_id')->references('flower_color_id')->on('flower_colors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plant_flower_color', function (Blueprint $table) {
            $table->dropForeign('plant_flower_color_plant_id_foreign');
            $table->dropForeign('plant_flower_color_flower_color_id_foreign');
        });
    }
}
