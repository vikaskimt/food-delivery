<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // roles/permissions must exist before AdminSeeder assigns them
            AdminSeeder::class,          // super_admin / menu_manager / order_manager test accounts
            MenuSeeder::class,           // categories + food items + variants
            CouponSeeder::class,         // test coupons
            CustomerSeeder::class,       // test customers + addresses
            OrderSeeder::class,          // orders + order items + status history (needs the above)
        ]);
    }
}
