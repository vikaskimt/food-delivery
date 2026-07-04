<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'image' => null,
            'sort_order' => $this->faker->numberBetween(0, 20),
            'is_active' => true,
        ];
    }
}
