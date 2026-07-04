<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'phone' => '9' . $this->faker->unique()->numerify('#########'),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => true,
            'phone_verified_at' => now(),
        ];
    }
}
