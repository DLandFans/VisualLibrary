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
            $table->increments('plant_id');
            $table->string('genus_name', 40)->nullable();
            $table->string('specific_epithet', 40)->nullable();
            $table->string('variety_name', 40)->nullable();
            $table->string('cultivar_name', 40)->nullable();
            $table->string('hybrid_genus', 40)->nullable();
            $table->string('hybrid_epithet', 40)->nullable();
            $table->tinyInteger('trademarked')->default(0);
            $table->string('common_name',75)->nullable();
            $table->integer('leaf_drop_bw')->default(0);
            $table->decimal('height_min',8,4)->default(0.0000);
            $table->decimal('height_max',8,4)->default(0.0000);
            $table->decimal('width_min',8,4)->default(0.0000);
            $table->decimal('width_max',8,4)->default(0.0000);
            $table->integer('zone_low')->default(0);
            $table->integer('zone_high')->default(0);
            $table->integer('bloom_months_bw')->default(0);
            $table->string('flower_color_desc', 75)->nullable();
            $table->integer('sun_exposure')->default(0);
            $table->integer('hardiness_low')->default(-99);
            $table->integer('hardiness_high')->default(-99);
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
