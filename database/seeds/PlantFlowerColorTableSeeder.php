<?php

use Illuminate\Database\Seeder;

class PlantFlowerColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/plant_flower_color.sql'));
    }
}
