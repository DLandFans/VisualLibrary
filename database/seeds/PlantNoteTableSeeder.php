<?php

use Illuminate\Database\Seeder;

class PlantNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/plant_notes.sql'));
    }
}
