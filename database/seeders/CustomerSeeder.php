<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // A handful of predictable test customers, plus a batch of random ones.
        $fixed = [
            ['phone' => '9999999901', 'name' => 'Vikas Chauhan', 'email' => 'vikas@test.com'],
            ['phone' => '9999999902', 'name' => 'Priya Sharma', 'email' => 'priya@test.com'],
            ['phone' => '9999999903', 'name' => 'Rahul Verma', 'email' => 'rahul@test.com'],
        ];

        foreach ($fixed as $data) {
            $user = User::firstOrCreate(
                ['phone' => $data['phone']],
                array_merge($data, ['is_active' => true, 'phone_verified_at' => now()])
            );

            if ($user->addresses()->count() === 0) {
                $user->addresses()->createMany([
                    [
                        'label' => 'Home',
                        'full_address' => fake()->address(),
                        'landmark' => fake()->streetName(),
                        'latitude' => fake()->latitude(28.4, 28.9),
                        'longitude' => fake()->longitude(77.0, 77.6),
                        'is_default' => true,
                    ],
                ]);
            }
        }

        // 12 more random customers, each with 1 address, for fuller list/pagination testing.
        User::factory()
            ->count(12)
            ->has(\App\Models\Address::factory()->state(['is_default' => true]), 'addresses')
            ->create();

        $this->command?->info('Seeded ' . (count($fixed) + 12) . ' customers with addresses.');
    }
}
