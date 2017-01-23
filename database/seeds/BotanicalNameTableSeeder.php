<?php

use Illuminate\Database\Seeder;

class BotanicalNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/botanical_names.sql'));
    }
}
