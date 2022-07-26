<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{

    public function definition(){

        return [
            'name' => $this->faker->name,
            'email' => "admin_". rand(0,999)."@example.com",
            'phonecode' => now(),
            'phone' => $this->faker->PhoneNumber,
            'password' => '$2y$10$xSugoyKv765TY8DsERJ2/.mPIOwLNdM5Iw1n3x1XNVymBlHNG4cX6',
        ];
    }
}
