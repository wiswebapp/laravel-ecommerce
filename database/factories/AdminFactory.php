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
            'password' => '123456',
        ];
    }
}
