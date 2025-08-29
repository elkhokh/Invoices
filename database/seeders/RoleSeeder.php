<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // give roles
        $owner = Role::firstOrCreate(['name' => 'owner']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user  = Role::firstOrCreate(['name' => 'user']);

        // owner roles have full access
        $owner->givePermissionTo(Permission::all());

        //admin
        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-invoice',
            'edit-invoice',
            'delete-invoice'
        ]);

        // user
        $user->givePermissionTo([
            // 'view-invoice'
        ]);
    }
}
