<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Store::factory()->count(100)->create();
    }
}
