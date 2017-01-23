<?php

use Illuminate\Database\Seeder;

class CommonNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/common_names.sql'));
    }
}
