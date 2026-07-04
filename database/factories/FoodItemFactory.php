<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodItemFactory extends Factory
{
    protected $model = FoodItem::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($this->faker->unique()->words(3, true)),
            'description' => $this->faker->sentence(10),
            'image' => null,
            'price' => $this->faker->randomFloat(2, 49, 499),
            'is_veg' => $this->faker->boolean(70),
            'is_available' => true,
            'sort_order' => $this->faker->numberBetween(0, 50),
        ];
    }
}
