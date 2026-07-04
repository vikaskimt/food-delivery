<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Super Admin', 'Menu Manager', 'Order Manager'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'admin']);
        }

        $superAdmin = Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password123'), 'is_active' => true]
        );

        $superAdmin->syncRoles(['Super Admin']);

        $this->command->info('Super Admin created: admin@example.com / password123 — change this password immediately.');
    }
}
