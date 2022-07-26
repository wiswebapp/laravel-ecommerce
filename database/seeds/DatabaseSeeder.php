<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            AdminTableSeeder::class,
            UserTableSeeder::class,
            CategoryTableSeeder::class,
            ProductTableSeeder::class,
            CountriesTableSeeder::class,
            StateTableSeeder::class,
            CitiesTableSeeder::class,
            PageTableSeeder::class,
        ]);

    }
}
