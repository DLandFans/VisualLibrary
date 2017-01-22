<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstablishMMPlantClassification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plant_classification', function (Blueprint $table) {
            $table->foreign('plant_id')->references('plant_id')->on('plants');
            $table->foreign('class_id')->references('class_id')->on('classifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plant_classification', function (Blueprint $table) {
            $table->dropForeign('plant_classification_plant_id_foreign');
            $table->dropForeign('plant_classification_class_id_foreign');
        });
    }
}
