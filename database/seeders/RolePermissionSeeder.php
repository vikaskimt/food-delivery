<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Sets up the 3 admin roles: super_admin, menu_manager, order_manager.
     * Adjust the guard_name here if your Admin model uses a different guard.
     */
    public function run(): void
    {
        $guard = 'admin';

        $permissions = [
            'menu.view', 'menu.manage',
            'orders.view', 'orders.manage',
            'customers.view',
            'coupons.view', 'coupons.manage',
            'admins.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => $guard]);
        $superAdmin->syncPermissions($permissions); // gets everything

        $menuManager = Role::firstOrCreate(['name' => 'menu_manager', 'guard_name' => $guard]);
        $menuManager->syncPermissions(['menu.view', 'menu.manage']);

        $orderManager = Role::firstOrCreate(['name' => 'order_manager', 'guard_name' => $guard]);
        $orderManager->syncPermissions(['orders.view', 'orders.manage', 'customers.view']);
    }
}
