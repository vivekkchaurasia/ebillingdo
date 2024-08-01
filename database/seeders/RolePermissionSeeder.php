<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create user
        $user = User::create([
            'name' => 'Vivek',
            'email' => 'ervivekkc@gmail.com',
            'password' => bcrypt('Vivek@2025'), // Always use bcrypt to hash passwords
        ]);

        // Create role
        $adminRole = Role::create(['name' => 'Admin']);

        // Create permissions
        $permissions = [
            'view-item-categories', 'create-item-categories', 'edit-item-categories', 'delete-item-categories',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-stock-purchases', 'create-stock-purchases', 'edit-stock-purchases', 'delete-stock-purchases',
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
            'view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions',
            'view-invoices', 'create-invoices', 'edit-invoices', 'delete-invoices',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to the admin role
        $adminRole->syncPermissions($permissions);
        

        // Assign admin role to the user
        $user->assignRole($adminRole);
    }
}
