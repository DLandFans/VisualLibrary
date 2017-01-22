<?php

use Illuminate\Database\Seeder;

class FlowerColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('sql/flower_colors.sql'));
    }
}
