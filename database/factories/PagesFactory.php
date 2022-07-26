<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PagesFactory extends Factory
{

    public function definition(){

        return [
            'page_description' => $this->faker->sentence(750),
            'page_meta_keyword' => $this->faker->words(10, true),
            'page_meta_description' => $this->faker->words(10, true),
        ];
    }
}
