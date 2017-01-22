<?php

use Illuminate\Database\Seeder;

class PlantClassificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/plant_classification.sql'));
    }
}
