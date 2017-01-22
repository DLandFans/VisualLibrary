<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(PlantTableSeeder::class);

        $this->call(ClassificationTableSeeder::class);
        $this->call(FlowerColorTableSeeder::class);
        $this->call(SpecificationTableSeeder::class);

        $this->call(PlantClassificationTableSeeder::class);
        $this->call(PlantFlowerColorTableSeeder::class);
        $this->call(PlantSpecificationTableSeeder::class);

        $this->call(PlantImageTableSeeder::class);
        $this->call(PlantNoteTableSeeder::class);
    }
}
