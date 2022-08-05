<?php

use Database\Seeders\AdminTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\PageTableSeeder;
use Database\Seeders\ProductTableSeeder;
use Database\Seeders\StateTableSeeder;
use Database\Seeders\StoreTableSeeder;
use Database\Seeders\UserTableSeeder;
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
            PageTableSeeder::class,
            AdminTableSeeder::class,
            UserTableSeeder::class,
            CountriesTableSeeder::class,
            StateTableSeeder::class,
            CitiesTableSeeder::class,
            //Dependent Seeders
            StoreTableSeeder::class,
            CategoryTableSeeder::class,
            ProductTableSeeder::class,
        ]);

    }
}
