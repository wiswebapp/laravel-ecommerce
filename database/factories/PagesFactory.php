<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pages;
use Faker\Generator as Faker;

$factory->define(Pages::class, function (Faker $faker) {
    return [
        'page_description' => $faker->sentence(750),
        'page_meta_keyword' => $faker->words(10, true),
        'page_meta_description' => $faker->words(10, true),
    ];
});
