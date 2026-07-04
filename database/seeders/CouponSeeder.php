<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'WELCOME50', 'type' => 'flat', 'value' => 50, 'min_order_amount' => 199, 'max_discount' => null, 'usage_limit' => 500, 'per_user_limit' => 1],
            ['code' => 'SAVE20', 'type' => 'percent', 'value' => 20, 'min_order_amount' => 299, 'max_discount' => 150, 'usage_limit' => 200, 'per_user_limit' => 2],
            ['code' => 'FLAT100', 'type' => 'flat', 'value' => 100, 'min_order_amount' => 499, 'max_discount' => null, 'usage_limit' => null, 'per_user_limit' => 1],
        ];

        foreach ($coupons as $data) {
            Coupon::firstOrCreate(
                ['code' => $data['code']],
                array_merge($data, [
                    'used_count' => 0,
                    'valid_from' => now()->subDays(5),
                    'valid_until' => now()->addDays(60),
                    'is_active' => true,
                ])
            );
        }

        $this->command?->info('Seeded ' . count($coupons) . ' coupons.');
    }
}
