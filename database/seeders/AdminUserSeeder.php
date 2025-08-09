<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //         $user = User::updateOrCreate(
    //         ['email' => 'mustafaelkhokhy@gmail.com'],
    //         [
    //             'name' => 'mustafa elkhokhy',
    //             'password' => Hash::make('123456'),
    //             'roles_name' => ["owner"],
    //             'status' => 'مفعل',
    //         ]
    //     );
    //     $role = Role::create(['name' => 'owner']);

    //     $permissions = Permission::pluck('id','id')->all();

    //     $role->syncPermissions($permissions);

    //     $user->assignRole([$role->id]);
    // }
// public function run(): void
// {

    $owner = User::updateOrCreate(
        ['email' => 'mustafaelkhokhy@gmail.com'],
        [
            'name' => 'mustafa elkhokhy',
            'password' => Hash::make('123456'),
        ]
    );
    $owner->assignRole('owner');

    $admin = User::updateOrCreate(
        ['email' => 'ali@gmail.com'],
        [
            'name' => 'ali',
            'password' => Hash::make('123456'),
        ]
    );
    $admin->assignRole('admin');

    $user = User::updateOrCreate(
        ['email' => 'user@gmail.com'],
        [
            'name' => 'user',
            'password' => Hash::make('123456'),
        ]
    );
    $user->assignRole('user');
}

}
