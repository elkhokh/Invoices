<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

$permissions = [
            'show-index',
//file
            'show-roles',
//button
            'create-role',
            'edit-role',
            'delete-role',
//file
            'show-users',
//button
            'create-user',
            'edit-user',
            'delete-user',
//files
            'index-invoice',
            'paid-invoice',
            'unpaid-invoice',
            'partpaid-invoice',
            'archive-invoice',
//button
            'show-invoice',
            'create-invoice',
            'edit-invoice',
            'delete-invoice',
            'archive-invoice',
            'edit-status-invoice',
            'excel-import-invoice',
            'print-invoice',
//attachments
            'add-image-invoice',
            'delete-image-invoice',
            'show-image-invoice',
            'download-image-invoice',
//button
            'create-product',
            'edit-product',
            'delete-product',
//file
            'show-product',
//button
            'create-section',
            'edit-section',
            'delete-section',
//file
            'show-section',
        ];

foreach ($permissions as $permission) {
Permission::firstOrCreate(['name' => $permission]);
}


}

}
