<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'label' => $this->faker->randomElement(['Home', 'Work', 'Other']),
            'full_address' => $this->faker->address(),
            'landmark' => $this->faker->streetName(),
            'latitude' => $this->faker->latitude(28.4, 28.9),
            'longitude' => $this->faker->longitude(77.0, 77.6),
            'is_default' => false,
        ];
    }
}
