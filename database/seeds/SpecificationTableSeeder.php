<?php

use Illuminate\Database\Seeder;

class SpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/specifications.sql'));
    }
}
