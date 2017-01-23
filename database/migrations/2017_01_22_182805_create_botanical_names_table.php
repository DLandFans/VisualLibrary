<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotanicalNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('botanical_names', function (Blueprint $table) {
            $table->increments('botanical_id');
            $table->integer('plant_id')->unsigned();
            $table->string('genus_name', 40)->nullable();
            $table->string('specific_epithet', 40)->nullable();
            $table->string('variety_name', 40)->nullable();
            $table->string('cultivar_name', 40)->nullable();
            $table->string('hybrid_genus', 40)->nullable();
            $table->string('hybrid_epithet', 40)->nullable();
            $table->tinyInteger('trademarked')->default(0);
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
        Schema::dropIfExists('botanical_names');
    }
}
