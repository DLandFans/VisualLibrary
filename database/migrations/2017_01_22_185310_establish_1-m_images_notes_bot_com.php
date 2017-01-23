<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Establish1MImagesNotesBotCom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plant_images', function (Blueprint $table) { $table->foreign('plant_id')->references('plant_id')->on('plants'); });
        Schema::table('plant_notes', function (Blueprint $table) { $table->foreign('plant_id')->references('plant_id')->on('plants'); });
        Schema::table('botanical_names', function (Blueprint $table) { $table->foreign('plant_id')->references('plant_id')->on('plants'); });
        Schema::table('common_names', function (Blueprint $table) { $table->foreign('plant_id')->references('plant_id')->on('plants'); });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plant_images', function (Blueprint $table) { $table->dropForeign('plant_images_plant_id_foreign'); });
        Schema::table('plant_notes', function (Blueprint $table) { $table->dropForeign('plant_notes_plant_id_foreign'); });
        Schema::table('botanical_names', function (Blueprint $table) { $table->dropForeign('botanical_names_plant_id_foreign'); });
        Schema::table('common_names', function (Blueprint $table) { $table->dropForeign('common_names_plant_id_foreign'); });
    }
}
