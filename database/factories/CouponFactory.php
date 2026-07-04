<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['flat', 'percent']);

        return [
            'code' => strtoupper($this->faker->unique()->bothify('SAVE##??')),
            'type' => $type,
            'value' => $type === 'flat' ? $this->faker->randomElement([50, 100, 150]) : $this->faker->randomElement([10, 15, 20]),
            'min_order_amount' => $this->faker->randomElement([0, 199, 299, 499]),
            'max_discount' => $type === 'percent' ? $this->faker->randomElement([100, 150, 200]) : null,
            'usage_limit' => $this->faker->randomElement([50, 100, null]),
            'per_user_limit' => 1,
            'used_count' => 0,
            'valid_from' => now()->subDays(5),
            'valid_until' => now()->addDays(30),
            'is_active' => true,
        ];
    }
}
