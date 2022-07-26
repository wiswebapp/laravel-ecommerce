<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class CategoryFactory extends Factory
{
    public function definition(){

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return [
            'category_name' => "Category_".rand(0,999999999)
        ];
    }
}
