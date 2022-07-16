<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
        'subcategory_id' => function() {
            return factory(Category::class)->create([
                'parent_id' => factory(Category::class)->create()->id,
            ])->id;
        },
        'product_name' => $faker->name,
        'product_short_description' => $faker->sentence(20),
        'product_short_description' => $faker->sentence(150),
        'price' => rand(100,1000),
    ];
});
