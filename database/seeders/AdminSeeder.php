<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Super Admin', 'email' => 'superadmin@test.com', 'role' => 'super_admin'],
            ['name' => 'Menu Manager', 'email' => 'menu@test.com', 'role' => 'menu_manager'],
            ['name' => 'Order Manager', 'email' => 'orders@test.com', 'role' => 'order_manager'],
        ];

        foreach ($accounts as $data) {
            $admin = Admin::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'), // change after first login
                    'is_active' => true,
                ]
            );

            if (! $admin->hasRole($data['role'])) {
                $admin->assignRole($data['role']);
            }
        }

        $this->command?->info('Admin accounts seeded — login with any of these (password: "password"):');
        $this->command?->table(['Email', 'Role'], collect($accounts)->map(fn ($a) => [$a['email'], $a['role']])->all());
    }
}
