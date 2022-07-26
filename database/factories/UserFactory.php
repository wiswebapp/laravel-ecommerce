<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{

    public function definition(){

        return [
            'fname' => $this->faker->firstName,
            'lname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'phonecode' => now(),
            'phone' => $this->faker->PhoneNumber,
            'country' => 101,
            'state' => 4133,
            'phone_verified_at' => now(),
            'password' => '$2y$10$xSugoyKv765TY8DsERJ2/.mPIOwLNdM5Iw1n3x1XNVymBlHNG4cX6', // 123456
        ];
    }
}
