<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $masterRole = Role::create(['name' => 'master', 'guard_name' => 'web']);
        $clientRole = Role::create(['name' => 'client', 'guard_name' => 'web']);

        $permissions = [
            'manage-appointments',
            'manage-clients',
            'manage-materials',
            'view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $masterRole->givePermissionTo($permissions);
        $clientRole->givePermissionTo($permissions);
    }
}
