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
            User::updateOrCreate(
            ['email' => 'mustafaelkhokhy@gmail.com'],
            [
                'name' => 'mustafa elkhokhy',
                'password' => Hash::make('123456'), 
            ]
        );
    }
}
