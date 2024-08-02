<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make('Vivek@2025'), // Always use bcrypt to hash passwords
        ]);

        $adminUser = User::create([
            'name' => 'Prakash Motiramani',
            'email' => 'devioffset00@gmail.com',
            'password' => Hash::make('Devi@2024'), // Always use bcrypt to hash passwords
        ]);

        // Create Super Admin role
        $SuperadminRole = Role::create(['name' => 'SuperAdmin']);

        // Create Super Admin permissions
        $permissions = [
            'view-item-categories', 'create-item-categories', 'edit-item-categories', 'delete-item-categories',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-stock-purchases', 'create-stock-purchases', 'edit-stock-purchases', 'delete-stock-purchases',
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
            'view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions',
            'view-invoices', 'create-invoices', 'edit-invoices', 'delete-invoices', 'view-stock-report'
        ];

        // Save All Permissions if they don't exist
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Assign all permissions to the super admin role
        $SuperadminRole->syncPermissions($permissions);

        // Assign Super admin role to the super admin user
        $user->assignRole($SuperadminRole);

        // Create Admin Role Define and Sync permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminPermissions = [
            'view-item-categories', 'create-item-categories', 'edit-item-categories', 'delete-item-categories',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-stock-purchases', 'create-stock-purchases', 'edit-stock-purchases', 'delete-stock-purchases',
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-invoices', 'create-invoices', 'edit-invoices', 'delete-invoices', 'view-stock-report'
        ];
        $adminRole->syncPermissions($adminPermissions);

        // Assign admin role to the admin user
        $adminUser->assignRole($adminRole);

        // Create purchaseInvoice Role Define and Sync permissions
        $purchaseInvoiceRole = Role::create(['name' => 'purchase-invoice']);
        $purchaseInvoicePermissions = [
            'view-stock-purchases', 'create-stock-purchases', 'edit-stock-purchases', 'delete-stock-purchases',
            'view-invoices', 'create-invoices', 'edit-invoices', 'delete-invoices', 'view-stock-report'
        ];
        $purchaseInvoiceRole->syncPermissions($purchaseInvoicePermissions);

        // Create subAdmin Role Define and Sync permissions
        $subAdminRole = Role::create(['name' => 'sub-admin']);
        $subAdminPermissions = [
            'view-item-categories', 'create-item-categories', 'edit-item-categories', 'delete-item-categories',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-stock-purchases', 'create-stock-purchases', 'edit-stock-purchases', 'delete-stock-purchases',
            'view-invoices', 'create-invoices', 'edit-invoices', 'delete-invoices', 'view-stock-report'
        ];
        $subAdminRole->syncPermissions($subAdminPermissions);
    }
}