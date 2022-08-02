<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition(){

        return [
            'owner' => $this->faker->firstName,
            'name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phonecode' => now(),
            'phone' => $this->faker->PhoneNumber,
            'address' => $this->faker->streetAddress,
            'location' => $this->faker->streetAddress,
            'country' => 101,
            'state' => 12,
            'zipcode' => $this->faker->postcode,
            'password' => '$2y$10$xSugoyKv765TY8DsERJ2/.mPIOwLNdM5Iw1n3x1XNVymBlHNG4cX6', // 123456
        ];
    }
}
