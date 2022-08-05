<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition(){

        return [
            'category_id' => "1",
            'subcategory_id' => "2",
            'store_id' => "1",
            'product_name' => $this->faker->name(),
            'product_short_description' => $this->faker->sentence(20),
            'product_long_description' => $this->faker->sentence(150),
            'price' => rand(100,1000),
            'stock_count' => rand(1,20),
        ];
    }
}
