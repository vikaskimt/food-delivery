<?php

namespace Database\Factories;

use App\Models\FoodItem;
use App\Models\FoodVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodVariantFactory extends Factory
{
    protected $model = FoodVariant::class;

    public function definition(): array
    {
        return [
            'food_item_id' => FoodItem::factory(),
            'name' => $this->faker->randomElement(['Half', 'Full', 'Small', 'Large']),
            'price_delta' => $this->faker->randomElement([0, 20, 40, 60, 100]),
        ];
    }
}
