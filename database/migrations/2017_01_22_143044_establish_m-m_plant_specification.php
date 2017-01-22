<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstablishMMPlantSpecification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plant_specification', function (Blueprint $table) {
            $table->foreign('plant_id')->references('plant_id')->on('plants');
            $table->foreign('specification_id')->references('specification_id')->on('specifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plant_specification', function (Blueprint $table) {
            $table->dropForeign('plant_specification_plant_id_foreign');
            $table->dropForeign('plant_specification_specification_id_foreign');
        });
    }
}
