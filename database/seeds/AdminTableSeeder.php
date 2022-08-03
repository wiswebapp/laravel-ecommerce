<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::factory()->count(1)->create();
    }
}
